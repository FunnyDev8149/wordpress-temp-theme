<?php
/**
 * Alpha FrameWork Assets Class
 *
 * Enqueue framework assets including css, js and images.
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_Assets extends Alpha_Base {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {

		// Manage Theme and Plugin Assets
		if ( ! is_admin() ) {
			// Remove WooCommerce Style
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_css' ), 999 );

		// Unnecessary scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_unnecessary_scripts' ), 99 );
		if ( defined( 'YITH_WCWL' ) ) {
			add_filter( 'yith_wcwl_main_script_deps', array( $this, 'remove_yith_wcwl_selectbox' ) );
		}

		// Custom JS
		if ( ! is_admin() ) {
			add_action( 'wp_print_footer_scripts', array( $this, 'enqueue_custom_js' ), 20 );
		}

		// Stop heartbeat and emoji script
		add_action(
			'init',
			function() {
				// wp_deregister_script( 'heartbeat' );
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
				if ( function_exists( 'alpha_clean_filter' ) ) {
					alpha_clean_filter( 'the_content_feed', 'wp_staticize_emoji' );
					alpha_clean_filter( 'comment_text_rss', 'wp_staticize_emoji' );
					alpha_clean_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
				}
				add_filter(
					'tiny_mce_plugins',
					function( $plugins ) {
						if ( is_array( $plugins ) ) {
							return array_diff( $plugins, [ 'wpemoji' ] );
						}
						return [];
					}
				);
				add_filter(
					'wp_resource_hints',
					function( $urls, $relation_type ) {
						if ( 'dns-prefetch' === $relation_type ) {
							$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/11/svg/' );
							$urls          = array_diff( $urls, [ $emoji_svg_url ] );
						}
						return $urls;
					},
					10,
					2
				);
			},
			1
		);
	}

	/**
	 * Register styles and scripts.
	 *
	 * @since 1.0
	 */
	public function register_scripts() {

		// Styles
		wp_register_style( 'alpha-style', ALPHA_URI . '/style.css', array(), ALPHA_VERSION );
		wp_register_style( 'alpha-icons', ALPHA_ASSETS . '/vendor/' . ALPHA_NAME . '-icons/css/icons.min.css', array(), ALPHA_VERSION );
		wp_register_style( 'alpha-flag', ALPHA_CSS . '/flags.min.css', array(), ALPHA_VERSION );
		wp_register_style( 'fontawesome-free', ALPHA_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );
		wp_register_style( 'animate', ALPHA_ASSETS . '/vendor/animate/animate.min.css' );
		wp_register_style( 'magnific-popup', ALPHA_ASSETS . '/vendor/jquery.magnific-popup/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );

		// Theme Styles
		$css_files  = array( 'theme', 'blog', 'single-post', 'shop', 'shop-other', 'single-product' );
		$uploads    = wp_upload_dir();
		$upload_dir = $uploads['basedir'];
		$upload_url = $uploads['baseurl'];
		if ( ! isset( $_REQUEST['debug'] ) ) {
			foreach ( $css_files as $file ) {
				$filename = 'theme' . ( 'theme' == $file ? '' : '-' . $file );
				if ( file_exists( wp_normalize_path( $upload_dir . '/' . ALPHA_NAME . '_styles/' . $filename . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ) ) ) {
					wp_register_style( 'alpha-' . $filename, $upload_url . '/' . ALPHA_NAME . '_styles/' . $filename . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), ALPHA_VERSION );
				} else {
					wp_register_style( 'alpha-' . $filename, ALPHA_CSS . '/' . ( 'theme' == $file ? '' : 'pages/' ) . $file . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), ALPHA_VERSION );
				}
			}
		}

		if ( file_exists( wp_normalize_path( $upload_dir . '/' . ALPHA_NAME . '_styles/dynamic_css_vars.css' ) ) ) {
			$dynamic_url = $upload_url . '/' . ALPHA_NAME . '_styles/dynamic_css_vars.css';
		} else {
			$dynamic_url = ALPHA_CSS . '/dynamic_css_vars.css';
		}

		// global css
		$custom_css_handle = 'alpha-theme';
		if ( ! is_customize_preview() ) {
			wp_register_style( 'alpha-dynamic-vars', $dynamic_url, array( $custom_css_handle ), ALPHA_VERSION );
		} else {
			global $wp_filesystem;
			// Initialize the WordPress filesystem, no more using file_put_contents function
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
			$dynamic_url = str_replace( 'https:', 'http:', $dynamic_url );
			$data        = $wp_filesystem->get_contents( $dynamic_url );
			wp_add_inline_style( $custom_css_handle, $data );
		}

		// Scripts
		wp_register_script( 'alpha-sticky-lib', alpha_framework_uri( '/assets/js/sticky' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );
		wp_register_script( 'alpha-framework', alpha_framework_uri( '/assets/js/framework' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );
		wp_register_script( 'alpha-framework-async', alpha_framework_uri( '/assets/js/framework-async' . ALPHA_JS_SUFFIX ), array( 'alpha-framework' ), ALPHA_VERSION, true );
		wp_register_script( 'alpha-theme', ALPHA_JS . '/theme' . ALPHA_JS_SUFFIX, array( 'alpha-framework-async' ), ALPHA_VERSION, true );
		wp_register_script( 'isotope-pkgd', ALPHA_ASSETS . '/vendor/isotope/isotope.pkgd' . ALPHA_JS_SUFFIX, array( 'jquery-core', 'imagesloaded' ), '3.0.6', true );
		wp_register_script( 'jquery-cookie', ALPHA_ASSETS . '/vendor/jquery.cookie/jquery.cookie' . ALPHA_JS_SUFFIX, array(), '1.4.1', true );
		wp_register_script( 'jquery-count-to', ALPHA_ASSETS . '/vendor/jquery.count-to/jquery.count-to' . ALPHA_JS_SUFFIX, array( 'jquery-core' ), false, true );
		wp_register_script( 'jquery-countdown', ALPHA_ASSETS . '/vendor/jquery.countdown/jquery.countdown.min.js', array( 'jquery-core' ), false, true );
		wp_register_script( 'jquery-fitvids', ALPHA_ASSETS . '/vendor/jquery.fitvids/jquery.fitvids.min.js', array( 'jquery-core' ), false, true );
		wp_register_script( 'jquery-magnific-popup', ALPHA_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup' . ALPHA_JS_SUFFIX, array( 'jquery-core', 'imagesloaded' ), '1.1.0', true );
		wp_register_script( 'jquery-parallax', ALPHA_ASSETS . '/vendor/parallax/parallax.min.js', array( 'jquery-core' ), false, true );
		wp_register_script( 'three-sixty', ALPHA_ASSETS . '/vendor/threesixty/threesixty.min.js', array( 'jquery-core' ), false, true );
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			wp_register_script( 'swiper', ALPHA_ASSETS . '/vendor/swiper/swiper' . ALPHA_JS_SUFFIX, '6.7.0', true );
		}
	}

	/**
	 * Enqueue styles and scripts for admin.
	 *
	 * @since 1.0
	 */
	public function enqueue_admin_scripts() {

		wp_register_style( 'fontawesome-free', ALPHA_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );
		wp_register_style( 'jquery-select2', ALPHA_ASSETS . '/vendor/select2/select2.css', array(), '4.0.3' );
		wp_register_style( 'magnific-popup', ALPHA_ASSETS . '/vendor/jquery.magnific-popup/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );
		wp_register_script( 'isotope-pkgd', ALPHA_ASSETS . '/vendor/isotope/isotope.pkgd' . ALPHA_JS_SUFFIX, array( 'jquery-core', 'imagesloaded' ), '3.0.6', true );
		wp_register_script( 'jquery-magnific-popup', ALPHA_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup' . ALPHA_JS_SUFFIX, array( 'jquery-core', 'imagesloaded' ), '1.1.0', true );
		wp_register_script( 'jquery-select2', ALPHA_ASSETS . '/vendor/select2/select2' . ALPHA_JS_SUFFIX, array( 'jquery' ), '4.0.3', true );

		// Admin Scripts
		wp_enqueue_style( 'fontawesome-free' );
		wp_enqueue_style( 'alpha-admin', alpha_framework_uri( '/admin/admin/admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ), array(), ALPHA_VERSION );
		wp_enqueue_script( 'alpha-admin', alpha_framework_uri( '/admin/admin/admin' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );
		wp_enqueue_script( 'wp-color-picker' );

		// Load google font
		alpha_load_google_font();

		wp_localize_script(
			'alpha-admin',
			'alpha_admin_vars',
			apply_filters(
				'alpha_admin_vars',
				array(
					'theme'              => ALPHA_NAME,
					'theme_icon_prefix'  => ALPHA_ICON_PREFIX,
					'theme_display_name' => ALPHA_DISPLAY_NAME,
					'ajax_url'           => esc_url( admin_url( 'admin-ajax.php' ) ),
					'dummy_url'          => ALPHA_SERVER_URI . 'dummy/api/' . ALPHA_NAME . '_api',
					'nonce'              => wp_create_nonce( 'alpha-admin' ),
				)
			)
		);
	}

	/**
	 * Enqueue frontend styles.
	 *
	 * @since 1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'fontawesome-free' );
		wp_enqueue_style( 'alpha-icons' );
		wp_enqueue_style( 'alpha-flag' );
		wp_enqueue_style( 'animate' );
		wp_enqueue_style( 'magnific-popup' );

		do_action( 'alpha_before_enqueue_theme_style' );

		wp_enqueue_style( 'alpha-dynamic-vars' );
		wp_enqueue_style( 'alpha-theme' );

		// Theme page style
		$custom_css_handle = 'alpha-theme';
		$layout            = alpha_get_page_layout();
		if ( 'archive_product' == $layout ) { // Product Archive Page
			$custom_css_handle = 'alpha-theme-shop';
		} elseif ( 'archive_' == substr( $layout, 0, 8 ) ) { // Blog Page
			$custom_css_handle = 'alpha-theme-blog';
		} elseif ( 'single_page' == $layout ) { // Page
			if (
				( defined( 'YITH_WCWL' ) && function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) ||
				( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) )
			) {
				$custom_css_handle = 'alpha-theme-shop-other';
			}
		} elseif ( 'single_product' == $layout ) { // Single Product Page
			$custom_css_handle = 'alpha-theme-single-product';
			wp_enqueue_script( 'photoswipe' );
		} elseif ( 'single_' == substr( $layout, 0, 7 ) ) { // Single Post Page
			$custom_css_handle = 'alpha-theme-single-post';
		}

		if ( 'alpha-theme' != $custom_css_handle ) {
			wp_enqueue_style( $custom_css_handle );
		}

		if ( function_exists( 'alpha_is_elementor_preview' ) && alpha_is_elementor_preview() && ALPHA_NAME . '_template' == get_post_type() && 'product_layout' == get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true ) ) {
			wp_enqueue_style( 'alpha-theme-single-product' );
		}

		// Styles for page editors (edit link tooltip)
		if ( current_user_can( 'edit_pages' ) ) {
			wp_enqueue_style( 'bootstrap-tooltip', ALPHA_ASSETS . '/vendor/bootstrap/bootstrap.tooltip.css', array(), '4.1.3' );
		}

		// Global css
		if ( ! is_customize_preview() ) {
			$custom_css = alpha_get_option( 'custom_css' );
			if ( $custom_css ) {
				wp_add_inline_style( 'alpha-style', '/* Global CSS */' . PHP_EOL . wp_strip_all_tags( wp_specialchars_decode( $custom_css ) ) );
			}
		}

		do_action( 'alpha_after_enqueue_theme_style' );

		alpha_load_google_font();
	}

	/**
	 * Dequeue unnecessary styles and scripts.
	 *
	 * @since 1.0
	 */
	public function dequeue_unnecessary_scripts() {

		// YITH WCWL styles & scripts
		if ( defined( 'YITH_WCWL' ) ) {

			// dequeue font awesome
			wp_dequeue_style( 'yith-wcwl-font-awesome' );
			wp_deregister_style( 'yith-wcwl-font-awesome' );

			// enqueue main style again because font-awesome dequeues it.
			wp_dequeue_style( 'yith-wcwl-main' );
			wp_dequeue_style( 'yith-wcwl-font-awesome' );

			// wp_dequeue_style( 'jquery-selectBox' );
			// wp_dequeue_script( 'jquery-selectBox' );

			// checkout
			if ( function_exists( 'is_checkout' ) && is_checkout() ) {
				// wp_dequeue_style( 'selectWoo' );
				// wp_deregister_style( 'selectWoo' );
			}
		}

		// @start feature: fs_plugin_woocommerce
		// WooCommerce PrettyPhoto(deprecated), but YITH Wishlist use
		if ( class_exists( 'WooCommerce' ) ) {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_deregister_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'prettyPhoto' );
		}
		// @end feature: fs_plugin_woocommerce

		// Optimize disable
		if ( alpha_get_option( 'resource_disable_gutenberg' ) ) {
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'wp-block-library' );
		}
		if ( alpha_get_option( 'resource_disable_wc_blocks' ) ) {
			wp_dequeue_style( 'wc-block-style' );
			wp_deregister_style( 'wc-block-style' );
			wp_dequeue_style( 'wc-block-vendors-style' );
			wp_deregister_style( 'wc-block-vendors-style' );
		}

		if ( ! is_admin_bar_showing() ) {
			wp_dequeue_style( 'dashicons' );
		}
	}

	/**
	 * Dequeue jquery-selectBox script.
	 *
	 * @since 1.0
	 */
	public function remove_yith_wcwl_selectbox( $deps ) {
		foreach ( $deps as $i => $dep ) {
			if ( 'jquery-selectBox' == $dep ) {
				array_splice( $deps, $i, 1 );
			}
		}
		return $deps;
	}

	/**
	 * Enqueue custom css
	 *
	 * @since 1.0
	 */
	public function enqueue_custom_css() {

		do_action( 'alpha_before_enqueue_custom_css' );

		// Getting Page ID
		if ( class_exists( 'WooCommerce' ) && is_shop() ) { // Shop Page
			$page_id = wc_get_page_id( 'shop' );
		} elseif ( is_home() && get_option( 'page_for_posts' ) ) { // Blog Page
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

		// Theme Style
		wp_enqueue_style( 'alpha-style' );

		// Enqueue Page CSS
		if ( function_exists( 'alpha_is_elementor_preview' ) && alpha_is_elementor_preview() ) {
			$page_css = '';

			wp_enqueue_script( 'isotope-pkgd' );
			wp_enqueue_script( 'jquery-parallax' );
			wp_enqueue_script( 'isotope-plugin' );
			wp_enqueue_script( 'jquery-countdown' );
		} else {
			$page_css = get_post_meta( intval( $page_id ), 'page_css', true );
		}

		if ( $page_css ) {
			wp_add_inline_style( 'alpha-style', '/* Page CSS */' . PHP_EOL . $page_css );
		}

		do_action( 'alpha_after_enqueue_custom_style' );
	}

	/**
	 * Enqueue frontend scripts and localize vars.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'alpha-framework' );
		wp_enqueue_script( 'alpha-framework-async' );
		wp_enqueue_script( 'alpha-theme' );

		$localize_vars = array(
			'theme'                => ALPHA_NAME,
			'theme_icon_prefix'    => ALPHA_ICON_PREFIX,
			'alpha_gap'            => ALPHA_GAP,
			'home_url'             => esc_js( home_url( '/' ) ),
			'ajax_url'             => esc_js( admin_url( 'admin-ajax.php' ) ),
			'nonce'                => wp_create_nonce( 'alpha-nonce' ),
			'lazyload'             => alpha_get_option( 'lazyload' ),
			'container'            => alpha_get_option( 'container' ),
			'assets_url'           => ALPHA_ASSETS,
			'texts'                => array(
				'loading'        => esc_html__( 'Loading...', 'alpha' ),
				'loadmore_error' => esc_html__( 'Loading failed', 'alpha' ),
				'popup_error'    => esc_html__( 'The content could not be loaded.', 'alpha' ),
			),
			'resource_async_js'    => alpha_get_option( 'resource_async_js' ),
			'resource_split_tasks' => alpha_get_option( 'resource_split_tasks' ),
			'resource_idle_run'    => alpha_get_option( 'resource_idle_run' ),
			'resource_after_load'  => alpha_get_option( 'resource_after_load' ),
			'alpha_cache_key'      => 'alpha_cache_' . MD5( home_url() ),
			'lazyload_menu'        => boolval( alpha_get_option( 'lazyload_menu' ) ),
			'countdown'            => array(
				'labels'       => array(
					esc_html__( 'Years', 'alpha' ),
					esc_html__( 'Months', 'alpha' ),
					esc_html__( 'Weeks', 'alpha' ),
					esc_html__( 'Days', 'alpha' ),
					esc_html__( 'Hours', 'alpha' ),
					esc_html__( 'Minutes', 'alpha' ),
					esc_html__( 'Seconds', 'alpha' ),
				),
				'labels_short' => array(
					esc_html__( 'Years', 'alpha' ),
					esc_html__( 'Months', 'alpha' ),
					esc_html__( 'Weeks', 'alpha' ),
					esc_html__( 'Days', 'alpha' ),
					esc_html__( 'Hrs', 'alpha' ),
					esc_html__( 'Mins', 'alpha' ),
					esc_html__( 'Secs', 'alpha' ),
				),
				'label1'       => array(
					esc_html__( 'Year', 'alpha' ),
					esc_html__( 'Month', 'alpha' ),
					esc_html__( 'Week', 'alpha' ),
					esc_html__( 'Day', 'alpha' ),
					esc_html__( 'Hour', 'alpha' ),
					esc_html__( 'Minute', 'alpha' ),
					esc_html__( 'Second', 'alpha' ),
				),
				'label1_short' => array(
					esc_html__( 'Year', 'alpha' ),
					esc_html__( 'Month', 'alpha' ),
					esc_html__( 'Week', 'alpha' ),
					esc_html__( 'Day', 'alpha' ),
					esc_html__( 'Hour', 'alpha' ),
					esc_html__( 'Min', 'alpha' ),
					esc_html__( 'Sec', 'alpha' ),
				),
			),
		);

		// Scripts for page editors (edit link tooltip)
		if ( current_user_can( 'edit_pages' ) ) {
			wp_enqueue_script( 'bootstrap-tooltip', ALPHA_ASSETS . '/vendor/bootstrap/bootstrap.tooltip' . ALPHA_JS_SUFFIX, array( 'jquery-core' ), '4.1.3', true );
		}

		if ( alpha_get_option( 'lazyload_menu' ) ) {
			$localize_vars['menu_last_time'] = alpha_get_option( 'menu_last_time' );
		}

		if ( alpha_get_option( 'skeleton_screen' ) ) {
			$localize_vars['skeleton_screen'] = true;
			$localize_vars['posts_per_page']  = get_query_var( 'posts_per_page' );
		}

		if ( alpha_get_option( 'blog_ajax' ) && ( is_archive() || is_home() ) && ! alpha_is_shop() || is_search() ) {
			$localize_vars['blog_ajax'] = 1;
		}

		// @start feature: fs_plugin_woocommerce
		if ( class_exists( 'WooCommerce' ) && alpha_get_option( 'compare_available' ) ) {
			$localize_vars['compare_limit'] = alpha_get_option( 'compare_limit' );
		}
		// @end feature: fs_plugin_woocommerce

		// @start feature: fs_pb_elementor
		if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) ) {
			if ( class_exists( 'Elementor\Plugin' ) && Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_assets_loading' ) ) {
				$localize_vars['swiper_url'] = plugins_url( 'elementor/assets/lib/swiper/swiper' . ALPHA_JS_SUFFIX );
			}
			if ( apply_filters( 'alpha_resource_disable_elementor', alpha_get_option( 'resource_disable_elementor' ) ) && ! current_user_can( 'edit_pages' ) ) {
				$localize_vars['resource_disable_elementor'] = 1;
			}
		}
		// @end feature: fs_pb_elementor

		// @start feature: fs_plugin_woocommerce
		if ( class_exists( 'WooCommerce' ) ) {
			if ( alpha_get_option( 'shop_ajax' ) && ! apply_filters( 'alpha_is_vendor_store', false ) && alpha_is_shop() ) {
				$localize_vars['shop_ajax'] = 1;
			}

			$localize_vars = array_merge_recursive(
				$localize_vars,
				array(
					'home_url'            => esc_js( home_url( '/' ) ),
					'shop_url'            => esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ),
					'quickview_type'      => alpha_get_option( 'quickview_type' ),
					'quickview_thumbs'    => alpha_get_option( 'quickview_thumbs' ),
					'prod_open_click_mob' => alpha_get_option( 'prod_open_click_mob' ),
					'texts'               => array(
						/* translators: %d represents loaded products count. */
						'show_info_all'   => esc_html__( 'all %d', 'alpha' ),
						'already_voted'   => esc_html__( 'You already voted!', 'alpha' ),
						'view_checkout'   => esc_html__( 'Checkout', 'alpha' ),
						'view_cart'       => esc_html__( 'View Cart', 'alpha' ),
						'add_to_wishlist' => esc_html__( 'Add to wishlist', 'alpha' ),
						'cart_suffix'     => esc_html__( 'has been added to cart', 'alpha' ),
						'select_category' => esc_js( __( 'Select a category', 'woocommerce' ) ),
						'no_matched'      => esc_js( _x( 'No matches found', 'enhanced select', 'woocommerce' ) ),
					),
					'pages'               => array(
						'cart'     => wc_get_page_permalink( 'cart' ),
						'checkout' => wc_get_page_permalink( 'checkout' ),
					),
					'single_product'      => array(
						'zoom_enabled' => true,
						'zoom_options' => array(),
					),
					'cart_auto_update'    => alpha_get_option( 'cart_auto_update' ),
					'cart_show_qty'       => alpha_get_option( 'cart_show_qty' ),
				)
			);
		}
		// @end feature: fs_plugin_woocommerce

		wp_localize_script( 'alpha-framework', 'alpha_vars', apply_filters( 'alpha_vars', $localize_vars ) );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueue custom js.
	 *
	 * @since 1.0
	 */
	public function enqueue_custom_js() {
		global $alpha_layout;
		$global_js = alpha_get_option( 'custom_js' );
		if ( $global_js ) {
			?>
			<script id="alpha_custom_global_script">
				<?php echo alpha_strip_script_tags( $global_js ); ?>
			</script>
			<?php
		}

		// Getting Page ID
		if ( class_exists( 'WooCommerce' ) && is_shop() ) { // Shop Page
			$page_id = wc_get_page_id( 'shop' );
		} elseif ( is_home() && get_option( 'page_for_posts' ) ) { // Blog Page
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

		$page_js = get_post_meta( intval( $page_id ), 'page_js', true );
		if ( $page_js ) {
			?>
			<script id="alpha_custom_page_script">
				<?php echo alpha_strip_script_tags( $page_js ); ?>
			</script>
			<?php
		}

		if ( isset( $alpha_layout['used_blocks'] ) && $alpha_layout['used_blocks'] ) {
			foreach ( $alpha_layout['used_blocks'] as $block_id => $value ) {
				$script = get_post_meta( $block_id, 'page_js', true );
				if ( $script ) {
					?>
				<script id="alpha_block_<?php echo esc_attr( $block_id ); ?>_script">
					<?php echo alpha_strip_script_tags( $script ); ?>
				</script>
					<?php
				}

				$alpha_layout['used_blocks'][ $block_id ]['js'] = true;
			}
		}
	}
}

Alpha_Assets::get_instance();

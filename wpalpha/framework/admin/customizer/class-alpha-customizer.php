<?php
/**
 * Alpha Customizer
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Customizer' ) ) :

	class Alpha_Customizer extends Alpha_Base {

		/**
		 * The WP_Customizer instance
		 *
		 * @var WP_Customizer
		 * @since 1.0
		 */
		protected $wp_customize;
		public $blocks;
		public $popups;
		public $product_layouts;

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'load_styles' ) );
			add_action( 'customize_controls_print_scripts', array( $this, 'load_scripts' ), 30 );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_selective_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_global_custom_css' ), 21 );
			add_action( 'customize_save_after', array( $this, 'save_theme_options' ), 1 );
			add_action( 'customize_register', array( $this, 'customize_register' ) );

			// Theme Option Import/Export
			add_action( 'wp_ajax_alpha_import_theme_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_nopriv_alpha_import_theme_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_alpha_export_theme_options', array( $this, 'export_options' ) );
			add_action( 'wp_ajax_nopriv_alpha_export_theme_options', array( $this, 'export_options' ) );

			// Theme Option Reset
			add_action( 'wp_ajax_alpha_reset_theme_options', array( $this, 'reset_options' ) );
			add_action( 'wp_ajax_nopriv_alpha_reset_theme_options', array( $this, 'reset_options' ) );

			// Get Page Links ( Load other page for previewer )
			add_filter( 'alpha_admin_vars', array( $this, 'add_local_vars' ) );

			// Customize Navigator
			add_action( 'customize_controls_print_scripts', array( $this, 'customizer_navigator' ) );

			add_action( 'wp_ajax_alpha_save_customize_nav', array( $this, 'customizer_nav_save' ) );
			add_action( 'wp_ajax_nopriv_alpha_save_customize_nav', array( $this, 'customizer_nav_save' ) );

			// Setup options
			add_action( 'init', array( $this, 'setup_options' ) );

			// Selective Refresh
			add_action( 'customize_register', array( $this, 'selective_refresh' ) );

			// Update Product Placeholder
			if ( class_exists( 'WooCommerce' ) ) {
				add_filter( 'pre_set_theme_mod_product_placeholder_image', array( $this, 'update_woocommerce_placeholder_image' ), 10, 2 );
			}
		}

		/**
		 * load selective refresh JS
		 *
		 * @since 1.0
		 */
		public function load_selective_assets() {

			wp_enqueue_script( 'alpha-selective', alpha_framework_uri( '/admin/customizer/selective-refresh' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_VERSION, true );

			wp_localize_script(
				'alpha-selective',
				'alpha_selective_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'    => wp_create_nonce( 'alpha-selective' ),
				)
			);
		}

		/**
		 * load custom css
		 *
		 * @since 1.0
		 */
		public function load_global_custom_css() {
			wp_enqueue_style( 'alpha-preview-custom', ALPHA_FRAMEWORK_ADMIN_URI . '/customizer/preview-custom.css' );
			wp_add_inline_style( 'alpha-preview-custom', wp_strip_all_tags( wp_specialchars_decode( alpha_get_option( 'custom_css' ) ) ) );
		}

		/**
		 * Add CSS for Customizer Options
		 *
		 * @since 1.0
		 */
		public function load_styles() {
			wp_enqueue_style( 'alpha-customizer', alpha_framework_uri( '/admin/customizer/customizer' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' ), null, ALPHA_VERSION, 'all' );
			wp_enqueue_style( 'magnific-popup' );
		}

		/**
		 * Add JS for Customizer Options
		 *
		 * @since 1.0
		 */
		public function load_scripts() {

			wp_enqueue_script( 'alpha-customizer', alpha_framework_uri( '/admin/customizer/customizer' . ALPHA_JS_SUFFIX ), array(), ALPHA_VERSION, true );

			wp_localize_script(
				'alpha-customizer',
				'alpha_customizer_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'    => wp_create_nonce( 'alpha-customizer' ),
				)
			);
		}

		/**
		 * Save theme options
		 *
		 * @since 1.0
		 */
		public function save_theme_options() {
			ob_start();
			include alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/customizer/dynamic/dynamic_vars.php' );

			global $wp_filesystem;
			// Initialize the WordPress filesystem, no more using file_put_contents function
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			try {
				$target      = wp_upload_dir()['basedir'] . '/' . ALPHA_NAME . '_styles/dynamic_css_vars.css';
				$target_path = dirname( $target );
				if ( ! file_exists( $target_path ) ) {
					wp_mkdir_p( $target_path );
				}

				// check file mode and make it writable.
				if ( is_writable( $target_path ) == false ) {
					@chmod( get_theme_file_path( $target ), 0755 );
				}
				if ( file_exists( $target ) ) {
					if ( is_writable( $target ) == false ) {
						@chmod( $target, 0755 );
					}
					@unlink( $target );
				}

				$wp_filesystem->put_contents( $target, ob_get_clean(), FS_CHMOD_FILE );
			} catch ( Exception $e ) {
				var_dump( $e );
				var_dump( 'error occured while saving dynamic css vars.' );
			}
		}

		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		/**
		 * Import theme options
		 *
		 * @since 1.0
		 */
		public function import_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'alpha-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( empty( $_FILES['file'] ) || empty( $_FILES['file']['name'] ) ) {
				wp_send_json_error( 'Empty file pathname' );
			}

			$filename = $_FILES['file']['name'];

			if ( empty( $_FILES['file']['tmp_name'] ) || '.json' !== substr( $filename, -5 ) ) {
				wp_send_json_error( 'invalid_type' );
			}

			$options = file_get_contents( $_FILES['file']['tmp_name'] );
			if ( $options ) {
				$options = json_decode( $options, true );
			}
			if ( $options ) {
				update_option( 'theme_mods_' . get_option( 'stylesheet' ), $options );
				wp_send_json_success();
			} else {
				wp_send_json_error( 'invalid_type' );
			}
		}

		/**
		 * Get menus
		 *
		 * @since 1.0
		 */
		public function get_menus() {
			$nav_menus = wp_get_nav_menus();
			$menus     = array();
			foreach ( $nav_menus as $menu ) {
				$menus[ $menu->slug ] = esc_html( $menu->name );
			}
			return $menus;
		}

		/**
		 * Get social shares.
		 *
		 * @since 1.0
		 */
		public function get_social_shares() {
			$social_shares      = alpha_get_social_shares();
			$social_shares_list = array();
			foreach ( $social_shares as $share => $data ) {
				$social_shares_list[ $share ] = $data['title'];
			}
			return $social_shares_list;
		}

		/**
		 * Export theme options.
		 *
		 * @since 1.0
		 */
		public function export_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'alpha-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			header( 'Content-Description: File Transfer' );
			header( 'Content-type: application/txt' );
			header( 'Content-Disposition: attachment; filename="alpha_theme_options_backup_' . date( 'Y-m-d' ) . '.json"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			echo json_encode( get_theme_mods() );
			exit;
		}

		/**
		 * Reset theme options
		 *
		 * @since 1.0
		 */
		public function reset_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'alpha-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			remove_theme_mods();

			// Delete compiled css in uploads/alpha_style directory.
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			try {
				$wp_filesystem->delete( wp_upload_dir()['basedir'] . '/' . ALPHA_NAME . '_styles', true );
			} catch ( Exception $e ) {
				wp_send_json_error( 'error occured while deleting compiled css.' );
			}

			wp_send_json_success();
		}

		/**
		 * Get Page Links
		 *
		 * @since 1.0
		 */
		public function add_local_vars( $vars ) {

			$home_url        = esc_js( home_url() );
			$blog_url        = '';
			$post_url        = '';
			$shop_url        = '';
			$cart_url        = '';
			$checkout_url    = '';
			$product_url     = '';
			$vendor_page_url = '';

			$post = get_posts( array( 'posts_per_page' => 1 ) );
			if ( is_array( $post ) && count( $post ) ) {
				$blog_url = esc_js( get_post_type_archive_link( 'post' ) );
				$post_url = esc_js( get_permalink( $post[0] ) );
			}
			// @start feature: fs_plugin_woocommerce
			if ( class_exists( 'WooCommerce' ) ) {
				$shop_url        = esc_js( wc_get_page_permalink( 'shop' ) );
				$cart_url        = esc_js( wc_get_page_permalink( 'cart' ) );
				$checkout_url    = esc_js( wc_get_page_permalink( 'checkout' ) );
				$product_url     = '';
				$vendor_page_url = '#';
				$product         = get_posts(
					array(
						'posts_per_page' => 1,
						'post_type'      => 'product',
					)
				);
				if ( is_array( $product ) && count( $product ) ) {
					$product_url = esc_js( get_permalink( $product[0] ) );
				}
			}
			// @end feature: fs_plugin_woocommerce

			$vars['page_links'] = apply_filters(
				'alpha_customize_page_links',
				array(
					'blog_archive'         => array(
						'url'      => $blog_url,
						'is_panel' => false,
					),
					'blog_single'          => array(
						'url'      => $post_url,
						'is_panel' => false,
					),
					'products_archive'     => array(
						'url'      => $shop_url,
						'is_panel' => false,
					),
					'product_detail'       => array(
						'url'      => $product_url,
						'is_panel' => false,
					),
					'wc_cart'              => array(
						'url'      => $cart_url,
						'is_panel' => false,
					),
					'woocommerce_checkout' => array(
						'url'      => $checkout_url,
						'is_panel' => false,
					),
				)
			);

			return $vars;
		}

		/**
		 * Get Navigator Template
		 *
		 * @since 1.0
		 */
		public function customizer_navigator() {
			$nav_items = alpha_get_option( 'navigator_items' );

			ob_start();
			?>
			<div class="customizer-nav">
				<h3><?php esc_html_e( 'Navigator', 'alpha' ); ?><a href="#" class="navigator-toggle"><i class="fas fa-chevron-left"></i></a></h3>
				<div class="customizer-nav-content">
					<ul class="customizer-nav-items">
						<?php foreach ( $nav_items as $section => $label ) : ?>
						<li>
							<a href="#" data-target="<?php echo esc_attr( $section ); ?>" data-type="<?php echo esc_attr( $label[1] ); ?>" class="customizer-nav-item"><?php echo esc_html( $label[0] ); ?></a>
							<a href="#" class="customizer-nav-remove"><i class="fas fa-trash"></i></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}

		/**
		 * Save Navigator Items
		 *
		 * @since 1.0
		 */
		public function customizer_nav_save() {
			if ( ! check_ajax_referer( 'alpha-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( isset( $_POST['navs'] ) ) {
				set_theme_mod( 'navigator_items', $_POST['navs'] );
				wp_send_json_success();
			}
		}

		/**
		 * Get editing menu label control.
		 *
		 * @since 1.0
		 */
		public function get_edit_menu_label_control() {
			ob_start();
			?>
			<div class="label-list">
				<label><?php esc_html_e( 'Menu Labels', 'alpha' ); ?></label>
				<select id="label-select" name="label-select">
				<?php
				$labels = json_decode( alpha_get_option( 'menu_labels' ), true );
				if ( $labels ) :
					foreach ( $labels as $text => $color ) :
						?>
						<option value="<?php echo esc_html( $color ); ?>"><?php echo esc_html( $text ); ?></option>
						<?php
					endforeach;
				endif;
				?>
				</select>
			</div>
			<div class="menu-label">
				<label><?php esc_html_e( 'Label Text to Change', 'alpha' ); ?></label>
				<input type="text" class="label-text" value="<?php echo esc_attr( $labels ? array_keys( $labels )[0] : '' ); ?>">
				<label><?php esc_html_e( 'Label Background Color to Change', 'alpha' ); ?></label>
				<input type="text" class="alpha-color-picker" value="<?php echo esc_attr( $labels ? $labels[ array_keys( $labels )[0] ] : '' ); ?>">
				<div class="label-actions">
					<button class="button button-primary btn-change-label"><?php esc_html_e( 'Change', 'alpha' ); ?></button>
					<button class="button btn-remove-label"><?php esc_html_e( 'Remove', 'alpha' ); ?></button>
				</div>
				<p class="error-msg"></p>
			</div>
			<?php
			return ob_get_clean();
		}

		public function get_new_menu_label_control() {
			ob_start();
			?>
			<div class="menu-label">
				<label><?php esc_html_e( 'Input Label Text', 'alpha' ); ?></label>
				<input type="text" class="label-text">
				<label><?php esc_html_e( 'Choose Label Background Color', 'alpha' ); ?></label>
				<input type="text" class="alpha-color-picker" value="">
				<div class="label-actions">
					<button class="button button-primary btn-add-label"><?php esc_html_e( 'Add', 'alpha' ); ?></button>
				</div>
				<p class="error-msg"></p>
			</div>
			<?php
			return ob_get_clean();
		}


		public function setup_options() {

			$alpha_templates = alpha_get_global_templates_sidebars();
			if ( ! empty( $alpha_templates['block'] ) ) {
				$custom_tab_block     = $alpha_templates['block'];
				$custom_tab_block[''] = esc_html__( 'None', 'alpha' );
			}

			$panels = array(
				'style'     => array(
					'title'    => esc_html__( 'Style', 'alpha' ),
					'priority' => 20,
				),
				'layouts'   => array(
					'title'    => esc_html__( 'Page Layouts', 'alpha' ),
					'priority' => 30,
				),
				'nav_menus' => array(
					'title'    => esc_html__( 'Menus', 'alpha' ),
					'priority' => 40,
				),
				'blog'      => array(
					'title'    => esc_html__( 'Blog', 'alpha' ),
					'priority' => 50,
				),
				'widgets'   => array(
					'title'    => esc_html__( 'Widgets', 'alpha' ),
					'priority' => 100,
				),
				'advanced'  => array(
					'title'    => esc_html__( 'Miscellaneous', 'alpha' ),
					'priority' => 120,
				),
				'features'  => array(
					'title'    => esc_html__( 'Features', 'alpha' ),
					'priority' => 110,
				),
			);

			$sections = array(
				// General Panel
				'general'           => array(
					'title'    => esc_html__( 'General', 'alpha' ),
					'priority' => 10,
				),
				// Header Panel
				'header_footer'     => array(
					'title'    => esc_html__( 'Header & Footer', 'alpha' ),
					'priority' => 10,
				),
				// Share Panel
				'share'             => array(
					'title'    => esc_html__( 'Share', 'alpha' ),
					'priority' => 110,
				),
				// Custom CSS & JS Panel
				'custom_css_js'     => array(
					'title'    => esc_html__( 'Custom CSS & JS', 'alpha' ),
					'priority' => 130,
				),
				// Change Orders
				'title_tagline'     => array(
					'title'    => esc_html__( 'Site Identity', 'alpha' ),
					'priority' => 150,
				),
				'static_front_page' => array(
					'title'    => esc_html__( 'Homepage Settings', 'alpha' ),
					'priority' => 160,
				),
				'colors'            => array(
					'title'    => esc_html__( 'Color', 'alpha' ),
					'priority' => 160,
				),
				'header_image'      => array(
					'title'    => esc_html__( 'Header Image', 'alpha' ),
					'priority' => 170,
				),
				'background_image'  => array(
					'title'    => esc_html__( 'Background Image', 'alpha' ),
					'priority' => 180,
				),
				// Style Panel
				'color'             => array(
					'title'    => esc_html__( 'Color & Skin', 'alpha' ),
					'panel'    => 'style',
					'priority' => 10,
				),
				'typo'              => array(
					'title'    => esc_html__( 'Typography', 'alpha' ),
					'panel'    => 'style',
					'priority' => 20,
				),
				'title_bar'         => array(
					'title'    => esc_html__( 'Page Title Bar', 'alpha' ),
					'panel'    => 'style',
					'priority' => 30,
				),
				'breadcrumb'        => array(
					'title'    => esc_html__( 'Breadcrumbs', 'alpha' ),
					'panel'    => 'style',
					'priority' => 40,
				),
				// Menus
				'menu_labels'       => array(
					'title'    => esc_html__( 'Menu Labels', 'alpha' ),
					'panel'    => 'nav_menus',
					'priority' => 3,
				),
				'mobile_menu'       => array(
					'title'    => esc_html__( 'Mobile Menu', 'alpha' ),
					'panel'    => 'nav_menus',
					'priority' => 6,
				),
				'mobile_bar'        => array(
					'title'    => esc_html__( 'Mobile Sticky Icon Bar', 'alpha' ),
					'priority' => 8,
					'panel'    => 'nav_menus',
				),
				// Blog Panel
				'blog_global'       => array(
					'title'    => esc_html__( 'Blog Global', 'alpha' ),
					'priority' => 10,
					'panel'    => 'blog',
				),
				'blog_archive'      => array(
					'title'    => esc_html__( 'Blog Page', 'alpha' ),
					'priority' => 20,
					'panel'    => 'blog',
				),
				'blog_single'       => array(
					'title'    => esc_html__( 'Single Post Page', 'alpha' ),
					'priority' => 30,
					'panel'    => 'blog',
				),
				// Features
				'ajax_filter'       => array(
					'title'    => esc_html__( 'Ajax Filter', 'alpha' ),
					'panel'    => 'features',
					'priority' => 10,
				),
				'lazyload'          => array(
					'title'    => esc_html__( 'Lazy Load', 'alpha' ),
					'priority' => 50,
					'panel'    => 'features',
				),
				'quickview'         => array(
					'title'    => esc_html__( 'Quickview', 'alpha' ),
					'panel'    => 'features',
					'priority' => 60,
				),
				'search'            => array(
					'title'    => esc_html__( 'Search', 'alpha' ),
					'priority' => 70,
					'panel'    => 'features',
				),
				'sociallogin'       => array(
					'title'    => esc_html__( 'Social Login', 'alpha' ),
					'priority' => 80,
					'panel'    => 'features',
				),
				// Advanced Panel
				'images'            => array(
					'title'    => esc_html__( 'Image Size & Quality', 'alpha' ),
					'priority' => 30,
					'panel'    => 'advanced',
				),
				'reset_options'     => array(
					'title'    => esc_html__( 'Import/Export/Reset', 'alpha' ),
					'priority' => 40,
					'panel'    => 'advanced',
				),
				'seo'               => array(
					'title'    => esc_html__( 'SEO', 'alpha' ),
					'priority' => 50,
					'panel'    => 'advanced',
				),
				'white_label'       => array(
					'title'    => esc_html__( 'White Label', 'alpha' ),
					'priority' => 60,
					'panel'    => 'advanced',
				),
			);

			$fields = array(
				// General / Site Layout
				'cs_site_layout'                => array(
					'section' => 'general',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Site Layout', 'alpha' ) . '</h3>',
				),
				// 'site_type'                       => array(
				// 	'section'   => 'general',
				// 	'type'      => 'radio_buttonset',
				// 	'label'     => esc_html__( 'Site Type', 'alpha' ),
				// 	'transport' => 'postMessage',
				// 	'choices'   => array(
				// 		'full'   => esc_html__( 'Full', 'alpha' ),
				// 		'boxed'  => esc_html__( 'Boxed', 'alpha' ),
				// 		'framed' => esc_html__( 'Framed', 'alpha' ),
				// 	),
				// ),
				'site_type'                     => array(
					'section'   => 'general',
					'type'      => 'radio_image',
					'label'     => esc_html__( 'Site Type', 'alpha' ),
					'transport' => 'postMessage',
					'choices'   => array(
						'full'   => ALPHA_ASSETS . '/images/admin/customizer/site-full.svg',
						'boxed'  => ALPHA_ASSETS . '/images/admin/customizer/site-boxed.svg',
						'framed' => ALPHA_ASSETS . '/images/admin/customizer/site-framed.svg',
					),
				),
				'site_width'                    => array(
					'section'         => 'general',
					'type'            => 'text',
					'label'           => esc_html__( 'Site Width (px)', 'alpha' ),
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'site_type',
							'operator' => '!=',
							'value'    => 'full',
						),
					),
				),
				'site_gap'                      => array(
					'section'         => 'general',
					'type'            => 'text',
					'label'           => esc_html__( 'Site Gap (px)', 'alpha' ),
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'site_type',
							'operator' => '!=',
							'value'    => 'full',
						),
					),
				),
				'site_bg'                       => array(
					'section'         => 'general',
					'type'            => 'background',
					'label'           => esc_html__( 'Site Background', 'alpha' ),
					'tooltip'         => esc_html__( 'Change background of outside the frame.', 'alpha' ),
					'default'         => '',
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'site_type',
							'operator' => '!=',
							'value'    => 'full',
						),
					),
				),
				'content_bg'                    => array(
					'section'   => 'general',
					'type'      => 'background',
					'label'     => esc_html__( 'Content Background', 'alpha' ),
					'default'   => '',
					'transport' => 'postMessage',
				),
				// General / Site Content
				'cs_general_content_title'      => array(
					'section' => 'general',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Site Content', 'alpha' ) . '</h3>',
				),
				'container'                     => array(
					'section'   => 'general',
					'type'      => 'text',
					'label'     => esc_html__( 'Container Width (px)', 'alpha' ),
					'transport' => 'postMessage',
				),
				'container_fluid'               => array(
					'section'   => 'general',
					'type'      => 'text',
					'label'     => esc_html__( 'Container Fluid Width (px)', 'alpha' ),
					'transport' => 'postMessage',
				),
				// Header & Footer
				'cs_header_title'               => array(
					'section' => 'header_footer',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Header', 'alpha' ) . '</h3><p style="margin-bottom: 20px; cursor: auto;">' . esc_html__( 'Create your header template and show it in Layout Builder', 'alpha' ) . '</p>' .
						(
							class_exists( 'Alpha_Builders' ) ?
							'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template&' . ALPHA_NAME . '_template_type=header' ) ) . '" target="_blank">' . esc_html__( 'Header Builder', 'alpha' ) . '</a>' :
							'<p>' . sprintf( esc_html__( 'Please install %s Core Plugin', 'alpha' ), ALPHA_DISPLAY_NAME ) . '</p>' .
							'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=default_plugins' ) ) . '" target="_blank">' . esc_html__( 'Install Plugins', 'alpha' ) . '</a>'
						) .
						'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ) . '" target="_blank">' . esc_html__( 'Layout Builder', 'alpha' ) . '</a>',
				),
				'cs_footer_title'               => array(
					'section' => 'header_footer',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Footer', 'alpha' ) . '</h3><p style="margin-bottom: 20px; cursor: auto;">' . esc_html__( 'Create your footer template and show it in Layout Builder', 'alpha' ) . '</p>' .
					(
						class_exists( 'Alpha_Builders' ) ?
						'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template&' . ALPHA_NAME . '_template_type=footer' ) ) . '" target="_blank">' :
						'<p>' . sprintf( esc_html__( 'Please install %s Core Plugin', 'alpha' ), ALPHA_DISPLAY_NAME ) . '</p>' .
							'<a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=default_plugins' ) ) . '" target="_blank">' . esc_html__( 'Install Plugins', 'alpha' ) . '</a>'
					) . esc_html__( 'Footer Builder', 'alpha' ) . '</a><a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ) . '" target="_blank">' . esc_html__( 'Layout Builder', 'alpha' ) . '</a>',
				),
				// Style / Color
				'cs_colors_title'               => array(
					'section' => 'color',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Colors', 'alpha' ) . '</h3>',
				),
				'primary_color'                 => array(
					'section'   => 'color',
					'type'      => 'color',
					'label'     => esc_html__( 'Primary Color', 'alpha' ),
					'choices'   => array(
						'alpha' => true,
					),
					'transport' => 'postMessage',
				),
				'secondary_color'               => array(
					'section'   => 'color',
					'type'      => 'color',
					'label'     => esc_html__( 'Secondary Color', 'alpha' ),
					'choices'   => array(
						'alpha' => true,
					),
					'transport' => 'postMessage',
				),
				'dark_color'                    => array(
					'section'   => 'color',
					'type'      => 'color',
					'label'     => esc_html__( 'Dark Color', 'alpha' ),
					'choices'   => array(
						'alpha' => true,
					),
					'transport' => 'postMessage',
				),
				'light_color'                   => array(
					'section'   => 'color',
					'type'      => 'color',
					'label'     => esc_html__( 'Light Color', 'alpha' ),
					'choices'   => array(
						'alpha' => true,
					),
					'transport' => 'postMessage',
				),
				'cs_skin_title'                 => array(
					'section' => 'color',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Skin', 'alpha' ) . '</h3>',
				),
				'rounded_skin'                  => array(
					'section' => 'color',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Rounded Skin', 'alpha' ),
					'tooltip' => esc_html__( 'Enable rounded border skin for banner, posts and so on.', 'alpha' ),
				),
				// Style / Typography
				'cs_typo_default_font'          => array(
					'section' => 'typo',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Default Typography', 'alpha' ) . '</h3>',
				),
				'typo_default'                  => array(
					'section'   => 'typo',
					'type'      => 'typography',
					'label'     => '',
					'transport' => 'postMessage',
				),
				'cs_typo_heading'               => array(
					'section' => 'typo',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Heading Typography', 'alpha' ) . '</h3>',
				),
				'typo_heading'                  => array(
					'section'   => 'typo',
					'type'      => 'typography',
					'label'     => '',
					'transport' => 'postMessage',
				),
				'cs_typo_custom_title'          => array(
					'section' => 'typo',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Custom Google Fonts', 'alpha' ) . '</h3>',
				),
				'cs_typo_custom_desc'           => array(
					'section' => 'typo',
					'type'    => 'custom',
					'default' => '<p style="margin: 0;">' . esc_html__( 'Select other google fonts to download', 'alpha' ) . '</p>',
				),
				'typo_custom_part'              => array(
					'section'   => 'typo',
					'type'      => 'radio-buttonset',
					'default'   => '1',
					'transport' => 'postMessage',
					'choices'   => array(
						'1' => esc_html__( 'Custom 1', 'alpha' ),
						'2' => esc_html__( 'Custom 2', 'alpha' ),
						'3' => esc_html__( 'Custom 3', 'alpha' ),
					),
				),
				'typo_custom1'                  => array(
					'section'         => 'typo',
					'type'            => 'typography',
					'label'           => esc_html__( 'Custom Font 1', 'alpha' ),
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'typo_custom_part',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'typo_custom2'                  => array(
					'section'         => 'typo',
					'type'            => 'typography',
					'label'           => esc_html__( 'Custom Font 2', 'alpha' ),
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'typo_custom_part',
							'operator' => '==',
							'value'    => '2',
						),
					),
				),
				'typo_custom3'                  => array(
					'section'         => 'typo',
					'type'            => 'typography',
					'label'           => esc_html__( 'Custom Font 3', 'alpha' ),
					'transport'       => 'postMessage',
					'active_callback' => array(
						array(
							'setting'  => 'typo_custom_part',
							'operator' => '==',
							'value'    => '3',
						),
					),
				),
				// Style / Title Bar
				'cs_ptb_bar_style_title'        => array(
					'section'   => 'title_bar',
					'type'      => 'custom',
					'label'     => '',
					'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Title Bar Style', 'alpha' ) . '</h3>',
					'transport' => 'postMessage',
				),
				'ptb_height'                    => array(
					'section'   => 'title_bar',
					'type'      => 'number',
					'label'     => esc_html__( 'Title Bar Height (px)', 'alpha' ),
					'transport' => 'postMessage',
				),

				'ptb_bg'                        => array(
					'section'   => 'title_bar',
					'type'      => 'background',
					'label'     => esc_html__( 'Title Bar Background', 'alpha' ),
					'transport' => 'postMessage',
				),
				'cs_ptb_typo_title'             => array(
					'section'   => 'title_bar',
					'type'      => 'custom',
					'label'     => '',
					'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Title Bar Typography', 'alpha' ) . '</h3>',
					'transport' => 'postMessage',
				),
				'typo_ptb_title'                => array(
					'section'   => 'title_bar',
					'type'      => 'typography',
					'label'     => esc_html__( 'Page Title', 'alpha' ),
					'transport' => 'postMessage',
				),
				'typo_ptb_subtitle'             => array(
					'section'   => 'title_bar',
					'type'      => 'typography',
					'label'     => esc_html__( 'Page Subtitle', 'alpha' ),
					'transport' => 'postMessage',
				),
				// Style / Breadcrumb
				'cs_ptb_breadcrumb_style_title' => array(
					'section'   => 'breadcrumb',
					'type'      => 'custom',
					'label'     => '',
					'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Breadcrumb', 'alpha' ) . '</h3>',
					'transport' => 'postMessage',
				),
				'ptb_home_icon'                 => array(
					'section'   => 'breadcrumb',
					'type'      => 'toggle',
					'label'     => esc_html__( 'Show Home Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'ptb_delimiter'                 => array(
					'section'   => 'breadcrumb',
					'type'      => 'text',
					'label'     => esc_html__( 'Breadcrumb Delimiter', 'alpha' ),
					'transport' => 'postMessage',
				),
				'typo_ptb_breadcrumb'           => array(
					'section'   => 'breadcrumb',
					'type'      => 'typography',
					'label'     => esc_html__( 'Breadcrumb Typography', 'alpha' ),
					'transport' => 'postMessage',
				),
				// Menus / Menu Labels
				'cs_menu_labels_title'          => array(
					'section' => 'menu_labels',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Menu Labels', 'alpha' ) . '</h3>',
				),
				'menu_labels'                   => array(
					'section'           => 'menu_labels',
					'type'              => 'text',
					'label'             => esc_html__( 'Menu Labels', 'alpha' ),
					'transport'         => 'refresh',
					'sanitize_callback' => 'wp_strip_all_tags',
				),
				'cs_menu_labels'                => array(
					'section' => 'menu_labels',
					'type'    => 'custom',
					'default' => $this->get_edit_menu_label_control(),
				),
				'cs_new_label'                  => array(
					'section' => 'menu_labels',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'New Label', 'alpha' ) . '</h3>',
				),
				'cs_new_menu_label'             => array(
					'section' => 'menu_labels',
					'type'    => 'custom',
					'default' => $this->get_new_menu_label_control(),
				),
				// Menus / Mobile Menu
				'cs_mobile_menu_title'          => array(
					'section'   => 'mobile_menu',
					'type'      => 'custom',
					'label'     => '',
					'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Menu', 'alpha' ) . '</h3><a class="button button-primary button-xlarge" style="margin-top: 20px" href="' . esc_url( admin_url( 'nav-menus.php?action=edit&menu=0' ) ) . '" target="_blank">' . esc_html__( 'Create New Menu', 'alpha' ) . '</a>',
					'transport' => 'postMessage',
				),
				'mobile_menu_items'             => array(
					'section'   => 'mobile_menu',
					'type'      => 'sortable',
					'label'     => esc_html__( 'Mobile Menus', 'alpha' ),
					'transport' => 'refresh',
					'choices'   => $this->get_menus(),
				),
				// Menus / Mobile Sticky Icon Bar
				'cs_mobile_bar_title'           => array(
					'section'   => 'mobile_bar',
					'type'      => 'custom',
					'label'     => '',
					'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Icon Bar', 'alpha' ) . '</h3>',
					'transport' => 'postMessage',
				),
				'mobile_bar_icons'              => array(
					'section'   => 'mobile_bar',
					'type'      => 'sortable',
					'label'     => esc_html__( 'Mobile Bar Icons', 'alpha' ),
					'transport' => 'refresh',
					'choices'   => array(
						'menu'     => esc_html__( 'Mobile Menu Toggle', 'alpha' ),
						'home'     => esc_html__( 'Home', 'alpha' ),
						'shop'     => esc_html__( 'Shop', 'alpha' ),
						'wishlist' => esc_html__( 'Wishlist', 'alpha' ),
						'account'  => esc_html__( 'Account', 'alpha' ),
						'compare'  => esc_html__( 'Compare', 'alpha' ),
						'cart'     => esc_html__( 'Cart', 'alpha' ),
						'search'   => esc_html__( 'Search', 'alpha' ),
						'top'      => esc_html__( 'To Top', 'alpha' ),
					),
				),
				'mobile_bar_menu_label'         => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Menu Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_menu_icon'          => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Menu Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_home_label'         => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Home Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_home_icon'          => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Home Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_shop_label'         => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Shop Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_shop_icon'          => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Shop Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_wishlist_label'     => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Wishlist Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_wishlist_icon'      => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Wishlist Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_account_label'      => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Account Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_account_icon'       => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Account Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_cart_label'         => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Cart Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_cart_icon'          => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Cart Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_search_label'       => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Search Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_search_icon'        => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'Search Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_top_label'          => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'To Top Label', 'alpha' ),
					'transport' => 'postMessage',
				),
				'mobile_bar_top_icon'           => array(
					'section'   => 'mobile_bar',
					'type'      => 'text',
					'label'     => esc_html__( 'To Top Icon', 'alpha' ),
					'transport' => 'postMessage',
				),
				// Blog / Blog Global / Excerpt
				'cs_post_type'                  => array(
					'section' => 'blog_global',
					'type'    => 'custom',
					'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Post Type', 'alpha' ) . '</h3>',
				),
				'post_type'                     => array(
					'section' => 'blog_global',
					'type'    => 'radio_image',
					'label'   => '',
					'choices' => apply_filters(
						'alpha_post_types',
						array(
							'default' => ALPHA_ASSETS . '/images/options/post/default.jpg', // @feature: fs_bt_default
							'mask'    => ALPHA_ASSETS . '/images/options/post/mask.jpg',    // @feature: fs_bt_mask
							'list'    => ALPHA_ASSETS . '/images/options/post/list.jpg',    // @feature: fs_bt_list
						),
						'theme'
					),
				),
				'post_overlay'                  => array(
					'section' => 'blog_global',
					'type'    => 'select',
					'label'   => esc_html__( 'Hover Effect', 'alpha' ),
					'choices' => array(
						''           => esc_html__( 'None', 'alpha' ),
						'light'      => esc_html__( 'Light', 'alpha' ),
						'dark'       => esc_html__( 'Dark', 'alpha' ),
						'zoom'       => esc_html__( 'Zoom', 'alpha' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'alpha' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'alpha' ),
					),
				),
				'cs_post_excerpt'               => array(
					'section' => 'blog_global',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Excerpt', 'alpha' ) . '</h3>',
				),
				'excerpt_type'                  => array(
					'section' => 'blog_global',
					'type'    => 'radio_buttonset',
					'label'   => esc_html__( 'Type', 'alpha' ),
					'choices' => array(
						''          => esc_html__( 'Word', 'alpha' ),
						'character' => esc_html__( 'Letter', 'alpha' ),
					),
				),
				'excerpt_length'                => array(
					'section' => 'blog_global',
					'type'    => 'number',
					'label'   => esc_html__( 'Length', 'alpha' ),
					'choices' => array(
						'min' => 0,
						'max' => 250,
					),
				),

				// Blog / Blog Page
				'cs_posts_title'                => array(
					'section' => 'blog_archive',
					'type'    => 'custom',
					'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Blog', 'alpha' ) . '</h3>',
				),
				'posts_layout'                  => array(
					'section' => 'blog_archive',
					'type'    => 'radio_buttonset',
					'label'   => esc_html__( 'Layout', 'alpha' ),
					'tooltip' => esc_html__( 'Masonry layout will use uncropped images.', 'alpha' ),
					'choices' => array(
						'grid'    => esc_html__( 'Grid', 'alpha' ),
						'masonry' => esc_html__( 'Masonry', 'alpha' ),
					),
				),
				'posts_column'                  => array(
					'section' => 'blog_archive',
					'type'    => 'number',
					'label'   => esc_html__( 'Column', 'alpha' ),
					'choices' => array(
						'min' => 1,
						'max' => 8,
					),
				),
				'posts_filter'                  => array(
					'section' => 'blog_archive',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Filter By Category', 'alpha' ),
				),
				'blog_ajax'                     => array(
					'section' => 'blog_archive',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Enable Ajax Filter', 'alpha' ),
				),
				'posts_load'                    => array(
					'section' => 'blog_archive',
					'type'    => 'radio_image',
					'label'   => esc_html__( 'Load More', 'alpha' ),
					'choices' => array(
						'button' => ALPHA_ASSETS . '/images/options/loadmore-btn.png',
						''       => ALPHA_ASSETS . '/images/options/loadmore-page.png',
						'scroll' => ALPHA_ASSETS . '/images/options/loadmore-scroll.png',
					),
				),

				// Blog / Blog Single
				'cs_post_title'                 => array(
					'section' => 'blog_single',
					'type'    => 'custom',
					'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Show Information', 'alpha' ) . '</h3>',
				),
				'post_show_info'                => array(
					'section' => 'blog_single',
					'type'    => 'multicheck',
					'label'   => esc_html__( 'Items to show', 'alpha' ),
					'choices' => array(
						'image'         => esc_html__( 'Media', 'alpha' ),
						'author'        => esc_html__( 'Meta Author', 'alpha' ),
						'date'          => esc_html__( 'Meta Date', 'alpha' ),
						'comment'       => esc_html__( 'Meta Comments Count', 'alpha' ),
						'category'      => esc_html__( 'Category', 'alpha' ),
						'tag'           => esc_html__( 'Tags', 'alpha' ),
						'author_info'   => esc_html__( 'Author Information', 'alpha' ),
						'share'         => esc_html__( 'Share', 'alpha' ),
						'navigation'    => esc_html__( 'Prev and Next', 'alpha' ),
						'related'       => esc_html__( 'Related Posts', 'alpha' ),
						'comments_list' => esc_html__( 'Comments', 'alpha' ),
					),
				),
				'cs_post_related_title'         => array(
					'section' => 'blog_single',
					'type'    => 'custom',
					'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Related Posts', 'alpha' ) . '</h3>',
				),
				'post_related_count'            => array(
					'section' => 'blog_single',
					'type'    => 'number',
					'label'   => esc_html__( 'Count', 'alpha' ),
					'choices' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'post_related_column'           => array(
					'section' => 'blog_single',
					'type'    => 'number',
					'label'   => esc_html__( 'Column', 'alpha' ),
					'choices' => array(
						'min' => 1,
						'max' => 6,
					),
				),
				'post_related_order'            => array(
					'section' => 'blog_single',
					'type'    => 'select',
					'label'   => esc_html__( 'Order By', 'alpha' ),
					'choices' => array(
						''              => esc_html__( 'Default', 'alpha' ),
						'ID'            => esc_html__( 'ID', 'alpha' ),
						'title'         => esc_html__( 'Title', 'alpha' ),
						'date'          => esc_html__( 'Date', 'alpha' ),
						'modified'      => esc_html__( 'Modified', 'alpha' ),
						'author'        => esc_html__( 'Author', 'alpha' ),
						'comment_count' => esc_html__( 'Comment count', 'alpha' ),
					),
				),
				'posts_related_orderway'        => array(
					'section' => 'blog_single',
					'type'    => 'radio_buttonset',
					'label'   => esc_html__( 'Order Way', 'alpha' ),
					'choices' => array(
						'ASC' => esc_html( 'ASC', 'alpha' ),
						''    => esc_html( 'DESC', 'alpha' ),
					),
				),
				// Custom CSS, JS
				'custom_css'                    => array(
					'section'   => 'custom_css_js',
					'type'      => 'code',
					'label'     => esc_html__( 'CSS code', 'alpha' ),
					'transport' => 'postMessage',
					'choices'   => array(
						'language' => 'css',
						'theme'    => 'monokai',
					),
				),

				/**
				 * Custom Image Size
				 */
				'cs_image_quality_title'        => array(
					'section' => 'images',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Image Quality and Threshold', 'alpha' ) . '</h3>',
				),
				'image_quality'                 => array(
					'section' => 'images',
					'type'    => 'number',
					'label'   => esc_html__( 'Image Quality', 'alpha' ),
					'tooltip' => esc_html__( 'Quality level between 0 (low) and 100 (high) of the JPEG. After changing this value, please install and run the Regenerate Thumbnails plugin once.', 'alpha' ),
					'choices' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'big_image_threshold'           => array(
					'section' => 'images',
					'type'    => 'number',
					'label'   => esc_html__( 'Big Image Size Threshold', 'alpha' ),
					'tooltip' => esc_html__( 'Threshold for image height and width in pixels. WordPress will scale down newly uploaded images to this values as max-width or max-height. Set to "0" to disable the threshold completely.', 'alpha' ),
					'choices' => array(
						'min' => 0,
					),
				),
				'cs_image_size_title'           => array(
					'section' => 'images',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Custom Image Size', 'alpha' ) . '</h3>',
				),
				'custom_image_size'             => array(
					'section' => 'images',
					'type'    => 'dimensions',
					'label'   => esc_html__( 'Register Custom Image Size (px)', 'alpha' ),
					'tooltip' => esc_html__( 'Don\'t forget to regenerate previously uploaded images.', 'alpha' ),
				),
				/**
				* Import/Export/Reset Options
				*/
				'cs_import_title'               => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Import Options', 'alpha' ) . '</h3>',
				),
				'import_src'                    => array(
					'section'   => 'reset_options',
					'type'      => 'custom',
					'transport' => 'postMessage',
					'label'     => esc_html__( 'Please select source option file to import', 'alpha' ),
					'default'   => '<input type="file">',
				),
				'cs_import_option'              => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'default' => '<button name="import" id="alpha-import-options" class="button button-primary" disabled>' . esc_html__( 'Import', 'alpha' ) . '</button>',
				),
				'cs_export_title'               => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Export Options', 'alpha' ) . '</h3>',
				),
				'cs_export_option'              => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'default' => '<p>' . esc_html__( 'Export theme options', 'alpha' ) . '</p><a href="' . esc_url( admin_url( 'admin-ajax.php?action=alpha_export_theme_options&wp_customize=on&nonce=' . wp_create_nonce( 'alpha-customizer' ) ) ) . '" name="export" id="alpha-export-options" class="button button-primary">' . esc_html__( 'Download Theme Options', 'alpha' ) . '</a>',
				),
				'cs_reset_title'                => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Reset Options', 'alpha' ) . '</h3>',
				),
				'cs_reset_option'               => array(
					'section' => 'reset_options',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<button name="reset" id="alpha-reset-options" class="button button-primary">' . esc_html__( 'Reset Theme Options', 'alpha' ) . '</button>',
				),

				/**
				 * SEO / Options
				 */
				'cs_nofollow_title'             => array(
					'section' => 'seo',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Use by search engines for ranking', 'alpha' ) . '</h3>',
				),
				'share_link_nofollow'           => array(
					'section' => 'seo',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Share &amp; Social Links', 'alpha' ),
				),
				'menu_item_nofollow'            => array(
					'section' => 'seo',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Mobile Menu Items', 'alpha' ),
				),

				/**
				* White Label / Options
				*/
				'cs_white_label_title'          => array(
					'section' => 'white_label',
					'type'    => 'custom',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'White Label', 'alpha' ) . '</h3>',
				),
				'white_label_title'             => array(
					'section' => 'white_label',
					'type'    => 'text',
					'label'   => esc_html__( 'White Label', 'alpha' ),
					'tooltip' => esc_html__( 'Theme name in AdminPanel', 'alpha' ),
				),
				'white_label_icon'              => array(
					'section' => 'white_label',
					'type'    => 'image',
					'label'   => esc_html__( 'White Icon', 'alpha' ),
					'tooltip' => esc_html__( 'Theme icon in Admin Menu and Admin Bar', 'alpha' ),
				),
				'white_label_logo'              => array(
					'section' => 'white_label',
					'type'    => 'image',
					'label'   => esc_html__( 'White Logo', 'alpha' ),
					'tooltip' => esc_html__( 'Theme logo in AdminPanel', 'alpha' ),
				),

				// Share
				'cs_share_icon_title'           => array(
					'section' => 'share',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Share Icons', 'alpha' ) . '</h3>',
				),
				'share_icons'                   => array(
					'section' => 'share',
					'type'    => 'sortable',
					'label'   => esc_html__( 'Share Icons', 'alpha' ),
					'choices' => $this->get_social_shares(),
				),
				'cs_share_icon_style_title'     => array(
					'section' => 'share',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Share Icons Style', 'alpha' ) . '</h3>',
				),
				'share_use_hover'               => array(
					'section' => 'share',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Live Color', 'alpha' ),
				),
				'share_type'                    => array(
					'section' => 'share',
					'type'    => 'radio_image',
					'label'   => esc_html__( 'Share Icon Type', 'alpha' ),
					'choices' => array(
						''        => ALPHA_ASSETS . '/images/options/share1.png',
						'stacked' => ALPHA_ASSETS . '/images/options/share3.png',
						'framed'  => ALPHA_ASSETS . '/images/options/share2.png',
					),
				),
				// Features / Social Login
				'cs_social_login_about_title'   => array(
					'section' => 'sociallogin',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'alpha' ) . '</h3>',
				),
				'cs_social_login_about_desc'    => array(
					'section' => 'sociallogin',
					'type'    => 'custom',
					'label'   => esc_html__( 'With this feature, customers could be allowed to login your site with famous social site\'s user information.', 'alpha' ),
					'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/social-login.jpg' . '" alt="Theme Option Descrpition Image"></p>',
				),
				'cs_social_login_title'         => array(
					'section' => 'sociallogin',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Social Login', 'alpha' ) . '</h3>',
				),
				'social_login'                  => array(
					'section' => 'sociallogin',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Enable Social Login', 'alpha' ),
					'tooltip' => esc_html__( 'Enable login by Nextend Social Login plugin.', 'alpha' ),
				),
				// Features / Lazyload
				'cs_lazyload_about_title'       => array(
					'section' => 'lazyload',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'alpha' ) . '</h3>',
				),
				'cs_lazyload_about_desc'        => array(
					'section' => 'lazyload',
					'type'    => 'custom',
					'label'   => esc_html__( 'All images will be lazyloaded when they come into screen.', 'alpha' ),
					'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/lazyload.jpg" alt="Theme Option Descrpition Image"></p>',
				),
				'cs_lazyload_title'             => array(
					'section' => 'lazyload',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Lazy Load', 'alpha' ) . '</h3>',
				),
				'loading_animation'             => array(
					'section' => 'lazyload',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Loading Overlay', 'alpha' ),
					'tooltip' => esc_html__( 'Display overlay animation while loading.', 'alpha' ),
				),
				'skeleton_screen'               => array(
					'section' => 'lazyload',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Skeleton Screen', 'alpha' ),
					'tooltip' => esc_html__( 'Display the virtual area of each element on page while loading.', 'alpha' ),
				),
				'lazyload_menu'                 => array(
					'section' => 'lazyload',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Menu Lazyload', 'alpha' ),
					'tooltip' => esc_html__( 'Menus will be saved in browsers after lazyload.', 'alpha' ),
				),
				'lazyload'                      => array(
					'section' => 'lazyload',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Images Lazyload', 'alpha' ),
					'tooltip' => esc_html__( 'All images will be lazyloaded.', 'alpha' ),
				),
				'lazyload_bg'                   => array(
					'section'         => 'lazyload',
					'type'            => 'color',
					'label'           => esc_html__( 'Lazyload Image Initial Color', 'alpha' ),
					'choices'         => array(
						'alpha' => true,
					),
					'active_callback' => array(
						array(
							'setting'  => 'lazyload',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				// Features / Search
				'cs_search_about_title'         => array(
					'section' => 'search',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'alpha' ) . '</h3>',
				),
				'cs_search_desc'                => array(
					'section' => 'search',
					'type'    => 'custom',
					'label'   => esc_html__( 'Without redirecting or entering search results page, you can get the results instantly and quickly.', 'alpha' ),
					'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/search.jpg' . '" alt="Theme Option Descrpition Image"></p>',
				),
				'cs_search_title'               => array(
					'section' => 'search',
					'type'    => 'custom',
					'label'   => '',
					'default' => '<h3 class="options-custom-title">' . esc_html__( 'Search', 'alpha' ) . '</h3>',
				),
				'live_search'                   => array(
					'section' => 'search',
					'type'    => 'toggle',
					'label'   => esc_html__( 'Live Search', 'alpha' ),
					'tooltip' => esc_html__( 'Search results will be displayed instantly.', 'alpha' ),
				),
				'live_relevanssi'               => array(
					'section'         => 'search',
					'type'            => 'toggle',
					'label'           => esc_html__( 'Use Relevanssi for Live Search', 'alpha' ),
					/* translators: 1. anchor tag open, 2. anchor tag close. */
					'tooltip'         => sprintf( esc_html__( 'You will need to install and activate this %1$splugin%2$s', 'alpha' ), '<a href="https://wordpress.org/plugins/relevanssi/" target="_blank">', '</a>' ),
					'active_callback' => array(
						array(
							'setting'  => 'live_search',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),
				'search_post_type'              => array(
					'section'         => 'search',
					'type'            => 'radio-buttonset',
					'transport'       => 'postMessage',
					'label'           => esc_html__( 'Search Post Type', 'alpha' ),
					'choices'         => array(
						''        => esc_html__( 'All', 'alpha' ),
						'product' => esc_html__( 'Product', 'alpha' ),
						'post'    => esc_html__( 'Post', 'alpha' ),
					),
					'active_callback' => array(
						array(
							'setting'  => 'live_search',
							'operator' => '!=',
							'value'    => '',
						),
					),
				),
			);

			if ( current_user_can( 'unfiltered_html' ) ) {
				$fields['custom_js'] = array(
					'section'   => 'custom_css_js',
					'type'      => 'code',
					'label'     => esc_html__( 'JS code', 'alpha' ),
					'transport' => 'postMessage',
					'choices'   => array(
						'language' => 'js',
						'theme'    => 'monokai',
					),
				);
			}

			if ( class_exists( 'WooCommerce' ) ) {

				$panels = array_merge(
					$panels,
					array(
						'woocommerce' => array(
							'title'    => esc_html__( 'WooCommerce', 'alpha' ),
							'priority' => 90,
						),
					)
				);

				$sections = array_merge(
					$sections,
					array(
						// Woocommerce
						'products_archive'     => array(
							'title'    => esc_html__( 'Shop', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 0,
						),
						'product_detail'       => array(
							'title'    => esc_html__( 'Single Product', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 0,
						),
						'product_type'         => array(
							'title'    => esc_html__( 'Product Type', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 0,
						),
						'category_type'        => array(
							'title'    => esc_html__( 'Category Type', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 0,
						),
						'woo_compare'          => array(
							'title'    => esc_html__( 'Compare', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 0,
						),
						// Product
						'product_instagram'    => array(
							'title'    => esc_html__( 'Instagram Photos', 'alpha' ),
							'panel'    => 'product',
							'priority' => 60,
						),
						// WooCommerce Panel
						'wc_cart'              => array(
							'title'    => esc_html__( 'Cart Page', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 20,
						),
						'woocommerce_checkout' => array(
							'title'    => esc_html__( 'Checkout', 'alpha' ),
							'panel'    => 'woocommerce',
							'priority' => 20,
						),
					)
				);

				$fields = array_merge(
					$fields,
					array(
						// Woocommerce / Shop
						'cs_products_grid'              => array(
							'section' => 'products_archive',
							'type'    => 'custom',
							'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Shop Products', 'alpha' ) . '</h3>',
						),
						'cs_shop_page_alert'            => array(
							'section' => 'products_archive',
							'type'    => 'custom',
							'label'   => '<p class="options-description"><span>Warning: </span>' . sprintf( esc_html__( 'Layout builder\'s "%1$sShop Layout%2$s / Content / Options" is prior than this theme options in shop page.', 'alpha' ), '<a target="_blank" href="' . esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ) . '">', '</a>' ) . '</p>',
						),
						'products_column'               => array(
							'section' => 'products_archive',
							'type'    => 'number',
							'label'   => esc_html__( 'Column', 'alpha' ),
							'choices' => array(
								'min' => 1,
								'max' => 8,
							),
						),
						'products_gap'                  => array(
							'section' => 'products_archive',
							'type'    => 'radio_buttonset',
							'label'   => esc_html__( 'Gap Size', 'alpha' ),
							'tooltip' => esc_html__( 'Choose gap size between products', 'alpha' ),
							'choices' => array(
								'no' => esc_html__( 'No', 'alpha' ),
								'xs' => esc_html__( 'XS', 'alpha' ),
								'sm' => esc_html__( 'S', 'alpha' ),
								''   => esc_html__( 'M', 'alpha' ),
								'lg' => esc_html__( 'L', 'alpha' ),
							),
						),
						'products_load'                 => array(
							'section' => 'products_archive',
							'type'    => 'radio_image',
							'label'   => esc_html__( 'Load More', 'alpha' ),
							'choices' => array(
								'button' => ALPHA_ASSETS . '/images/options/loadmore-btn.png',
								''       => ALPHA_ASSETS . '/images/options/loadmore-page.png',
								'scroll' => ALPHA_ASSETS . '/images/options/loadmore-scroll.png',
							),
						),
						'products_load_label'           => array(
							'section'         => 'products_archive',
							'type'            => 'text',
							'label'           => esc_html__( 'Load Button Label', 'alpha' ),
							'active_callback' => array(
								array(
									'setting'  => 'products_load',
									'operator' => '==',
									'value'    => 'button',
								),
							),
						),
						'products_count_select'         => array(
							'section' => 'products_archive',
							'type'    => 'text',
							'label'   => esc_html__( 'Showing Products for pagination', 'alpha' ),
							'tooltip' => esc_html__( 'Please input comma separated integers. Every integers will be shown as option of select box in product archive page. Integer with prefix "_" will be default count. e.g: 9, _12, 24, 36', 'alpha' ),
						),
						'cs_woo_ajax'                   => array(
							'section' => 'products_archive',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Load more and category ajax filter', 'alpha' ) . '</h3>
							<p>' . sprintf( esc_html__( 'You can customize ajax filter options in %1$sFeatures/Ajax Filter%2$s panel.', 'alpha' ), '<b>', '</b>' ) . '</p>' .
							'<a class="button button-primary button-xlarge customizer-nav-item" data-target="ajax_filter" data-type="section" href="#">' . esc_html__( 'Go to Ajax Filter', 'alpha' ) . '</a>',
						),
						// Woocommerce / Product Type
						'cs_product_type_title'         => array(
							'section' => 'product_type',
							'type'    => 'custom',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Product Type', 'alpha' ) . '</h3>',
						),
						'product_type'                  => array(
							'section' => 'product_type',
							'type'    => 'radio_image',
							'label'   => esc_html__( 'Product Type', 'alpha' ),
							'choices' => apply_filters(
								'alpha_product_loop_types',
								array(
									'product-1' => ALPHA_ASSETS . '/images/options/products/product-sm-1.jpg', // @feature: fs_pt_1
									'product-2' => ALPHA_ASSETS . '/images/options/products/product-sm-2.jpg', // @feature: fs_pt_2
									'product-3' => ALPHA_ASSETS . '/images/options/products/product-sm-3.jpg', // @feature: fs_pt_3
									'product-4' => ALPHA_ASSETS . '/images/options/products/product-sm-4.jpg', // @feature: fs_pt_4
									'product-5' => ALPHA_ASSETS . '/images/options/products/product-sm-5.jpg', // @feature: fs_pt_5
									'product-6' => ALPHA_ASSETS . '/images/options/products/product-sm-6.jpg', // @feature: fs_pt_6
									'product-7' => ALPHA_ASSETS . '/images/options/products/product-sm-7.jpg', // @feature: fs_pt_7
									'product-8' => ALPHA_ASSETS . '/images/options/products/product-sm-8.jpg', // @feature: fs_pt_8
								),
								'theme'
							),
						),
						'show_in_box'                   => array(
							'section' => 'product_type',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Show In Box', 'alpha' ),
						),
						'show_hover_shadow'             => array(
							'section' => 'product_type',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Box shadow on Hover', 'alpha' ),
						),
						'show_media_shadow'             => array(
							'section' => 'product_type',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Media Shadow Effect on Hover', 'alpha' ),
						),
						'hover_change'                  => array(
							'section' => 'product_type',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Change Image on Hover', 'alpha' ),
						),
						'prod_open_click_mob'           => array(
							'section' => 'product_type',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Open product on second click on mobile', 'alpha' ),
						),
						'cs_product_show_info'          => array(
							'section' => 'product_type',
							'type'    => 'custom',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Show Information', 'alpha' ) . '</h3>',
						),
						'show_info'                     => array(
							'section' => 'product_type',
							'type'    => 'multicheck',
							'label'   => esc_html__( 'Items to show', 'alpha' ),
							'tooltip' => esc_html__( 'This option works only when shop catalog mode is enabled.', 'alpha' ),
							'choices' => array(
								'category'     => esc_html__( 'Category', 'alpha' ),
								'label'        => esc_html__( 'Label', 'alpha' ),
								'custom_label' => esc_html__( 'Custom Label', 'alpha' ),
								'price'        => esc_html__( 'Price', 'alpha' ),
								'sold_by'      => esc_html__( 'Sold By', 'alpha' ),
								'rating'       => esc_html__( 'Rating', 'alpha' ),
								'attribute'    => esc_html__( 'Attribute Swatches', 'alpha' ),
								'addtocart'    => esc_html__( 'Add To Cart', 'alpha' ),
								'compare'      => esc_html__( 'Compare', 'alpha' ),
								'quickview'    => esc_html__( 'Quickview', 'alpha' ),
								'wishlist'     => esc_html__( 'Wishlist', 'alpha' ),
							),
						),
						'sold_by_label'                 => array(
							'section'         => 'product_type',
							'type'            => 'text',
							'label'           => esc_html__( 'Sold by Label', 'alpha' ),
							'default'         => esc_html__( 'Sold By', 'alpha' ),
							'active_callback' => array(
								array(
									'setting'  => 'show_info',
									'operator' => 'in',
									'value'    => array( 'sold_by' ),
								),
							),
						),
						'cs_product_excerpt'            => array(
							'section' => 'product_type',
							'type'    => 'custom',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Product Excerpt', 'alpha' ) . '</h3>',
						),
						'prod_excerpt_type'             => array(
							'section' => 'product_type',
							'type'    => 'radio_buttonset',
							'label'   => esc_html__( 'Type', 'alpha' ),
							'choices' => array(
								''          => esc_html__( 'Word', 'alpha' ),
								'character' => esc_html__( 'Letter', 'alpha' ),
							),
						),
						'prod_excerpt_length'           => array(
							'section' => 'product_type',
							'type'    => 'number',
							'label'   => esc_html__( 'Length', 'alpha' ),
							'choices' => array(
								'min' => 0,
								'max' => 250,
							),
						),
						'cs_product_quickview_title'    => array(
							'section' => 'product_type',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Quickview', 'alpha' ) . '</h3>
							<p>' . sprintf( esc_html__( 'You can customize quickview options in %1$sFeatures/Quickview%2$s panel.', 'alpha' ), '<b>', '</b>' ) . '</p>' .
							'<a class="button button-primary button-xlarge customizer-nav-item" data-target="quickview" data-type="section" href="#">' . esc_html__( 'Go to Quickview Options', 'alpha' ) . '</a>',
						),
						// Woocommerce / Category Type
						'cs_category_type_title'        => array(
							'section' => 'category_type',
							'type'    => 'custom',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Category Type', 'alpha' ) . ' </h3>',
						),
						'category_type'                 => array(
							'section' => 'category_type',
							'type'    => 'radio-image',
							'label'   => esc_html__( 'Category Type', 'alpha' ),
							'choices' => apply_filters(
								'alpha_pc_types',
								array(
									''          => ALPHA_ASSETS . '/images/options/categories/category-1.jpg',  // @feature: fs_pct_default
									'frame'     => ALPHA_ASSETS . '/images/options/categories/category-2.jpg',  // @feature: fs_pct_frame
									'banner'    => ALPHA_ASSETS . '/images/options/categories/category-3.jpg',  // @feature: fs_pct_banner
									'simple'    => ALPHA_ASSETS . '/images/options/categories/category-4.jpg',  // @feature: fs_pct_simple
									'icon'      => ALPHA_ASSETS . '/images/options/categories/category-5.jpg',  // @feature: fs_pct_icon
									'classic'   => ALPHA_ASSETS . '/images/options/categories/category-6.jpg',  // @feature: fs_pct_classic
									'classic-2' => ALPHA_ASSETS . '/images/options/categories/category-7.jpg',  // @feature: fs_pct_classic-2
									'ellipse'   => ALPHA_ASSETS . '/images/options/categories/category-8.jpg',  // @feature: fs_pct_ellipse
									'ellipse-2' => ALPHA_ASSETS . '/images/options/categories/category-9.jpg',  // @feature: fs_pct_ellipse-2
									'group'     => ALPHA_ASSETS . '/images/options/categories/category-10.jpg', // @feature: fs_pct_group
									'group-2'   => ALPHA_ASSETS . '/images/options/categories/category-11.jpg', // @feature: fs_pct_group-2
									'label'     => ALPHA_ASSETS . '/images/options/categories/category-12.jpg', // @feature: fs_pct_label
								),
								'theme'
							),
						),
						'subcat_cnt'                    => array(
							'section'         => 'category_type',
							'type'            => 'text',
							'label'           => esc_html__( 'Subcategory Count', 'alpha' ),
							'transport'       => 'refresh',
							'active_callback' => array(
								array(
									'setting'  => 'category_type',
									'operator' => 'in',
									'value'    => array( 'group', 'group-2' ),
								),
							),
						),
						'category_show_icon'            => array(
							'section'         => 'category_type',
							'type'            => 'toggle',
							'label'           => esc_html__( 'Show Icon', 'alpha' ),
							'transport'       => 'refresh',
							'active_callback' => array(
								array(
									'setting'  => 'category_type',
									'operator' => 'in',
									'value'    => array( 'icon', 'group', 'group-2' ),
								),
							),
						),
						'category_overlay'              => array(
							'section' => 'category_type',
							'type'    => 'select',
							'label'   => esc_html__( 'Hover Effect', 'alpha' ),
							'choices' => array(
								'no'         => esc_html__( 'None', 'alpha' ),
								'light'      => esc_html__( 'Light', 'alpha' ),
								'dark'       => esc_html__( 'Dark', 'alpha' ),
								'zoom'       => esc_html__( 'Zoom', 'alpha' ),
								'zoom_light' => esc_html__( 'Zoom and Light', 'alpha' ),
								'zoom_dark'  => esc_html__( 'Zoom and Dark', 'alpha' ),
							),
						),
						// Woocommerce / Compare
						'cs_woo_compare_advanced'       => array(
							'section' => 'woo_compare',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Compare', 'alpha' ) . '</h3>
							<p>' . sprintf( esc_html__( 'You can customize compare options in %1$sFeatures/Compare%2$s panel.', 'alpha' ), '<b>', '</b>' ) . '</p>' .
							'<a class="button button-primary button-xlarge customizer-nav-item" data-target="compare" data-type="section" href="#">' . esc_html__( 'Go to Compare Options', 'alpha' ) . '</a>',
						),
						// Features / Ajax Filter
						'cs_shop_ajax_about_title'      => array(
							'section' => 'ajax_filter',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'alpha' ) . '</h3>',
						),
						'cs_shop_ajax_about_desc'       => array(
							'section' => 'ajax_filter',
							'type'    => 'custom',
							'label'   => esc_html__( 'Make your page-speed faster than the others with modern ajax search feature.', 'alpha' ),
							'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/ajax-shop.jpg' . '" alt="Theme Option Descrpition Image"></p>',
						),
						'cs_shop_ajax_title'            => array(
							'section' => 'ajax_filter',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Ajax Filter', 'alpha' ) . '</h3>',
						),
						'shop_ajax'                     => array(
							'type'    => 'toggle',
							'label'   => esc_html__( 'Enable Ajax Filter', 'alpha' ),
							'section' => 'ajax_filter',
						),
						// Features / Quickview
						'cs_shop_quickview_about_title' => array(
							'section' => 'quickview',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'alpha' ) . '</h3>',
						),
						'cs_shop_quickview_desc'        => array(
							'section' => 'quickview',
							'type'    => 'custom',
							'label'   => esc_html__( 'Choose your favourite one of 3 quickview types - default, offcanvas or animate.', 'alpha' ),
							'default' => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . ALPHA_ASSETS . '/images/admin/customizer/quickview.jpg' . '" alt="Theme Option Descrpition Image"></p>',
						),
						'cs_quickview_title'            => array(
							'section' => 'quickview',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Quickview', 'alpha' ) . '</h3>',
						),
						'quickview_type'                => array(
							'section' => 'quickview',
							'type'    => 'radio-image',
							'label'   => esc_html__( 'Quickview Type', 'alpha' ),
							'choices' => array(
								''          => ALPHA_ASSETS . '/images/options/quickview-popup.jpg',
								'zoom'      => ALPHA_ASSETS . '/images/options/quickview-zoom.jpg',
								'offcanvas' => ALPHA_ASSETS . '/images/options/quickview-offcanvas.jpg',
							),
						),
						'quickview_thumbs'              => array(
							'section'         => 'quickview',
							'type'            => 'radio-image',
							'label'           => esc_html__( 'Thumbnails Position', 'alpha' ),
							'choices'         => array(
								'vertical'   => ALPHA_ASSETS . '/images/options/quickview1.png',
								'horizontal' => ALPHA_ASSETS . '/images/options/quickview2.png',
							),
							'active_callback' => array(
								array(
									'setting'  => 'quickview_type',
									'operator' => '!=',
									'value'    => 'offcanvas',
								),
							),
						),
						// Product Page / Product Layout
						'cs_product_layout'             => array(
							'section' => 'product_detail',
							'type'    => 'custom',
							'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Product Layout', 'alpha' ) . '</h3>',
						),
						'single_product_type'           => array(
							'section' => 'product_detail',
							'type'    => 'select',
							'label'   => esc_html__( 'Single Product Layout', 'alpha' ),
							'choices' => apply_filters(
								'alpha_sp_types',
								array(
									''              => esc_html__( 'Horizontal Thumbs', 'alpha' ),       // @feature: fs_spt_horizontal
									'vertical'      => esc_html__( 'Vertical Thumbs', 'alpha' ),         // @feature: fs_spt_vertical
									'grid'          => esc_html__( 'Grid Images', 'alpha' ),             // @feature: fs_spt_grid
									'masonry'       => esc_html__( 'Masonry', 'alpha' ),                 // @feature: fs_spt_masonry
									'gallery'       => esc_html__( 'Gallery', 'alpha' ),                 // @feature: fs_spt_gallery
									'sticky-info'   => esc_html__( 'Sticky Information', 'alpha' ),      // @feature: fs_spt_sticky-info
									'sticky-thumbs' => esc_html__( 'Sticky Thumbs', 'alpha' ),           // @feature: fs_spt_sticky-thumbs
									'sticky-both'   => esc_html__( 'Left &amp; Right Sticky', 'alpha' ), // @feature: fs_spt_sticky-both
								),
								'theme'
							),
							'tooltip' => esc_html__( 'Layout builder\'s "Product Detail Layout/Content/Single Product Type" option is prior than this.', 'alpha' ),
						),
						'single_product_sticky'         => array(
							'section' => 'product_detail',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Add To Cart Sticky', 'alpha' ),
						),
						'single_product_sticky_mobile'  => array(
							'section'         => 'product_detail',
							'type'            => 'toggle',
							'label'           => esc_html__( 'Add To Cart Sticky On Mobile', 'alpha' ),
							'active_callback' => array(
								array(
									'setting'  => 'single_product_sticky',
									'operator' => '==',
									'value'    => true,
								),
							),
						),

						// Product Page / Product Data / Custom Tab
						'cs_product_data'               => array(
							'section' => 'product_detail',
							'type'    => 'custom',
							'label'   => '<h3 class="options-custom-title">' . esc_html__( 'Product Data Type', 'alpha' ) . '</h3>',
						),
						'product_data_type'             => array(
							'section' => 'product_detail',
							'type'    => 'radio_buttonset',
							'label'   => esc_html__( 'Product Data Type', 'alpha' ),
							'choices' => array(
								'tab'       => esc_html__( 'Tab', 'alpha' ),
								'accordion' => esc_html__( 'Accordion', 'alpha' ),
								'section'   => esc_html__( 'Section', 'alpha' ),
							),
						),
						'product_description_title'     => array(
							'section'   => 'product_detail',
							'type'      => 'text',
							'label'     => esc_html__( 'Description Title', 'alpha' ),
							'transport' => 'postMessage',
						),
						'product_specification_title'   => array(
							'section'     => 'product_detail',
							'type'        => 'text',
							'label'       => esc_html__( 'Specification Title', 'alpha' ),
							'placeholder' => esc_html__( 'Specification', 'alpha' ),
							'transport'   => 'postMessage',
						),
						'product_reviews_title'         => array(
							'section'     => 'product_detail',
							'type'        => 'text',
							'label'       => esc_html__( 'Reviews Title', 'alpha' ),
							'placeholder' => esc_html__( 'Customer Reviews', 'alpha' ),
							'transport'   => 'postMessage',
						),

						// Product Page / Product Data / Custom Tab
						'cs_product_custom_tab'         => array(
							'section' => 'product_detail',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Custom Tab', 'alpha' ) . '</h3>',
						),
						'product_tab_title'             => array(
							'section'   => 'product_detail',
							'type'      => 'text',
							'label'     => esc_html__( 'Custom Tab Title', 'alpha' ),
							'tooltip'   => esc_html__( 'Show custom tab in all product pages.', 'alpha' ),
							'transport' => 'postMessage',
						),
						'product_tab_block'             => array(
							'section' => 'product_detail',
							'type'    => 'select',
							'label'   => esc_html__( 'Custom Tab Content ( Block Builder )', 'alpha' ),
							'choices' => empty( $alpha_templates['block'] ) ? array() : $custom_tab_block,
						),

						// Product Page / Related Products
						'cs_product_related'            => array(
							'section' => 'product_detail',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Related Products', 'alpha' ) . '</h3>',
						),
						'product_related_title'         => array(
							'section'   => 'product_detail',
							'type'      => 'text',
							'label'     => esc_html__( 'Title', 'alpha' ),
							'transport' => 'postMessage',
						),
						'product_related_count'         => array(
							'section' => 'product_detail',
							'type'    => 'number',
							'label'   => esc_html__( 'Count', 'alpha' ),
							'choices' => array(
								'min' => 1,
								'max' => 50,
							),
						),
						'product_related_column'        => array(
							'section' => 'product_detail',
							'type'    => 'number',
							'label'   => esc_html__( 'Column', 'alpha' ),
							'choices' => array(
								'min' => 1,
								'max' => 6,
							),
						),
						'product_related_order'         => array(
							'section' => 'product_detail',
							'type'    => 'select',
							'label'   => esc_html__( 'Order', 'alpha' ),
							'choices' => array(
								''              => esc_html__( 'Default', 'alpha' ),
								'ID'            => esc_html__( 'ID', 'alpha' ),
								'title'         => esc_html__( 'Title', 'alpha' ),
								'date'          => esc_html__( 'Date', 'alpha' ),
								'modified'      => esc_html__( 'Modified', 'alpha' ),
								'price'         => esc_html__( 'Price', 'alpha' ),
								'rand'          => esc_html__( 'Random', 'alpha' ),
								'rating'        => esc_html__( 'Rating', 'alpha' ),
								'popularity'    => esc_html__( 'popularity', 'alpha' ),
								'comment_count' => esc_html__( 'Comment count', 'alpha' ),
							),
						),
						'product_related_orderway'      => array(
							'section' => 'product_detail',
							'type'    => 'radio_buttonset',
							'label'   => esc_html__( 'Order Way', 'alpha' ),
							'choices' => array(
								'asc' => esc_html( 'ASC', 'alpha' ),
								''    => esc_html( 'DESC', 'alpha' ),
							),
						),
						// Product Page / Up-Sells Products
						'cs_product_upsells'            => array(
							'section' => 'product_detail',
							'type'    => 'custom',
							'label'   => '',
							'default' => '<h3 class="options-custom-title">' . esc_html__( 'Up-Sells Products', 'alpha' ) . '</h3>',
						),
						'product_upsells_title'         => array(
							'section'   => 'product_detail',
							'type'      => 'text',
							'label'     => esc_html__( 'Title', 'alpha' ),
							'transport' => 'postMessage',
						),
						'product_upsells_count'         => array(
							'section' => 'product_detail',
							'type'    => 'number',
							'label'   => esc_html__( 'Count', 'alpha' ),
							'choices' => array(
								'min' => 1,
								'max' => 50,
							),
						),
						'product_upsells_order'         => array(
							'section' => 'product_detail',
							'type'    => 'select',
							'label'   => esc_html__( 'Order', 'alpha' ),
							'choices' => array(
								''              => esc_html__( 'Default', 'alpha' ),
								'ID'            => esc_html__( 'ID', 'alpha' ),
								'title'         => esc_html__( 'Title', 'alpha' ),
								'date'          => esc_html__( 'Date', 'alpha' ),
								'modified'      => esc_html__( 'Modified', 'alpha' ),
								'price'         => esc_html__( 'Price', 'alpha' ),
								'rand'          => esc_html__( 'Random', 'alpha' ),
								'rating'        => esc_html__( 'Rating', 'alpha' ),
								'popularity'    => esc_html__( 'popularity', 'alpha' ),
								'comment_count' => esc_html__( 'Comment count', 'alpha' ),
							),
						),
						'product_upsells_orderway'      => array(
							'section' => 'product_detail',
							'type'    => 'radio_buttonset',
							'label'   => esc_html__( 'Order Way', 'alpha' ),
							'choices' => array(
								'asc' => esc_html__( 'ASC', 'alpha' ),
								''    => esc_html__( 'DESC', 'alpha' ),
							),
						),
						// WooCommerce Panel
						'cart_show_clear'               => array(
							'section' => 'wc_cart',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Show Clear Button', 'alpha' ),
							'tooltip' => esc_html__( 'Show clear cart button on cart page.', 'alpha' ),
						),
						'cart_auto_update'              => array(
							'section' => 'wc_cart',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Auto Update Quantity', 'alpha' ),
							'tooltip' => esc_html__( 'Automatically update on quantity change.', 'alpha' ),
						),
						'cart_show_qty'                 => array(
							'section' => 'wc_cart',
							'type'    => 'toggle',
							'label'   => esc_html__( 'Quantity Input in Mini Cart', 'alpha' ),
							'tooltip' => esc_html__( 'Show quantity input in mini-cart.', 'alpha' ),
						),
					)
				);

				if ( defined( 'ALPHA_FRAMEWORK_VENDORS' ) ) {
					$panels   = array_merge(
						$panels,
						array(
							'vendor' => array(
								'title'    => esc_html__( 'Vendor', 'alpha' ),
								'priority' => 70,
							),
						)
					);
					$sections = array_merge(
						$sections,
						array(
							// Vendor
							'vendor_store' => array(
								'title'    => esc_html__( 'Vendor Store', 'alpha' ),
								'panel'    => 'vendor',
								'priority' => 10,
							),
							'vendor_style' => array(
								'title'    => esc_html__( 'Vendor Style', 'alpha' ),
								'panel'    => 'vendor',
								'priority' => 20,
							),
							'vendor_tab'   => array(
								'title'    => esc_html__( 'Vendor Info Tab', 'alpha' ),
								'panel'    => 'vendor',
								'priority' => 30,
							),
						)
					);
					$fields   = array_merge(
						$fields,
						array(
							// Vendor / Vendor Store Page
							'cs_vendor_products_title'     => array(
								'section' => 'vendor_store',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Store Page', 'alpha' ) . '</h3>',
							),
							'vendor_products_column'       => array(
								'section' => 'vendor_store',
								'type'    => 'number',
								'label'   => esc_html__( 'Products Column', 'alpha' ),
								'choices' => array(
									'min' => 1,
									'max' => 6,
								),
							),
							// Vendor / Vendor Style
							'cs_vendor_dashboard_style_title' => array(
								'section' => 'vendor_style',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Dashboard', 'alpha' ) . '</h3>',
							),
							'vendor_style_option'          => array(
								'section' => 'vendor_style',
								'type'    => 'radio_buttonset',
								'label'   => esc_html__( 'Style', 'alpha' ),
								'tooltip' => esc_html__( 'Choose style for vendor pages', 'alpha' ),
								'default' => 'theme',
								'choices' => array(
									'theme'  => esc_html__( 'Theme Style', 'alpha' ),
									'plugin' => esc_html__( 'Plugin Style', 'alpha' ),
								),
							),
							// Vendor / Sold By Style
							'cs_vendor_sold_by_style'      => array(
								'section' => 'vendor_style',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Sold By Template', 'alpha' ) . '</h3>',
							),
							'vendor_soldby_style_option'   => array(
								'section' => 'vendor_style',
								'type'    => 'radio_buttonset',
								'label'   => esc_html__( 'Style', 'alpha' ),
								'tooltip' => esc_html__( 'Choose style of sold by template', 'alpha' ),
								'default' => 'theme',
								'choices' => array(
									'theme'  => esc_html__( 'Theme Style', 'alpha' ),
									'plugin' => esc_html__( 'Plugin Style', 'alpha' ),
								),
							),
							// Product Page / Product Data / Vendor Info Tab
							'cs_product_vendor_tab'        => array(
								'section' => 'vendor_tab',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Info Tab', 'alpha' ) . '</h3>',
							),
							'product_hide_vendor_tab'      => array(
								'section' => 'vendor_tab',
								'type'    => 'toggle',
								'label'   => esc_html__( 'Hide Vendor Info Tab', 'alpha' ),
							),
							'product_vendor_info_title'    => array(
								'section'         => 'vendor_tab',
								'type'            => 'text',
								'label'           => esc_html__( 'Vendor Info Title', 'alpha' ),
								'active_callback' => array(
									array(
										'setting'  => 'product_hide_vendor_tab',
										'operator' => '!=',
										'value'    => true,
									),
								),
							),
							// Product Page / Product Data / Vendor Info Tab
							'cs_product_vendor_info_tab'   => array(
								'section' => 'product_detail',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Info Tab', 'alpha' ) . '</h3>
															<p>' . sprintf( esc_html__( 'You can customize vendor info tab in %1$sVendor/Vendor Info Tab%2$s panel.', 'alpha' ), '<b>', '</b>' ) . '</p>' .
									'<a class="button button-primary button-xlarge customizer-nav-item" data-target="vendor_tab" data-type="section" href="#">' . esc_html__( 'Go to Vendor Info Tab Options', 'alpha' ) . '</a>',
							),
							'product_vendor_more_products' => array(
								'section' => 'product_detail',
								'type'    => 'custom',
								'label'   => '',
								'default' => '<h3 class="options-custom-title">' . esc_html__( 'Vendor More Products', 'alpha' ) . '</h3>
									<p>' . sprintf( esc_html__( 'You can customize vendor more products in %1$sVendor/Vendor More Products%2$s panel.', 'alpha' ), '<b>', '</b>' ) . '</p>' .
									'<a class="button button-primary button-xlarge customizer-nav-item" data-target="vendor_more_products" data-type="section" href="#">' . esc_html__( 'Go to Vendor More Products Options', 'alpha' ) . '</a>',
							),
						)
					);
				}
			}

			$panels = apply_filters( 'alpha_customize_panels', $panels );
			foreach ( $panels as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}

			$sections = apply_filters( 'alpha_customize_sections', $sections );
			foreach ( $sections as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}

			$fields = apply_filters( 'alpha_customize_fields', $fields );
			foreach ( $fields as $field => $settings ) {
				if ( ! isset( $settings['default'] ) ) {
					$settings['default'] = alpha_get_option( $field );
				}
				$settings['settings'] = $field;
				Kirki::add_field( 'option', $settings );
			}
		}

		public function selective_refresh( $customize ) {
			$customize->selective_refresh->add_partial(
				'selective-post-share',
				array(
					'selector'            => '.post-details .social-icons, .product-single .summary .social-icons',
					'settings'            => array( 'share_type', 'share_icons', 'share_use_hover' ),
					'container_inclusive' => true,
					'render_callback'     => function() {
						if ( function_exists( 'alpha_print_share' ) ) {
							alpha_print_share();
						}
					},
				)
			);
			// @start feature: fs_plugin_woocommerce
			if ( class_exists( 'WooCommerce' ) ) {
				$customize->selective_refresh->add_partial(
					'selective-breadcrumb',
					array(
						'selector'            => '.breadcrumb-container',
						'settings'            => array( 'ptb_home_icon', 'ptb_delimiter' ),
						'container_inclusive' => true,
						'render_callback'     => function() {
							alpha_breadcrumb();
						},
					)
				);
			}
			// @end feature: fs_plugin_woocommerce
		}

		// @start feature: fs_plugin_woocommerce
		/**
		 * Change placeholder image for product
		 *
		 * @since 1.0
		 */
		public function update_woocommerce_placeholder_image( $value, $old_value ) {
			update_option( 'woocommerce_placeholder_image', $value );
			return $value;
		}
		// @end feature: fs_plugin_woocommerce
	}
endif;

if ( class_exists( 'Kirki' ) ) {
	Alpha_Customizer::get_instance();
}

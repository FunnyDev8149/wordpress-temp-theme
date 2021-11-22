<?php
/**
 * Alpha Admin Page
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
if ( ! class_exists( 'Alpha_Admin' ) ) {
	class Alpha_Admin extends Alpha_Base {

		/**
		 * Check whether theme is activated or not.
		 *
		 * @var   bool
		 * @since 1.0
		 */
		private $checked_purchase_code;

		/**
		 * Activation url for checking license key.
		 *
		 * @var   string
		 * @since 1.0
		 */
		private $activation_url = ALPHA_SERVER_URI . 'dummy/api/includes/verify_purchase.php';

		/**
		 *
		 */
		public $admin_config;

		/**
		 * Constructor
		 *
		 * Add actions and filters for admin page.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			if ( is_admin_bar_showing() ) {
				add_action( 'wp_before_admin_bar_render', array( $this, 'add_wp_toolbar_menu' ) );
			}

			add_action( 'admin_menu', array( $this, 'custom_admin_menu_order' ) );
			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
			add_action( 'after_switch_theme', array( $this, 'reset_child_theme_options' ), 15 );

			if ( is_child_theme() && empty( alpha_get_option( 'container' ) ) ) {
				$parent_theme_options = get_option( 'theme_mods_' . ALPHA_NAME );
				update_option( 'theme_mods_' . get_option( 'stylesheet' ), $parent_theme_options );
			}
			add_action( 'admin_enqueue_scripts', array( $this, 'add_theme_update_url' ), 1001 );

			add_action( 'admin_init', array( $this, 'check_activation' ) );
			add_action( 'admin_init', array( $this, 'show_activation_notice' ) );
			add_action( 'admin_init', array( $this, 'add_admin_class' ) );

			if ( is_admin() ) {
				add_filter( 'pre_set_site_transient_update_themes', array( $this, 'pre_set_site_transient_update_themes' ) );
				add_filter( 'upgrader_pre_download', array( $this, 'upgrader_pre_download' ), 10, 3 );
				add_filter( 'wp_ajax_alpha_activation', array( $this, 'ajax_activation' ) );
			}

			$this->admin_config = array(
				'admin_navs'     => array(
					'dashboard'     => array(
						'icon'  => 'fas fa-tachometer-alt',
						'label' => esc_html__( 'Dashboard', 'alpha' ),
						'url'   => admin_url( 'admin.php?page=alpha' ),
					),
					'management'    => array(
						'icon'    => 'fas fa-cog',
						'label'   => esc_html__( 'Management', 'alpha' ),
						'submenu' => array(
							'setup_wizard'    => array(
								'label' => esc_html__( 'Setup Wizard', 'alpha' ),
								'icon'  => 'admin-svg-cog',
								'url'   => admin_url( 'admin.php?page=alpha-setup-wizard' ),
							),
							'optimize_wizard' => array(
								'label' => esc_html__( 'Optimize Wizard', 'alpha' ),
								'icon'  => 'admin-svg-rocket',
								'url'   => admin_url( 'admin.php?page=alpha-optimize-wizard' ),
							),
							'tools'           => array(
								'label' => esc_html__( 'Tools', 'alpha' ),
								'icon'  => 'admin-svg-tools',
								'url'   => admin_url( 'admin.php?page=alpha-tools' ),
							),
						),
					),
					'layouts'       => array(
						'icon'    => 'fas fa-layer-group',
						'label'   => esc_html__( 'Layouts', 'alpha' ),
						'submenu' => array(
							'layout_builder' => array(
								'label' => esc_html__( 'Layout Builder', 'alpha' ),
								'icon'  => 'admin-svg-cog',
								'url'   => admin_url( 'admin.php?page=alpha-layout-builder' ),
							),
						),
					),
					'theme_options' => array(
						'icon'  => 'admin-svg-brush',
						'label' => esc_html__( 'Theme Options', 'alpha' ),
						'url'   => admin_url( 'customize.php' ),
					),
				),
				'demos'          => array(
					'best_selling' => array(
						'demo1' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-1',
							'label' => 'Demo 1',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-1.jpg',
						),
						'demo2' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-2',
							'label' => 'Demo 2',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-2.jpg',
						),
						'demo3' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-3',
							'label' => 'Demo 3',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-3.jpg',
						),
						'demo4' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-4',
							'label' => 'Demo 4',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-4.jpg',
						),
						'demo5' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-5',
							'label' => 'Demo 5',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-5.jpg',
						),
					),
					'top_rated'    => array(
						'demo1' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-3',
							'label' => 'Demo 3',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-3.jpg',
						),
						'demo2' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-4',
							'label' => 'Demo 4',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-4.jpg',
						),
						'demo3' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-2',
							'label' => 'Demo 2',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-2.jpg',
						),
						'demo4' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-5',
							'label' => 'Demo 5',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-5.jpg',
						),
						'demo5' => array(
							'url'   => 'https://funny-wp.com/wordpress/wolmart/demo-1',
							'label' => 'Demo 1',
							'image' => 'https://funny-wp.com/wordpress/wolmart/landing/assets/images/demos/demo-1.jpg',
						),
					),
				),
				'social_links'   => array(
					'facebook'  => array(
						'label' => esc_html__( 'Facebook', 'alpha' ),
						'link'  => 'Facebook.com',
						'url'   => 'https://www.facebook.com/',
						'icon'  => 'fab fa-facebook-square',
						'color' => '#3b5999',
					),
					'twitter'   => array(
						'label' => esc_html__( 'Twitter', 'alpha' ),
						'link'  => 'Twitter.com',
						'url'   => 'https://www.twitter.com/',
						'icon'  => 'fab fa-twitter',
						'color' => '#00acee',
					),
					'instagram' => array(
						'label' => esc_html__( 'Instagram', 'alpha' ),
						'link'  => 'Instagram.com',
						'url'   => 'https://www.instagram.com/',
						'icon'  => 'fab fa-instagram',
						'color' => '#000000',
					),
					'wordpress' => array(
						'label' => esc_html__( 'WordPress', 'alpha' ),
						'link'  => 'WordPress.org',
						'url'   => 'https://wordpress.org/',
						'icon'  => 'fab fa-wordpress',
						'color' => '#0073aa',
					),
					'envato'    => array(
						'label' => esc_html__( 'Envato', 'alpha' ),
						'link'  => 'Themeforest.net',
						'url'   => 'https://themeforest.net/',
						'icon'  => 'icon-envato',
						'color' => '#81B441',
					),
				),
				'other_products' => array(
					'molla'   => array(
						'name'  => 'Molla',
						'url'   => 'https://funny-wp.com/wordpress/molla/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/molla.jpg',
					),
					'riode'   => array(
						'name'  => 'Riode',
						'url'   => 'https://funny-wp.com/wordpress/riode/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/riode.jpg',
					),
					'wolmart' => array(
						'name'  => 'Wolmart',
						'url'   => 'https://funny-wp.com/wordpress/wolmart/',
						'image' => ALPHA_ASSETS . '/images/admin/dashboard/wolmart.jpg',
					),
					'more'    => array(
						'name'       => 'Comming Soon...',
						'url'        => '#',
						'image'      => ALPHA_ASSETS . '/images/admin/dashboard/coming.jpg',
						'image_dark' => ALPHA_ASSETS . '/images/admin/dashboard/coming-dark.jpg',
					),
				),
				'sticky_links'   => array(
					'documentation' => array(
						'label' => esc_html__( 'Documentation', 'alpha' ),
						'url'   => ALPHA_SERVER_URI . 'documentation/',
						'icon'  => 'fas fa-info-circle',
					),
					'support'       => array(
						'label' => esc_html__( 'Support', 'alpha' ),
						'url'   => 'https://funny-wp.com/support/',
						'icon'  => 'fas fa-comments',
					),
					'reviews'       => array(
						'label' => esc_html__( 'Reviews', 'alpha' ),
						'url'   => 'https://themeforest.net/downloads/',
						'icon'  => 'fas fa-star',
					),
					'buynow'        => array(
						'label' => esc_html__( 'Buy now!', 'alpha' ),
						'url'   => 'https://funny-wp.com/buynow/' . ALPHA_NAME . 'wp',
						'icon'  => 'fas fa-shopping-cart',
					),
				),
			);
			if ( class_exists( 'Alpha_Builders' ) ) {
				$this->admin_config['admin_navs']['layouts']['submenu']['templates'] = array(
					'label' => esc_html__( 'Templates', 'alpha' ),
					'icon'  => 'admin-svg-templates',
					'url'   => admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ),
				);
			}
			if ( class_exists( 'Alpha_Sidebar_Builder' ) ) {
				$this->admin_config['admin_navs']['layouts']['submenu']['sidebars'] = array(
					'label' => esc_html__( 'Sidebars', 'alpha' ),
					'icon'  => 'admin-svg-sidebars',
					'url'   => admin_url( 'admin.php?page=alpha_sidebar' ),
				);
			}
			$this->admin_config = apply_filters( 'alpha_admin_config', $this->admin_config );

		}

		/**
		 * Add alpha-admin-page class to body tag.
		 *
		 * @since 1.0
		 */
		public function add_admin_class() {
			if ( ( isset( $_REQUEST['page'] ) && 'alpha' == substr( $_REQUEST['page'], 0, 5 ) ) || ( isset( $_REQUEST['post_type'] ) && ALPHA_NAME . '_template' == $_REQUEST['post_type'] ) ) {
				add_filter(
					'admin_body_class',
					function() {
						if ( 'dark' == ALPHA_ADMIN_SKIN ) {
							return 'alpha-admin-page dark-version';
						} else {
							return 'alpha-admin-page light-version';
						}
					}
				);
			}
		}

		/**
		 * Check Theme Activation Status
		 *
		 * @since 1.0
		 */
		public function ajax_activation() {
			if ( ! check_ajax_referer( 'alpha-admin', 'nonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__( 'Nonce Error', 'alpha' ),
					)
				);
			}
			$this->check_activation();
			$this->show_activation_notice();
			require_once ALPHA_FRAMEWORK_PATH . '/admin/panel/views/activation.php';
			die();
		}

		/**
		 * Add Alpha menu items to WordPress admin menu.
		 *
		 * @since 1.0
		 */
		public function add_wp_toolbar_menu() {

			$target = is_admin() ? '_self' : '_blank';

			if ( current_user_can( 'edit_theme_options' ) ) {

				$title = esc_html( alpha_get_option( 'white_label_title' ) );
				$icon  = esc_html( alpha_get_option( 'white_label_icon' ) );
				$this->add_wp_toolbar_menu_item(
					'<span class="ab-icon dashicons ' . ( ! $icon ? 'dashicons-alpha-logo">' : 'custom-mini-logo"><img src="' . $icon . '" alt="logo" width="20" height="20" />' ) . '</span><span class="ab-label">' . ( $title ? $title : ALPHA_DISPLAY_NAME ) . '</span>',
					false,
					esc_url( admin_url( 'admin.php?page=alpha' ) ),
					array(
						'class'  => 'alpha-menu',
						'target' => $target,
					),
					'alpha'
				);

				// License

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Dashboard', 'alpha' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha' ) ),
					array(
						'target' => $target,
					)
				);

				// Theme Options

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Theme Options', 'alpha' ),
					'alpha',
					esc_url( admin_url( 'customize.php' ) ),
					array(
						'target' => $target,
					)
				);

				// Management Submenu

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Management', 'alpha' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
					array(
						'target' => $target,
					),
					'alpha_management'
				);

				if ( class_exists( 'Alpha_Setup_Wizard' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Setup Wizard', 'alpha' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Status', 'alpha' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Child Theme', 'alpha' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=customize' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Plugins', 'alpha' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=default_plugins' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup_plugins'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Demo', 'alpha' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=demo_content' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Ready', 'alpha' ),
						'alpha_setup',
						esc_url( admin_url( 'admin.php?page=alpha-setup-wizard&step=ready' ) ),
						array(
							'target' => $target,
						),
						'alpha_setup_ready'
					);
				}
				if ( class_exists( 'Alpha_Optimize_Wizard' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Optimize Wizard', 'alpha' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard' ) ),
						array(
							'target' => $target,
						),
						'alpha_optimize'
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Resources', 'alpha' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Lazyload', 'alpha' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=lazyload' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Performance', 'alpha' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=performance' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Plugins', 'alpha' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=plugins' ) ),
						array(
							'target' => $target,
						)
					);
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Ready', 'alpha' ),
						'alpha_optimize',
						esc_url( admin_url( 'admin.php?page=alpha-optimize-wizard&step=ready' ) ),
						array(
							'target' => $target,
						)
					);
				}
				if ( class_exists( 'Alpha_Tools' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Tools', 'alpha' ),
						'alpha_management',
						esc_url( admin_url( 'admin.php?page=alpha-tools' ) ),
						array(
							'target' => $target,
						)
					);
				}

				// Layouts Submenu

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Layouts', 'alpha' ),
					'alpha',
					esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ),
					array(
						'target' => $target,
					),
					'alpha_layouts'
				);

				$this->add_wp_toolbar_menu_item(
					esc_html__( 'Layout Builder', 'alpha' ),
					'alpha_layouts',
					esc_url( admin_url( 'admin.php?page=alpha-layout-builder' ) ),
					array(
						'target' => $target,
					)
				);

				if ( class_exists( 'Alpha_Builders' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'All Templates', 'alpha' ),
						'alpha_layouts',
						esc_url( admin_url( 'edit.php?post_type=' . ALPHA_NAME . '_template' ) ),
						array(
							'target' => $target,
						)
					);
				}
				if ( class_exists( 'Alpha_Sidebar_Builder' ) ) {
					$this->add_wp_toolbar_menu_item(
						esc_html__( 'Sidebars', 'alpha' ),
						'alpha_layouts',
						esc_url( admin_url( 'admin.php?page=alpha_sidebar' ) ),
						array(
							'target' => $target,
						)
					);
				}

				if ( class_exists( 'Alpha_Builders' ) ) {

					global $alpha_layout;

					if ( ! empty( $alpha_layout['used_blocks'] ) && count( $alpha_layout['used_blocks'] ) ) {

						$used_templates = $alpha_layout['used_blocks'];

						foreach ( $used_templates as $template_id => $data ) {

							$template_type = get_post_meta( $template_id, ALPHA_NAME . '_template_type', true );
							if ( ! $template_type ) {
								$template_type = 'block';
							}

							$template = get_post( $template_id );

							if ( alpha_get_feature( 'fs_pb_elementor' ) && defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $template_id, '_elementor_edit_mode', true ) ) {
								$edit_link = admin_url( 'post.php?post=' . $template_id . '&action=elementor' );
							} else {
								$edit_link = admin_url( 'post.php?post=' . $template_id . '&action=edit' );
							}

							if ( $template ) {
								$this->add_wp_toolbar_menu_item(
									// translators: %s represents template title.
									'<span class="alpha-ab-template-title">' . sprintf( esc_html__( 'Edit %s', 'alpha' ), $template->post_title ) . '</span><span class="alpha-ab-template-type">' . str_replace( '_', ' ', $template_type ) . '</span>',
									'edit',
									esc_url( $edit_link ),
									array(
										'target' => $target,
									),
									'edit_' . ALPHA_NAME . '_template_' . $template_id
								);
							}
						}
					}
				}

				// Activate Theme
				if ( ! $this->is_registered() ) {
					$this->add_wp_toolbar_menu_item(
						'<span class="ab-icon dashicons dashicons-admin-network"></span><span class="ab-label">' . esc_html__( 'Activate Theme', 'alpha' ) . '</span>',
						false,
						esc_url( admin_url( 'admin.php?page=alpha' ) ),
						array(
							'class'  => 'alpha-menu',
							'target' => $target,
						),
						'alpha-activate'
					);
				}

				do_action( 'alpha_add_wp_toolbar_menu', $this );
			}
		}

		/**
		 * Add Alpha menu items to WordPress admin menu.
		 *
		 * @param string $title         Title of menu item
		 * @param string $parent        Parent Menu id
		 * @param string $href          Link of menu item
		 * @param array  $custom_meta   Metadata for link
		 * @param string $custom_id     Menu id
		 * @since 1.0
		 */
		public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {
			global $wp_admin_bar;
			if ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
					return;
				}
				// Set custom ID
				if ( $custom_id ) {
					$id = $custom_id;
				} else { // Generate ID based on $title
					$id = strtolower( str_replace( ' ', '-', $title ) );
				}
				// links from the current host will open in the current window
				$meta = strpos( $href, home_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new $targetw

				$meta = array_merge( $meta, $custom_meta );
				$wp_admin_bar->add_node(
					array(
						'parent' => $parent,
						'id'     => $id,
						'title'  => $title,
						'href'   => $href,
						'meta'   => $meta,
					)
				);
			}
		}

		/**
		 * Change admin menu order.
		 *
		 * @since 1.0
		 */
		public function custom_admin_menu_order() {
			global $menu;

			$admin_menus = array();

			// Change dasbhoard menu order.
			$posts = array();
			$idx   = 0;
			foreach ( $menu as $key => $menu_item ) {
				if ( 'Posts' == $menu_item[0] ) {
					$admin_menus[9] = $menu_item;
				} elseif ( 'separator1' == $menu_item[2] ) {
					$admin_menus[8] = $menu_item;
				} else {
					$admin_menus[ $key ] = $menu_item;
				}
			}

			$menu = $admin_menus;
		}

		/**
		 * Check purchase code for license.
		 *
		 * @return string Return checking value of purchase code. e.g: verified, unregister and invalid.
		 * @since 1.0
		 */
		public function check_purchase_code() {

			if ( ! $this->checked_purchase_code ) {
				$code         = isset( $_POST['code'] ) ? sanitize_text_field( $_POST['code'] ) : '';
				$code_confirm = $this->get_purchase_code();

				if ( isset( $_POST['form_action'] ) && ! empty( $_POST['form_action'] ) ) {
					if ( 'unregister' == $_POST['form_action'] && $code != $code_confirm ) {
						if ( $code_confirm ) {
							$result = $this->curl_purchase_code( $code_confirm, 'remove' );
						}
						if ( $result && isset( $result['result'] ) && 3 == (int) $result['result'] ) {
							$this->checked_purchase_code = 'unregister';
							$this->set_purchase_code( '' );
							delete_transient( 'alpha_purchase_code_error_msg' );
							if ( isset( $_COOKIE['alpha_dismiss_code_error_msg'] ) ) {
								setcookie( 'alpha_dismiss_code_error_msg', '', time() - 3600 );
							}
							return $this->checked_purchase_code;
						}
					}
					if ( $code ) {
						$result = $this->curl_purchase_code( $code, 'add' );
						if ( ! $result ) {
							$this->checked_purchase_code = 'invalid';
							$code_confirm                = '';
						} elseif ( isset( $result['result'] ) && 1 == (int) $result['result'] ) {
							$code_confirm                = $code;
							$this->checked_purchase_code = 'verified';
						} else {
							$this->checked_purchase_code = $this->get_api_message( $result['message'] );
							$code_confirm                = '';
						}
					} else {
						$code_confirm                = '';
						$this->checked_purchase_code = '';
					}
					$this->set_purchase_code( $code_confirm );
				} else {
					if ( $code && $code_confirm && $code == $code_confirm ) {
						$this->checked_purchase_code = 'verified';
					}
				}
			}
			return $this->checked_purchase_code;
		}

		/**
		 * Get api message to activate license.
		 *
		 * @param  string $msg_code  Messaeg code
		 * @return string Return msg to response for activating license.
		 * @since 1.0
		 */
		public function get_api_message( $msg_code ) {
			if ( 'blocked_spam' == $msg_code ) {
				return esc_html__( 'Your ip address is blocked as spam!!!', 'alpha' );
			} elseif ( 'code_invalid' == $msg_code ) {
				return esc_html__( 'Purchase Code is not valid!!!', 'alpha' );
			} elseif ( 'already_used' == $msg_code && ! empty( $data['domain'] ) ) {
				return sprintf( esc_html__( 'This code was already used in %s', 'alpha' ), $data['domain'] );
			} elseif ( 'reactivate' == $msg_code ) {
				return esc_html__( 'Please re-activate the theme.', 'alpha' );
			} elseif ( 'unregistered' == $msg_code ) {
				return ALPHA_DISPLAY_NAME . esc_html__( ' Theme is unregistered!', 'alpha' );
			} elseif ( 'activated' == $msg_code ) {
				return ALPHA_DISPLAY_NAME . esc_html__( ' Theme is activated!', 'alpha' );
			} elseif ( 'p_blocked' == $msg_code ) { //permanetly blocked
				return sprintf( esc_html__( 'You are using illegal version now. Please purchase legal version %1$shere%2$s.', 'alpha' ), '<a href="' . $this->admin_config['sticky_links']['buynow']['url'] . '" target="_blank">', '</a>' );
			} elseif ( 's_blocked' == $msg_code ) { // soft blocked
				return sprintf( esc_html__( 'Your purchase code is temporarily blocked. Please contact us %1$shere%2$s to unblock it.', 'alpha' ), '<a href="' . $this->admin_config['sticky_links']['support']['url'] . '" target="_blank">', '</a>' );
			}
			return '';
		}

		/**
		 * Get curl purchase code.
		 *
		 * @param  string $code       License code
		 * @param  string $domain     Theme user domain for license.
		 * @param  string $act        Actions for purchase code. e.g: 'add' or 'remove'
		 * @return string Result code
		 *
		 * @since 1.0
		 */
		public function curl_purchase_code( $code, $act ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api = new Alpha_Importer_API();

			$result = $importer_api->get_response( $this->activation_url . '?item=' . ALPHA_ENVATO_CODE . "&code=$code&act=$act" );

			if ( ! $result ) {
				return false;
			}
			if ( is_wp_error( $result ) ) {
				return array( 'message' => $result->get_error_message() );
			}
			return $result;
		}

		/**
		 * Get purchase code.
		 *
		 * @return string Return purchase code if registed.
		 * @since 1.0
		 */
		public function get_purchase_code() {
			if ( $this->is_envato_hosted() ) {
				return SUBSCRIPTION_CODE;
			}
			return get_option( 'envato_purchase_code_' . ALPHA_ENVATO_CODE );
		}

		/**
		 * Get whether theme is activated or not.
		 *
		 * @return bool True if registed, false not.
		 * @since 1.0
		 */
		public function is_registered() {
			if ( $this->is_envato_hosted() ) {
				return true;
			}
			return get_option( 'alpha_registered' );
		}

		/**
		 * Store purchase code to option table.
		 *
		 * @param string $code Verified purchase code.
		 * @since 1.0
		 */
		public function set_purchase_code( $code ) {
			update_option( 'envato_purchase_code_' . ALPHA_ENVATO_CODE, $code );
		}

		/**
		 * Is envato hosted ?
		 *
		 * @return bool True if defined, false not.
		 * @since 1.0
		 */
		public function is_envato_hosted() {
			return defined( 'ENVATO_HOSTED_KEY' ) ? true : false;
		}

		/**
		 * Get ish
		 *
		 * @return bool|string Host key code if defined, false not.
		 * @since 1.0
		 */
		public function get_ish() {
			if ( ! defined( 'ENVATO_HOSTED_KEY' ) ) {
				return false;
			}
			return substr( ENVATO_HOSTED_KEY, 0, 16 );
		}

		/**
		 * Get virtual code for displaying purchase code.
		 *
		 * @return string Return virtual code.
		 * @since 1.0
		 */
		public function get_purchase_code_asterisk() {
			$code = $this->get_purchase_code();
			if ( $code ) {
				$code = substr( $code, 0, 13 );
				$code = $code . '-****-****-************';
			}
			return $code;
		}

		/**
		 * Adjust transient before setting for update themes.
		 *
		 * @param array $transient Values for setting transient
		 * @return array Filtered transient.
		 */
		public function pre_set_site_transient_update_themes( $transient ) {
			if ( ! $this->is_registered() ) {
				return $transient;
			}
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api   = new Alpha_Importer_API();
			$new_version    = $importer_api->get_latest_theme_version();
			$theme_template = get_template();
			if ( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {

				$args = $importer_api->generate_args( false );
				if ( $this->is_envato_hosted() ) {
					$args['ish'] = $this->get_ish();
				}

				$transient->response[ $theme_template ] = array(
					'theme'       => $theme_template,
					'new_version' => $new_version,
					'url'         => $importer_api->get_url( 'changelog' ),
					'package'     => add_query_arg( $args, $importer_api->get_url( 'theme' ) ),
				);

			}
			return $transient;
		}

		/**
		 * Filters whether to return the package.
		 *
		 * @param  bool        $reply   Whether to bail without returning the package. Default false.
		 * @param  string      $package The package file name.
		 * @param  WP_Upgrader $obj     The instance
		 * @return bool                 Returning package.
		 */
		public function upgrader_pre_download( $reply, $package, $obj ) {

			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
			$importer_api = new Alpha_Importer_API();
			if ( strpos( $package, $importer_api->get_url( 'theme' ) ) !== false || strpos( $package, $importer_api->get_url( 'plugins' ) ) !== false ) {
				if ( ! $this->is_registered() ) {
					return new WP_Error( 'not_registerd', sprintf( esc_html__( 'Please %s theme to get access to pre-built demo websites and auto updates.', 'alpha' ), '<a href="admin.php?page=alpha">' . esc_html__( 'register', 'alpha' ) . '</a> ' . ALPHA_DISPLAY_NAME ) );
				}
				$code   = $this->get_purchase_code();
				$result = $this->curl_purchase_code( $code, 'add' );
				if ( ! isset( $result['result'] ) || 1 !== (int) $result['result'] ) {
					$message = isset( $result['message'] ) ? $result['message'] : esc_html__( 'Purchase Code is not valid or could not connect to the API server!', 'alpha' );
					return new WP_Error( 'purchase_code_invalid', esc_html( $message ) );
				}
			}
			return $reply;
		}

		/**
		 * Add theme update url.
		 *
		 * @since 1.0
		 */
		public function add_theme_update_url() {
			global $pagenow;
			if ( 'update-core.php' == $pagenow ) {
				require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
				$importer_api   = new Alpha_Importer_API();
				$new_version    = $importer_api->get_latest_theme_version();
				$theme_template = get_template();
				if ( version_compare( ALPHA_VERSION, $new_version, '<' ) ) {
					$url         = $importer_api->get_url( 'changelog' );
					$checkbox_id = md5( wp_get_theme( $theme_template )->get( 'Name' ) );
					wp_add_inline_script( 'alpha-admin', 'if (jQuery(\'#checkbox_' . $checkbox_id . '\').length) {jQuery(\'#checkbox_' . $checkbox_id . '\').closest(\'tr\').children().last().append(\'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_js( esc_html__( 'View Details', 'alpha' ) ) . '</a>\');}' );
				}
			}
		}

		/**
		 * Clear transients after switching theme.
		 *
		 * @since 1.0
		 */
		public function after_switch_theme() {
			if ( $this->is_registered() ) {
				$this->refresh_transients();
			}
		}

		/**
		 * Reset child theme's options.
		 *
		 * @since 1.0
		 */
		public function reset_child_theme_options() {
			if ( is_child_theme() && empty( alpha_get_option( 'container' ) ) ) {
				update_option( 'theme_mods_' . get_option( 'stylesheet' ), get_option( 'theme_mods_' . ALPHA_NAME ) );
			}
		}

		/**
		 * Clear transients
		 *
		 * @since 1.0
		 */
		public function refresh_transients() {
			delete_site_transient( 'alpha_plugins' );
			delete_site_transient( 'update_themes' );
			unset( $_COOKIE['alpha_dismiss_activate_msg'] );
			setcookie( 'alpha_dismiss_activate_msg', null, -1, '/' );
			delete_transient( 'alpha_purchase_code_error_msg' );
			setcookie( 'alpha_dismiss_code_error_msg', '', time() - 3600 );
		}

		/**
		 * Show activation notices.
		 *
		 * @since 1.0
		 */
		public function activation_notices() {
			?>
			<div class="notice error notice-error is-dismissible">
				<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
				<p><?php printf( esc_html__( 'Please %1$sregister%2$s alpha theme to get access to pre-built demo websites and auto updates.', 'alpha' ), '<a href="admin.php?page=alpha">', '</a>' ); ?></p>
				<?php /* translators: $1 and $2 opening and closing strong tags respectively, and $3 and $4 are opening and closing anchor tags respectively */ ?>
				<p><?php printf( esc_html__( '%1$s Important! %2$s One %3$s standard license %4$s is valid for only %1$s1 website%2$s. Running multiple websites on a single license is a copyright violation.', 'alpha' ), '<strong>', '</strong>', '<a target="_blank" href="https://themeforest.net/licenses/standard">', '</a>' ); ?></p>
				<button type="button" class="notice-dismiss alpha-notice-dismiss"><span class="screen-reader-text"><?php esc_html__( 'Dismiss this notice.', 'alpha' ); ?></span></button>
			</div>
			<script>
				(function($) {
					var setCookie = function (name, value, exdays) {
						var exdate = new Date();
						exdate.setDate(exdate.getDate() + exdays);
						var val = encodeURIComponent(value) + ((null === exdays) ? "" : "; expires=" + exdate.toUTCString());
						document.cookie = name + "=" + val;
					};
					$(document).on('click.alpha-notice-dismiss', '.alpha-notice-dismiss', function(e) {
						e.preventDefault();
						var $el = $(this).closest('.notice');
						$el.fadeTo( 100, 0, function() {
							$el.slideUp( 100, function() {
								$el.remove();
							});
						});
						setCookie('alpha_dismiss_activate_msg', '<?php echo ALPHA_VERSION; ?>', 30);
					});
				})(window.jQuery);
			</script>
			<?php
		}

		/**
		 * Show activation message.
		 *
		 * @since 1.0
		 */
		public function activation_message() {
			?>
			<script>
				(function($){
					$(window).on( 'load', function() {
						<?php /* translators: $1 and $2 are opening and closing anchor tags respectively */ ?>
						$('.themes .theme.active .theme-screenshot').after('<div class="notice update-message notice-error notice-alt"><p><?php printf( esc_html__( 'Please %1$sverify purchase%2$s to get updates!', 'alpha' ), '<a href="admin.php?page=alpha" class="button-link">', '</a>' ); ?></p></div>');
					});
				})(window.jQuery);
			</script>
			<?php
		}

		/**
		 * Check activation
		 *
		 * @since 1.0
		 */
		public function check_activation() {
			if ( isset( $_POST['alpha_registration'] ) && check_admin_referer( 'alpha-setup-wizard' ) ) {
				update_option( 'alpha_register_error_msg', '' );
				$result = $this->check_purchase_code();
				if ( 'verified' == $result ) {
					update_option( 'alpha_registered', true );
					$this->refresh_transients();
				} elseif ( 'unregister' == $result ) {
					update_option( 'alpha_registered', false );
					$this->refresh_transients();
				} elseif ( 'invalid' == $result ) {
					update_option( 'alpha_registered', false );
					update_option( 'alpha_register_error_msg', sprintf( esc_html__( 'There is a problem contacting to the %s API server. Please try again later.', 'alpha' ), ALPHA_DISPLAY_NAME ) );
				} else {
					update_option( 'alpha_registered', false );
					update_option( 'alpha_register_error_msg', $result );
				}
			}
		}

		/**
		 * Show activation notice
		 *
		 * @since 1.0
		 */
		public function show_activation_notice() {
			if ( ! $this->is_registered() ) {
				if ( ( 'themes.php' == $GLOBALS['pagenow'] && isset( $_GET['page'] ) ) ||
					empty( $_COOKIE['alpha_dismiss_activate_msg'] ) ||
					version_compare( $_COOKIE['alpha_dismiss_activate_msg'], ALPHA_VERSION, '<' )
				) {
					add_action( 'admin_notices', array( $this, 'activation_notices' ) );
				} elseif ( 'themes.php' == $GLOBALS['pagenow'] ) {
					add_action( 'admin_footer', array( $this, 'activation_message' ) );
				}
			}
		}
	}
}

Alpha_Admin::get_instance();

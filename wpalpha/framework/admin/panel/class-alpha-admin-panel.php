<?php
/**
 * Alpha Admin Panel
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

/**
 * Alpha Admin Panel Class
 *
 * @since 1.0
 */
if ( ! class_exists( 'Alpha_Admin_Panel' ) ) {
	class Alpha_Admin_Panel extends Alpha_Base {

		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_admin_menus' ), 5 );
			add_action(
				'admin_enqueue_scripts',
				function () {
					$suffix = ALPHA_JS_SUFFIX;
					wp_enqueue_script( 'admin-swiper', ALPHA_ASSETS . '/vendor/swiper/swiper' . $suffix, '6.7.0', true );
				}
			);
		}

		/**
		 * Add admin menus
		 *
		 * @since 1.0
		 */
		public function add_admin_menus() {

			if ( current_user_can( 'edit_theme_options' ) ) {

				// Menu - alpha
				add_menu_page( ALPHA_DISPLAY_NAME, ALPHA_DISPLAY_NAME, 'administrator', 'alpha', array( $this, 'panel_activate' ), 'dashicons-alpha-logo', '2' );

				// Menu - alpha / licence
				add_submenu_page( 'alpha', esc_html__( 'Dashboard', 'alpha' ), esc_html__( 'Dashboard', 'alpha' ), 'administrator', 'alpha', array( $this, 'panel_activate' ) );

				// Menu - alpha / theme options
				add_submenu_page( 'alpha', esc_html__( 'Theme Options', 'alpha' ), esc_html__( 'Theme Options', 'alpha' ), 'administrator', 'customize.php', '' );

				// Menu - alpha / layout builder
				if ( class_exists( 'Alpha_Layout_Builder_Admin' ) ) {
					add_submenu_page( 'alpha', esc_html__( 'Layout Builder', 'alpha' ), esc_html__( 'Layout Builder', 'alpha' ), 'manage_options', 'alpha-layout-builder', array( Alpha_Layout_Builder_Admin::get_instance(), 'view_layout_builder' ), 2 );
				} else {
					add_submenu_page( 'alpha', esc_html__( 'Layout Builder', 'alpha' ), esc_html__( 'Layout Builder', 'alpha' ), 'manage_options', 'admin.php?page=alpha-layout-builder', '', 2 );
				}
			}
		}

		/**
		 * Load header template for admin panel.
		 *
		 * @since 1.0
		 */
		public function view_header( $active_page, $admin_config = array(), $title = array() ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/header.php' );
		}

		/**
		 * Load footer template for admin panel.
		 *
		 * @since 1.0
		 */
		public function view_footer( $admin_config = array() ) {
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/footer.php' );
		}

		/**
		 * Load license panel template.
		 *
		 * @since 1.0
		 */
		public function panel_activate() {

			$admin_config = Alpha_Admin::get_instance()->admin_config;
			$this->view_header( 'license', $admin_config );
			require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/panel/views/license.php' );
			$this->view_footer( $admin_config );
		}
	}
}

Alpha_Admin_Panel::get_instance();

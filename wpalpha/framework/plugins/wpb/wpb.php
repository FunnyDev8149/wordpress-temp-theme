<?php
/**
 * WPBakery Compatibility
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

// WPBakery Templates
if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	vc_set_shortcodes_templates_dir( ALPHA_FRAMEWORK_PATH . '/' . ALPHA_PART . '/wpb' );
}

if ( is_admin() ) {
	if ( function_exists( 'alpha_is_wpb_preview' ) && alpha_is_wpb_preview() ) {
		add_action( 'admin_enqueue_scripts', 'alpha_enqueue_wpb_editor_assets', 999 );
	}
}

function alpha_enqueue_wpb_editor_assets() {
	wp_enqueue_style( 'bootstrap-datepicker', ALPHA_ASSETS . '/vendor/bootstrap/bootstrap-datepicker.min.css', array(), ALPHA_VERSION );
	// Color Variables
	$custom_css  = 'html {';
	$custom_css .= '--alpha-primary-color:' . alpha_get_option( 'primary_color' ) . ';';
	$custom_css .= '--alpha-secondary-color:' . alpha_get_option( 'secondary_color' ) . ';';
	$custom_css .= '--alpha-dark-color:' . alpha_get_option( 'dark_color' ) . ';';
	$custom_css .= '--alpha-light-color:' . alpha_get_option( 'light_color' ) . ';';
	$custom_css .= '}';

	wp_add_inline_style( 'alpha-js-composer-editor', wp_strip_all_tags( wp_specialchars_decode( $custom_css ) ) );
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'alpha_vc_set_as_theme' );
function alpha_vc_set_as_theme() {
	if ( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme();
	}
}

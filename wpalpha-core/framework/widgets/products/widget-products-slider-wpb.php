<?php
/**
 * Alpha Products
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		'alpha_wpb_products_select_controls',
	),
	esc_html__( 'Layout', 'alpha-core' )           => array(
		'alpha_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'alpha-core' )             => array(
		'alpha_wpb_products_type_controls',
	),
	esc_html__( 'Style', 'alpha-core' )            => array(
		'alpha_wpb_products_style_controls',
	),
	esc_html__( 'Carousel Options', 'alpha-core' ) => array(
		esc_html__( 'Options', 'alpha-core' ) => array(
			'alpha_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'alpha-core' )     => array(
			'alpha_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'alpha-core' )    => array(
			'alpha_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_products_slider' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Slider', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_products_slider',
		'icon'            => 'alpha-icon alpha-icon-products-slider',
		'class'           => 'alpha_products alpha_products_slider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha products with slider layout.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_categories_callback', 'alpha_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_categories_render', 'alpha_wpb_shortcode_product_category_id_render', 10, 1 );

// Brand Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_brands_callback', 'alpha_wpb_shortcode_brand_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_brands_render', 'alpha_wpb_shortcode_brand_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_product_ids_callback', 'alpha_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_slider_product_ids_render', 'alpha_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_alpha_products_slider_product_ids_param_value', 'alpha_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Products_Slider extends WPBakeryShortCode {}' );
}

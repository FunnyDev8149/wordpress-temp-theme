<?php
/**
 * Alpha Single Product
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
	esc_html__( 'Type', 'alpha-core' )             => array(
		'alpha_wpb_single_product_type_controls',
	),
	esc_html__( 'Style', 'alpha-core' )            => array(
		'alpha_wpb_single_product_style_controls',
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

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Products', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_singleproducts',
		'icon'            => 'alpha-icon alpha-icon-single-product',
		'class'           => 'alpha_singleproducts',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha single products.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_singleproducts_categories_callback', 'alpha_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_singleproducts_categories_render', 'alpha_wpb_shortcode_product_category_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_singleproducts_product_ids_callback', 'alpha_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_singleproducts_product_ids_render', 'alpha_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_alpha_singleproducts_product_ids_param_value', 'alpha_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_SingleProducts extends WPBakeryShortCode {}' );
}

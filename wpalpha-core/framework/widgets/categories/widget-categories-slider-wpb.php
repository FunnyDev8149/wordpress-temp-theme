<?php
/**
 * Alpha Categories
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$creative_layout = alpha_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => ALPHA_CORE_URI . $item,
	);
}


$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		'alpha_wpb_categories_select_controls',
	),
	esc_html__( 'Layout', 'alpha-core' )           => array(
		'alpha_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'alpha-core' )             => array(
		'alpha_wpb_categories_type_controls',
	),
	esc_html__( 'Style', 'alpha-core' )            => array(
		esc_html__( 'Category', 'alpha-core' )         => array( 'alpha_wpb_categories_wrap_style_controls' ),
		esc_html__( 'Category Icon', 'alpha-core' )    => array( 'alpha_wpb_categories_icon_style_controls' ),
		esc_html__( 'Category Content', 'alpha-core' ) => array( 'alpha_wpb_categories_content_style_controls' ),
		esc_html__( 'Category Name', 'alpha-core' )    => array( 'alpha_wpb_categories_name_style_controls' ),
		esc_html__( 'Products Count', 'alpha-core' )   => array( 'alpha_wpb_categories_count_style_controls' ),
		esc_html__( 'Button', 'alpha-core' )           => array( 'alpha_wpb_categories_button_style_controls' ),
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


$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_categories_slider' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Categories Slider', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_categories_slider',
		'icon'            => 'alpha-icon alpha-icon-cat-slider',
		'class'           => 'alpha_categories alpha_categories_slider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha product categories with slider layout.', 'alpha-core' ),
		'params'          => $params,
	)
);

add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_categories_slider_category_ids_callback', 'alpha_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_categories_slider_category_ids_render', 'alpha_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Categories_Slider extends WPBakeryShortCode {}' );
}

<?php
/**
 * Alpha Image Gallery
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Images', 'alpha-core' )           => array(
		'alpha_wpb_images_select_controls',
	),
	esc_html__( 'Layout', 'alpha-core' )           => array(
		'alpha_wpb_elements_layout_controls',
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

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_images_slider' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Images Slider', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_images_slider',
		'icon'            => 'alpha-icon alpha-icon-images-slider',
		'class'           => 'alpha_images alpha_images_slider image-gallery',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha images slider.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Images_Slider extends WPBakeryShortCode {}' );
}

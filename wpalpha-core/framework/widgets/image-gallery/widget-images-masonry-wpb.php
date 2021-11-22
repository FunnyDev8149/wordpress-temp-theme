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
	esc_html__( 'Images', 'alpha-core' ) => array(
		'alpha_wpb_images_select_controls',
	),
	esc_html__( 'Layout', 'alpha-core' ) => array(
		'alpha_wpb_elements_layout_controls',
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_images_masonry' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Images Masonry', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_images_masonry',
		'icon'            => 'alpha-icon alpha-icon-images-masonry',
		'class'           => 'alpha_images alpha_images_masonry image-gallery grid-gallery',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha images masonry.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Images_Masonry extends WPBakeryShortCode {}' );
}

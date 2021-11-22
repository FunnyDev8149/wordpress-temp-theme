<?php
/**
 * Banner Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )  => array(
		'alpha_wpb_banner_general_controls',
	),
	esc_html__( 'Effect', 'alpha-core' )   => array(
		'alpha_wpb_banner_effect_controls',
	),
	esc_html__( 'Parallax', 'alpha-core' ) => array(
		'alpha_wpb_banner_parallax_controls',
	),
	esc_html__( 'Video', 'alpha-core' )    => array(
		'alpha_wpb_banner_video_controls',
	),

);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner', 'alpha-core' ),
		'base'                    => 'wpb_' . ALPHA_NAME . '_banner',
		'icon'                    => 'alpha-icon alpha-icon-banner',
		'class'                   => 'alpha_banner',
		'controls'                => 'full',
		'category'                => ALPHA_DISPLAY_NAME,
		'description'             => esc_html__( 'Create alpha banner.', 'alpha-core' ),
		'as_parent'               => array( 'only' => 'wpb_' . ALPHA_NAME . '_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_' . ALPHA_NAME . '_banner_layer banner_origin="t-m" layer_pos="{``top``:{``xl``:``50%``},``right``:{``xl``:``2rem``},``left``:{``xl``:``2rem``}}" align="center" layer_width="{``xl``:````}" layer_height="{``xl``:````}"][wpb_' . ALPHA_NAME . '_heading heading_title="' . base64_encode( esc_html__( 'This is a simple banner​', 'alpha-core' ) ) . '" decoration="simple" title_align="title-center"][wpb_' . ALPHA_NAME . '_heading heading_title=' . base64_encode( esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibheuismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'alpha-core' ) ) . ' html_tag="p" decoration="simple" title_align="title-center" extra_class="mt-4"][wpb_' . ALPHA_NAME . '_button button_align="center" button_skin="btn-white" extra_class="mt-4"][/wpb_' . ALPHA_NAME . '_banner_layer]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Banner extends WPBakeryShortCodesContainer {}' );
}

<?php
/**
 * Alpha Element Wrapper shortcode
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'alpha_dropdown',
			'heading'     => esc_html__( 'Tag', 'alpha-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'Div'     => 'div',
				'Section' => 'section',
				'H1'      => 'h1',
				'H2'      => 'h2',
				'H3'      => 'h3',
				'H4'      => 'h4',
				'H5'      => 'h5',
				'H6'      => 'h6',
				'P'       => 'p',
				'Span'    => 'span',
			),
			'std'         => 'div',
			'admin_label' => true,
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Element Wrapper', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_wrapper',
		'icon'            => 'alpha-icon alpha-icon-element-wrapper',
		'class'           => 'alpha_wrapper',
		'as_parent'       => array( 'except' => 'wpb_' . ALPHA_NAME . '_wrapper' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha element wrapper.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Wrapper extends WPBakeryShortCodesContainer {}' );
}

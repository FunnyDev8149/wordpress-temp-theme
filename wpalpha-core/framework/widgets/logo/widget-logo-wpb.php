<?php
/**
 * Logo Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	array(
		'type'       => 'dropdown',
		'param_name' => 'logo_image_size',
		'heading'    => esc_html__( 'Image Size', 'alpha-core' ),
		'value'      => alpha_get_image_sizes(),
	),
	array(
		'type'       => 'alpha_number',
		'heading'    => esc_html__( 'Width', 'alpha-core' ),
		'param_name' => 'logo_width',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'{{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'alpha_number',
		'heading'    => esc_html__( 'Max Width', 'alpha-core' ),
		'param_name' => 'logo_max_width',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'{{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'alpha_number',
		'heading'    => esc_html__( 'Width on Sticky', 'alpha-core' ),
		'param_name' => 'logo_width_sticky',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'.fixed {{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'       => 'alpha_number',
		'heading'    => esc_html__( 'Max Width on Sticky', 'alpha-core' ),
		'param_name' => 'logo_max_width_sticky',
		'units'      => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'      => '',
		'selectors'  => array(
			'.fixed {{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Logo', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_logo',
		'icon'            => 'alpha-icon alpha-icon-logo',
		'class'           => 'alpha_logo',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha site logo.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Logo extends WPBakeryShortCode {}' );
}

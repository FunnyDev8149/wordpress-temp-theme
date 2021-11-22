<?php
/**
 * Header V-Divider Button
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'alpha-core' ),
			'param_name' => 'divider_color',
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Height', 'alpha-core' ),
			'param_name' => 'divider_height',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Width', 'alpha-core' ),
			'param_name' => 'divider_width',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vw',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Vertical Divider', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_v_divider',
		'icon'            => 'alpha-icon alpha-icon-vertical-divider',
		'class'           => 'alpha_hb_v_divider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha vertical divider.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_V_Divider extends WPBakeryShortCode {}' );
}

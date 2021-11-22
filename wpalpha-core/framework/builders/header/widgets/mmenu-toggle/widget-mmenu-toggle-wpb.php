<?php
/**
 * Header Mobile Menu Toggle Button
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'alpha-core' ),
			'param_name' => 'icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-hamburger',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'toggle_border',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top: {{TOP}} solid;border-right: {{RIGHT}} solid;border-bottom: {{BOTTOM}} solid;border-left: {{LEFT}} solid;',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'param_name' => 'toggle_border_radius',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .mobile-menu-toggle',
				'hover'  => '{{WRAPPER}} .mobile-menu-toggle:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Mobile Menu Toggle', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_mmenu_toggle',
		'icon'            => 'alpha-icon alpha-icon-mmenu-toggle',
		'class'           => 'alpha_hb_mmenu_toggle',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha mobile menu toggle.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Mmenu_Toggle extends WPBakeryShortCode {}' );
}

<?php
/**
 * Header Language Switcher Button
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Switcher Toggle', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Typography', 'alpha-core' ),
			'param_name' => 'toggle_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle .switcher > li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'toggle_border',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid;',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'param_name' => 'toggle_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher .switcher-toggle' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher .switcher-toggle',
				'hover'  => '{{WRAPPER}} .menu > li:hover > a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Dropdown Box', 'alpha-core' )    => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'dropdown_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Position', 'alpha-core' ),
			'param_name' => 'dropdown_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Border', 'alpha-core' ),
			'param_name' => 'dropdown_border_style',
			'std'        => 'none',
			'value'      => array(
				esc_html__( 'None', 'alpha-core' )   => 'none',
				esc_html__( 'Solid', 'alpha-core' )  => 'solid',
				esc_html__( 'Double', 'alpha-core' ) => 'double',
				esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
				esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
				esc_html__( 'Groove', 'alpha-core' ) => 'groove',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-style: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'dropdown_border_width',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
			'param_name' => 'dropdown_border_color',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
			'param_name' => 'dropdown_bg',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'background-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Currency Item', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Typography', 'alpha-core' ),
			'param_name' => 'item_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'item_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Margin', 'alpha-core' ),
			'param_name' => 'item_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'item_border',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid;',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'param_name' => 'item_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'item_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher ul a',
				'hover'  => '{{WRAPPER}} .switcher ul > li:hover a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Language Switcher', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_language_switcher',
		'icon'            => 'alpha-icon alpha-icon-language',
		'class'           => 'alpha_hb_language_switcher',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha language switcher.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Language_Switcher extends WPBakeryShortCode {}' );
}

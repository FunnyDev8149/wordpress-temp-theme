<?php
/**
 * Accordion Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )         => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Accordion Type', 'alpha-core' ),
			'param_name' => 'accordion_type',
			'std'        => '',
			'value'      => array(
				''       => array(
					'title' => esc_html__( 'Default', 'alpha-core' ),
				),
				'simple' => array(
					'title' => esc_html__( 'Simple', 'alpha-core' ),
				),
				'border' => array(
					'title' => esc_html__( 'Border', 'alpha-core' ),
				),
				'boxed'  => array(
					'title' => esc_html__( 'Boxed', 'alpha-core' ),
				),
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Card Space', 'alpha-core' ),
			'param_name' => 'accordion_card_space',
			'units'      => array(
				'px',
				'rem',
			),
			'dependency' => array(
				'element' => 'accordion_type',
				'value'   => 'boxed',
			),
			'selectors'  => array(
				'{{WRAPPER}} .card:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'alpha-core' ),
			'param_name' => 'accordion_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-plus',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Active Toggle Icon', 'alpha-core' ),
			'param_name' => 'accordion_active_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-minus',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Toggle Icon Size', 'alpha-core' ),
			'param_name' => 'toggle_icon_size',
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .toggle-icon' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Accordion Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'accordion_bd',
			'selectors'  => array(
				'{{WRAPPER}} .card' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
			'param_name' => 'accordion_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .accordion' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .card'      => 'border-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Card Item Style', 'alpha-core' ) => array(
		esc_html__( 'Header', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'accordion_header_pad',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .card-header > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
					'{{WRAPPER}} .opened, {{WRAPPER}} .closed' => 'right: {{RIGHT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'accordion_header_bd',
				'selectors'  => array(
					'{{WRAPPER}} .card-header a' => 'border: 1px solid; border-color: inherit; border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'panel_header_typography',
				'selectors'  => array(
					'{{WRAPPER}} .card-header > a',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'accordion_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .card-header a',
					'hover'  => '{{WRAPPER}} .card-header a:hover',
					'active' => '{{WRAPPER}} .card-header a:not(.expand)',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Prefix Icon Size', 'alpha-core' ),
				'param_name' => 'accordion_icon_size',
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-header a > i:first-child' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Prefix Icon Space', 'alpha-core' ),
				'param_name' => 'accordion_icon_space',
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			),
		),
		esc_html__( 'Content', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'accordion_content_pad',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .card-body' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Accordion', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_accordion',
		'icon'            => 'alpha-icon alpha-icon-accordion',
		'class'           => 'alpha_accordion',
		'as_parent'       => array( 'only' => 'wpb_' . ALPHA_NAME . '_accordion_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha accordion.', 'alpha-core' ),
		'default_content' => vc_is_inline() ? '[wpb_' . ALPHA_NAME . '_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_' . ALPHA_NAME . '_accordion_item][wpb_' . ALPHA_NAME . '_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_' . ALPHA_NAME . '_accordion_item][wpb_' . ALPHA_NAME . '_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_' . ALPHA_NAME . '_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Accordion extends WPBakeryShortCodesContainer { }' );
}

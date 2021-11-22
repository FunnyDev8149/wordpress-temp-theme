<?php
/**
 * Alpha Single Product Tab Data
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'param_name' => 'sp_type',
			'value'      => array(
				esc_html__( 'Theme Option', 'alpha-core' ) => '',
				esc_html__( 'Tab', 'alpha-core' )       => 'tab',
				esc_html__( 'Accordion', 'alpha-core' ) => 'accordion',
			),
			'std'        => '',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'sp_tab_link_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'dependency' => array(
				'element'            => 'sp_type',
				'value_not_equal_to' => 'accordion',
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs > .tabs' => 'justify-content: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Navigation', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Typography', 'alpha-core' ),
			'param_name' => 'sp_tab_link_typo',
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'sp_tab_link_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		esc_html__( 'Normal', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'sp_tab_link_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'sp_tab_link_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Hover', 'alpha-core' )  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_hover_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_hover_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'sp_tab_link_hover_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'sp_tab_link_hover_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_hover_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_hover_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_hover_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Active', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_active_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_active_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'sp_tab_link_active_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'sp_tab_link_active_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a.active' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_active_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_tab_link_active_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header a:active' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'sp_tab_link_active_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
	),
	esc_html__( 'Content', 'alpha-core' )    => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'sp_tab_link_content_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .panel.woocommerce-Tabs-panel' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Data Tab', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_data_tab',
		'icon'            => 'alpha-icon alpha-icon-sp-data',
		'class'           => 'alpha_sp_data_tab',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product tab data.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Data_Tab extends WPBakeryShortCode {}' );
}

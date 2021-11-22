<?php
/**
 * Tab Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Tab Layout', 'alpha-core' ),
			'param_name' => 'tab_type',
			'std'        => '',
			'value'      => array(
				''         => array(
					'title' => esc_html__( 'Horizontal', 'alpha-core' ),
				),
				'vertical' => array(
					'title' => esc_html__( 'Vertical', 'alpha-core' ),
				),
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Vertical Nav Width', 'alpha-core' ),
			'param_name' => 'tab_nav_width',
			'units'      => array(
				'px',
				'rem',
				'vw',
				'%',
			),
			'dependency' => array(
				'element' => 'tab_type',
				'value'   => 'vertical',
			),
			'selectors'  => array(
				'{{WRAPPER}} .tab-vertical .nav'         => 'width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-vertical .tab-content' => 'width: calc( 100% - {{VALUE}}{{UNIT}} );',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Navs Alignment', 'alpha-core' ),
			'param_name' => 'tab_navs_pos',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'dependency' => array(
				'element'            => 'tab_type',
				'value_not_equal_to' => 'vertical',
			),
			'std'        => '{``xl``:``left``}',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Tab Type', 'alpha-core' ),
			'param_name' => 'tab_v_type',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => '',
				esc_html__( 'Simple', 'alpha-core' )  => 'simple',
				esc_html__( 'Solid', 'alpha-core' )   => 'solid',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'tab_type',
				'value'   => 'vertical',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Tab Type', 'alpha-core' ),
			'param_name' => 'tab_h_type',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' )   => '',
				esc_html__( 'Simple', 'alpha-core' )    => 'simple',
				esc_html__( 'Solid 1', 'alpha-core' )   => 'solid1',
				esc_html__( 'Solid 2', 'alpha-core' )   => 'solid2',
				esc_html__( 'Outline 1', 'alpha-core' ) => 'outline1',
				esc_html__( 'Outline 2', 'alpha-core' ) => 'outline2',
				esc_html__( 'Underline', 'alpha-core' ) => 'link',
			),
			'std'        => '',
			'dependency' => array(
				'element'            => 'tab_type',
				'value_not_equal_to' => 'vertical',
			),
		),
	),
	esc_html__( 'Tab Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Tab Border Radius', 'alpha-core' ),
			'param_name' => 'tab_br',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .tab-content'               => 'border-radius: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .nav .nav-link'             => 'border-radius: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-outline2 .nav-link'    => 'border-radius: {{VALUE}}{{UNIT}} {{VALUE}}{{UNIT}} 0 0;',
				'{{WRAPPER}} .tab-outline2 .tab-content' => 'border-radius: 0 0 {{VALUE}}{{UNIT}} {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Nav Box Margin', 'alpha-core' ),
			'param_name' => 'nav_box_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .nav' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Nav Item Margin', 'alpha-core' ),
			'param_name' => 'nav_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .nav .nav-link' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Nav Item Padding', 'alpha-core' ),
			'param_name' => 'nav_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .nav .nav-link' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Nav Item Typography', 'alpha-core' ),
			'param_name' => 'tab_nav_typography',
			'selectors'  => array(
				'{{WRAPPER}} .nav .nav-link',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Nav Border Width', 'alpha-core' ),
			'param_name' => 'nav_bd',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .tab:not(.tab-vertical) .nav-link' => 'border-width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab.tab-nav-underline .nav-link' => 'border-width: 0 0 {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-nav-simple .nav-link.active, {{WRAPPER}} .tab-nav-simple .nav-link:hover' => 'border-bottom-width: calc({{VALUE}}{{UNIT}} * 2)',
				'{{WRAPPER}} .tab-outline .nav-link' => 'border-top-width: calc({{VALUE}}{{UNIT}} * 2);',
				'{{WRAPPER}} .tab-nav-underline .nav-link:after' => 'border-bottom-width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-vertical.tab-simple .nav-link::after' => 'width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-vertical.tab-simple .nav-link' => 'margin-right: -{{VALUE}}{{UNIT}}; width: calc(100% + {{VALUE}}{{UNIT}});',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Nav Item Colors', 'alpha-core' ),
			'param_name' => 'tab_nav_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .tab .nav .nav-link, {{WRAPPER}} .tab-nav-underline .nav-link:after',
				'hover'  => '{{WRAPPER}} .tab .nav .nav-link:hover, {{WRAPPER}} .tab-nav-underline .nav-link:hover:after',
				'active' => '{{WRAPPER}} .tab .nav .nav-link.active, {{WRAPPER}} .tab-nav-underline .nav-link.active:after',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Tab', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_tab',
		'icon'            => 'alpha-icon alpha-icon-tab',
		'class'           => 'alpha_tab',
		'as_parent'       => array( 'only' => 'wpb_' . ALPHA_NAME . '_tab_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha tab.', 'alpha-core' ),
		'default_content' => vc_is_inline() ? '[wpb_' . ALPHA_NAME . '_tab_item tab_title="Tab 1"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_' . ALPHA_NAME . '_tab_item][wpb_' . ALPHA_NAME . '_tab_item tab_title="Tab 2"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_' . ALPHA_NAME . '_tab_item][wpb_' . ALPHA_NAME . '_tab_item tab_title="Tab 3"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_' . ALPHA_NAME . '_tab_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Tab extends WPBakeryShortCodesContainer {}' );
}

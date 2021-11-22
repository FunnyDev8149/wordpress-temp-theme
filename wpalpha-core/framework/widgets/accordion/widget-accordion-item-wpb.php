<?php
/**
 * Accordion Item Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Card Title', 'alpha-core' ),
			'param_name'  => 'card_title',
			'value'       => 'Card Item',
			'admin_label' => true,
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Card Icon', 'alpha-core' ),
			'param_name' => 'card_icon',
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Card Icon Typography', 'alpha-core' ),
			'param_name' => 'card_icon_typography',
			'selectors'  => array(
				'{{WRAPPER}} .card-header a > i:first-child',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Card Icon Space', 'alpha-core' ),
			'param_name' => 'card_icon_space',
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => ALPHA_DISPLAY_NAME . esc_html__( ' Accordion Item', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_accordion_item',
		'icon'            => 'alpha-icon alpha-icon-accordion',
		'class'           => 'alpha_accordion_item',
		'as_parent'       => array( 'except' => 'wpb_' . ALPHA_NAME . '_accordion_item' ),
		'as_child'        => array( 'only' => 'wpb_' . ALPHA_NAME . '_accordion' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha accordion item.', 'alpha-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_alpha_tab_item tab_title="Tab 1"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_alpha_tab_item][wpb_alpha_tab_item tab_title="Tab 2"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_alpha_tab_item][wpb_alpha_tab_item tab_title="Tab 3"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_alpha_tab_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Accordion_Item extends WPBakeryShortCodesContainer {}' );
}

<?php
/**
 * Banner Layer Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Origin', 'alpha-core' ),
			'param_name' => 'banner_origin',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => 't-none',
				esc_html__( 'Vertical Center', 'alpha-core' ) => 't-m',
				esc_html__( 'Horizontal Center', 'alpha-core' ) => 't-c',
				esc_html__( 'Center', 'alpha-core' )  => 't-mc',
			),
			'std'        => 't-mc',
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Position', 'alpha-core' ),
			'param_name' => 'layer_pos',
			'std'        => '{"top":{"xl":"50%","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":""},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":""},"left":{"xs":"","sm":"","md":"","lg":"","xl":"50%"}}',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'align',
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
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Width', 'alpha-core' ),
			'param_name' => 'layer_width',
			'responsive' => true,
			'value'      => '',
			'std'        => '{"xl":"300","unit":"px"}',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}}.banner-content' => 'max-width: {{VALUE}}{{UNIT}}; width: 100%;',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Height', 'alpha-core' ),
			'param_name' => 'layer_height',
			'responsive' => true,
			'value'      => '',
			'units'      => array(
				'px',
				'%',
			),
			'std'        => '{"xl":"300","unit":"px"}',
			'selectors'  => array(
				'{{WRAPPER}}'                       => 'height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .banner-content-inner' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'layer_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
			'param_name' => 'layer_bgcolor',
			'selectors'  => array(
				'{{WRAPPER}}' => 'background-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner Layer', 'alpha-core' ),
		'base'                    => 'wpb_' . ALPHA_NAME . '_banner_layer',
		'icon'                    => 'alpha-icon alpha-icon-banner',
		'class'                   => 'wpb_' . ALPHA_NAME . '_banner_layer',
		'controls'                => 'full',
		'category'                => ALPHA_DISPLAY_NAME,
		'description'             => esc_html__( 'Create alpha banner layer.', 'alpha-core' ),
		'as_child'                => array( 'only' => 'wpb_' . ALPHA_NAME . '_banner, wpb_alpha_products_banner_item' ),
		'as_parent'               => array( 'except' => 'wpb_' . ALPHA_NAME . '_banner, wpb_alpha_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Banner_Layer extends WPBakeryShortCodesContainer {}' );
}

<?php
/**
 * Filter Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Filter Item Width', 'alpha-core' ),
			'param_name' => 'filter_width',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .alpha-filter' => 'width: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Filter Height', 'alpha-core' ),
			'param_name' => 'filter_height',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn-filter' => 'height: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Filter Gap', 'alpha-core' ),
			'param_name' => 'filter_gap',
			'with_units' => true,
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .align-left > *'   => 'margin-right: {{VALUE}};',
				'{{WRAPPER}} .align-center > *' => 'margin-left: calc( {{VALUE}} / 2 );',
				'{{WRAPPER}} .align-right > *'  => 'margin-left: {{VALUE}};',
			),
			'std'        => '{"xl":"10", "unit":"", "lg":"", "md":"", "sm":"", "xs":""}',
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
			'std'        => 'center',
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'filter_bd_width',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'dependency' => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => __( 'Border Color', 'alpha-core' ),
			'param_name' => 'filter_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-color: {{VALUE}};',
			),
			'dependency' => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'param_name' => 'filter_bd_radius',
			'selectors'  => array(
				'{{WRAPPER}} .select-ul-toggle, {{WRAPPER}} .btn-filter' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Filter Button Label', 'alpha-core' ),
			'param_name' => 'btn_label',
			'value'      => 'Filter',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Filter Button Skin', 'alpha-core' ),
			'param_name' => 'btn_skin',
			'std'        => 'btn-primary',
			'value'      => array(
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'alpha-core' ),
					'color' => 'var(--alpha-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'alpha-core' ),
					'color' => 'var(--alpha-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'alpha-core' ),
					'color' => 'var(--alpha-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'alpha-core' ),
					'color' => 'var(--alpha-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'alpha-core' ),
					'color' => 'var(--alpha-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'alpha-core' ),
					'color' => '#fff',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Attribute Filter', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_filter',
		'icon'            => 'alpha-icon alpha-icon-filter',
		'class'           => 'alpha_filter',
		'as_parent'       => array( 'only' => 'wpb_' . ALPHA_NAME . '_filter_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha product attribute filter.', 'alpha-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_alpha_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_alpha_accordion_item][wpb_alpha_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_alpha_accordion_item][wpb_alpha_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_alpha_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Filter extends WPBakeryShortCodesContainer {}' );
}

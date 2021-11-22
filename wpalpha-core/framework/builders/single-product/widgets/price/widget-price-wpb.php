<?php
/**
 * Alpha Single Product Price
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => __( 'Typography', 'alpha-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} p.price',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'sp_price_align',
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
			'selectors'  => array(
				'{{WRAPPER}} p.price' => 'text-align: {{VALUE}};',
			),
		),
		esc_html__( 'Color', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Normal', 'alpha-core' ),
				'param_name' => 'normal_price_color',
				'selectors'  => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'New', 'alpha-core' ),
				'param_name' => 'new_price_color',
				'selectors'  => array(
					'{{WRAPPER}} ins' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Old', 'alpha-core' ),
				'param_name' => 'old_price_color',
				'selectors'  => array(
					'{{WRAPPER}} del' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Price', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_price',
		'icon'            => 'alpha-icon alpha-icon-sp-price',
		'class'           => 'alpha_sp_price',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product price.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Price extends WPBakeryShortCode {}' );
}

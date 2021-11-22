<?php
/**
 * Alpha Single Product Flash Sale
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Content', 'alpha-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'param_name' => 'sp_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-check',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label', 'alpha-core' ),
			'param_name' => 'sp_label',
			'std'        => esc_html__( 'Flash Deals', 'alpha-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Ends Label', 'alpha-core' ),
			'param_name' => 'sp_ends_label',
			'std'        => esc_html__( 'Ends in:', 'alpha-core' ),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
			'param_name' => 'sp_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-countdown-container' => 'background-color: {{VALUE}};',
			),
		),
		esc_html__( 'Label', 'alpha-core' )      => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'sp_label_typo',
				'selectors'  => array(
					'{{WRAPPER}} .product-sale-info',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_label_color',
				'selectors'  => array(
					'{{WRAPPER}} .product-sale-info' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Ends Label', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'sp_ends_typo',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-wrap',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'sp_ends_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-wrap' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Flash Sale', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_flash_sale',
		'icon'            => 'alpha-icon alpha-icon-sp-flash-sale',
		'class'           => 'alpha_sp_flash_sale',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product flash sale.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Flash_Sale extends WPBakeryShortCode {}' );
}

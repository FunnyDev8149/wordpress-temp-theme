<?php
/**
 * Alpha Single Product Meta
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Style', 'alpha-core' ) => array(
		esc_html__( 'General', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
				'param_name' => 'sp_align',
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
					'{{WRAPPER}} .product_meta' => 'text-align: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Text', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'sp_typo',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'text_color',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Link', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'link_typography',
				'selectors'  => array(
					'{{WRAPPER}} a',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'link_color',
				'selectors'  => array(
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Meta', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_meta',
		'icon'            => 'alpha-icon alpha-icon-sp-meta',
		'class'           => 'alpha_sp_meta',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product meta.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Meta extends WPBakeryShortCode {}' );
}

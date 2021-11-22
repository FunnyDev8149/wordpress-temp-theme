<?php
/**
 * Alpha Single Product Wishlist
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Content', 'alpha-core' ) => array(
		esc_html__( 'wishlist', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'wishlist_typo',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'param_name' => 'wishlist_icon_size',
				'units'      => array(
					'px',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Space', 'alpha-core' ),
				'param_name' => 'wishlist_icon_space',
				'units'      => array(
					'px',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Normal Color', 'alpha-core' ),
				'param_name' => 'wishlist_color',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Hover Color', 'alpha-core' ),
				'param_name' => 'wishlist_hover_color',
				'selectors'  => array(
					'{{WRAPPER}} .yith-wcwl-add-to-wishlist a:hover' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Alpha Single Product Wishlist', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_wishlist',
		'icon'            => 'alpha-icon',
		'class'           => 'alpha_sp_wishlist',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product wishlist.', 'alpha-core' ),
		'params'          => $params,
	)
);


if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Wishlist  extends WPBakeryShortCode {}' );
}

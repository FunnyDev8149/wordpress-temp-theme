<?php
/**
 * Alpha Single Product Navigation
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'sp_align',
			'value'      => array(
				''         => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'   => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end' => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-navigation' => 'justify-content: {{VALUE}}',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Typography', 'alpha-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav span span',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'value'      => '',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Previous Icon', 'alpha-core' ),
			'param_name' => 'sp_prev_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-angle-left',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Next Icon', 'alpha-core' ),
			'param_name' => 'sp_next_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-angle-right',
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'nav_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} i',
				'hover'  => '{{WRAPPER}} li:hover i',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Navigation', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_navigation',
		'icon'            => 'alpha-icon alpha-icon-sp-nav',
		'class'           => 'alpha_sp_navigation',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product navigation.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Navigation extends WPBakeryShortCode {}' );
}

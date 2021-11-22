<?php
/**
 * Alpha Breadcrumb
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
			'heading'     => esc_html__( 'Delimiter', 'alpha-core' ),
			'param_name'  => 'delimiter',
			'description' => 'You can use text, number or symbol as delimiter.',
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Delimiter Icon', 'alpha-core' ),
			'param_name'  => 'delimiter_icon',
			'description' => 'You can use icon as delimiter.',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Home Icon', 'alpha-core' ),
			'param_name' => 'home_icon',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Typography', 'alpha-core' ),
			'param_name' => 'breadcrumb_typography',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb',
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
				'{{WRAPPER}} .breadcrumb' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Normal Color', 'alpha-core' ),
			'param_name' => 'normal_color',
			'std'        => '#666',
			'value'      => '#666',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'alpha-core' ),
			'param_name' => 'hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb a'       => 'opacity: 1;',
				'{{WRAPPER}} .breadcrumb a:hover' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Delimiter Size', 'alpha-core' ),
			'param_name' => 'delimiter_size',
			'units'      => array(
				'px',
				'rem',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .delimiter' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Delimiter Space', 'alpha-core' ),
			'param_name' => 'delimiter_space',
			'units'      => array(
				'px',
				'rem',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'button_padding',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Breadcrumb', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_breadcrumb',
		'icon'            => 'alpha-icon alpha-icon-breadcrumb',
		'class'           => 'alpha_breadcrumb',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha breadcrumb.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Breadcrumb extends WPBakeryShortCode {}' );
}

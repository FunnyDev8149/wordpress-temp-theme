<?php
/**
 * Alpha Single Product Share
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
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'sp_size',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
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
					'{{WRAPPER}} .social-icons' => 'justify-content: {{VALUE}}; width: 100%;',
				),
			),
		),
		esc_html__( 'Color', 'alpha-core' )   => array(
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'sp_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .social-icons > .social-icon',
					'hover'  => '{{WRAPPER}} .social-icons > .social-icon:hover',
					'active' => '{{WRAPPER}} .social-icons > .social-icon:active',
				),
				'choices'    => array( 'color', 'background', 'border' ),
			),
		),
		esc_html__( 'Border', 'alpha-core' )  => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'sp_share_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-style: {{VALUE}}; width: 2.5em; height: 2.5em;',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'sp_share_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_share_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'sp_share_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .social-icons > .social-icon' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'sp_share_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Share', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_share',
		'icon'            => 'alpha-icon alpha-icon-sp-share',
		'class'           => 'alpha_sp_share',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product share.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Share extends WPBakeryShortCode {}' );
}

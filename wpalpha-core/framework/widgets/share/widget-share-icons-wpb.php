<?php
/**
 * Share Icons Element
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
			'param_name' => 'share_direction',
			'heading'    => esc_html__( 'Share Direction', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Row', 'alpha-core' )    => 'flex',
				esc_html__( 'Column', 'alpha-core' ) => 'block',
			),
			'std'        => 'flex',
			'selectors'  => array(
				'{{WRAPPER}}.social-icons' => 'display:{{VALUE}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'border_type',
			'heading'    => esc_html__( 'Border Style', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Rectangle', 'alpha-core' ) => '0',
				esc_html__( 'Rounded', 'alpha-core' )   => '10px',
				esc_html__( 'Circle', 'alpha-core' )    => '50%',
			),
			'std'        => '50%',
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-radius:{{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'param_name' => 'icon_border',
			'heading'    => esc_html__( 'Border', 'alpha-core' ),
			'responsive' => false,
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'param_name' => 'br_radius',
			'responsive' => false,
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Background Size', 'alpha-core' ),
			'param_name' => 'bg_size',
			'responsive' => false,
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};display:inline-flex;align-items:center;justify-content:center;',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Icon Colors', 'alpha-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .social-icon',
				'hover'  => '{{WRAPPER}} .social-icon:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Column Spacing', 'alpha-core' ),
			'param_name' => 'icon_spacing',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon'            => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .social-icon:last-child' => 'margin-right: 0;',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Row Spacing', 'alpha-core' ),
			'param_name' => 'row_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .social-icon + .social-icon' => 'margin-top: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Share Icons', 'alpha-core' ),
		'base'                    => 'wpb_' . ALPHA_NAME . '_share_icons',
		'icon'                    => 'alpha-icon alpha-icon-share',
		'class'                   => 'wpb_' . ALPHA_NAME . '_share_icons',
		'controls'                => 'full',
		'category'                => ALPHA_DISPLAY_NAME,
		'description'             => esc_html__( 'Create alpha share icons.', 'alpha-core' ),
		'as_parent'               => array( 'only' => 'wpb_' . ALPHA_NAME . '_share_icon' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_' . ALPHA_NAME . '_share_icon icon="facebook"][wpb_' . ALPHA_NAME . '_share_icon icon="twitter"][wpb_' . ALPHA_NAME . '_share_icon icon="linkedin"]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Share_Icons extends WPBakeryShortCodesContainer {}' );
}

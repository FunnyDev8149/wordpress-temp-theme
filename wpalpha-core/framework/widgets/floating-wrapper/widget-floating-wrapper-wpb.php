<?php
/**
 * Alpha Element Wrapper shortcode
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Scroll Effects', 'alpha-core' )     => array(

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Viewport', 'alpha-core' ),
			'param_name' => 'viewport',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => 'centered',
				esc_html__( 'Top - Bottom', 'alpha-core' ) => 'top_bottom',
				esc_html__( 'Top - Center', 'alpha-core' ) => 'center_top',
				esc_html__( 'Center - Bottom', 'alpha-core' ) => 'center_bottom',
			),
			'std'        => 'centered',
		),
		esc_html__( 'Vertical Scroll', 'alpha-core' )   => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
				'param_name' => 'vertical_scroll',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Direction', 'alpha-core' ),
				'param_name' => 'v_direction',
				'value'      => array(
					'up'     => array(
						'title' => esc_html__( 'Up', 'alpha-core' ),
					),
					'bottom' => array(
						'title' => esc_html__( 'Down', 'alpha-core' ),
					),
				),
				'std'        => 'up',
				'dependency' => array(
					'element' => 'vertical_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Speed', 'alpha-core' ),
				'param_name' => 'v_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'vertical_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Horizontal Scroll', 'alpha-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
				'param_name' => 'horizontal_scroll',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Direction', 'alpha-core' ),
				'param_name' => 'h_direction',
				'value'      => array(
					'left'  => array(
						'title' => esc_html__( 'To Left', 'alpha-core' ),
					),
					'right' => array(
						'title' => esc_html__( 'To Right', 'alpha-core' ),
					),
				),
				'std'        => 'left',
				'dependency' => array(
					'element' => 'horizontal_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Speed', 'alpha-core' ),
				'param_name' => 'h_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'horizontal_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Transparency', 'alpha-core' )      => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
				'param_name' => 'transparency_scroll',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Direction', 'alpha-core' ),
				'param_name' => 't_direction',
				'value'      => array(
					'in'  => array(
						'title' => esc_html__( 'Fade In', 'alpha-core' ),
					),
					'out' => array(
						'title' => esc_html__( 'Fade Out', 'alpha-core' ),
					),
				),
				'std'        => 'in',
				'dependency' => array(
					'element' => 'transparency_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Speed', 'alpha-core' ),
				'param_name' => 't_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'transparency_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Rotate', 'alpha-core' )            => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
				'param_name' => 'rotate_scroll',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Direction', 'alpha-core' ),
				'param_name' => 'r_direction',
				'value'      => array(
					'left'  => array(
						'title' => esc_html__( 'To Left', 'alpha-core' ),
					),
					'right' => array(
						'title' => esc_html__( 'To Right', 'alpha-core' ),
					),
				),
				'std'        => 'left',
				'dependency' => array(
					'element' => 'rotate_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Speed', 'alpha-core' ),
				'param_name' => 'r_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'rotate_scroll',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Scale', 'alpha-core' )             => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
				'param_name' => 'scale_scroll',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Direction', 'alpha-core' ),
				'param_name' => 's_direction',
				'value'      => array(
					'in'  => array(
						'title' => esc_html__( 'Scale Up', 'alpha-core' ),
					),
					'out' => array(
						'title' => esc_html__( 'Scale Down', 'alpha-core' ),
					),
				),
				'std'        => 'in',
				'dependency' => array(
					'element' => 'scale_scroll',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Speed', 'alpha-core' ),
				'param_name' => 's_speed',
				'value'      => 3,
				'dependency' => array(
					'element' => 'scale_scroll',
					'value'   => 'yes',
				),
			),
		),
	),
	esc_html__( 'Mouse Track Effect', 'alpha-core' ) => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Effect', 'alpha-core' ),
			'param_name' => 'mouse_track',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Relative', 'alpha-core' ),
			'param_name' => 'track_relative',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Direction', 'alpha-core' ),
			'param_name' => 'track_direction',
			'value'      => array(
				'opposite' => array(
					'title' => esc_html__( 'Opposite', 'alpha-core' ),
				),
				'direct'   => array(
					'title' => esc_html__( 'Direct', 'alpha-core' ),
				),
			),
			'std'        => 'opposite',
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Speed', 'alpha-core' ),
			'param_name' => 'track_speed',
			'value'      => 1,
			'dependency' => array(
				'element' => 'mouse_track',
				'value'   => 'yes',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Floating Wrapper', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_floating_wrapper',
		'icon'            => 'alpha-icon alpha-icon-floating',
		'class'           => 'alpha_floating_wrapper',
		'as_parent'       => array( 'except' => '' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha floating wrapper.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Floating_Wrapper extends WPBakeryShortCodesContainer {}' );
}

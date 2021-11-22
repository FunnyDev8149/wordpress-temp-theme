<?php
/**
 * Carousel Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		array(
			'type'        => 'alpha_number',
			'heading'     => esc_html__( 'Columns', 'alpha-core' ),
			'responsive'  => true,
			'param_name'  => 'col_cnt',
			'description' => esc_html__( 'Leave it blank to give default value', 'alpha-core' ),
		),
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Column Spacing', 'alpha-core' ),
			'param_name'  => 'col_sp',
			'value'       => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'alpha-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'alpha-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'alpha-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'alpha-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'alpha-core' ),
				),
			),
			'description' => esc_html__( 'Change gap size of carousel items.', 'alpha-core' ),
			'std'         => 'md',
		),
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Vertical Align', 'alpha-core' ),
			'param_name'  => 'slider_vertical_align',
			'value'       => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'alpha-core' ),
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'alpha-core' ),
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'alpha-core' ),
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'alpha-core' ),
				),
			),
			'description' => esc_html__( 'Change vertical alignment of carousel items.', 'alpha-core' ),
		),
	),
	esc_html__( 'Carousel Options', 'alpha-core' ) => array(
		esc_html__( 'Options', 'alpha-core' ) => array(
			'alpha_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'alpha-core' )     => array(
			'alpha_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'alpha-core' )    => array(
			'alpha_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_carousel' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Carousel', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_carousel',
		'icon'            => 'alpha-icon alpha-icon-carousel',
		'class'           => 'alpha_carousel',
		'as_parent'       => array( 'except' => 'wpb_' . ALPHA_NAME . '_carousel' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha carousel.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Carousel extends WPBakeryShortCodesContainer {}' );
}

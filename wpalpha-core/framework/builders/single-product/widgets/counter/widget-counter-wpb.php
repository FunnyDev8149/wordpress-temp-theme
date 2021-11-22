<?php
/**
 * Alpha Single Product Counter
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Content', 'alpha-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Starting Number', 'alpha-core' ),
			'param_name' => 'starting_number',
			'std'        => 0,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Additional Count', 'alpha-core' ),
			'param_name' => 'adding_number',
			'std'        => 0,
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Ending Number', 'alpha-core' ),
			'param_name' => 'ending_number',
			'value'      => array(
				esc_html__( 'Sale Count', 'alpha-core' ) => 'sale',
				esc_html__( 'Stock', 'alpha-core' )      => 'stock',
			),
			'std'        => 'sale',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Number Prefix', 'alpha-core' ),
			'param_name' => 'prefix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Number Suffix', 'alpha-core' ),
			'param_name' => 'suffix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Animation Duration', 'alpha-core' ),
			'param_name' => 'duration',
			'std'        => 0,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Thousand Separator', 'alpha-core' ),
			'param_name' => 'thousand_separator',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Separator', 'alpha-core' ),
			'param_name' => 'thousand_separator_char',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => '',
				esc_html__( 'Dot', 'alpha-core' )     => '.',
				esc_html__( 'Space', 'alpha-core' )   => ' ',
			),
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'alpha-core' ),
			'param_name' => 'title',
			'std'        => esc_html__( 'Sale Products', 'alpha-core' ),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'counter_align',
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
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Number', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper',
				),
			),
		),
		esc_html__( 'Title', 'alpha-core' )  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'title_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Counter', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_counter',
		'icon'            => 'alpha-icon alpha-icon-sp-counter',
		'class'           => 'alpha_sp_counter',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product counter.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Counter extends WPBakeryShortCode {}' );
}

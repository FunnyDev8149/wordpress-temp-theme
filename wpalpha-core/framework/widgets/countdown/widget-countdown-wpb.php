<?php
/**
 * Alpha Countdown
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Content', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .countdown-container' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'type',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Block', 'alpha-core' )  => 'block',
				esc_html__( 'Inline', 'alpha-core' ) => 'inline',
			),
			'std'        => 'block',
		),
		array(
			'type'       => 'alpha_datetimepicker',
			'param_name' => 'date',
			'heading'    => esc_html__( 'Target Date', 'alpha-core' ),
			'value'      => '',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'timezone',
			'heading'    => esc_html__( 'Timezone', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'WordPress Defined Timezone', 'alpha-core' )    => '',
				esc_html__( 'User System Timezone', 'alpha-core' )   => 'user_timezone',
			),
			'std'        => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Label', 'alpha-core' ),
			'param_name'  => 'label',
			'value'       => 'Offer Ends In',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'inline',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'label_type',
			'heading'    => esc_html__( 'Unit Type', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Full', 'alpha-core' )  => '',
				esc_html__( 'Short', 'alpha-core' ) => 'short',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'label_pos',
			'heading'    => esc_html__( 'Unit Position', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Inner', 'alpha-core' )  => '',
				esc_html__( 'Outer', 'alpha-core' )  => 'outer',
				esc_html__( 'Custom', 'alpha-core' ) => 'custom',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Label Position', 'alpha-core' ),
			'param_name' => 'label_dimension',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .countdown .countdown-period' => 'bottom: {{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'label_pos',
				'value'   => 'custom',
			),
		),
		array(
			'type'       => 'alpha_multiselect',
			'param_name' => 'date_format',
			'heading'    => esc_html__( 'Units', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Year', 'alpha-core' )   => 'Y',
				esc_html__( 'Month', 'alpha-core' )  => 'O',
				esc_html__( 'Week', 'alpha-core' )   => 'W',
				esc_html__( 'Day', 'alpha-core' )    => 'D',
				esc_html__( 'Hour', 'alpha-core' )   => 'H',
				esc_html__( 'Minute', 'alpha-core' ) => 'M',
				esc_html__( 'Second', 'alpha-core' ) => 'S',
			),
			'std'        => 'D,H,M,S',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide Spliter', 'alpha-core' ),
			'param_name' => 'hide_split',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Dimension', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Item Padding', 'alpha-core' ),
				'param_name' => 'item_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Label Margin', 'alpha-core' ),
				'param_name' => 'label_margin',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-label' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'inline',
				),
			),
		),
		esc_html__( 'Typography', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Amount', 'alpha-core' ),
				'param_name' => 'countdown_amount',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-container .countdown-amount',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Unit, Label', 'alpha-core' ),
				'param_name' => 'countdown_label',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-period',
					'{{WRAPPER}} .countdown-label',
				),
			),
		),
		esc_html__( 'Color', 'alpha-core' )      => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Section Background', 'alpha-core' ),
				'param_name' => 'countdown_section_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Amount', 'alpha-core' ),
				'param_name' => 'countdown_amount_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-amount' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Unit, Label', 'alpha-core' ),
				'param_name' => 'countdown_label_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-period' => 'color: {{VALUE}};',
					'{{WRAPPER}} .countdown-label'  => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Separator Color', 'alpha-core' ),
				'param_name' => 'countdown_separator_color',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Border', 'alpha-core' )     => array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'border-type',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => '',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'std'        => '',
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'border-style: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'border-radius',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .countdown-section' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Countdown', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_countdown',
		'icon'            => 'alpha-icon alpha-icon-timer',
		'class'           => 'alpha_countdown',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha countdown.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Countdown extends WPBakeryShortCode {}' );
}

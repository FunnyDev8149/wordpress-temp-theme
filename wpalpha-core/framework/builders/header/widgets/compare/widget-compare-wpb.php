<?php
/**
 * Header Compare Button
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )       => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Compare Type', 'alpha-core' ),
			'param_name' => 'type',
			'std'        => 'inline',
			'value'      => array(
				'block'  => array(
					'title' => esc_html__( 'Block', 'alpha-core' ),
				),
				'inline' => array(
					'title' => esc_html__( 'Inline', 'alpha-core' ),
				),
			),
		),
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Mini Compare List', 'alpha-core' ),
			'param_name'  => 'minicompare',
			'description' => esc_html__( 'Choose where to display mini compare list', 'alpha-core' ),
			'std'         => '',
			'value'       => array(
				''          => array(
					'title' => esc_html__( 'Simple', 'alpha-core' ),
				),
				'dropdown'  => array(
					'title' => esc_html__( 'Dropdown', 'alpha-core' ),
				),
				'offcanvas' => array(
					'title' => esc_html__( 'Off-Canvas', 'alpha-core' ),
				),
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Icon', 'alpha-core' ),
			'param_name' => 'show_icon',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Count', 'alpha-core' ),
			'param_name' => 'show_count',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => '',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'alpha-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Compare Icon', 'alpha-core' ),
			'param_name' => 'icon',
			'dependency' => array(
				'element' => 'show_icon',
				'value'   => 'yes',
			),
			'std'        => ALPHA_ICON_PREFIX . '-icon-compare',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Compare Label', 'alpha-core' ),
			'param_name' => 'label',
			'std'        => esc_html__( 'Compare', 'alpha-core' ),
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Dropdown Position', 'alpha-core' ),
			'param_name' => 'dropdown_pos',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'dependency' => array(
				'element' => 'minicompare',
				'value'   => 'dropdown',
			),
			'selectors'  => array(
				'{{WRAPPER}} .dropdown-box' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
	),
	esc_html__( 'Compare Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Compare Typography', 'alpha-core' ),
			'param_name' => 'compare_typography',
			'selectors'  => array(
				'{{WRAPPER}} .compare-open',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'compare_icon',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-open i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Space', 'alpha-core' ),
			'param_name' => 'compare_icon_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .block-type i + span'  => 'margin-top: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .inline-type i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'compare_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .compare-open',
				'hover'  => '{{WRAPPER}} .compare-open:hover',
			),
			'choices'    => array( 'color' ),
		),
	),
	esc_html__( 'Compare Badge', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Badge Size', 'alpha-core' ),
			'param_name' => 'badge_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Horizontal Position', 'alpha-core' ),
			'param_name' => 'badge_h_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Vertical Position', 'alpha-core' ),
			'param_name' => 'badge_v_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Background Color', 'alpha-core' ),
			'param_name' => 'badge_count_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Color', 'alpha-core' ),
			'param_name' => 'badge_count_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Compare', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_compare',
		'icon'            => 'alpha-icon alpha-icon-compare',
		'class'           => 'alpha_hb_compare',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Mini compare of dropdown, offcanvas type.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Compare extends WPBakeryShortCode {}' );
}

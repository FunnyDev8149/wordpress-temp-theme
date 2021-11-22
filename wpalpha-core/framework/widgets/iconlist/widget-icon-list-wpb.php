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
			'param_name' => 'view',
			'heading'    => esc_html__( 'Layout', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => 'block',
				esc_html__( 'Inline', 'alpha-core' )  => 'inline',
			),
			'std'        => 'block',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'icon_h_align',
			'value'      => array(
				'start'  => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
				),
				'end'    => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
				),
			),
			'dependency' => array(
				'element' => 'view',
				'value'   => 'block',
			),
			'std'        => 'start',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'icon_v_align',
			'value'      => array(
				'start'  => array(
					'title' => esc_html__( 'Top', 'alpha-core' ),
				),
				'center' => array(
					'title' => esc_html__( 'Middle', 'alpha-core' ),
				),
				'end'    => array(
					'title' => esc_html__( 'Bottom', 'alpha-core' ),
				),
			),
			'dependency' => array(
				'element' => 'view',
				'value'   => 'inline',
			),
			'std'        => 'center',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'alpha-core' ),
			'param_name'  => 'title',
			'placeholder' => esc_html( 'Enter your title', 'alpha-core' ),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Title', 'alpha-core' )     => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'title_margin',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .list-title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .list-title',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .list-title' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'List Item', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'item_typography',
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'item_padding',
				'responsive' => true,
				'std'        => '{``top``:{``xl``:``5``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``right``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``10``},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5``},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``10``}}',
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'item_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .alpha-icon-list-item',
					'hover'  => '{{WRAPPER}} .alpha-icon-list-item:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Divider', 'alpha-core' )   => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Divider', 'alpha-core' ),
				'param_name' => 'divider',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item:not(:last-child):after' => 'content:"";',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'alpha-core' ),
				'param_name' => 'divider_style',
				'value'      => array(
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
				),
				'std'        => 'solid',
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item:not(:last-child):after' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Width', 'alpha-core' ),
				'param_name' => 'divider_width',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}.block-type .alpha-icon-list-item:not(:last-child):after' => 'width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .alpha-icon-list-item:not(:last-child):after' => 'border-right-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .alpha-icon-list-item:not(:last-child)' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Height', 'alpha-core' ),
				'param_name' => 'divider_height',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}.block-type .alpha-icon-list-item:not(:last-child):after' => 'border-bottom-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.block-type .alpha-icon-list-item:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}}.inline-type .alpha-icon-list-item:not(:last-child):after' => 'height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'divider_color',
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Icon', 'alpha-core' )      => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'icon_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'icon_padding',
				'responsive' => true,
				'std'        => '{``top``:{``xl``:``0``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``right``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5``},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``0``},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``0``}}',
				'selectors'  => array(
					'{{WRAPPER}} .alpha-icon-list-item i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'icon_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}}  .alpha-icon-list-item i',
					'hover'  => '{{WRAPPER}}  .alpha-icon-list-item i:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Icon List', 'alpha-core' ),
		'base'                    => 'wpb_' . ALPHA_NAME . '_icon_list',
		'icon'                    => 'alpha-icon alpha-icon-list',
		'class'                   => 'wpb_' . ALPHA_NAME . '_icon_list',
		'controls'                => 'full',
		'category'                => ALPHA_DISPLAY_NAME,
		'description'             => esc_html__( 'Create alpha icon list.', 'alpha-core' ),
		'as_parent'               => array( 'only' => 'wpb_' . ALPHA_NAME . '_icon_list_item' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_' . ALPHA_NAME . '_icon_list_item][wpb_' . ALPHA_NAME . '_icon_list_item selected_icon="fas fa-times"][wpb_' . ALPHA_NAME . '_icon_list_item selected_icon="fas fa-dot-circle"][/wpb_' . ALPHA_NAME . '_icon_list]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Icon_List extends WPBakeryShortCodesContainer {}' );
}

<?php
/**
 * Share Icon Element
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
			'heading'     => esc_html__( 'Text', 'alpha-core' ),
			'param_name'  => 'text',
			'std'         => esc_html( 'List Item', 'alpha-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'param_name' => 'selected_icon',
			'std'        => 'fas fa-check',
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'alpha-core' ),
			'param_name' => 'link',
			'value'      => '',
		),

	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}}.alpha-icon-list-item i' => 'font-size: {{VALUE}}{{UNIT}}',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'icon_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}.alpha-icon-list-item i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Icon List Item', 'alpha-core' ),
		'base'        => 'wpb_' . ALPHA_NAME . '_icon_list_item',
		'icon'        => 'alpha-icon alpha-icon-list',
		'class'       => 'wpb_' . ALPHA_NAME . '_icon_list_item',
		'controls'    => 'full',
		'category'    => ALPHA_DISPLAY_NAME,
		'description' => esc_html__( 'Create alpha icon list item.', 'alpha-core' ),
		'as_child'    => array( 'only' => 'wpb_' . ALPHA_NAME . '_icon_list' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Icon_List_Item extends WPBakeryShortCode {}' );
}

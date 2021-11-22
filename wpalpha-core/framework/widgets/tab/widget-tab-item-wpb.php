<?php
/**
 * Tab Item Element
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
			'heading'     => esc_html__( 'Tab Item Title', 'alpha-core' ),
			'param_name'  => 'tab_title',
			'value'       => 'Tab',
			'admin_label' => true,
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Tab Item', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_tab_item',
		'icon'            => 'alpha-icon alpha-icon-tab',
		'class'           => 'alpha_tab_item',
		'as_parent'       => array( 'except' => 'wpb_' . ALPHA_NAME . '_tab_item' ),
		'as_child'        => array( 'only' => 'wpb_' . ALPHA_NAME . '_tab' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha tab item.', 'alpha-core' ),
		'default_content' => '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Tab_Item extends  WPBakeryShortCodesContainer {}' );
}

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
			'type'       => 'alpha_button_group',
			'param_name' => 'social_type',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'value'      => array(
				'left'    => array(
					'title' => esc_html__( 'Default', 'alpha-core' ),
				),
				'stacked' => array(
					'title' => esc_html__( 'Stacked', 'alpha-core' ),
				),
				'framed'  => array(
					'title' => esc_html__( 'Framed', 'alpha-core' ),
				),
			),
			'std'        => 'stacked',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon',
			'heading'     => esc_html__( 'Select Icon', 'alpha-core' ),
			'value'       => array(
				esc_html__( 'facebook', 'alpha-core' )  => 'facebook',
				esc_html__( 'twitter', 'alpha-core' )   => 'twitter',
				esc_html__( 'linkedin', 'alpha-core' )  => 'linkedin',
				esc_html__( 'email', 'alpha-core' )     => 'email',
				esc_html__( 'instagram', 'alpha-core' ) => 'instagram',
				esc_html__( 'youtube', 'alpha-core' )   => 'youtube',
				esc_html__( 'google', 'alpha-core' )    => 'google',
				esc_html__( 'pinterest', 'alpha-core' ) => 'pinterest',
				esc_html__( 'reddit', 'alpha-core' )    => 'reddit',
				esc_html__( 'tumblr', 'alpha-core' )    => 'tumblr',
				esc_html__( 'vk', 'alpha-core' )        => 'vk',
				esc_html__( 'whatsapp', 'alpha-core' )  => 'whatsapp',
				esc_html__( 'xing', 'alpha-core' )      => 'xing',
			),
			'std'         => 'facebook',
			'admin_label' => true,
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'alpha-core' ),
			'description' => esc_html__( 'Please leave it blank to share this page or input URL for social login', 'alpha-core' ),
			'param_name'  => 'link',
			'value'       => '',
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Icon Colors', 'alpha-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}}.social-icon',
				'hover'  => '{{WRAPPER}}.social-icon:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
			'dependency' => array(
				'element'   => 'icon',
				'not_empty' => true,
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Share Icon', 'alpha-core' ),
		'base'        => 'wpb_' . ALPHA_NAME . '_share_icon',
		'icon'        => 'alpha-icon alpha-icon-share',
		'class'       => 'wpb_' . ALPHA_NAME . '_share_icon',
		'controls'    => 'full',
		'category'    => ALPHA_DISPLAY_NAME,
		'description' => esc_html__( 'Create alpha share icon.', 'alpha-core' ),
		'as_child'    => array( 'only' => 'wpb_' . ALPHA_NAME . '_share_icons' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Share_Icon extends WPBakeryShortCode {}' );
}

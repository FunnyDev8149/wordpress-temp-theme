<?php
/**
 * Header Contact Link
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )       => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Contact Icon', 'alpha-core' ),
			'param_name' => 'contact_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-call',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Live Chat Text', 'alpha-core' ),
			'param_name' => 'contact_link_text',
			'std'        => esc_html__( 'Live Chat', 'alpha-core' ),
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Live Chat Link', 'alpha-core' ),
			'param_name'  => 'link',
			'placeholder' => 'mailto://youremail',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Telephone Number', 'alpha-core' ),
			'param_name' => 'contact_telephone',
			'std'        => esc_html__( '0(800)123-456', 'alpha-core' ),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Telephone Link', 'alpha-core' ),
			'param_name'  => 'contact_telephone_link',
			'placeholder' => 'tel://1234567890',
			'value'       => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Delimiter', 'alpha-core' ),
			'param_name' => 'contact_delimiter',
			'std'        => esc_html__( 'or:', 'alpha-core' ),
		),
	),
	esc_html__( 'Contact Style', 'alpha-core' ) => array(
		esc_html__( 'Contact Icon', 'alpha-core' ) => array(

			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'param_name' => 'icon_font_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'icon_color',
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'icon_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .contact i' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
		),
		esc_html__( 'Live Chat', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'link_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .live-chat',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'live_chat_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .contact-content .live-chat',
					'hover'  => '{{WRAPPER}} .contact-content .live-chat:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Telephone', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'telephone_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .telephone',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'telephone_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .contact-content .telephone',
					'hover'  => '{{WRAPPER}} .contact:hover .telephone, {{WRAPPER}} .contact:hover i',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Delimiter', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'delimiter_typography',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .contact-delimiter',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'delimiter_color',
				'selectors'  => array(
					'{{WRAPPER}} .contact-content .contact-delimiter' => 'color: {{VALUE}};',
				),
			),
		),
	),

);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Contact', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_contact',
		'icon'            => 'alpha-icon alpha-icon-contact',
		'class'           => 'alpha_hb_contact',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha contact.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Contact extends WPBakeryShortCode {}' );
}

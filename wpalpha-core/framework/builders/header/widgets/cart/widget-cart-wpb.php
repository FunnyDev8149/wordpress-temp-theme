<?php
/**
 * Alpha Header Cart
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		esc_html__( 'Cart Type', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Cart Type', 'alpha-core' ),
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
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Cart Icon Type', 'alpha-core' ),
				'param_name' => 'icon_type',
				'std'        => 'badge',
				'value'      => array(
					'badge' => array(
						'title' => esc_html__( 'Badge Type', 'alpha-core' ),
					),
					'label' => array(
						'title' => esc_html__( 'Label Type', 'alpha-core' ),
					),
				),
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Cart Icon', 'alpha-core' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'std'        => ALPHA_ICON_PREFIX . '-icon-cart',
			),
		),
		esc_html__( 'Cart Label', 'alpha-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Label', 'alpha-core' ),
				'param_name' => 'show_label',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Label', 'alpha-core' ),
				'param_name' => 'label',
				'std'        => esc_html__( 'My Cart', 'alpha-core' ),
				'dependency' => array(
					'element' => 'show_label',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Cart Total Price', 'alpha-core' ),
				'param_name' => 'show_price',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Delimiter', 'alpha-core' ),
				'param_name' => 'delimiter',
				'std'        => '/',
				'dependency' => array(
					'element' => 'show_label',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Count Prefix', 'alpha-core' ),
				'param_name' => 'count_pfx',
				'std'        => '(',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'label',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Cart Count Suffix', 'alpha-core' ),
				'param_name' => 'count_sfx',
				'std'        => esc_html__( 'items )', 'alpha-core' ),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'label',
				),
			),
		),
		esc_html__( 'Off Canvas', 'alpha-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Off Canvas', 'alpha-core' ),
				'param_name' => 'cart_off_canvas',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Cart Toggle', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'cart_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'cart_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .cart-toggle',
					'hover'  => '{{WRAPPER}} .cart-dropdown:hover .cart-toggle',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Cart Label', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'cart_typography',
				'selectors'  => array(
					'{{WRAPPER}} .cart-toggle, {{WRAPPER}} .cart-count',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Delimiter Space', 'alpha-core' ),
				'param_name' => 'cart_delimiter_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart-name-delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
				),
			),
		),
		esc_html__( 'Cart Price', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'cart_price_typography',
				'selectors'  => array(
					'{{WRAPPER}} .cart-price',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'cart_price_margin',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .cart-price' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Cart Icon', 'alpha-core' )   => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'param_name' => 'cart_icon_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .cart-dropdown .cart-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Space', 'alpha-core' ),
				'param_name' => 'cart_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .block-type .cart-label + i' => 'margin-bottom: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .inline-type .cart-label + i' => "margin-{$left}: {{VALUE}}{{UNIT}};",
				),
			),
		),
		esc_html__( 'Badge', 'alpha-core' )       => array(
			array(
				'type'       => 'alpha_heading',
				'label'      => esc_html__( 'These options are avaiable only in badge icon type.', 'alpha-core' ),
				'param_name' => 'cart_badge_style_description',
				'tag'        => 'p',
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Badge Size', 'alpha-core' ),
				'param_name' => 'badge_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Horizontal Position', 'alpha-core' ),
				'param_name' => 'badge_h_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => "{$left}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Vertical Position', 'alpha-core' ),
				'param_name' => 'badge_v_position',
				'responsive' => true,
				'units'      => array(
					'px',
					'%',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'top: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Count Background Color', 'alpha-core' ),
				'param_name' => 'badge_count_bg_color',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Count Color', 'alpha-core' ),
				'param_name' => 'badge_count_bd_color',
				'dependency' => array(
					'element' => 'icon_type',
					'value'   => 'badge',
				),
				'selectors'  => array(
					'{{WRAPPER}} .badge-type .cart-count' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Cart Form', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_cart',
		'icon'            => 'alpha-icon alpha-icon-cart',
		'class'           => 'alpha_hb_cart',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha cart.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Cart extends WPBakeryShortCode {}' );
}

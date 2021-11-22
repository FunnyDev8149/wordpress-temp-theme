<?php
/**
 * Header Account Button
 *
 * @since 1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Account Type', 'alpha-core' ),
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
			'type'       => 'alpha_multiselect',
			'heading'    => esc_html__( 'Show Items', 'alpha-core' ),
			'param_name' => 'account_items',
			'value'      => array(
				esc_html__( 'User Icon', 'alpha-core' ) => 'icon',
				esc_html__( 'Login/Logout Label', 'alpha-core' ) => 'login',
				esc_html__( 'Register Label', 'alpha-core' ) => 'register',
			),
			'std'        => 'icon,login,register',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Dropdown Align', 'alpha-core' ),
			'param_name' => 'dropdown_align',
			'value'      => array(
				'auto' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				''     => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => '',
			'selectors'  => array(
				'{{WRAPPER}} .dropdown-box' => 'right: {{VALUE}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'param_name' => 'icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-account',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Login Text', 'alpha-core' ),
			'param_name' => 'account_login',
			'std'        => esc_html__( 'Log in', 'alpha-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Logout Text', 'alpha-core' ),
			'param_name' => 'account_logout',
			'std'        => esc_html__( 'Log out', 'alpha-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Register Text', 'alpha-core' ),
			'param_name' => 'account_register',
			'std'        => esc_html__( 'Register', 'alpha-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Delimiter Text', 'alpha-core' ),
			'param_name'  => 'account_delimiter',
			'description' => esc_html__( 'Account Delimiter will be shown between Login and Register links', 'alpha-core' ),
			'std'         => '/',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Enable Social Login', 'alpha-core' ),
			'param_name' => 'social_login',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Loggined Options', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_heading',
			'label'      => esc_html__( 'When user is logged in', 'alpha-core' ),
			'tag'        => 'h4',
			'param_name' => 'account_loggined_heading',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Menu Dropdown', 'alpha-core' ),
			'param_name'  => 'account_dropdown',
			'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'description' => esc_html__( 'Menu that is located in Account Menu will be shown.', 'alpha-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Logout Text', 'alpha-core' ),
			'param_name'  => 'account_logout',
			'std'         => 'Log out',
			'description' => esc_html__( 'Please input %name% where you want to show current user name. ( ex: Hi, %name%! )', 'alpha-core' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Avatar', 'alpha-core' ),
			'param_name' => 'account_avatar',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Styles', 'alpha-core' )           => array(
		esc_html__( 'Account Styles', 'alpha-core' )   => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Account Typography', 'alpha-core' ),
				'param_name' => 'account_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account a',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'param_name' => 'account_icon',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Space', 'alpha-core' ),
				'param_name' => 'account_icon_space',
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
				'param_name' => 'account_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .account > a',
					'hover'  => '{{WRAPPER}} .account > a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Delimiter Styles', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Delimiter Typography', 'alpha-core' ),
				'param_name' => 'deimiter_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Delimiter Color', 'alpha-core' ),
				'param_name' => 'delimiter_color',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Delimiter Space', 'alpha-core' ),
				'param_name' => 'account_delimiter_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'margin-left: {{VALUE}}{{UNIT}}; margin-right: {{VALUE}}{{UNIT}}; ',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Account', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hb_account',
		'icon'            => 'alpha-icon alpha-icon-account',
		'class'           => 'alpha_hb_account',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Header', 'alpha-core' ),
		'description'     => esc_html__( 'Create alpha account.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_HB_Account extends WPBakeryShortCode {}' );
}

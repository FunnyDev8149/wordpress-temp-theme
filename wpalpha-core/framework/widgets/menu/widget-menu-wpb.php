<?php
/**
 * Alpha Menu Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

function get_menu_items() {
	$menu_items = array();
	$menus      = wp_get_nav_menus();
	foreach ( $menus as $key => $item ) {
		$menu_items[ $item->name ] = $item->term_id;
	}
	return $menu_items;
}

$wpb_menu_items = array_merge( array( esc_html__( 'Select Menu', 'alpha-core' ) => '' ), get_menu_items() );

$params = array(
	esc_html__( 'Menu', 'alpha-core' )  => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'menu_id',
			'heading'     => esc_html__( 'Select Menu', 'alpha-core' ),
			'value'       => $wpb_menu_items,
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'type',
			'heading'     => esc_html__( 'Select Type', 'alpha-core' ),
			'value'       => array(
				esc_html__( 'Horizontal', 'alpha-core' ) => 'horizontal',
				esc_html__( 'Vertical', 'alpha-core' )   => 'vertical',
				esc_html__( 'Vertical Collapsible', 'alpha-core' ) => 'collapsible',
				esc_html__( 'Toggle Dropdown', 'alpha-core' ) => 'dropdown',
			),
			'std'         => 'vertical',
			'admin_label' => true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show as dropdown links in mobile', 'alpha-core' ),
			'param_name' => 'mobile',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'horizontal',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Mobile Links Label', 'alpha-core' ),
			'description' => esc_html__( 'When mobile options is true, It only works.', 'alpha-core' ),
			'param_name'  => 'mobile_label',
			'value'       => esc_html__( 'LINKS', 'alpha-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'horizontal',
				'element' => 'mobile',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Mobile Dropdown Position', 'alpha-core' ),
			'description' => esc_html__( 'When mobile options is true, It only works.', 'alpha-core' ),
			'param_name'  => 'mobile_dropdown_pos',
			'value'       => array(
				'dp-left'  => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'dp-right' => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'horizontal',
				'element' => 'mobile',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Width', 'alpha-core' ),
			'param_name' => 'width',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'value'      => '{"xl":"300","unit":"px"}',
			'dependency' => array(
				'element'            => 'type',
				'value_not_equal_to' => 'horizontal',
			),
			'selectors'  => array(
				'{{WRAPPER}} .menu,{{WRAPPER}} .toggle-menu' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Underline on hover', 'alpha-core' ),
			'param_name' => 'underline',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element'            => 'type',
				'value_not_equal_to' => 'dropdown',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Toggle Label', 'alpha-core' ),
			'param_name' => 'label',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'alpha-core' ),
			'param_name' => 'icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-category',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'No Border', 'alpha-core' ),
			'param_name' => 'no_bd',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'No Triangle in Dropdown', 'alpha-core' ),
			'param_name' => 'no_triangle',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'selectors'  => array(
				'{{WRAPPER}}  .menu .menu-item-has-children:after, {{WRAPPER}} .toggle-menu:after' => 'content: none;',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show In Homepage', 'alpha-core' ),
			'description' => esc_html__( 'Menu Dropdown will be shown only in homepage.', 'alpha-core' ),
			'param_name'  => 'show_home',
			'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show In All Page', 'alpha-core' ),
			'description' => esc_html__( 'Menu Dropdown will be shown in all pages.', 'alpha-core' ),
			'param_name'  => 'show_page',
			'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' ) => array(
		esc_html__( 'Menu Toggle', 'alpha-core' )   => array(
			array(
				'type'       => 'alpha_heading',
				'label'      => esc_html__( 'Here options are available for only \'Toggle Dropdown\' type.  ', 'alpha-core' ),
				'param_name' => 'toggle_heading',
				'tag'        => 'p',
				'class'      => 'alpha-heading-control-class',
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'toggle_typography',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu .dropdown-menu-toggle',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'param_name' => 'toggle_icon',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Icon Space', 'alpha-core' ),
				'param_name' => 'toggle_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'toggle_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'toggle_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'toggle_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .toggle-menu .dropdown-menu-toggle',
					'hover'  => '{{WRAPPER}} .toggle-menu:hover .dropdown-menu-toggle',
				),
				'choices'    => array( 'color', 'background-color' ),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'toggle_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu .dropdown-menu-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
			),
		),
		esc_html__( 'Menu Ancestor', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'ancestor_typography',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'ancestor_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .menu > li:not(:last-child) > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'ancestor_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'ancestor_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .menu > li > a',
					'hover'  => '{{WRAPPER}} .menu > li:hover > a, {{WRAPPER}} .menu > .current-menu-item > a, {{WRAPPER}} .menu > .current-menu-ancestor > a',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'ancestor_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'ancestor_margin',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .menu > li'            => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
					'{{WRAPPER}} .menu > li:last-child' => 'margin: 0;',
				),
			),
		),
		esc_html__( 'Submenu Item', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'submenu_typography',
				'selectors'  => array(
					'{{WRAPPER}} li ul',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'submenu_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'submenu_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'submenu_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} li .menu-item > a',
					'hover'  => '{{WRAPPER}} li .menu-item:hover > a:not(.nolink)',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'submenu_padding',
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'submenu_margin',
				'selectors'  => array(
					'{{WRAPPER}} li li'            => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
					'{{WRAPPER}} li li:last-child' => 'margin: 0;',
				),
			),
		),
		esc_html__( 'Menu Dropdown', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'dropdown_padding',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu .menu'     => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
					'{{WRAPPER}} .mobile-links nav > ul' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'dropdown_bg',
				'selectors'  => array(
					'{{WRAPPER}} .vertical-menu'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .menu li > ul'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .collapsible-menu'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .toggle-menu::after'  => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .menu > .menu-item-has-children::after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .vertical-menu > .menu-item-has-children::after' => 'border-right-color: {{VALUE}};border-bottom-color: transparent;',
					'{{WRAPPER}} .mobile-links nav'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mobile-links::after' => 'border-bottom-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
				'param_name' => 'dropdown_bd_color',
				'selectors'  => array(
					'{{WRAPPER}} .has-border .menu'   => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .has-border::before' => 'border-bottom-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'type',
					'value'              => 'dropdown',
					'element'            => 'no_bd',
					'value_not_equal_to' => 'yes',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Menu', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_menu',
		'icon'            => 'alpha-icon alpha-icon-menu',
		'class'           => 'alpha_menu',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create Menu.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Menu extends WPBakeryShortCode {}' );
}

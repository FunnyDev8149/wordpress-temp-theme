<?php
/**
 * Button Element
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
			'heading'     => esc_html__( 'Button Title', 'alpha-core' ),
			'param_name'  => 'label',
			'value'       => esc_html( 'Click here', 'alpha-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Expand Button', 'alpha-core' ),
			'param_name' => 'button_expand',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'button_align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'dependency' => array(
				'element'            => 'button_expand',
				'value_not_equal_to' => 'yes',
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'alpha-core' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'param_name' => 'button_type',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => 'default',
				esc_html__( 'Solid', 'alpha-core' )   => 'btn-solid',
				esc_html__( 'Outline', 'alpha-core' ) => 'btn-outline',
				esc_html__( 'Inline', 'alpha-core' )  => 'btn-link',
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Size', 'alpha-core' ),
			'param_name' => 'button_size',
			'value'      => array(
				'btn-sm'  => array(
					'title' => esc_html__( 'Small', 'alpha-core' ),
				),
				'btn-md'  => array(
					'title' => esc_html__( 'Medium', 'alpha-core' ),
				),
				'default' => array(
					'title' => esc_html__( 'Normal', 'alpha-core' ),
				),
				'btn-lg'  => array(
					'title' => esc_html__( 'Large', 'alpha-core' ),
				),
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Hover Underline', 'alpha-core' ),
			'param_name' => 'link_hover_type',
			'value'      => array(
				'default'          => array(
					'title' => esc_html__( 'None', 'alpha-core' ),
				),
				'btn-underline sm' => array(
					'title' => esc_html__( 'Underline1', 'alpha-core' ),
				),
				'btn-underline'    => array(
					'title' => esc_html__( 'Underline2', 'alpha-core' ),
				),
				'btn-underline lg' => array(
					'title' => esc_html__( 'Underline3', 'alpha-core' ),
				),
			),
			'std'        => 'default',
			'dependency' => array(
				'element' => 'button_type',
				'value'   => 'btn-link',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Box Shadow', 'alpha-core' ),
			'param_name' => 'shadow',
			'value'      => array(
				esc_html__( 'None', 'alpha-core' )     => 'default',
				esc_html__( 'Shadow 1', 'alpha-core' ) => 'btn-shadow-sm',
				esc_html__( 'Shadow 2', 'alpha-core' ) => 'btn-shadow',
				esc_html__( 'Shadow 3', 'alpha-core' ) => 'btn-shadow-lg',
			),
			'std'        => 'default',
			'dependency' => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Border Style', 'alpha-core' ),
			'param_name' => 'button_border',
			'label_type' => 'icon',
			'value'      => array(
				'default'     => array(
					'title' => esc_html__( 'Rectangle', 'alpha-core' ),
					'icon'  => 'attr-icon-square',
				),
				'btn-rounded' => array(
					'title' => esc_html__( 'Rounded', 'alpha-core' ),
					'icon'  => 'attr-icon-rounded',
				),
				'btn-ellipse' => array(
					'title' => esc_html__( 'Ellipse', 'alpha-core' ),
					'icon'  => 'attr-icon-ellipse',
				),
			),
			'std'        => 'default',
			'dependency' => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Skin', 'alpha-core' ),
			'param_name' => 'button_skin',
			'value'      => array(
				'default'       => array(
					'title' => esc_html__( 'Default', 'alpha-core' ),
					'color' => '#eee',
				),
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'alpha-core' ),
					'color' => 'var(--alpha-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'alpha-core' ),
					'color' => 'var(--alpha-secondary-color,#f93)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'alpha-core' ),
					'color' => 'var(--alpha-alert-color,#a94442)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'alpha-core' ),
					'color' => 'var(--alpha-success-color,#799b5a)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'alpha-core' ),
					'color' => 'var(--alpha-dark-color,#333)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'alpha-core' ),
					'color' => '#fff',
				),
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Disable Line-break', 'alpha-core' ),
			'param_name' => 'line_break',
			'value'      => array(
				'nowrap' => array(
					'title' => esc_html__( 'On', 'alpha-core' ),
				),
				'normal' => array(
					'title' => esc_html__( 'Off', 'alpha-core' ),
				),
			),
			'std'        => 'nowrap',
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'white-space: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Icon', 'alpha-core' )    => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Icon?', 'alpha-core' ),
			'param_name' => 'show_icon',
			'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'alpha-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'param_name' => 'icon',
			'std'        => '',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Icon Position', 'alpha-core' ),
			'param_name' => 'icon_pos',
			'value'      => array(
				'after'  => array(
					'title' => esc_html__( 'After', 'alpha-core' ),
				),
				'before' => array(
					'title' => esc_html__( 'Before', 'alpha-core' ),
				),
			),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Spacing', 'alpha-core' ),
			'param_name' => 'icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'value'      => '',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-left:hover i, {{WRAPPER}} .btn-reveal-left:active i, {{WRAPPER}} .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-right:hover i, {{WRAPPER}} .btn-reveal-right:active i, {{WRAPPER}} .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'value'      => '',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Icon Hover Effect', 'alpha-core' ),
			'param_name' => 'icon_hover_effect',
			'value'      => array(
				esc_html__( 'none', 'alpha-core' )       => 'default',
				esc_html__( 'Slide Left', 'alpha-core' ) => 'btn-slide-left',
				esc_html__( 'Slide Right', 'alpha-core' ) => 'btn-slide-right',
				esc_html__( 'Slide Up', 'alpha-core' )   => 'btn-slide-up',
				esc_html__( 'Slide Down', 'alpha-core' ) => 'btn-slide-down',
				esc_html__( 'Reveal Left', 'alpha-core' ) => 'btn-reveal-left',
				esc_html__( 'Reveal Right', 'alpha-core' ) => 'btn-reveal-right',
			),
			'std'        => 'default',
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Animation Infinite', 'alpha-core' ),
			'param_name' => 'icon_hover_effect_infinite',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Buttton Padding', 'alpha-core' ),
			'param_name' => 'button_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Buttton Border Width', 'alpha-core' ),
			'param_name' => 'button_border_width',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Button Typography', 'alpha-core' ),
			'param_name' => 'btn_font',
			'selectors'  => array(
				'{{WRAPPER}} .btn',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'btn_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Button', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_button',
		'icon'            => 'alpha-icon alpha-icon-button',
		'class'           => 'alpha_button',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha button.', 'alpha-core' ),
		'params'          => $params,
	)
);


if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Button extends WPBakeryShortCode {}' );
}

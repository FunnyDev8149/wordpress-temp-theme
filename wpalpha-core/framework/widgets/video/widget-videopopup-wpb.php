<?php
/**
 * Alpha Video Popup
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
			'heading'    => esc_html__( 'Video Source', 'alpha-core' ),
			'param_name' => 'vtype',
			'value'      => array(
				esc_html__( 'Youtube', 'alpha-core' )     => 'youtube',
				esc_html__( 'Vimeo', 'alpha-core' )       => 'vimeo',
				esc_html__( 'Self Hosted', 'alpha-core' ) => 'hosted',
			),
			'std'        => 'youtube',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Video URL', 'alpha-core' ),
			'param_name' => 'video_url',
			'value'      => '',
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Player Icon', 'alpha-core' ),
			'param_name' => 'button_icon',
			'std'        => ALPHA_ICON_PREFIX . '-icon-play',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Player Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
			'std'        => '{"xl":"23","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'alignment',
			'value'      => array(
				'start'  => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'end'    => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'start',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Button Size', 'alpha-core' ),
			'param_name' => 'button_size',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
			),
			'std'        => '{"xl":"60","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Padding', 'alpha-core' ),
			'param_name' => 'button_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
			'std'        => '{"top":{"xl":"10","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"12"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"10"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"12"}}',
		),
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
			'param_name' => 'button_bd_width',
			'selectors'  => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'std'        => '{"top":{"xl":"1","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"1"}}',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Shape', 'alpha-core' ),
			'param_name' => 'button_border',
			'label_type' => 'icon',
			'value'      => array(
				''            => array(
					'title' => esc_html__( 'Square', 'alpha-core' ),
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
			'std'        => 'btn-ellipse',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Skin', 'alpha-core' ),
			'param_name' => 'button_skin',
			'value'      => array(
				''              => array(
					'title' => esc_html__( 'Default', 'alpha-core' ),
					'color' => '#eee',
				),
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'alpha-core' ),
					'color' => 'var(--alpha-primary-color,#2879FE)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'alpha-core' ),
					'color' => 'var(--alpha-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'alpha-core' ),
					'color' => 'var(--alpha-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'alpha-core' ),
					'color' => 'var(--alpha-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'alpha-core' ),
					'color' => 'var(--alpha-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'alpha-core' ),
					'color' => '#fff',
				),
			),
			'std'        => 'btn-primary',
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'btn_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Video Popup', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_videopopup',
		'icon'            => 'alpha-icon alpha-icon-video',
		'class'           => 'alpha_videopopup',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha video popup.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Videopopup extends WPBakeryShortCode {}' );
}

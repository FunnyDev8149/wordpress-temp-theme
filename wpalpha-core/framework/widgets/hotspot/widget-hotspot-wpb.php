<?php
/**
 * Alpha Hotspot
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Hotspot', 'alpha-core' )       => array(
		array(
			'type'       => 'iconpicker',
			'param_name' => 'icon',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'std'        => ALPHA_ICON_PREFIX . '-icon-plus',
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'horizontal',
			'heading'    => esc_html__( 'Horizontal Position', 'alpha-core' ),
			'units'      => array(
				'px',
				'%',
				'vw',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'vertical',
			'heading'    => esc_html__( 'Vertical Position', 'alpha-core' ),
			'units'      => array(
				'px',
				'%',
				'vw',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}}' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'effect',
			'heading'    => esc_html__( 'Hotspot Effect', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'None', 'alpha-core' )    => '',
				esc_html__( 'Spread', 'alpha-core' )  => 'type1',
				esc_html__( 'Twinkle', 'alpha-core' ) => 'type2',
			),
		),
	),
	esc_html__( 'Popup', 'alpha-core' )         => array(
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Content', 'alpha-core' ),
			'param_name'  => 'type',
			'value'       => array(
				'html'    => array(
					'title' => esc_html__( 'HTML', 'alpha-core' ),
				),
				'block'   => array(
					'title' => esc_html__( 'Block', 'alpha-core' ),
				),
				'product' => array(
					'title' => esc_html__( 'Product', 'alpha-core' ),
				),
				'image'   => array(
					'title' => esc_html__( 'Image', 'alpha-core' ),
				),
			),
			'std'         => 'html',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'param_name' => 'html',
			'heading'    => esc_html__( 'Custom Html', 'alpha-core' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'html',
			),
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'block',
			'heading'    => esc_html__( 'Block', 'alpha-core' ),
			'settings'   => array(
				'multiple' => false,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'       => 'attach_image',
			'heading'    => esc_html__( 'Choose Image', 'alpha-core' ),
			'param_name' => 'image',
			'value'      => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'image_size',
			'std'        => 'full',
			'heading'    => esc_html__( 'Image Size', 'alpha-core' ),
			'value'      => alpha_get_image_sizes(),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'       => 'autocomplete',
			'heading'    => __( 'Product', 'js_composer' ),
			'param_name' => 'product',
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'product',
			),
		),
		array(
			'type'       => 'vc_link',
			'param_name' => 'link',
			'heading'    => esc_html__( 'Link URL', 'alpha-core' ),
			'dependency' => array(
				'element' => 'type',
				'value'   => array( 'html', 'block', 'image' ),
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'popup_position',
			'heading'    => esc_html__( 'Popup Position', 'alpha-core' ),
			'value'      => array(
				'none'   => array(
					'title' => esc_html__( 'Hide', 'alpha-core' ),
				),
				'top'    => array(
					'title' => esc_html__( 'Top', 'alpha-core' ),
				),
				'left'   => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'alpha-core' ),
				),
			),
			'std'        => 'top',
		),
	),
	esc_html__( 'Hotspot Style', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_number',
			'param_name' => 'size',
			'heading'    => esc_html__( 'Hotspot Size', 'alpha-core' ),
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot' => 'width:{{VALUE}}{{UNIT}};height:{{VALUE}}{{UNIT}};line-height:{{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'icon_size',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'units'      => array(
				'px',
				'em',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_dimension',
			'param_name' => 'border_radius',
			'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot, {{WRAPPER}} .hotspot-wrapper::before' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Spread Color', 'alpha-core' ),
			'param_name' => 'hotspot_colors',
			'selectors'  => array(
				'{{WRAPPER}} .hotspot-type1:not(:hover):before' => 'background: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'effect',
				'value'   => 'type1',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Colors', 'alpha-core' ),
			'param_name' => 'hotspot_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .hotspot',
				'hover'  => '{{WRAPPER}}:hover .hotspot',
			),
			'choices'    => array( 'color', 'background-color' ),
		),
	),
	esc_html__( 'Popup Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_number',
			'param_name' => 'popup_width',
			'heading'    => esc_html__( 'Popup Width', 'alpha-core' ),
			'units'      => array(
				'px',
				'%',
				'rem',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .hotspot-box' => 'width:{{VALUE}}{{UNIT}};min-width:{{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Hotspot', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_hotspot',
		'icon'            => 'alpha-icon alpha-icon-hotspot',
		'class'           => 'alpha_hotspot',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha hotspot.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_hotspot_product_callback', 'alpha_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_hotspot_product_render', 'alpha_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_alpha_hotspot_product_param_value', 'alpha_wpb_shortcode_product_id_param_value', 10, 4 );

// Block Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_hotspot_block_callback', 'alpha_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_hotspot_block_render', 'alpha_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Hotspot extends WPBakeryShortCode {}' );
}

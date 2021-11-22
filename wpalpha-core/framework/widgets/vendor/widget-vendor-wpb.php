<?php
/**
 * Vendor Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		array(
			'type'       => 'dropdown',
			'param_name' => 'vendor_select_type',
			'heading'    => esc_html__( 'Select', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Individually', 'alpha-core' ) => 'individual',
				esc_html__( 'Group', 'alpha-core' )        => 'group',
			),
			'std'        => 'individual',
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'vendor_ids',
			'heading'    => esc_html__( 'Select Vendors', 'alpha-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'individual',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'vendor_category',
			'heading'    => esc_html__( 'Vendor Type', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'General', 'alpha-core' ) => '',
				esc_html__( 'Top Selling Vendors', 'alpha-core' ) => 'sale',
				esc_html__( 'Top Rating Vendors', 'alpha-core' ) => 'rating',
				esc_html__( 'Newly Added Vendors', 'alpha-core' ) => 'recent',
			),
			'std'        => '',
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'vendor_count',
			'heading'    => esc_html__( 'Vendor Count', 'alpha-core' ),
			'std'        => 4,
			'dependency' => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
	),
	esc_html__( 'Layout', 'alpha-core' )           => array(
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'layout_type',
			'heading'    => esc_html__( 'Vendors Layout', 'alpha-core' ),
			'value'      => array(
				'grid'   => array(
					'title' => esc_html__( 'Grid', 'alpha-core' ),
				),
				'slider' => array(
					'title' => esc_html__( 'Slider', 'alpha-core' ),
				),
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'col_cnt',
			'heading'    => esc_html__( 'Columns', 'alpha-core' ),
			'responsive' => true,
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => array(
					'grid',
					'slider',
				),
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'row_cnt',
			'heading'    => esc_html__( 'Rows', 'alpha-core' ),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'alpha-core' ),
			'std'        => apply_filters( 'alpha_col_default', 'md' ),
			'value'      => apply_filters(
				'alpha_col_sp',
				array(
					'no' => array(
						'title' => esc_html__( 'No space', 'alpha-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'Extra Small', 'alpha-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'Small', 'alpha-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'Medium', 'alpha-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'Large', 'alpha-core' ),
					),
				),
				'wpb'
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'slider_vertical_align',
			'heading'    => esc_html__( 'Vertical Align', 'alpha-core' ),
			'value'      => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'alpha-core' ),
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'alpha-core' ),
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'alpha-core' ),
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'alpha-core' ),
				),
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
	),
	esc_html__( 'Vendor Type', 'alpha-core' )      => array(
		array(
			'type'         => 'alpha_button_group',
			'param_name'   => 'vendor_type',
			'heading'      => esc_html__( 'Display Type', 'alpha-core' ),
			'button_width' => '250',
			'value'        => array(
				'vendor-1' => array(
					'image' => ALPHA_CORE_URI . '/assets/images/vendors/type-1.jpg',
					'title' => esc_html__( 'Type 1', 'alpha-core' ),
				),
				'vendor-2' => array(
					'image' => ALPHA_CORE_URI . '/assets/images/vendors/type-2.jpg',
					'title' => esc_html__( 'Type 2', 'alpha-core' ),
				),
				'vendor-3' => array(
					'image' => ALPHA_CORE_URI . '/assets/images/vendors/type-3.jpg',
					'title' => esc_html__( 'Type 3', 'alpha-core' ),
				),
			),
			'std'          => 'vendor-1',
		),
		array(
			'type'       => 'alpha_multiselect',
			'heading'    => esc_html__( 'Show Information', 'alpha-core' ),
			'param_name' => 'vendor_show_info',
			'value'      => array(
				esc_html__( 'Name', 'alpha-core' )     => 'name',
				esc_html__( 'Avatar', 'alpha-core' )   => 'avatar',
				esc_html__( 'Rating', 'alpha-core' )   => 'rating',
				esc_html__( 'Products Count', 'alpha-core' ) => 'product_count',
				esc_html__( 'Products', 'alpha-core' ) => 'products',
			),
			'std'        => 'name,avatar,rating,product_count,products',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_total_sale',
			'heading'    => esc_html__( 'Show Total Sale', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'vendor_category',
				'value'   => 'sale',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_vendor_link',
			'heading'    => esc_html__( 'Show Visit Vendor Link', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'vendor_type',
				'value'   => array( 'vendor-1', 'vendor-3' ),
			),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'vendor_link_text',
			'heading'    => esc_html__( 'Link Text', 'alpha-core' ),
			'std'        => esc_html__( 'Browse This Vendor', 'alpha-core' ),
			'dependency' => array(
				'element' => 'show_vendor_link',
				'value'   => 'yes',
			),
		),
	),
	esc_html__( 'Vendor Product', 'alpha-core' )   => array(
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail_size',
			'heading'    => esc_html__( 'Product Image Size', 'alpha-core' ),
			'value'      => alpha_get_image_sizes(),
		),
	),
	esc_html__( 'Carousel Options', 'alpha-core' ) => array(
		esc_html__( 'Options', 'alpha-core' ) => array(
			'alpha_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'alpha-core' )     => array(
			'alpha_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'alpha-core' )    => array(
			'alpha_wpb_slider_dots_controls',
		),
	),
	esc_html__( 'Style', 'alpha-core' )            => array(
		esc_html__( 'Vendor Name', 'alpha-core' )   => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Vendor Name Typography', 'alpha-core' ),
				'param_name' => 'vendor_name_typography',
				'selectors'  => array(
					'{{WRAPPER}} .vendor-name a',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Vendor Name Colors', 'alpha-core' ),
				'param_name' => 'vendor_name_colors',
				'group'      => esc_html__( 'General', 'alpha-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .vendor-name a',
					'hover'  => '{{WRAPPER}} .vendor-name a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Vendor Avatar', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'avatar_size_1',
				'value'      => '70',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .vendor-widget .vendor-logo' => 'max-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .vendor-widget .vendor-personal' => 'max-width: calc(100% - {{VALUE}}{{UNIT}});',
				),
				'dependency' => array(
					'element' => 'vendor_type',
					'value'   => array( 'vendor-1', 'vendor-2' ),
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'avatar_size_2',
				'value'      => '90',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .vendor-widget-3 .vendor-logo' => 'max-width: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .vendor-widget-3 .vendor-personal' => 'margin-top: calc(-{{VALUE}}{{UNIT}} / 2);',
				),
				'dependency' => array(
					'element' => 'vendor_type',
					'value'   => array( 'vendor-3' ),
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Vendors', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_vendor',
		'icon'            => 'alpha-icon alpha-icon-vendors',
		'class'           => 'alpha_vendor',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create Vendors.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Vendor Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_vendor_vendor_ids_callback', 'alpha_wpb_shortcode_vendor_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_vendor_vendor_ids_render', 'alpha_wpb_shortcode_vendor_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Vendor extends WPBakeryShortCode {}' );
}

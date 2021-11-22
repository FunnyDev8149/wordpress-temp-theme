<?php
/**
 * Brands Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )          => array(
		array(
			'type'       => 'autocomplete',
			'param_name' => 'brands',
			'heading'    => esc_html__( 'Select Brands', 'alpha-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'hide_empty',
			'heading'    => esc_html__( 'Hide Empty', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'count',
			'heading'    => esc_html__( 'Brands Count', 'alpha-core' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Order By', 'alpha-core' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Name', 'alpha-core' )        => 'name',
				esc_html__( 'ID', 'alpha-core' )          => 'id',
				esc_html__( 'Slug', 'alpha-core' )        => 'slug',
				esc_html__( 'Modified', 'alpha-core' )    => 'modified',
				esc_html__( 'Product Count', 'alpha-core' ) => 'count',
				esc_html__( 'Parent', 'alpha-core' )      => 'parent',
				esc_html__( 'Description', 'alpha-core' ) => 'description',
				esc_html__( 'Term Group', 'alpha-core' )  => 'term_group',
			),
			'std'        => 'name',
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'orderway',
			'value'      => array(
				'DESC' => array(
					'title' => esc_html__( 'Descending', 'alpha-core' ),
				),
				'ASC'  => array(
					'title' => esc_html__( 'Ascending', 'alpha-core' ),
				),
			),
			'std'        => 'ASC',
		),
	),
	esc_html__( 'Layout', 'alpha-core' )           => array(
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'layout_type',
			'heading'    => esc_html__( 'Layout', 'alpha-core' ),
			'value'      => array(
				'grid'   => array(
					'title' => esc_html__( 'Grid', 'alpha-core' ),
				),
				'slider' => array(
					'title' => esc_html__( 'Slider', 'alpha-core' ),
				),
			),
			'std'        => 'grid',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail',
			'heading'    => esc_html__( 'Image Size', 'alpha-core' ),
			'value'      => array_flip( alpha_get_image_sizes() ),
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
			'type'       => 'alpha_number',
			'param_name' => 'col_cnt',
			'heading'    => esc_html__( 'Columns', 'alpha-core' ),
			'responsive' => true,
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
		array(
			'type'       => 'checkbox',
			'param_name' => 'slider_image_expand',
			'heading'    => esc_html__( 'Image Full Width', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'slider_horizontal_align',
			'heading'    => esc_html__( 'Horizontal Align', 'alpha-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; justify-content:{{VALUE}};',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'grid_vertical_align',
			'heading'    => esc_html__( 'Vertical Align', 'alpha-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'alpha-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'alpha-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'alpha-core' ),
				),
				'stretch'    => array(
					'title' => esc_html__( 'Stretch', 'alpha-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; align-items:{{VALUE}}; height: 100%;',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'grid_image_expand',
			'heading'    => esc_html__( 'Image Full Width', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'selectors'  => array(
				'{{WRAPPER}} figure a, {{WRAPPER}} figure img' => 'width: 100%;',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'grid_horizontal_align',
			'heading'    => esc_html__( 'Horizontal Align', 'alpha-core' ),
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} figure' => 'display: flex; justify-content:{{VALUE}};',
			),
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
		),
	),
	esc_html__( 'Brands Type', 'alpha-core' )      => array(
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'brand_type',
			'value'      => array(
				'1' => array(
					'title' => esc_html__( 'Type 1', 'alpha-core' ),
				),
				'2' => array(
					'title' => esc_html__( 'Type 2', 'alpha-core' ),
				),
				'3' => array(
					'title' => esc_html__( 'Type 3', 'alpha-core' ),
				),
			),
			'std'        => '1',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_brand_rating',
			'heading'    => esc_html__( 'Show Brand Rating', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'brand_type',
				'value'   => array( '2', '3' ),
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_brand_products',
			'heading'    => esc_html__( 'Show Brand Products', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'brand_type',
				'value'   => '3',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )            => array(
		esc_html__( 'Brand Name', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'brand_name_typo',
				'selectors'  => array(
					'{{WRAPPER}} .brand-name',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'param_name' => 'brand_name_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .brand-name a',
					'hover'  => '{{WRAPPER}} .brand-name a:hover',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Product Count', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'brand_product_count_typo',
				'selectors'  => array(
					'{{WRAPPER}} .brand-product-count',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'brand_product_count_color',
				'selectors'  => array(
					'{{WRAPPER}} .brand-product-count' => 'color: {{VALUE}};',
				),
			),
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
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Brands', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_brands',
		'icon'            => 'alpha-icon alpha-icon-brands',
		'class'           => 'alpha_brands',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha product brands.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Brand Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_brands_brands_callback', 'alpha_wpb_shortcode_brand_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_brands_brands_render', 'alpha_wpb_shortcode_brand_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Brands extends WPBakeryShortCode {}' );
}

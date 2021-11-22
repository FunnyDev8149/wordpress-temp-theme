<?php

if ( ! function_exists( 'alpha_wpb_categories_select_controls' ) ) {
	function alpha_wpb_categories_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'category_ids',
				'heading'     => esc_html__( 'Category IDs', 'alpha-core' ),
				'description' => esc_html__( 'comma separated list of category ids', 'alpha-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'run_as_filter',
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'heading'     => esc_html__( 'Filter Products', 'alpha-core' ),
				'description' => esc_html__( 'In a same section, this will interact with products widget so taht you\'ll be able to filter products by category.', 'alpha-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_all_filter',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Show \'All\'', 'alpha-core' ),
				'dependency' => array(
					'element' => 'run_as_filter',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'run_as_filter_shop',
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'heading'     => esc_html__( 'Filter Products in Shop', 'alpha-core' ),
				'description' => esc_html__( 'You\'ll be able to filter products by category in shop page in case that ajax filter is enabled in theme options.', 'alpha-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_subcategories',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Show Subcategories', 'alpha-core' ),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'hide_empty',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'heading'    => esc_html__( 'Hide Empty', 'alpha-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'count',
				'heading'     => esc_html__( 'Category Count', 'alpha-core' ),
				'description' => esc_html__( '0 value will show all categories.', 'alpha-core' ),
				'std'         => '4',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'alpha-core' ),
				'std'        => 'name',
				'value'      => array(
					esc_html__( 'Name', 'alpha-core' )     => 'name',
					esc_html__( 'ID', 'alpha-core' )       => 'id',
					esc_html__( 'Slug', 'alpha-core' )     => 'slug',
					esc_html__( 'Modified', 'alpha-core' ) => 'modified',
					esc_html__( 'Product Count', 'alpha-core' ) => 'count',
					esc_html__( 'Parent', 'alpha-core' )   => 'parent',
					esc_html__( 'Description', 'alpha-core' ) => 'description',
					esc_html__( 'Term Group', 'alpha-core' ) => 'term_group',
				),
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
				'std'        => 'DESC',
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_type_controls' ) ) {
	function alpha_wpb_categories_type_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'follow_theme_option',
				'heading'    => esc_html__( 'Follow Theme Option', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'         => 'alpha_button_group',
				'param_name'   => 'category_type',
				'heading'      => esc_html__( 'Category Type', 'alpha-core' ),
				'button_width' => '350',
				'value'        => apply_filters(
					'alpha_pc_types',
					array(
						// @start feature: fs_pct_default
						'default'   => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-1.jpg',
							'title' => esc_html__( 'Default', 'alpha-core' ),
						),
						// @end feature: fs_pct_default
						// @start feature: fs_pct_frame
						'frame'     => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-2.jpg',
							'title' => esc_html__( 'Frame', 'alpha-core' ),
						),
						// @end feature: fs_pct_frame
						// @start feature: fs_pct_banner
						'banner'    => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-3.jpg',
							'title' => esc_html__( 'Banner', 'alpha-core' ),
						),
						// @end feature: fs_pct_banner
						// @start feature: fs_pct_simple
						'simple'    => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-4.jpg',
							'title' => esc_html__( 'Simple', 'alpha-core' ),
						),
						// @end feature: fs_pct_simple
						// @start feature: fs_pct_icon
						'icon'      => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-5.jpg',
							'title' => esc_html__( 'Icon', 'alpha-core' ),
						),
						// @end feature: fs_pct_icon
						// @start feature: fs_pct_classic
						'classic'   => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-6.jpg',
							'title' => esc_html__( 'Classic', 'alpha-core' ),
						),
						// @end feature: fs_pct_classic
						// @start feature: fs_pct_classic-2
						'classic-2' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-7.jpg',
							'title' => esc_html__( 'Classic 2', 'alpha-core' ),
						),
						// @end feature: fs_pct_classic-2
						// @start feature: fs_pct_ellipse
						'ellipse'   => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-8.jpg',
							'title' => esc_html__( 'Ellipse', 'alpha-core' ),
						),
						// @end feature: fs_pct_ellipse
						// @start feature: fs_pct_ellipse-2
						'ellipse-2' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-9.jpg',
							'title' => esc_html__( 'Ellipse 2', 'alpha-core' ),
						),
						// @end feature: fs_pct_ellipse-2
						// @start feature: fs_pct_group
						'group'     => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-10.jpg',
							'title' => esc_html__( 'Group', 'alpha-core' ),
						),
						// @end feature: fs_pct_group
						// @start feature: fs_pct_group-2
						'group-2'   => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-11.jpg',
							'title' => esc_html__( 'Group 2', 'alpha-core' ),
						),
						// @end feature: fs_pct_group-2
						// @start feature: fs_pct_label
						'label'     => array(
							'image' => ALPHA_CORE_URI . '/assets/images/categories/category-12.jpg',
							'title' => esc_html__( 'Label', 'alpha-core' ),
						),
						// @end feature: fs_pct_label
					),
					'wpb'
				),
				'std'          => 'default',
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_icon',
				'heading'     => esc_html__( 'Show Icon', 'alpha-core' ),
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'description' => esc_html__( 'This option works only for the last 3 category types', 'alpha-core' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'subcat_cnt',
				'heading'     => esc_html__( 'Subcategory Count', 'alpha-core' ),
				'description' => esc_html__( 'This option only works in group type categories', 'alpha-core' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'overlay',
				'heading'    => esc_html__( 'Overlay Effect', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'No', 'alpha-core' )    => '',
					esc_html__( 'Light', 'alpha-core' ) => 'light',
					esc_html__( 'Dark', 'alpha-core' )  => 'dark',
					esc_html__( 'Zoom', 'alpha-core' )  => 'zoom',
					esc_html__( 'Zoom and Light', 'alpha-core' ) => 'zoom_light',
					esc_html__( 'Zoom and Dark', 'alpha-core' ) => 'zoom_dark',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_wrap_style_controls' ) ) {
	function alpha_wpb_categories_wrap_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'cat_padding',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'param_name' => 'category_min_height',
				'heading'    => esc_html__( 'Min Height', 'alpha-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category img' => 'min-height:{{VALUE}}{{UNIT}}; object-fit: cover;',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_bg',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'color: {{VALUE}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_icon_style_controls' ) ) {
	function alpha_wpb_categories_icon_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'icon_margin',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'icon_padding',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'param_name' => 'icon_size',
				'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
				'with_units' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'font-size: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'icon_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'color: {{VALUE}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_content_style_controls' ) ) {
	function alpha_wpb_categories_content_style_controls() {
		return array(
			array(
				'type'       => 'alpha_button_group',
				'param_name' => 'content_origin',
				'heading'    => esc_html__( 'Origin X, Y', 'alpha-core' ),
				'value'      => array(
					'default' => array(
						'title' => esc_html__( 'Default Default', 'alpha-core' ),
					),
					't-m'     => array(
						'title' => esc_html__( 'Default Center', 'alpha-core' ),
					),
					't-c'     => array(
						'title' => esc_html__( 'Center Default', 'alpha-core' ),
					),
					't-mc'    => array(
						'title' => esc_html__( 'Center Center', 'alpha-core' ),
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'content_pos',
				'heading'    => esc_html__( 'Content Position', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'content_padding',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_button_group',
				'param_name' => 'content_align',
				'heading'    => esc_html__( 'Content Align', 'alpha-core' ),
				'value'      => array(
					'default'        => array(
						'title' => esc_html__( 'Default', 'alpha-core' ),
						'icon'  => 'fas fa-ban',
					),
					'content-left'   => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'content-center' => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'content-right'  => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'content_radius',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .category-content',
					'hover'  => '{{WRAPPER}} .product-category:hover .category-content',
				),
				'choices'    => array( 'color', 'background-color' ),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_name_style_controls' ) ) {
	function alpha_wpb_categories_name_style_controls() {
		return array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Text Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'title_typography',
				'heading'    => esc_html__( 'Text Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_count_style_controls' ) ) {
	function alpha_wpb_categories_count_style_controls() {
		return array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'count_color',
				'heading'    => esc_html__( 'Count Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'count_typography',
				'heading'    => esc_html__( 'Count Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_categories_button_style_controls' ) ) {
	function alpha_wpb_categories_button_style_controls() {
		return array(
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .btn',
					'hover'  => '{{WRAPPER}} .product-category .btn:hover, {{WRAPPER}} .product-category .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'button_border_type',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_margin',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
		);
	}
}

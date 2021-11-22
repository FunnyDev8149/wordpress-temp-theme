<?php

if ( ! function_exists( 'alpha_wpb_products_select_controls' ) ) {
	function alpha_wpb_products_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'product_ids',
				'heading'     => esc_html__( 'Product IDs', 'alpha-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
				'admin_label' => true,
			),
			array(
				'type'       => 'autocomplete',
				'param_name' => 'categories',
				'heading'    => esc_html__( 'Categories', 'alpha-core' ),
				'settings'   => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'       => 'autocomplete',
				'param_name' => 'brands',
				'heading'    => esc_html__( 'Brands', 'alpha-core' ),
				'settings'   => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'       => 'alpha_number',
				'param_name' => 'count',
				'heading'    => esc_html__( 'Product Count', 'alpha-core' ),
				'value'      => '10',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'status',
				'heading'    => esc_html__( 'Product Status', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'All', 'alpha-core' )      => '',
					esc_html__( 'Featured', 'alpha-core' ) => 'featured',
					esc_html__( 'On Sale', 'alpha-core' )  => 'sale',
					esc_html__( 'Recently Viewed', 'alpha-core' ) => 'viewed',
				),
				'std'        => '',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'alpha-core' ),
				'std'        => 'name',
				'value'      => array(
					esc_html__( 'Default', 'alpha-core' )  => '',
					esc_html__( 'ID', 'alpha-core' )       => 'ID',
					esc_html__( 'Name', 'alpha-core' )     => 'title',
					esc_html__( 'Date', 'alpha-core' )     => 'date',
					esc_html__( 'Modified', 'alpha-core' ) => 'modified',
					esc_html__( 'Price', 'alpha-core' )    => 'price',
					esc_html__( 'Random', 'alpha-core' )   => 'rand',
					esc_html__( 'Rating', 'alpha-core' )   => 'rating',
					esc_html__( 'Comment count', 'alpha-core' ) => 'comment_count',
					esc_html__( 'Total Sales', 'alpha-core' ) => 'popularity',
					esc_html__( 'Wish', 'alpha-core' )     => 'wishqty',
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
				'std'        => 'ASC',
			),
			// array(
			// 	'type'       => 'checkbox',
			// 	'param_name' => 'hide_out_date',
			// 	'heading'    => esc_html__( 'Hide Product Out of Date', 'alpha-core' ),
			// 	'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			// ),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_products_type_controls' ) ) {
	function alpha_wpb_products_type_controls() {
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
				'param_name'   => 'product_type',
				'heading'      => esc_html__( 'Product Type', 'alpha-core' ),
				'button_width' => '250',
				'value'        => apply_filters(
					'alpha_product_loop_types',
					array(
						// @start feature: fs_pt_1
						'product-1' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-1.jpg',
							'title' => esc_html__( 'Type 1', 'alpha-core' ),
						),
						// @end feature: fs_pt_1
						// @start feature: fs_pt_2
						'product-2' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-2.jpg',
							'title' => esc_html__( 'Type 2', 'alpha-core' ),
						),
						// @end feature: fs_pt_2
						// @start feature: fs_pt_3
						'product-3' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-3.jpg',
							'title' => esc_html__( 'Type 3', 'alpha-core' ),
						),
						// @end feature: fs_pt_3
						// @start feature: fs_pt_4
						'product-4' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-4.jpg',
							'title' => esc_html__( 'Type 4', 'alpha-core' ),
						),
						// @end feature: fs_pt_4
						// @start feature: fs_pt_5
						'product-5' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-5.jpg',
							'title' => esc_html__( 'Type 5', 'alpha-core' ),
						),
						// @end feature: fs_pt_5
						// @start feature: fs_pt_6
						'product-6' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-6.jpg',
							'title' => esc_html__( 'Type 6', 'alpha-core' ),
						),
						// @end feature: fs_pt_6
						// @start feature: fs_pt_7
						'product-7' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-7.jpg',
							'title' => esc_html__( 'Type 7', 'alpha-core' ),
						),
						// @end feature: fs_pt_7
						// @start feature: fs_pt_8
						'product-8' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-8.jpg',
							'title' => esc_html__( 'Type 8', 'alpha-core' ),
						),
						// @end feature: fs_pt_8
						// @start feature: fs_pt_widget
						'widget'    => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-widget.jpg',
							'title' => esc_html__( 'Type Widget', 'alpha-core' ),
						),
						// @end feature: fs_pt_widget
						// @start feature: fs_pt_list
						'list'      => array(
							'image' => ALPHA_CORE_URI . '/assets/images/products/product-list.jpg',
							'title' => esc_html__( 'Type List', 'alpha-core' ),
						),
						// @end feature: fs_pt_list
					),
					'wpb'
				),
				'std'          => '',
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_in_box',
				'heading'    => esc_html__( 'Show In Box', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_hover_shadow',
				'heading'     => esc_html__( 'Shadow Effect on Hover', 'alpha-core' ),
				'description' => esc_html__( 'This option does not work for widget & list type products', 'alpha-core' ),
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_media_shadow',
				'heading'    => esc_html__( 'Media Shadow Effect on Hover', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			// Showing Info
			array(
				'type'       => 'alpha_multiselect',
				'heading'    => esc_html__( 'Show Information', 'alpha-core' ),
				'param_name' => 'show_info',
				'value'      => array(
					esc_html__( 'Category', 'alpha-core' ) => 'category',
					esc_html__( 'Label', 'alpha-core' )    => 'label',
					esc_html__( 'Custom Label', 'alpha-core' ) => 'custom_label',
					esc_html__( 'Price', 'alpha-core' )    => 'price',
					esc_html__( 'Rating', 'alpha-core' )   => 'rating',
					esc_html__( 'Attribute', 'alpha-core' ) => 'attribute',
					esc_html__( 'Deal Countdown', 'alpha-core' ) => 'countdown',
					esc_html__( 'Add To Cart', 'alpha-core' ) => 'addtocart',
					esc_html__( 'Compare', 'alpha-core' )  => 'compare',
					esc_html__( 'Quickview', 'alpha-core' ) => 'quickview',
					esc_html__( 'Wishlist', 'alpha-core' ) => 'wishlist',
					esc_html__( 'Short Description', 'alpha-core' ) => 'short_desc',
					esc_html__( 'Sold By', 'alpha-core' )  => 'sold_by',
				),
				'std'        => 'category,label,custom_label,price,rating,countdown,addtocart,compare,quickview,wishlist',
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Line Clamp', 'alpha - core' ),
				'param_name' => 'desc_line_clamp',
				'value'      => '3',
				'selectors'  => array(
					'{{WRAPPER}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient:vertical; overflow: hidden;',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			array(
				'type'       => 'checkbox',
				'param_name' => 'show_progress',
				'heading'    => esc_html__( 'Show Sales Bar', 'alpha - core' ),
				'value'      => array( esc_html__( 'Yes', 'alpha - core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			// Showing Labels
			array(
				'type'       => 'alpha_multiselect',
				'heading'    => esc_html__( 'Show Labels', 'alpha - core' ),
				'param_name' => 'show_labels',
				'value'      => array(
					esc_html__( 'Top', 'alpha - core' )   => 'top',
					esc_html__( 'Sale', 'alpha - core' )  => 'sale',
					esc_html__( 'new', 'alpha - core' )   => 'new',
					esc_html__( 'Stock', 'alpha - core' ) => 'stock',
				),
				'std'        => 'top,sale,new,stock',
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_products_style_controls' ) ) {
	function alpha_wpb_products_style_controls() {
		return array(
			array(
				'type'       => 'alpha_accordion_header',
				'heading'    => esc_html__( 'Category Filter', 'alpha-core' ),
				'param_name' => 'category-filter-style-ah',
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'filter_margin',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'filter_item_margin',
				'heading'    => esc_html__( 'Item Margin', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filters > li' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'filter_item_padding',
				'heading'    => esc_html__( 'Item Padding', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'cat_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'cat_border_width',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-style:solid;border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'filter_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter',
				),
			),
			array(
				'type'       => 'alpha_button_group',
				'param_name' => 'cat_align',
				'heading'    => esc_html__( 'Align', 'alpha-core' ),
				'value'      => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'flex-start',
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'justify-content:{{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .nav-filter',
					'hover'  => '{{WRAPPER}} .nav-filter:hover',
					'active' => '{{WRAPPER}} .nav-filter.active',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}

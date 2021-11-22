<?php
/**
 * Products partial
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Alpha_Controls_Manager;


/**
 * Register elementor products layout controls
 *
 * @since 1.0
 */
function alpha_elementor_products_layout_controls( $self, $mode = '' ) {

	$self->start_controls_section(
		'section_products_layout',
		array(
			'label' => esc_html__( 'Products Layout', 'alpha-core' ),
		)
	);

	$self->add_control(
		'layout_type',
		array(
			'label'   => esc_html__( 'Products Layout', 'alpha-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'custom_layouts' == $mode ? 'creative' : 'grid',
			'options' => array(
				'grid'     => esc_html__( 'Grid', 'alpha-core' ),
				'slider'   => esc_html__( 'Slider', 'alpha-core' ),
				'creative' => esc_html__( 'Creative', 'alpha-core' ),
			),
		)
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
			'exclude' => [ 'custom' ],
			'default' => 'woocommerce_thumbnail',
		)
	);

	alpha_elementor_grid_layout_controls( $self, 'layout_type', true, 'product' );
	alpha_elementor_slider_layout_controls( $self, 'layout_type' );

	$self->end_controls_section();

	if ( ! $mode ) {

		$self->start_controls_section(
			'product_filter_section',
			array(
				'label' => esc_html__( 'Product Ajax', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			alpha_elementor_loadmore_layout_controls( $self, 'layout_type' );

			$self->add_control(
				'filter_cat_w',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Filter by Category Widget', 'alpha-core' ),
					'description' => esc_html__( 'If there is a category widget enabled "Filter Products" option in the same section, you can filter products by category widget.', 'alpha-core' ),
				)
			);

			$self->add_control(
				'filter_cat',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Filter by Category', 'alpha-core' ),
				)
			);

			$self->add_control(
				'show_all_filter',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show "All" Filter', 'alpha-core' ),
					'default'   => 'yes',
					'condition' => array(
						'filter_cat' => 'yes',
					),
				)
			);

		$self->end_controls_section();
	}
}
/**
 * Register elementor products select controls
 *
 * @since 1.0
 */
function alpha_elementor_products_select_controls( $self, $add_section = true ) {

	if ( $add_section ) {
		$self->start_controls_section(
			'section_products_selector',
			array(
				'label' => esc_html__( 'Products Selector', 'alpha-core' ),
			)
		);
	}

	$self->add_control(
		'product_ids',
		array(
			'label'       => esc_html__( 'Select Products', 'alpha-core' ),
			'type'        => Alpha_Controls_Manager::AJAXSELECT2,
			'options'     => 'product',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'categories',
		array(
			'label'       => esc_html__( 'Select Categories', 'alpha-core' ),
			'type'        => Alpha_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_cat',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'brands',
		array(
			'label'       => esc_html__( 'Select Brands', 'alpha-core' ),
			'type'        => Alpha_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_brand',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'count',
		array(
			'type'    => Controls_Manager::SLIDER,
			'label'   => esc_html__( 'Product Count', 'alpha-core' ),
			'default' => array(
				'unit' => 'px',
				'size' => 10,
			),
			'range'   => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
		)
	);

	$self->add_control(
		'status',
		array(
			'label'   => esc_html__( 'Product Status', 'alpha-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''         => esc_html__( 'All', 'alpha-core' ),
				'featured' => esc_html__( 'Featured', 'alpha-core' ),
				'sale'     => esc_html__( 'On Sale', 'alpha-core' ),
				'viewed'   => esc_html__( 'Recently Viewed', 'alpha-core' ),
			),
		)
	);

	$self->add_control(
		'orderby',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Order By', 'alpha-core' ),
			'default'   => '',
			'options'   => array(
				''               => esc_html__( 'Default', 'alpha-core' ),
				'ID'             => esc_html__( 'ID', 'alpha-core' ),
				'title'          => esc_html__( 'Name', 'alpha-core' ),
				'date'           => esc_html__( 'Date', 'alpha-core' ),
				'modified'       => esc_html__( 'Modified', 'alpha-core' ),
				'price'          => esc_html__( 'Price', 'alpha-core' ),
				'rand'           => esc_html__( 'Random', 'alpha-core' ),
				'rating'         => esc_html__( 'Rating', 'alpha-core' ),
				'comment_count'  => esc_html__( 'Comment count', 'alpha-core' ),
				'popularity'     => esc_html__( 'Total Sales', 'alpha-core' ),
				'wishqty'        => esc_html__( 'Wish', 'alpha-core' ),
				'sale_date_to'   => esc_html__( 'Sale End Date', 'alpha-core' ),
				'sale_date_from' => esc_html__( 'Sale Start Date', 'alpha-core' ),
			),
			'separator' => 'before',
		)
	);

	$self->add_control(
		'orderway',
		array(
			'type'    => Controls_Manager::SELECT,
			'label'   => esc_html__( 'Order Way', 'alpha-core' ),
			'default' => 'ASC',
			'options' => array(
				'ASC'  => esc_html__( 'Ascending', 'alpha-core' ),
				'DESC' => esc_html__( 'Descending', 'alpha-core' ),
			),
		)
	);

	$self->add_control(
		'order_from',
		array(
			'label'       => esc_html__( 'Date From', 'alpha-core' ),
			'description' => esc_html__( 'Start date that the ordering will be applied', 'alpha-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'alpha-core' ),
				'week'   => esc_html__( 'This Week', 'alpha-core' ),
				'month'  => esc_html__( 'This Month', 'alpha-core' ),
				'year'   => esc_html__( 'This Year', 'alpha-core' ),
				'custom' => esc_html__( 'Custom', 'alpha-core' ),
			),
			'condition'   => array(
				'product_ids' => '',
			),
		)
	);

	$self->add_control(
		'order_from_date',
		array(
			'label'     => esc_html__( 'Date', 'alpha-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'product_ids' => '',
				'order_from'  => 'custom',
			),
		)
	);

	$self->add_control(
		'order_to',
		array(
			'label'       => esc_html__( 'Date To', 'alpha-core' ),
			'description' => esc_html__( 'End date that the ordering will be applied', 'alpha-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'alpha-core' ),
				'week'   => esc_html__( 'This Week', 'alpha-core' ),
				'month'  => esc_html__( 'This Month', 'alpha-core' ),
				'year'   => esc_html__( 'This Year', 'alpha-core' ),
				'custom' => esc_html__( 'Custom', 'alpha-core' ),
			),
			'condition'   => array(
				'product_ids' => '',
			),
		)
	);

	$self->add_control(
		'order_to_date',
		array(
			'label'     => esc_html__( 'Date', 'alpha-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'product_ids' => '',
				'order_to'    => 'custom',
			),
		)
	);

	// $self->add_control(
	// 	'hide_out_date',
	// 	array(
	// 		'type'      => Controls_Manager::SWITCHER,
	// 		'label'     => esc_html__( 'Hide Product Out of Date', 'alpha-core' ),
	// 		'condition' => array(
	// 			'product_ids' => '',
	// 		),
	// 	)
	// );

	if ( $add_section ) {
		$self->end_controls_section();
	}
}

/**
 * Register elementor single product style controls
 *
 * @since 1.0
 */
function alpha_elementor_single_product_style_controls( $self ) {
	$self->start_controls_section(
		'section_sp_style',
		array(
			'label' => esc_html__( 'Single Product', 'alpha-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'product_summary_height',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Summary Max Height', 'alpha-core' ),
				'size_units' => array( 'px', 'rem', '%' ),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-single.product-widget .summary' => 'max-height: {{SIZE}}{{UNIT}}; overflow-y: auto;',
				),
			)
		);

		$self->start_controls_tabs(
			'sp_tabs',
			array(
				'separator' => 'before',
			)
		);

			$self->start_controls_tab(
				'sp_title_tab',
				array(
					'label' => esc_html__( 'Title', 'alpha-core' ),
				)
			);

				$self->add_control(
					'sp_title_color',
					array(
						'label'     => esc_html__( 'Title Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .product_title a' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Title Typography', 'alpha-core' ),
						'name'     => 'sp_title_typo',
						'selector' => '.elementor-element-{{ID}} .product_title',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_price_tab',
				array(
					'label' => esc_html__( 'Price', 'alpha-core' ),
				)
			);

				$self->add_control(
					'sp_price_color',
					array(
						'label'     => esc_html__( 'Price Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} p.price' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Price Typography', 'alpha-core' ),
						'name'     => 'sp_price_typo',
						'selector' => '.elementor-element-{{ID}} p.price',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_old_price_tab',
				array(
					'label' => esc_html__( 'Old Price', 'alpha-core' ),
				)
			);

				$self->add_control(
					'sp_old_price_color',
					array(
						'label'     => esc_html__( 'Old Price Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .price del' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'label'    => esc_html__( 'Old Price Typography', 'alpha-core' ),
						'name'     => 'sp_old_price_typo',
						'selector' => '.elementor-element-{{ID}} .price del',
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_countdown',
			array(
				'label'     => esc_html__( 'Countdown', 'alpha-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'sp_countdown_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-coundown-container' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'sp_countdown_color',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sp_countdown_typo',
				'selector' => '.elementor-element-{{ID}} .product-countdown-container',
			)
		);

		$self->add_control(
			'style_cart_button',
			array(
				'label'     => esc_html__( 'Add To Cart Button', 'alpha-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->start_controls_tabs( 'sp_cart_tabs' );

			$self->start_controls_tab(
				'sp_cart_btn_tab',
				array(
					'label' => esc_html__( 'Default', 'alpha-core' ),
				)
			);

				$self->add_control(
					'sp_cart_btn_bg',
					array(
						'label'     => esc_html__( 'Background Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							// Stronger selector to avoid section style from overwriting
							'.elementor-element-{{ID}} .single_add_to_cart_button' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
						),
					)
				);

				$self->add_control(
					'sp_cart_btn_color',
					array(
						'label'     => esc_html__( 'Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .single_add_to_cart_button' => 'color: {{VALUE}};',
						),
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_cart_btn_tab_hover',
				array(
					'label' => esc_html__( 'Hover', 'alpha-core' ),
				)
			);

				$self->add_control(
					'sp_cart_btn_bg_hover',
					array(
						'label'     => esc_html__( 'Hover Background Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							// Stronger selector to avoid section style from overwriting
							'.elementor-element-{{ID}} .single_add_to_cart_button:not(.disabled):hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
						),
					)
				);

				$self->add_control(
					'sp_cart_btn_color_hover',
					array(
						'label'     => esc_html__( 'Hover Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .single_add_to_cart_button:hover' => 'color: {{VALUE}};',
						),
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'sp_cart_btn_typo',
				'separator' => 'before',
				'selector'  => '.elementor-element-{{ID}} .single_add_to_cart_button',
			)
		);

	$self->end_controls_section();
}
/**
 * Register elementor product type controls
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_product_type_controls' ) ) {
	function alpha_elementor_product_type_controls( $self ) {

		$self->start_controls_section(
			'section_product_type',
			array(
				'label' => esc_html__( 'Product Type', 'alpha-core' ),
			)
		);

			$self->add_control(
				'follow_theme_option',
				array(
					'label'   => esc_html__( 'Follow Theme Option', 'alpha-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$self->add_control(
				'product_type',
				array(
					'label'     => esc_html__( 'Product Type', 'alpha-core' ),
					'type'      => Alpha_Controls_Manager::IMAGE_CHOOSE,
					'default'   => '',
					'options'   => apply_filters(
						'alpha_product_loop_types',
						array(
							'product-1' => 'assets/images/products/product-1.jpg',      // @feature: fs_pt_1
							'product-2' => 'assets/images/products/product-2.jpg',      // @feature: fs_pt_2
							'product-3' => 'assets/images/products/product-3.jpg',      // @feature: fs_pt_3
							'product-4' => 'assets/images/products/product-4.jpg',      // @feature: fs_pt_4
							'product-5' => 'assets/images/products/product-5.jpg',      // @feature: fs_pt_5
							'product-6' => 'assets/images/products/product-6.jpg',      // @feature: fs_pt_6
							'product-7' => 'assets/images/products/product-7.jpg',      // @feature: fs_pt_7
							'product-8' => 'assets/images/products/product-8.jpg',      // @feature: fs_pt_8
							'widget'    => 'assets/images/products/product-widget.jpg', // @feature: fs_pt_widget
							'list'      => 'assets/images/products/product-list.jpg',   // @feature: fs_pt_list
						),
						'elementor'
					),
					'width'     => 1,
					'condition' => array(
						'follow_theme_option' => '',
					),
				)
			);

			$self->add_control(
				'show_in_box',
				array(
					'label'     => esc_html__( 'Show In Box', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'condition' => array(
						'follow_theme_option' => '',
					),
				)
			);

			$self->add_control(
				'show_hover_shadow',
				array(
					'label'     => esc_html__( 'Shadow Effect on Hover', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'condition' => array(
						'follow_theme_option' => '',
						'product_type!'       => array( 'product-5', 'product-6', 'product-7' ),
					),
				)
			);

			$self->add_control(
				'show_media_shadow',
				array(
					'label'     => esc_html__( 'Media Shadow Effect on Hover', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'condition' => array(
						'follow_theme_option' => '',
					),
				)
			);

			$self->add_control(
				'show_info',
				array(
					'type'      => Controls_Manager::SELECT2,
					'label'     => esc_html__( 'Show Information', 'alpha-core' ),
					'multiple'  => true,
					'default'   => array(
						'category',
						'label',
						'custom_label',
						'price',
						'rating',
						'countdown',
						'addtocart',
						'compare',
						'quickview',
						'wishlist',
					),
					'options'   => array(
						'category'     => esc_html__( 'Category', 'alpha-core' ),
						'label'        => esc_html__( 'Label', 'alpha-core' ),
						'custom_label' => esc_html__( 'Custom Label', 'alpha-core' ),
						'price'        => esc_html__( 'Price', 'alpha-core' ),
						'rating'       => esc_html__( 'Rating', 'alpha-core' ),
						'attribute'    => esc_html__( 'Attribute', 'alpha-core' ),
						'countdown'    => esc_html__( 'Deal Countdown', 'alpha-core' ),
						'addtocart'    => esc_html__( 'Add To Cart', 'alpha-core' ),
						'compare'      => esc_html__( 'Compare', 'alpha-core' ),
						'quickview'    => esc_html__( 'Quickview', 'alpha-core' ),
						'wishlist'     => esc_html__( 'Wishlist', 'alpha-core' ),
						'short_desc'   => esc_html__( 'Short Description', 'alpha-core' ),
						'sold_by'      => esc_html__( 'Sold By', 'alpha-core' ),
					),
					'condition' => array(
						'follow_theme_option' => '',
					),
				)
			);

			$self->add_control(
				'desc_line_clamp',
				array(
					'label'      => esc_html__( 'Line Clamp', 'alpha-core' ),
					'type'       => Controls_Manager::NUMBER,
					'selectors'  => array(
						'.elementor-element-{{ID}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient: vertical; overflow: hidden;',
					),
					'default'    => 3,
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'show_info',
								'operator' => 'contains',
								'value'    => 'short_desc',
							),
							array(
								'name'     => 'follow_theme_option',
								'operator' => '==',
								'value'    => '',
							),
						),
					),
				)
			);

			$self->add_control(
				'show_progress',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Show Sales Bar', 'alpha-core' ),
					'condition' => array(
						'product_type!' => array( 'product-2', 'product-3' ),
					),
				)
			);

			$self->add_control(
				'show_labels',
				array(
					'type'     => Controls_Manager::SELECT2,
					'label'    => esc_html__( 'Show Labels', 'alpha-core' ),
					'multiple' => true,
					'default'  => array(
						'hot',
						'sale',
						'new',
						'stock',
					),
					'options'  => array(
						'hot'   => esc_html__( 'Hot', 'alpha-core' ),
						'sale'  => esc_html__( 'Sale', 'alpha-core' ),
						'new'   => esc_html__( 'New', 'alpha-core' ),
						'stock' => esc_html__( 'Stock', 'alpha-core' ),
					),
				)
			);

		$self->end_controls_section();

	}
}

/**
 * Register elementor product style controls
 *
 * @since 1.0
 */
function alpha_elementor_product_style_controls( $self ) {

	$self->start_controls_section(
		'section_filter_style',
		array(
			'label'     => esc_html__( 'Category Filter', 'alpha-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'filter_cat' => 'yes',
			),
		)
	);

		$self->add_responsive_control(
			'filter_margin',
			array(
				'label'      => esc_html__( 'Margin', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_item_margin',
			array(
				'label'      => esc_html__( 'Item Margin', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filters > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'separator'  => 'after',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'filter_typography',
				'selector' => '.elementor-element-{{ID}} .nav-filter',
			)
		);

		$self->add_responsive_control(
			'cat_align',
			array(
				'label'     => esc_html__( 'Align', 'alpha-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .product-filters' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_cat_color' );
			$self->start_controls_tab(
				'tab_cat_normal',
				array(
					'label' => esc_html__( 'Normal', 'alpha-core' ),
				)
			);

			$self->add_control(
				'cat_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_hover',
				array(
					'label' => esc_html__( 'Hover', 'alpha-core' ),
				)
			);

			$self->add_control(
				'cat_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_active',
				array(
					'label' => esc_html__( 'Active', 'alpha-core' ),
				)
			);

			$self->add_control(
				'cat_active_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();
		$self->end_controls_tabs();

	$self->end_controls_section();
}

/**
 * Single Product Functions
 * Products Functions
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_single_product_widget_get_title_tag' ) ) {
	function alpha_single_product_widget_get_title_tag() {
		global $alpha_spw_settings;
		return isset( $alpha_spw_settings['sp_title_tag'] ) ? $alpha_spw_settings['sp_title_tag'] : 'h2';
	}
}
if ( ! function_exists( 'alpha_single_product_widget_get_gallery_type' ) ) {
	function alpha_single_product_widget_get_gallery_type() {
		global $alpha_spw_settings;
		return isset( $alpha_spw_settings['sp_gallery_type'] ) ? $alpha_spw_settings['sp_gallery_type'] : '';
	}
}

if ( ! function_exists( 'alpha_single_product_widget_remove_row_class' ) ) {
	function alpha_single_product_widget_remove_row_class( $classes ) {
		global $alpha_spw_settings;

		if ( isset( $alpha_spw_settings['sp_vertical'] ) && $alpha_spw_settings['sp_vertical'] ) {
			foreach ( $classes as $i => $class ) {
				if ( 'row' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
		}

		return $classes;
	}
}
if ( ! function_exists( 'alpha_single_product_widget_extend_gallery_class' ) ) {
	function alpha_single_product_widget_extend_gallery_class( $classes ) {
		global $alpha_spw_settings;
		$single_product_layout = empty( $alpha_spw_settings['sp_gallery_type'] ) ? '' : $alpha_spw_settings['sp_gallery_type'];
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}

			if ( isset( $alpha_spw_settings['sp_col_cnt'] ) ) {
				$col_cnt   = array(
					'xl'  => isset( $alpha_spw_settings['sp_col_cnt_xl'] ) ? (int) $alpha_spw_settings['sp_col_cnt_xl'] : 0,
					'lg'  => isset( $alpha_spw_settings['sp_col_cnt'] ) ? (int) $alpha_spw_settings['sp_col_cnt'] : 0,
					'md'  => isset( $alpha_spw_settings['sp_col_cnt_tablet'] ) ? (int) $alpha_spw_settings['sp_col_cnt_tablet'] : 0,
					'sm'  => isset( $alpha_spw_settings['sp_col_cnt_mobile'] ) ? (int) $alpha_spw_settings['sp_col_cnt_mobile'] : 0,
					'min' => isset( $alpha_spw_settings['sp_col_cnt_min'] ) ? (int) $alpha_spw_settings['sp_col_cnt_min'] : 0,
				);
				$classes[] = alpha_get_col_class( function_exists( 'alpha_get_responsive_cols' ) ? alpha_get_responsive_cols( $col_cnt ) : $col_cnt );

				$col_sp = empty( $alpha_spw_settings['sp_col_sp'] ) ? '' : $alpha_spw_settings['sp_col_sp'];
				if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
					$classes[] = 'gutter-' . $col_sp;
				}
			} else {
				$classes[]        = alpha_get_col_class( alpha_elementor_grid_col_cnt( $alpha_spw_settings ) );
				$grid_space_class = alpha_get_grid_space_class( $alpha_spw_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'alpha_single_product_extend_gallery_type_class' ) ) {
	function alpha_single_product_extend_gallery_type_class( $class ) {
		global $alpha_spw_settings;

		if ( isset( $alpha_spw_settings['sp_col_cnt'] ) ) {
			$col_cnt = array(
				'xl'  => isset( $alpha_spw_settings['sp_col_cnt_xl'] ) ? (int) $alpha_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $alpha_spw_settings['sp_col_cnt'] ) ? (int) $alpha_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $alpha_spw_settings['sp_col_cnt_tablet'] ) ? (int) $alpha_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $alpha_spw_settings['sp_col_cnt_mobile'] ) ? (int) $alpha_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $alpha_spw_settings['sp_col_cnt_min'] ) ? (int) $alpha_spw_settings['sp_col_cnt_min'] : 0,
			);
			$class   = alpha_get_col_class( function_exists( 'alpha_get_responsive_cols' ) ? alpha_get_responsive_cols( $col_cnt ) : $col_cnt );

			$col_sp = empty( $alpha_spw_settings['sp_col_sp'] ) ? '' : $alpha_spw_settings['sp_col_sp'];
			if ( 'lg' == $col_sp || 'sm' == $col_sp || 'xs' == $col_sp || 'no' == $col_sp ) {
				$class .= ' gutter-' . $col_sp;
			}
		} else {
			$class            = alpha_get_col_class( alpha_elementor_grid_col_cnt( $alpha_spw_settings ) );
			$grid_space_class = alpha_get_grid_space_class( $alpha_spw_settings );
			if ( $grid_space_class ) {
				$class .= $grid_space_class;
			}
		}

		return $class;
	}
}

if ( ! function_exists( 'alpha_single_product_extend_gallery_type_attr' ) ) {
	function alpha_single_product_extend_gallery_type_attr( $attr ) {
		global $alpha_spw_settings;

		if ( isset( $alpha_spw_settings['sp_col_cnt'] ) ) {
			$breakpoints = alpha_get_breakpoints();

			$col_cnt = array(
				'xl'  => isset( $alpha_spw_settings['sp_col_cnt_xl'] ) ? (int) $alpha_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $alpha_spw_settings['sp_col_cnt'] ) ? (int) $alpha_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $alpha_spw_settings['sp_col_cnt_tablet'] ) ? (int) $alpha_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $alpha_spw_settings['sp_col_cnt_mobile'] ) ? (int) $alpha_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $alpha_spw_settings['sp_col_cnt_min'] ) ? (int) $alpha_spw_settings['sp_col_cnt_min'] : 0,
			);
			$col_cnt = function_exists( 'alpha_get_responsive_cols' ) ? alpha_get_responsive_cols( $col_cnt ) : $col_cnt;

			$extra_options = array();

			$margin = alpha_get_grid_space( isset( $alpha_spw_settings['sp_col_sp'] ) ? $alpha_spw_settings['sp_col_sp'] : '' );
			if ( $margin > 0 ) { // default is 0
				$extra_options['margin'] = $margin;
			}

			$responsive = array();
			foreach ( $col_cnt as $w => $c ) {
				$responsive[ $breakpoints[ $w ] ] = array(
					'slidesPerView' => $c,
				);
			}
			if ( isset( $responsive[ $breakpoints['md'] ] ) && ! $responsive[ $breakpoints['md'] ] ) {
				$responsive[ $breakpoints['md'] ] = array();
			}
			if ( isset( $responsive[ $breakpoints['lg'] ] ) && ! $responsive[ $breakpoints['lg'] ] ) {
				$responsive[ $breakpoints['lg'] ] = array();
			}

			$extra_options['breakpoints'] = $responsive;

			$attr .= ' data-slider-options="' . esc_attr(
				json_encode(
					apply_filters( 'alpha_single_product_extended_slider_options', $extra_options )
				)
			) . '"';
		} else {
			$attr .= ' data-slider-options="' . esc_attr(
				json_encode(
					alpha_get_slider_attrs( $alpha_spw_settings, alpha_elementor_grid_col_cnt( $alpha_spw_settings ) )
				)
			) . '"';
		}

		return $attr;
	}
}

if ( ! function_exists( 'alpha_products_widget_render' ) ) {
	function alpha_products_widget_render( $atts ) {
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/products/render-products.php' );
	}
}

if ( ! function_exists( 'alpha_single_product_gallery_countdown' ) ) {
	function alpha_single_product_gallery_countdown() {
		global $alpha_spw_settings;

		alpha_single_product_sale_countdown();
	}
}

if ( ! function_exists( 'alpha_set_single_product_widget' ) ) {
	function alpha_set_single_product_widget( $atts ) {
		global $alpha_spw_settings;
		$alpha_spw_settings = $atts;

		// Add woocommerce default filters for compatibility with single product
		if ( alpha_is_elementor_preview() &&
			! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) { // Add only once

			// Add woocommerce actions for compatibility in elementor editor.
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			}
		}

		add_filter( 'alpha_is_single_product_widget', '__return_true' );
		add_filter( 'alpha_single_product_layout', 'alpha_single_product_widget_get_gallery_type' );
		add_filter( 'alpha_single_product_title_tag', 'alpha_single_product_widget_get_title_tag' );
		add_filter( 'alpha_single_product_gallery_main_classes', 'alpha_single_product_widget_extend_gallery_class', 20 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
			remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_end', 30 );
			remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
			remove_action( 'alpha_after_product_summary_wrap', 'alpha_single_product_wrap_second_end', 20 );
			add_filter( 'alpha_single_product_classes', 'alpha_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'alpha_wc_show_product_images_not_sticky_both', 20 );
				remove_action( 'alpha_before_product_summary', 'alpha_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
					remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_end', 30 );
					remove_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
					remove_action( 'alpha_after_product_summary_wrap', 'alpha_single_product_wrap_second_end', 20 );
					add_filter( 'alpha_single_product_classes', 'alpha_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			// if ( ! in_array( 'divider', $sp_show_info ) ) {
			// 	remove_action( 'woocommerce_single_product_summary', 'alpha_single_product_divider', 31 );
			// 	remove_action( 'woocommerce_before_add_to_cart_button', 'alpha_single_product_divider' );
			// }

			if ( ! in_array( 'share', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'alpha_print_wishlist_button', 52 );
			}

			if ( ! in_array( 'compare', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 54 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			remove_action( 'woocommerce_single_product_summary', 'alpha_single_product_sale_countdown', 9 );
			add_action( 'alpha_after_wc_gallery_figure', 'alpha_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			add_filter( 'alpha_single_product_gallery_type_class', 'alpha_single_product_extend_gallery_type_class' );
			add_filter( 'alpha_single_product_gallery_type_attr', 'alpha_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Alpha_Skeleton' ) ) {
			Alpha_Skeleton::prevent_skeleton();
		}

		/**
		 * Fires after setting single product widget
		 *
		 * @param array $atts
		 * @since 1.0
		 */
		do_action( 'alpha_after_set_single_product_widget', $atts );
	}
}

if ( ! function_exists( 'alpha_unset_single_product_widget' ) ) {
	function alpha_unset_single_product_widget( $atts ) {
		global $alpha_spw_settings;
		unset( $alpha_spw_settings );

		// Remove added filters
		remove_filter( 'alpha_is_single_product_widget', '__return_true' );
		remove_filter( 'alpha_single_product_layout', 'alpha_single_product_widget_get_gallery_type' );
		remove_filter( 'alpha_single_product_title_tag', 'alpha_single_product_widget_get_title_tag' );
		remove_filter( 'alpha_single_product_gallery_main_classes', 'alpha_single_product_widget_extend_gallery_class', 20 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
			add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_end', 30 );
			add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
			add_action( 'alpha_after_product_summary_wrap', 'alpha_single_product_wrap_second_end', 20 );
			remove_filter( 'alpha_single_product_classes', 'alpha_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				add_action( 'woocommerce_before_single_product_summary', 'alpha_wc_show_product_images_not_sticky_both', 20 );
				add_action( 'alpha_before_product_summary', 'alpha_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_start', 5 );
					add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_first_end', 30 );
					add_action( 'woocommerce_before_single_product_summary', 'alpha_single_product_wrap_second_start', 30 );
					add_action( 'alpha_after_product_summary_wrap', 'alpha_single_product_wrap_second_end', 20 );
					remove_filter( 'alpha_single_product_classes', 'alpha_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! in_array( 'divider', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'alpha_single_product_divider', 31 );
				add_action( 'woocommerce_before_add_to_cart_button', 'alpha_single_product_divider' );
			}
			if ( ! in_array( 'share', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'alpha_print_wishlist_button', 52 );
			}
			if ( ! in_array( 'compare', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'alpha_single_product_compare', 54 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			add_action( 'woocommerce_single_product_summary', 'alpha_single_product_sale_countdown', 9 );
			remove_action( 'alpha_after_wc_gallery_figure', 'alpha_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			remove_filter( 'alpha_single_product_gallery_type_class', 'alpha_single_product_extend_gallery_type_class' );
			remove_filter( 'alpha_single_product_gallery_type_attr', 'alpha_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Alpha_Skeleton' ) ) {
			Alpha_Skeleton::stop_prevent_skeleton();
		}

		/**
		 * Fires after unsetting single product widget
		 *
		 * @param array $atts
		 * @since 1.0
		 */
		do_action( 'alpha_after_unset_single_product_widget', $atts );
	}
}

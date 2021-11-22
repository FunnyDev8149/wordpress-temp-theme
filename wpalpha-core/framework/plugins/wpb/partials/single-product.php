<?php

if ( ! function_exists( 'alpha_wpb_single_product_type_controls' ) ) {
	function alpha_wpb_single_product_type_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'sp_title_tag',
				'heading'    => esc_html__( 'Title Tag', 'alpha-core' ),
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'        => 'h2',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'sp_gallery_type',
				'heading'    => esc_html__( 'Gallery Type', 'alpha-core' ),
				'width'      => '250',
				'value'      => apply_filters(
					'alpha_sp_types',
					array(
						esc_html__( 'Default', 'alpha-core' ) => '',
						esc_html__( 'Vertical', 'alpha-core' ) => 'vertical',     // @feature: fs_spt_vertical
						esc_html__( 'Horizontal', 'alpha-core' ) => 'horizontal', // @feature: fs_spt_horizontal
						esc_html__( 'Masonry', 'alpha-core' ) => 'masonry',       // @feature: fs_spt_masonry
						esc_html__( 'Grid Images', 'alpha-core' ) => 'grid',      // @feature: fs_spt_grid
						esc_html__( 'Gallery', 'alpha-core' ) => 'gallery',       // @feature: fs_spt_gallery
					),
					'wpb'
				),
				'std'        => '',
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'sp_vertical',
				'heading'    => esc_html__( 'Show Vertical', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_multiselect',
				'param_name' => 'sp_show_info',
				'heading'    => esc_html__( 'Show Information', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'Gallery', 'alpha-core' )  => 'gallery',
					esc_html__( 'Title', 'alpha-core' )    => 'title',
					esc_html__( 'Meta', 'alpha-core' )     => 'meta',
					esc_html__( 'Price', 'alpha-core' )    => 'price',
					esc_html__( 'Rating', 'alpha-core' )   => 'rating',
					esc_html__( 'Description', 'alpha-core' ) => 'excerpt',
					esc_html__( 'Add To Cart Form', 'alpha-core' ) => 'addtocart_form',
					esc_html__( 'Divider In Cart Form', 'alpha-core' ) => 'divider',
					esc_html__( 'Share', 'alpha-core' )    => 'share',
					esc_html__( 'Wishlist', 'alpha-core' ) => 'wishlist',
					esc_html__( 'Compare', 'alpha-core' )  => 'compare',
				),
				'std'        => 'gallery,title,meta,price,rating,excerpt,addtocart_form,divider,share,wishlist,compare',
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Columns', 'alpha-core' ),
				'param_name' => 'gallery_col_cnt',
				'dependency' => array(
					'element' => 'sp_gallery_type',
					'value'   => array( 'grid', 'masonry', 'gallery' ),
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
		);
	}
}

if ( ! function_exists( 'alpha_wpb_single_product_style_controls' ) ) {
	function alpha_wpb_single_product_style_controls() {
		return array(
			// esc_html__( 'Title', 'alpha-core' )     => array(
				array(
					'type'       => 'alpha_accordion_header',
					'heading'    => esc_html__( 'General', 'alpha-core' ),
					'param_name' => 'general-ah',
				),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Summary Max Height', 'alpha-core' ),
				'param_name' => 'summary_max_height',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-single.product-widget .summary' => 'max-height: {{VALUE}}{{UNIT}}; overflow-y: auto;',
				),
			),
			array(
				'type'       => 'alpha_accordion_header',
				'heading'    => esc_html__( 'Title', 'alpha-core' ),
				'param_name' => 'title-ah',
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_title_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product_title a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'sp_title_typo',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product_title',
				),
			),
			// ),
			// esc_html__( 'Price', 'alpha-core' )     => array(
				array(
					'type'       => 'alpha_accordion_header',
					'heading'    => esc_html__( 'Price', 'alpha-core' ),
					'param_name' => 'price-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_price_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'sp_price_typo',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} p.price',
				),
			),
			// ),
			// esc_html__( 'Old Price', 'alpha-core' ) => array(
				array(
					'type'       => 'alpha_accordion_header',
					'heading'    => esc_html__( 'Old Price', 'alpha-core' ),
					'param_name' => 'old-price-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_old_price_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .price del' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'sp_old_price_typo',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .price del',
				),
			),
			// ),
			// esc_html__( 'Countdown', 'alpha-core' ) => array(
				array(
					'type'       => 'alpha_accordion_header',
					'heading'    => esc_html__( 'Countdown', 'alpha-core' ),
					'param_name' => 'countdown-ah',
				),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'sp_countdown_color',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'sp_countdown_typo',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-countdown-container',
				),
			),
		// ),
		);
	}
}


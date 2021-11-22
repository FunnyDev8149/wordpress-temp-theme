<?php

if ( ! function_exists( 'alpha_wpb_posts_select_controls' ) ) {
	function alpha_wpb_posts_select_controls() {
		return array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'post_ids',
				'heading'     => esc_html__( 'Post IDs', 'alpha-core' ),
				'description' => esc_html__( 'comma separated list of Post ids', 'alpha-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'categories',
				'heading'     => esc_html__( 'Category IDs or slugs', 'alpha-core' ),
				'description' => esc_html__( 'comma separated list of category ids or slugs', 'alpha-core' ),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'alpha_number',
				'param_name'  => 'count',
				'heading'     => esc_html__( 'Posts Count', 'alpha-core' ),
				'description' => esc_html__( '0 value will show all categories.', 'alpha-core' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'orderby',
				'heading'    => esc_html__( 'Order By', 'alpha-core' ),
				'std'        => 'ID',
				'value'      => array(
					esc_html__( 'Default', 'alpha-core' )  => '',
					esc_html__( 'ID', 'alpha-core' )       => 'ID',
					esc_html__( 'Title', 'alpha-core' )    => 'title',
					esc_html__( 'Date', 'alpha-core' )     => 'date',
					esc_html__( 'Modified', 'alpha-core' ) => 'modified',
					esc_html__( 'Author', 'alpha-core' )   => 'author',
					esc_html__( 'Comment count', 'alpha-core' ) => 'comment_count',
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

if ( ! function_exists( 'alpha_wpb_posts_type_controls' ) ) {
	function alpha_wpb_posts_type_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'follow_theme_option',
				'heading'    => esc_html__( 'Follow Theme Option', 'alpha-core' ),
				'std'        => 'yes',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'         => 'alpha_button_group',
				'param_name'   => 'post_type',
				'heading'      => esc_html__( 'Post Type', 'alpha-core' ),
				'button_width' => '300',
				'std'          => 'default',
				'value'        => apply_filters(
					'alpha_post_types',
					array(
						// @start feature: fs_bt_default
						'default' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/posts/post-1.jpg',
							'title' => esc_html__( 'Default', 'alpha-core' ),
						),
						// @end feature: fs_bt_default
						// @start feature: fs_bt_list
						'list'    => array(
							'image' => ALPHA_CORE_URI . '/assets/images/posts/post-2.jpg',
							'title' => esc_html__( 'List', 'alpha-core' ),
						),
						// @end feature: fs_bt_list
						// @start feature: fs_bt_mask
						'mask'    => array(
							'image' => ALPHA_CORE_URI . '/assets/images/posts/post-3.jpg',
							'title' => esc_html__( 'Mask', 'alpha-core' ),
						),
						// @end feature: fs_bt_mask
						// @start feature: fs_bt_widget
						'widget'  => array(
							'image' => ALPHA_CORE_URI . '/assets/images/posts/post-4.jpg',
							'title' => esc_html__( 'Widget', 'alpha-core' ),
						),
						// @end feature: fs_bt_widget
						// @start feature: fs_bt_list-xs
						'list-xs' => array(
							'image' => ALPHA_CORE_URI . '/assets/images/posts/post-5.jpg',
							'title' => esc_html__( 'Calendar', 'alpha-core' ),
						),
						// @end feature: fs_bt_list-xs
					),
					'wpb'
				),
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'alpha_multiselect',
				'param_name' => 'show_info',
				'heading'    => esc_html__( 'Show Information', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'Featured Image', 'alpha-core' ) => 'image',
					esc_html__( 'Author', 'alpha-core' )   => 'author',
					esc_html__( 'Date', 'alpha-core' )     => 'date',
					esc_html__( 'Comments Count', 'alpha-core' ) => 'comment',
					esc_html__( 'Category', 'alpha-core' ) => 'category',
					esc_html__( 'Content', 'alpha-core' )  => 'content',
					esc_html__( 'Read More', 'alpha-core' ) => 'readmore',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'        => 'image,date,author,category,comment,readmore',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'overlay',
				'heading'    => esc_html__( 'Overlay', 'alpha-core' ),
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
			array(
				'type'        => 'checkbox',
				'param_name'  => 'excerpt_custom',
				'heading'     => esc_html__( 'Custom Excerpt', 'alpha-core' ),
				'description' => esc_html__( 'If you customize excerpt length, you have to set this toggle certainly.', 'alpha-core' ),
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'excerpt_type',
				'heading'    => esc_html__( 'Excerpt By', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'Words', 'alpha-core' ) => 'words',
					esc_html__( 'Characters', 'alpha-core' ) => 'character',
				),
				'std'        => 'words',
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => __( 'Excerpt Length', 'alpha-core' ),
				'param_name' => 'excerpt_length',
				'std'        => 5,
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_read_more_controls' ) ) {
	function alpha_wpb_posts_read_more_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		return array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Read More Label', 'alpha-core' ),
				'param_name'  => 'read_more_label',
				'admin_label' => true,
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Use Custom', 'alpha-core' ),
				'param_name' => 'read_more_custom',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'alpha-core' ),
				'param_name' => 'button_type',
				'value'      => array(
					esc_html__( 'Default', 'alpha-core' ) => '',
					esc_html__( 'Solid', 'alpha-core' )   => 'btn-solid',
					esc_html__( 'Outline', 'alpha-core' ) => 'btn-outline',
					esc_html__( 'Inline', 'alpha-core' )  => 'btn-link',
				),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'button_size',
				'value'      => array(
					'btn-sm' => array(
						'title' => esc_html__( 'Small', 'alpha-core' ),
					),
					'btn-md' => array(
						'title' => esc_html__( 'Medium', 'alpha-core' ),
					),
					''       => array(
						'title' => esc_html__( 'Normal', 'alpha-core' ),
					),
					'btn-lg' => array(
						'title' => esc_html__( 'Large', 'alpha-core' ),
					),
				),
				'std'        => '',
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Hover Underline', 'alpha-core' ),
				'param_name' => 'link_hover_type',
				'value'      => array(
					''                 => array(
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
					esc_html__( 'None', 'alpha-core' )     => '',
					esc_html__( 'Shadow 1', 'alpha-core' ) => 'btn-shadow-sm',
					esc_html__( 'Shadow 2', 'alpha-core' ) => 'btn-shadow',
					esc_html__( 'Shadow 3', 'alpha-core' ) => 'btn-shadow-lg',
				),
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
					''            => array(
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
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'        => 'alpha_button_group',
				'heading'     => esc_html__( 'Skin', 'alpha-core' ),
				'param_name'  => 'button_skin',
				'value'       => array(
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
				'description' => '',
				'dependency'  => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
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
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Icon?', 'alpha-core' ),
				'param_name' => 'show_icon',
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
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
					esc_html__( 'none', 'alpha-core' )     => '',
					esc_html__( 'Slide Left', 'alpha-core' ) => 'btn-slide-left',
					esc_html__( 'Slide Right', 'alpha-core' ) => 'btn-slide-right',
					esc_html__( 'Slide Up', 'alpha-core' ) => 'btn-slide-up',
					esc_html__( 'Slide Down', 'alpha-core' ) => 'btn-slide-down',
					esc_html__( 'Reveal Left', 'alpha-core' ) => 'btn-reveal-left',
					esc_html__( 'Reveal Right', 'alpha-core' ) => 'btn-reveal-right',
				),
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
			array(
				'type'       => 'alpha_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post .btn',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'alpha-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .post .btn',
					'hover'  => '{{WRAPPER}} .post .btn:hover, {{WRAPPER}} .post .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Button Padding', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
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
					'{{WRAPPER}} .post .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
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
					'{{WRAPPER}} .post .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_style_controls' ) ) {
	function alpha_wpb_posts_style_controls() {
		return array(
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
				'param_name' => 'content_align',
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
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_meta_style_controls' ) ) {
	function alpha_wpb_posts_meta_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'meta_margin',
				'heading'    => esc_html__( 'Meta Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-meta' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'meta_color',
				'heading'    => esc_html__( 'Meta Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-meta' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Meta Typography', 'alpha-core' ),
				'param_name' => 'meta_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-meta',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_title_style_controls' ) ) {
	function alpha_wpb_posts_title_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Title Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Title Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Title Typography', 'alpha-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-title',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_cat_style_controls' ) ) {
	function alpha_wpb_posts_cat_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'cats_margin',
				'heading'    => esc_html__( 'Category Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-cats' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cats_color',
				'heading'    => esc_html__( 'Category Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-cats' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Category Typography', 'alpha-core' ),
				'param_name' => 'cats_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-cats',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_posts_excerpt_style_controls' ) ) {
	function alpha_wpb_posts_excerpt_style_controls() {
		return array(
			array(
				'type'       => 'alpha_dimension',
				'param_name' => 'content_margin',
				'heading'    => esc_html__( 'Excerpt Margin', 'alpha-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-content p' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'content_color',
				'heading'    => esc_html__( 'Excerpt Color', 'alpha-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-content' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Excerpt Typography', 'alpha-core' ),
				'param_name' => 'content_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-content p',
				),
			),
		);
	}
}

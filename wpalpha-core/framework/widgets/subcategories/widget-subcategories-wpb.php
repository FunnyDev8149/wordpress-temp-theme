<?php
/**
 * Alpha Subcategories
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Category Type', 'alpha-core' ),
			'param_name'  => 'list_type',
			'value'       => array(
				'cat'  => array(
					'title' => esc_html__( 'Post', 'alpha-core' ),
				),
				'pcat' => array(
					'title' => esc_html__( 'Product', 'alpha-core' ),
				),
			),
			'std'         => 'pcat',
			'admin_label' => true,
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'category_ids',
			'heading'    => esc_html__( 'Select Categories', 'alpha-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'list_type',
				'value'   => 'cat',
			),
		),
		array(
			'type'       => 'autocomplete',
			'param_name' => 'product_category_ids',
			'heading'    => esc_html__( 'Select Categories', 'alpha-core' ),
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency' => array(
				'element' => 'list_type',
				'value'   => 'pcat',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_subcategories',
			'heading'    => esc_html__( 'Show Subcategories', 'alpha-core' ),
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'list_style',
			'heading'    => esc_html__( 'Style', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Simple', 'alpha-core' )    => '',
				esc_html__( 'Underline', 'alpha-core' ) => 'underline',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'count',
			'heading'     => esc_html__( 'Subcategories Count', 'alpha-core' ),
			'description' => esc_html__( '0 value will show all categories.', 'alpha-core' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'hide_empty',
			'heading'    => esc_html__( 'Hide Empty', 'alpha-core' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'view_all',
			'heading'    => esc_html__( 'View All Label', 'alpha-core' ),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_typography',
			'param_name' => 'title_typo',
			'heading'    => esc_html__( 'Title Typography', 'alpha-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'colorpicker',
			'param_name' => 'title_color',
			'heading'    => esc_html__( 'Title Color', 'alpha-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title' => 'color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'title_space',
			'heading'    => esc_html__( 'Title Space', 'alpha-core' ),
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-title' => 'margin-right:{{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'show_subcategories',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'param_name' => 'link_typo',
			'heading'    => esc_html__( 'Link Typography', 'alpha-core' ),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-nav a',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Link Colors', 'alpha-core' ),
			'param_name' => 'link_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .subcat-nav a',
				'hover'  => '{{WRAPPER}} .subcat-nav a:hover, {{WRAPPER}} .subcat-nav a:focus, {{WRAPPER}} .subcat-nav a:visited',
			),
			'choices'    => array( 'color' ),
		),
		array(
			'type'       => 'alpha_number',
			'param_name' => 'link_space',
			'heading'    => esc_html__( 'Link Space', 'alpha-core' ),
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .subcat-nav a' => 'margin-right:{{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Subcategories', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_subcategories',
		'icon'            => 'alpha-icon alpha-icon-subcategories',
		'class'           => 'alpha_subcategories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha subcategories.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_subcategories_category_ids_callback', 'alpha_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_subcategories_category_ids_render', 'alpha_wpb_shortcode_category_id_render', 10, 1 );

// Product Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_subcategories_product_category_ids_callback', 'alpha_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_subcategories_product_category_ids_render', 'alpha_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Subcategories extends WPBakeryShortCode {}' );
}

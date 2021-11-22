<?php
/**
 * Products Layout Single Product Item Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Layout', 'alpha-core' ) => array(
		array(
			'type'       => 'alpha_heading',
			'tag'        => 'p',
			'label'      => esc_html__( 'This element works only for creative products layout.', 'alpha-core' ),
			'param_name' => 'creative_item_heading',
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'product_ids',
			'heading'     => esc_html__( 'Product IDs', 'alpha-core' ),
			'description' => esc_html__( 'If this field is empty, it displays below index of user-selected products as single product.', 'alpha-core' ),
			'settings'    => array(
				'sortable' => true,
			),
		),
		array(
			'type'        => 'alpha_number',
			'param_name'  => 'item_no',
			'heading'     => esc_html__( 'Insert At', 'alpha-core' ),
			'description' => esc_html__( 'Input item index where this single product should be inserted before.', 'alpha-core' ),
		),
		array(
			'type'        => 'alpha_number',
			'heading'     => esc_html__( 'Single Product Column Size', 'alpha-core' ),
			'param_name'  => 'item_col_span',
			'std'         => '{"xl":"2","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control column size of single product in this layout. This option works only for creative layout.', 'alpha-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-column-end: span {{VALUE}}',
			),
		),
		array(
			'type'        => 'alpha_number',
			'heading'     => esc_html__( 'Single Product Row Size', 'alpha-core' ),
			'param_name'  => 'item_row_span',
			'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control row size of single product in this layout. This option works only for creative layout.', 'alpha-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.creative-grid > {{WRAPPER}}' => 'grid-row-end: span {{VALUE}}',
			),
		),
	),
	esc_html__( 'Type', 'alpha-core' )   => array(
		'alpha_wpb_single_product_type_controls',
	),
	esc_html__( 'Style', 'alpha-core' )  => array(
		'alpha_wpb_single_product_style_controls',
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Inner Products Layout', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_products_single_item',
		'icon'            => 'alpha-icon alpha-icon-single-product',
		'class'           => 'alpha_products_single_item',
		'controls'        => 'full',
		'content_element' => true,
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha single product item inside creative products layout.', 'alpha-core' ),
		'as_child'        => array( 'only' => 'wpb_' . ALPHA_NAME . '_products_layout' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_single_item_product_ids_callback', 'alpha_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_single_item_product_ids_render', 'alpha_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_alpha_products_single_item_product_ids_param_value', 'alpha_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Products_Single_Item extends WPBakeryShortCode {}' );
}

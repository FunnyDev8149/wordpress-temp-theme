<?php
/**
 * Alpha WP Product Categories
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'alpha-core' ),
			'param_name' => 'title',
			'std'        => 'Product categories',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show product counts', 'alpha-core' ),
			'param_name' => 'count',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'no',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show hierarchy', 'alpha-core' ),
			'param_name' => 'hierarchical',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide empty categories', 'alpha-core' ),
			'param_name' => 'hide_empty',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Maximum depth', 'alpha-core' ),
			'param_name' => 'max_depth',
			'std'        => 1,
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ) );

vc_map(
	array(
		'name'            => esc_html__( 'Product Categories List', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_wp_product_categories',
		'icon'            => 'alpha-icon alpha-icon-product-category',
		'class'           => 'wpb_' . ALPHA_NAME . '_wp_product_categories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha wordpress product categories with listed type.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_WP_Product_Categories extends WPBakeryShortCode {}' );
}

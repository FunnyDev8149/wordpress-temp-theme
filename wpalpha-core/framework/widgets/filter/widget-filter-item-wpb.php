<?php
/**
 * Filter Item Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$attributes  = array();
$taxonomies  = wc_get_attribute_taxonomies();
$default_att = '';

if ( count( $taxonomies ) ) {
	foreach ( $taxonomies as $key => $value ) {
		$attributes[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
	}
	$attributes = array_merge( array( 'default' => esc_html__( 'Select Attribute', 'alpha-core' ) ), $attributes );
}

if ( empty( $taxonomies ) ) {
	$params = array(
		esc_html__( 'General', 'alpha-core' ) => array(
			array(
				'type'       => 'alpha_heading',
				'label'      => sprintf( esc_html__( 'Sorry, there are no product attributes available in this site. Click %1$shere%2$s to add attributes.', 'alpha-core' ), '<a href="' . esc_url( admin_url() ) . 'edit.php?post_type=product&page=product_attributes" target="blank">', '</a>' ),
				'param_name' => 'no_attribute_description',
				'tag'        => 'p',
			),
		),
	);
} else {
	$params = array(
		esc_html__( 'General', 'alpha-core' ) => array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'name',
				'heading'    => esc_html__( 'Attribute', 'alpha-core' ),
				'value'      => array_flip( $attributes ),
				'std'        => 'default',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'query_opt',
				'heading'    => esc_html__( 'Query Type', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'AND', 'alpha-core' ) => 'and',
					esc_html__( 'OR', 'alpha-core' )  => 'or',
				),
				'std'        => 'or',
			),
		),
	);
}

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Filter Item', 'alpha-core' ),
		'base'        => 'wpb_' . ALPHA_NAME . '_filter_item',
		'icon'        => 'alpha-icon alpha-icon-filter',
		'class'       => 'wpb_' . ALPHA_NAME . '_filter_item',
		'controls'    => 'full',
		'category'    => ALPHA_DISPLAY_NAME,
		'description' => esc_html__( 'Create alpha filter item.', 'alpha-core' ),
		'as_child'    => array( 'only' => 'wpb_' . ALPHA_NAME . '_filter' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Filter_Item extends WPBakeryShortCode {}' );
}

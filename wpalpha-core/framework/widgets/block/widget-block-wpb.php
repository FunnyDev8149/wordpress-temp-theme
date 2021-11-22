<?php
/**
 * Alpha Block
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'       => 'autocomplete',
			'param_name' => 'block_id',
			'heading'    => esc_html__( 'Block ID', 'alpha-core' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Block', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_block',
		'icon'            => 'alpha-icon alpha-icon-block',
		'class'           => 'alpha_blcok',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha block.', 'alpha-core' ),
		'params'          => $params,
	)
);

// Block Id Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_block_block_id_callback', 'alpha_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_block_block_id_render', 'alpha_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Block extends WPBakeryShortCode {}' );
}

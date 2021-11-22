<?php
/**
 * Alpha Posts
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$creative_layout = alpha_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => ALPHA_CORE_URI . $item,
	);
}


$params = array(
	esc_html__( 'General', 'alpha-core' )          => array( 'alpha_wpb_posts_select_controls' ),
	esc_html__( 'Layout', 'alpha-core' )           => array( 'alpha_wpb_elements_layout_controls' ),
	esc_html__( 'Type', 'alpha-core' )             => array( 'alpha_wpb_posts_type_controls' ),
	esc_html__( 'Style', 'alpha-core' )            => array(
		'alpha_wpb_posts_style_controls',
		esc_html__( 'Meta', 'alpha-core' )      => array( 'alpha_wpb_posts_meta_style_controls' ),
		esc_html__( 'Title', 'alpha-core' )     => array( 'alpha_wpb_posts_title_style_controls' ),
		esc_html__( 'Category', 'alpha-core' )  => array( 'alpha_wpb_posts_cat_style_controls' ),
		esc_html__( 'Excerpt', 'alpha-core' )   => array( 'alpha_wpb_posts_excerpt_style_controls' ),
		esc_html__( 'Read More', 'alpha-core' ) => array( 'alpha_wpb_posts_read_more_controls' ),
	),
	esc_html__( 'Carousel Options', 'alpha-core' ) => array(
		esc_html__( 'Options', 'alpha-core' ) => array(
			'alpha_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'alpha-core' )     => array(
			'alpha_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'alpha-core' )    => array(
			'alpha_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_posts_slider' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Posts Slider', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_posts_slider',
		'icon'            => 'alpha-icon alpha-icon-posts-slider',
		'class'           => 'alpha_posts alpha_posts_slider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha posts with slider layout.', 'alpha-core' ),
		'params'          => $params,
	)
);


// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_posts_slider_categories_callback', 'alpha_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_posts_slider_categories_render', 'alpha_wpb_shortcode_category_id_render', 10, 1 );

// Post Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_posts_slider_post_ids_callback', 'alpha_wpb_shortcode_post_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_posts_slider_post_ids_render', 'alpha_wpb_shortcode_post_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Posts_Slider extends WPBakeryShortCode {}' );
}

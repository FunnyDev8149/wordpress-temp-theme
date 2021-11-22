<?php
/**
 * Filter Item Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

global $alpha_wpb_filter;

if ( isset( $atts['name'] ) ) {
	$alpha_wpb_filter[] = array(
		'name'      => $atts['name'],
		'query_opt' => isset( $atts['query_opt'] ) ? $atts['query_opt'] : 'or',
	);
}

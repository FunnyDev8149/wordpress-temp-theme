<?php
/**
 * Product + Single Product Item Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

global $alpha_products_single_items;

if ( ! isset( $alpha_products_single_items ) ) {
	$alpha_products_single_items = array();
}

$atts['editor'] = 'wpb';

$alpha_products_single_items[] = array(
	'sp_insert'            => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
	'single_in_products'   => '',
	'sp_id'                => '',
	'products_single_atts' => $atts,
	'sp_class'             => '',
);

if ( isset( $atts['product_ids'] ) ) {

	ob_start();
	require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/singleproducts/render-singleproducts-wpb.php' );
	$alpha_products_single_items[ count( $alpha_products_single_items ) - 1 ]['single_in_products'] = ob_get_clean();
	$alpha_products_single_items[ count( $alpha_products_single_items ) - 1 ]['sp_id']              = $atts['product_ids'];
}

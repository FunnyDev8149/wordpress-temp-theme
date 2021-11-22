<?php
/**
 * Product + Banner Item Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

global $alpha_products_banner_items;

if ( ! isset( $alpha_products_banner_items ) ) {
	$alpha_products_banner_items = array();
}

$alpha_products_banner_items[] = array(
	'banner_insert' => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
);

ob_start();
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/banner/render-banner-wpb.php' );
$alpha_products_banner_items[ count( $alpha_products_banner_items ) - 1 ]['product_banner'] = ob_get_clean();

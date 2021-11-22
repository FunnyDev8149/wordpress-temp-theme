<?php
/**
 * Products + Banner Layout Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-products-layout-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
do_shortcode( $atts['content'] );

// for various banner items
global $alpha_products_banner_items, $alpha_products_single_items;

if ( ! empty( $alpha_products_banner_items ) ) {
	$idxs = array();
	foreach ( $alpha_products_banner_items as $item ) {
		$idxs[] = $item['banner_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $alpha_products_banner_items );

	wc_set_loop_prop( 'product_banner', $alpha_products_banner_items[0]['product_banner'] );
	wc_set_loop_prop( 'banner_insert', $alpha_products_banner_items[0]['banner_insert'] );
	wc_set_loop_prop( 'banner_class', $alpha_products_banner_items[0]['banner_class'] );

	array_shift( $alpha_products_banner_items );
}
if ( ! empty( $alpha_products_single_items ) ) {
	$idxs = array();
	foreach ( $alpha_products_single_items as $item ) {
		$idxs[] = $item['sp_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $alpha_products_single_items );

	wc_set_loop_prop( 'single_in_products', $alpha_products_single_items[0]['single_in_products'] );
	wc_set_loop_prop( 'sp_id', $alpha_products_single_items[0]['sp_id'] );
	wc_set_loop_prop( 'sp_insert', $alpha_products_single_items[0]['sp_insert'] );
	wc_set_loop_prop( 'sp_class', $alpha_products_single_items[0]['sp_class'] );
	wc_set_loop_prop( 'products_single_atts', $alpha_products_single_items[0]['products_single_atts'] );

	array_shift( $alpha_products_single_items );
}

$atts['creative_mode'] = false;

// Responsive columns
// $atts = array_merge( $atts, alpha_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
// if ( ! $atts['col_cnt'] ) {
// 	$atts['col_cnt'] = $atts['col_cnt_xl'];
// }
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/products/render-products-masonry-wpb.php' );

if ( isset( $GLOBALS['alpha_current_product_id'] ) ) {
	unset( $GLOBALS['alpha_current_product_id'] );
}
?>
</div>
<?php

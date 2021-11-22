<?php
/**
 * Single Prodcut Navigation Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-navigation-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
$prev_icon = isset( $atts['sp_prev_icon'] ) ? $atts['sp_prev_icon'] : ALPHA_ICON_PREFIX . '-icon-angle-left';
$next_icon = isset( $atts['sp_next_icon'] ) ? $atts['sp_next_icon'] : ALPHA_ICON_PREFIX . '-icon-angle-right';
if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {
	add_filter( 'alpha_check_single_next_prev_nav', '__return_true' );
	add_filter(
		'alpha_single_product_nav_prev_icon',
		function( $prev_icon ) {
			return $prev_icon;
		}
	);
	add_filter(
		'alpha_single_product_nav_next_icon',
		function( $next_icon ) {
			return $next_icon;
		}
	);

	echo '<div class="product-navigation">' . alpha_single_product_navigation() . '</div>';

	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php

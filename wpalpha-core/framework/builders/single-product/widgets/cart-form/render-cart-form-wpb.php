<?php
/**
 * Single Prodcut Cart Form Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_sticky' => 'yes',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-rating-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

	if ( 'yes' == $sp_sticky ) {
		add_filter( 'alpha_single_product_sticky_cart_enabled', '__return_true' );
	}

	woocommerce_template_single_add_to_cart();

	if ( 'yes' == $sp_sticky ) {
		remove_filter( 'alpha_single_product_sticky_cart_enabled', '__return_true' );
	}

	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php

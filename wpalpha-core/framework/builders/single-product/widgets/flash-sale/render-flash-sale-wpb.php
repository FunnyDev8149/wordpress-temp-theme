<?php
/**
 * Single Prodcut Flash Sale Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_icon'       => ALPHA_ICON_PREFIX . '-icon-check',
			'sp_label'      => esc_html__( 'Flash Deals', 'alpha-core' ),
			'sp_ends_label' => esc_html__( 'Ends in:', 'alpha-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-flash-sale-container ' . $atts['shortcode_class'] . $atts['style_class'],
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

	if ( function_exists( 'alpha_single_product_sale_countdown' ) ) {
		$icon_html = '<i class="' . $sp_icon . '"></i>';
		alpha_single_product_sale_countdown( $sp_label, $sp_ends_label, $icon_html );
	}
	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php

<?php
/**
 * Single Prodcut Data Tab Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
		),
		$atts
	)
);
$GLOBALS['alpha_sp_data_tab_settings'] = $atts;
// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-data-tab-container ' . $atts['shortcode_class'] . $atts['style_class'],
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
	if ( ! function_exists( 'alpha_get_tab_type' ) ) {
		function alpha_get_tab_type( $type ) {
			global $alpha_sp_data_tab_settings;
			$sp_type = '';
			if ( isset( $alpha_sp_data_tab_settings['sp_type'] ) ) {
				$sp_type = $alpha_sp_data_tab_settings['sp_type'];
			}
			if ( 'accordion' == $sp_type ) {
				$type = $sp_type;
			}

			return $type;
		}
	}

	add_filter( 'alpha_single_product_data_tab_type', 'alpha_get_tab_type' );

	woocommerce_output_product_data_tabs();

	remove_filter( 'alpha_single_product_data_tab_type', 'alpha_get_tab_type' );

	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php

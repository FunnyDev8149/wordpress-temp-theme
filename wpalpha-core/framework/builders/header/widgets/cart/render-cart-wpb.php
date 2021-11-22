<?php
/**
 * Header Cart Shortcode Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-hb-cart-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$atts = array(
	'icon_type'       => isset( $atts['icon_type'] ) ? $atts['icon_type'] : 'badge',
	'cart_off_canvas' => isset( $atts['cart_off_canvas'] ) ? $atts['cart_off_canvas'] : 'yes',
	'label_type'      => isset( $atts['label_type'] ) ? $atts['label_type'] : 'block',
	'title'           => isset( $atts['show_label'] ) ? $atts['show_label'] : 'yes',
	'label'           => isset( $atts['label'] ) ? $atts['label'] : esc_html__( 'My Cart', 'alpha-core' ),
	'price'           => isset( $atts['show_price'] ) ? $atts['show_price'] : 'yes',
	'delimiter'       => isset( $atts['delimiter'] ) ? $atts['delimiter'] : '/',
	'pfx'             => isset( $atts['count_pfx'] ) ? $atts['count_pfx'] : '(',
	'sfx'             => isset( $atts['count_sfx'] ) ? $atts['count_sfx'] : 'items )',
	'icon'            => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : ALPHA_ICON_PREFIX . '-icon-cart',
);

if ( '/' == $atts['icon_type'] ) {
	$atts['icon_type'] = '';
}
?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
	<?php require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/cart/render-cart-elementor.php' ); ?>
</div>
<?php

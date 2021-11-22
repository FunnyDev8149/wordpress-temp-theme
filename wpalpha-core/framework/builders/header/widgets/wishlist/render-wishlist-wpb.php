<?php
/**
 * Header Wishlist Shortcode Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-hb-wishlist-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$atts = array(
	'type'         => isset( $atts['type'] ) ? $atts['type'] : 'inline',
	'show_label'   => isset( $atts['show_label'] ) ? 'yes' == $atts['show_label'] : 'yes',
	'show_count'   => isset( $atts['show_count'] ) ? 'yes' == $atts['show_count'] : '',
	'show_icon'    => isset( $atts['show_icon'] ) ? 'yes' == $atts['show_icon'] : 'yes',
	'icon'         => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : ALPHA_ICON_PREFIX . '-icon-heart',
	'label'        => isset( $atts['label'] ) ? $atts['label'] : esc_html__( 'Wishlist', 'alpha-core' ),
	'miniwishlist' => isset( $atts['miniwishlist'] ) ? $atts['miniwishlist'] : '',
);
?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
	<?php require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/wishlist/render-wishlist-elementor.php' ); ?>
</div>
<?php

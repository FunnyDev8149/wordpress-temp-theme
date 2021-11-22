<?php
/**
 * Breadcrumb Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'alpha-breadcrumb-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
$atts['widget'] = 'breadcrumb';
if ( isset( $atts['delimiter_icon'] ) ) {
	$atts['delimiter_icon'] = array( 'value' => $atts['delimiter_icon'] );
}
if ( ! isset( $atts['home_icon'] ) ) {
	$atts['home_icon'] = '';
}

if ( function_exists( 'alpha_breadcrumb' ) ) {
	global $alpha_breadcrumb;
	$alpha_breadcrumb = $atts;


	alpha_breadcrumb();
}
?>
</div>
<?php

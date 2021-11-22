<?php
/**
 * Logo Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-logo-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Logo Render
$args = array(
	'thumbnail_size' => isset( $atts['logo_image_size'] ) ? $atts['logo_image_size'] : '',
);

require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/logo/render-logo.php' );
?>
</div>
<?php

<?php
/**
 * Hotspot Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

$atts['icon'] = array(
	'value' => ! empty( $atts['icon'] ) ? $atts['icon'] : ALPHA_ICON_PREFIX . '-icon-plus',
);

$atts['page_builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'alpha-wpb-hotspot-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Button Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/hotspot/render-hotspot-elementor.php' );
?>
</div>
<?php

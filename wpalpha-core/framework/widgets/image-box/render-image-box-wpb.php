<?php
/**
 * Image Box Shortcode Render
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

// $settings                 = $atts;
$atts['page_builder'] = 'wpb';
$atts['content']      = rawurldecode( base64_decode( wp_strip_all_tags( $atts['content'] ) ) );
$wrapper_attrs        = array(
	'class' => 'alpha-imagebox-container ' . $atts['shortcode_class'] . $atts['style_class'],
);
// $atts                     = $settings;

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Image Box Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/image-box/render-image-box-elementor.php' );
?>
</div>
<?php

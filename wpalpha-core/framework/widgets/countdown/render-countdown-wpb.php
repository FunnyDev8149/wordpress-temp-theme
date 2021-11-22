<?php
/**
 * Countdown Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
wp_enqueue_script( 'jquery-countdown' );

$wrapper_attrs = array(
	'class' => 'alpha-countdown-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// countdown Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/countdown/render-countdown-elementor.php' );
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	?>
		<script>theme.countdown('<?php echo alpha_strip_script_tags( $selector ); ?> .countdown');</script>
	<?php
}

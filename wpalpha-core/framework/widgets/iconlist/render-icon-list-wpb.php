<?php
/**
 * List Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
// Preprocess

$wrapper_attrs = array(
	'class' => 'alpha-icon-list-container alpha-icon-lists ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$atts['view']         = isset( $atts['view'] ) ? $atts['view'] : 'block';
$atts['icon_h_align'] = isset( $atts['icon_h_align'] ) ? $atts['icon_h_align'] : 'start';
$atts['icon_v_align'] = isset( $atts['icon_v_align'] ) ? $atts['icon_v_align'] : 'center';

$wrapper_attrs['class'] .= ' ' . $atts['view'] . '-type align-items-' . ( 'block' == $atts['view'] ? $atts['icon_h_align'] : $atts['icon_v_align'] );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Title
if ( ! empty( $atts['title'] ) ) {
	echo '<h4 class="list-title">' . alpha_strip_script_tags( $atts['title'] ) . '</h4>';
}

// content
if ( $atts['content'] ) {
	echo do_shortcode( $atts['content'] );
}

?>
</div>
<?php

<?php
/**
 * Wrapper Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'element-wrapper ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$html_tag = isset( $atts['html_tag'] ) ? $atts['html_tag'] : 'div';

echo '<' . $html_tag . ' ' . $wrapper_attr_html . '>';
echo do_shortcode( $atts['content'] );
echo '</' . $html_tag . '>';

<?php
/**
 * Alpha WPBakery Heading Callback
 *
 * adds heading control for element option
 * follow below example of alpha_heading control
 *
 * array(
 *      'type'        => 'alpha_heading',
 *      'label'       => esc_html__( 'Button Heading Test', 'alpha-core' ),
 *      'param_name'  => 'test_heading',
 *      'tag'         => 'h2',
 *      'class'       => 'alpha-heading-control-class',
 *      'group'       => 'General',
 * ),
 *
 * @since 1.0
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 */
function alpha_heading_callback( $settings, $value ) {
	$tag   = isset( $settings['tag'] ) ? $settings['tag'] : 'h3';
	$class = isset( $settings['class'] ) ? $settings['class'] : '';
	$label = isset( $settings['label'] ) ? $settings['label'] : '';

	$html = sprintf( '<%1$s class="alpha-wpb-heading-container%2$s">%3$s</%4$s>', $tag, ( $class ? ' ' . $class : '' ), $label, $tag );

	return $html;
}

vc_add_shortcode_param( 'alpha_heading', 'alpha_heading_callback' );

<?php
/**
 * Alpha WPBakery Accordion Header Callback
 *
 * adds heading control for element option
 * follow below example of accordion_header control
 *
 * array(
 *      'type'       => 'alpha_accordion_header',
 *      'heading'    => esc_html__( 'Cart Type Options', 'alpha-core' ),
 *      'param_name' => 'test_accordion_header',
 *      'group'      => 'General',
 * ),
 *
 * @since 1.0
 *
 * @param array $settings
 * @param string $value
 *
 * @return string
 */
function alpha_accordion_header_callback( $settings, $value ) {
	$heading = isset( $settings['heading'] ) ? $settings['heading'] : '';

	$html = sprintf( '<h3 class="alpha-wpb-accordion-header">%1$s</h3>', $heading );

	return $html;
}

vc_add_shortcode_param( 'alpha_accordion_header', 'alpha_accordion_header_callback' );

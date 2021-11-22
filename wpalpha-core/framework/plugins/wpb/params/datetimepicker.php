<?php
/**
 * Alpha WPBakery datetimepicker Callback
 *
 * adds datepicker control for element option
 * follow below example of alpha_heading control
 *
 * array(
 *      'type'        => 'alpha_datetimepicker',
 *      'label'       => esc_html__( 'Date', 'alpha-core' ),
 *      'param_name'  => 'test_date',
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
function alpha_datetimepicker_callback( $settings, $value ) {
	$dependency = '';
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$uni        = uniqid( 'datetimepicker-' . rand() );
	$output     = '<div id="alpha-date-time' . esc_attr( $uni ) . '" class="alpha-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . esc_attr( $param_name ) . ' ' . esc_attr( $type ) . ' ' . esc_attr( $class ) . '" name="' . esc_attr( $param_name ) . '" style="width:258px;" value="' . esc_attr( $value ) . '" ' . $dependency . '/><div class="add-on" > <i data-time-icon="far fa-calendar" data-date-icon="far fa-calendar"></i></div></div>';
	$output    .= '<script type="text/javascript"></script>';
	return $output;
}

vc_add_shortcode_param( 'alpha_datetimepicker', 'alpha_datetimepicker_callback', ALPHA_CORE_PLUGINS_URI . '/wpb/params/datetimepicker.min.js' );

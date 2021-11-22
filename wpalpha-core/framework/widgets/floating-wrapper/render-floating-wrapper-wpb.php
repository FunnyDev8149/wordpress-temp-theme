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
	'class' => 'element-wrapper alpha-motion-effect-widget' . $atts['shortcode_class'] . $atts['style_class'],
);

$scrolls         = array(
	'vertical'     => 'v',
	'horizontal'   => 'h',
	'transparency' => 't',
	'rotate'       => 'r',
	'scale'        => 's',
);
$scroll_settings = array();

foreach ( $scrolls as $scroll => $prefix ) {
	if ( 'vertical' == $scroll ) {
		if ( ! isset( $atts['vertical_scroll'] ) || 'yes' == $atts['vertical_scroll'] ) {
			$scroll_settings['Vertical'] = array(
				'direction' => isset( $atts['v_direction'] ) ? $atts['v_direction'] : 'up',
				'speed'     => isset( $atts['v_speed'] ) ? $atts['v_speed'] : 3,
			);
		}
	} elseif ( isset( $atts[ $scroll . '_scroll' ] ) && 'yes' == $atts[ $scroll . '_scroll' ] ) {
		$scroll_settings[ ucfirst( $scroll ) ] = array(
			'speed' => isset( $atts[ $prefix . '_speed' ] ) ? $atts[ $prefix . '_speed' ] : 3,
		);
		if ( 'horizontal' == $scroll || 'rotate' == $scroll ) {
			$scroll_settings[ ucfirst( $scroll ) ]['direction'] = isset( $atts[ $prefix . '_direction' ] ) ? $atts[ $prefix . '_direction' ] : 'left';
		} elseif ( 'transparency' == $scroll || 'scale' == $scroll ) {
			$scroll_settings[ ucfirst( $scroll ) ]['direction'] = isset( $atts[ $prefix . '_direction' ] ) ? $atts[ $prefix . '_direction' ] : 'in';
		}
	}
}
if ( $scroll_settings ) {
	wp_enqueue_script( 'jquery-skrollr', ALPHA_CORE_FRAMEWORK_URI . '/assets/js/skrollr.min.js', array(), '0.6.30', true );
	$scroll_settings['viewport']                        = isset( $atts['viewport'] ) ? $atts['viewport'] : 'centered';
	$wrapper_attrs['class']                            .= ' alpha-scroll-effect-widget';
	$wrapper_attrs['data-alpha-scroll-effect-settings'] = json_encode( $scroll_settings );
}

$track_settings = array();
if ( isset( $atts['mouse_track'] ) && 'yes' == $atts['mouse_track'] ) {
	wp_enqueue_script( 'jquery-parallax', ALPHA_CORE_FRAMEWORK_URI . '/assets/js/jquery.parallax.min.js', array(), true, true );
	if ( isset( $atts['track_relative'] ) && 'yes' == $atts['track_relative'] ) {
		$track_settings['relativeInput']     = true;
		$track_settings['clipRelativeInput'] = true;
	} else {
		$track_settings['relativeInput']     = false;
		$track_settings['clipRelativeInput'] = false;
	}
	if ( ! isset( $atts['track_direction'] ) || 'opposite' == $atts['track_direction'] ) {
		$track_settings['invertX'] = true;
		$track_settings['invertY'] = true;
	} else {
		$track_settings['invertX'] = false;
		$track_settings['invertY'] = false;
	}
	$wrapper_attrs['class']       .= ' alpha-mouse-effect-widget floating-wrapper';
	$wrapper_attrs['data-toggle']  = 'floating';
	$wrapper_attrs['data-options'] = json_encode( $track_settings );
}


$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

echo '<div ' . $wrapper_attr_html . '>';
if ( $track_settings ) {
	echo '<div class="layer" data-depth="' . ( isset( $atts['track_speed'] ) ? $atts['track_speed'] : 1 ) . '">';
}
echo do_shortcode( $atts['content'] );
if ( $track_settings ) {
	echo '</div>';
}
echo '</div>';

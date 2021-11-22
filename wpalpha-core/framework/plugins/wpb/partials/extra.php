<?php
if ( ! function_exists( 'alpha_get_wpb_extra_controls' ) ) {
	function alpha_get_wpb_extra_controls() {

		$animations = alpha_get_animations( 'in' );

		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation Type', 'alpha-core' ),
				'param_name' => 'animation_type',
				'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
				'value'      => array_flip( $animations ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Animation Duration (ms)', 'alpha-core' ),
				'param_name' => 'animation_duration',
				'value'      => '1000',
				'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Animation Delay (ms)', 'alpha-core' ),
				'param_name' => 'animation_delay',
				'value'      => '0',
				'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'extra_class',
				'heading'     => esc_html__( 'Custom Class', 'alpha-core' ),
				'value'       => '',
				'group'       => esc_html__( 'Extra Options', 'alpha-core' ),
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'alpha-core' ),
			),
			array(
				'type'       => 'alpha_responsive',
				'param_name' => 'responsiveness',
				'heading'    => esc_html__( 'Responsiveness', 'alpha-core' ),
				'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
			),
		);
	}
}

add_filter(
	'alpha_wpb_element_wrapper_atts',
	function( $wrapper_attrs, $atts ) {
		// Responsive
		if ( ! empty( $atts['responsiveness'] ) ) {
			$responsive = str_replace( '``', '"', $atts['responsiveness'] );
			$responsive = json_decode( $responsive, true );
			// Generate Helper Classes
			$responsive_classes = array(
				'xl' => 'hide-on-xl',
				'lg' => 'hide-on-lg',
				'md' => 'hide-on-md',
				'sm' => 'hide-on-sm',
				'xs' => 'hide-on-xs',
			);

			$style = '';
			foreach ( $responsive_classes as $width => $helper_class ) {
				if ( ! empty( $responsive[ $width ] ) && true == $responsive[ $width ] ) {
					$wrapper_attrs['class'] .= ' ' . $helper_class;
				}
			}
		}
		// Extra Class
		if ( ! empty( $atts['extra_class'] ) ) {
			$wrapper_attrs['class'] .= ' ' . $atts['extra_class'];
		}
		// Animation
		if ( ! empty( $atts['animation_type'] ) ) {
			if ( ! vc_is_inline() ) {
				$wrapper_attrs['class'] .= ' appear-animate';
			}

			$animation_settings             = array(
				'_animation'          => $atts['animation_type'],
				'_animation_delay'    => ! empty( $atts['animation_delay'] ) ? $atts['animation_delay'] : '0',
				'_animation_duration' => ! empty( $atts['animation_duration'] ) ? $atts['animation_duration'] : '1000',
			);
			$wrapper_attrs['data-settings'] = esc_attr( json_encode( $animation_settings ) );
		}

		return $wrapper_attrs;
	},
	10,
	2
);

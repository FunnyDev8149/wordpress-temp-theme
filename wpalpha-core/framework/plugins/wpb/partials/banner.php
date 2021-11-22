<?php
if ( ! function_exists( 'alpha_wpb_banner_general_controls' ) ) {
	function alpha_wpb_banner_general_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Wrap with', 'alpha-core' ),
				'param_name' => 'wrap_with',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' ) => '',
					esc_html__( 'Container', 'alpha-core' ) => 'container',
					esc_html__( 'Container Fluid', 'alpha-core' ) => 'container-fluid',
				),
				'std'        => '',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'banner_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .banner'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .banner img' => 'background-color: transparent;',
				),
			),
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Image', 'alpha-core' ),
				'param_name' => 'banner_image',
				'value'      => '',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Image Position', 'alpha-core' ),
				'param_name'  => 'image_position',
				'description' => esc_html__( 'You can input image position like this: center top or 50% 50%.', 'alpha-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .banner-img img' => 'object-position: {{VALUE}};',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Full Screen', 'alpha-core' ),
				'param_name' => 'full_screen',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'no',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Stretch Height', 'alpha-core' ),
				'param_name'  => 'stretch_height',
				'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'         => 'no',
				'description' => esc_html__( 'You can make your banner height full of its parent.', 'alpha-core' ),
				'selectors'   => array(
					'{{WRAPPER}} , {{WRAPPER}} .banner, {{WRAPPER}} .banner-img img' => 'height: 100%;',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Min Height', 'alpha-core' ),
				'responsive' => true,
				'param_name' => 'min_height',
				'units'      => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'std'        => '{"xl":"300","unit":"px"}',
				'selectors'  => array(
					'{{WRAPPER}} .banner' => 'min-height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Max Height', 'alpha-core' ),
				'responsive' => true,
				'param_name' => 'max_height',
				'units'      => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'selectors'  => array(
					'{{WRAPPER}} .banner, {{WRAPPER}} img' => 'max-height: {{VALUE}}{{UNIT}};overflow: hidden;',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_banner_effect_controls' ) ) {
	function alpha_wpb_banner_effect_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hover Effect', 'alpha-core' ),
				'param_name' => 'hover_effect',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )  => '',
					esc_html__( 'Light', 'alpha-core' ) => 'overlay-light',
					esc_html__( 'Dark', 'alpha-core' )  => 'overlay-dark',
					esc_html__( 'Zoom', 'alpha-core' )  => 'overlay-zoom',
					esc_html__( 'Zoom and Light', 'alpha-core' ) => 'overlay-zoom overlay-light',
					esc_html__( 'Zoom and Dark', 'alpha-core' ) => 'overlay-zoom overlay-dark',
				),
				'std'        => '',
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_banner_parallax_controls' ) ) {
	function alpha_wpb_banner_parallax_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'parallax',
				'heading'    => esc_html__( 'Enable Parallax', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Parallax Speed', 'alpha-core' ),
				'param_name' => 'parallax_speed',
				'std'        => 1,
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Parallax Offset', 'alpha-core' ),
				'param_name' => 'parallax_offset',
				'std'        => 0,
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Parallax Height (%)', 'alpha-core' ),
				'param_name' => 'parallax_height',
				'std'        => '200',
				'dependency' => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'alpha_wpb_banner_video_controls' ) ) {
	function alpha_wpb_banner_video_controls() {
		return array(
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_banner',
				'heading'    => esc_html__( 'Enable Video', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Video URL', 'alpha-core' ),
				'param_name' => 'video_url',
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_autoplay',
				'heading'    => esc_html__( 'Autoplay', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_mute',
				'heading'    => esc_html__( 'Mute', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_loop',
				'heading'    => esc_html__( 'Loop', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'video_controls',
				'heading'    => esc_html__( 'Player Controls', 'alpha-core' ),
				'value'      => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
		);
	}
}

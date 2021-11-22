<?php

if ( ! function_exists( 'alpha_wpb_images_select_controls' ) ) {
	function alpha_wpb_images_select_controls() {
		return array(
			array(
				'type'        => 'attach_images',
				'heading'     => esc_html__( 'Add Images', 'alpha-core' ),
				'param_name'  => 'images',
				'value'       => '',
				'description' => esc_html__( 'Select images from media library.', 'alpha-core' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'caption_type',
				'heading'    => esc_html__( 'Caption', 'alpha-core' ),
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )  => 'none',
					esc_html__( 'Title', 'alpha-core' ) => 'title',
					esc_html__( 'Caption', 'alpha-core' ) => 'caption',
					esc_html__( 'Description', 'alpha-core' ) => 'description',
				),
				'std'        => 'none',
			),
		);
	}
}

<?php
/**
 * ImageBox Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Choose Images', 'alpha-core' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select images from media library.', 'alpha-core' ),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'thumbnail',
			'std'        => 'full',
			'heading'    => esc_html__( 'Image Size', 'alpha-core' ),
			'value'      => alpha_get_image_sizes(),
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'alpha-core' ),
			'param_name' => 'link',
			'value'      => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'alpha-core' ),
			'param_name'  => 'title',
			'value'       => 'Input Title Here',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'alpha-core' ),
			'param_name'  => 'subtitle',
			'value'       => 'Input SubTitle Here',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'Content', 'alpha-core' ),
			'param_name'  => 'content',
			// @codingStandardsIgnoreLine
			'value'       => base64_encode( '<div class="social-icons">
									<a href="#" class="social-icon framed use-hover social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed use-hover social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed use-hover social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>'
			),
			'admin_label' => true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'type',
			'heading'    => esc_html__( 'Imagebox Type', 'alpha-core' ),
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' ) => 'default',
				esc_html__( 'Outer Title', 'alpha-core' ) => 'outer',
				esc_html__( 'Inner Title', 'alpha-core' ) => 'inner',
			),
			'std'        => 'default',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
			'param_name' => 'imagebox_align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'left',
			'selectors'  => array(
				'{{WRAPPER}} .image-box' => 'text-align: {{VALUE}}',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Title', 'alpha-core' )       => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Title Typography', 'alpha-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Title Margin', 'alpha-core' ),
				'param_name' => 'title_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Sub title', 'alpha-core' )   => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'subtitle_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'SubTitle Typography', 'alpha-core' ),
				'param_name' => 'subtitle_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'SubTitle Margin', 'alpha-core' ),
				'param_name' => 'subtitle_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .subtitle' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Description', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'description_color',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'description_typography',
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'description_mg',
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .image-box .content' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'ImageBox', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_image_box',
		'icon'            => 'alpha-icon alpha-icon-image-box',
		'class'           => 'alpha_image_box',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha image box.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Image_Box extends WPBakeryShortCode {}' );
}

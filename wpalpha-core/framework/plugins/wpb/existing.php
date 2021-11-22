<?php
add_action( 'vc_after_init', 'alpha_wpb_enhance_shortcodes' );

if ( ! function_exists( 'alpha_wpb_enhance_shortcodes' ) ) {
	function alpha_wpb_enhance_shortcodes() {
		$section_group = ALPHA_DISPLAY_NAME . esc_html__( ' Options', 'alpha-core' );

		// Animation
		$animations = alpha_get_animations( 'in' );

		// Customize Row
		vc_add_params(
			'vc_section',
			array(
				array(
					'type'        => 'alpha_button_group',
					'heading'     => esc_html__( 'Content Width', 'alpha-core' ),
					'param_name'  => 'wrap_container',
					'value'       => array(
						'container'       => array(
							'title' => esc_html__( 'Boxed', 'alpha-core' ),
						),
						'container-fluid' => array(
							'title' => esc_html__( 'Fluid', 'alpha-core' ),
						),
						'none'            => array(
							'title' => esc_html__( 'Full Width', 'alpha-core' ),
						),
					),
					'std'         => 'none',
					'group'       => $section_group,
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'HTML Tag', 'alpha-core' ),
					'param_name'  => 'section_tag',
					'value'       => array(
						esc_html__( 'Default', 'alpha-core' ) => 'default',
						esc_html__( 'div', 'alpha-core' )  => 'div',
						esc_html__( 'header', 'alpha-core' ) => 'header',
						esc_html__( 'footer', 'alpha-core' ) => 'footer',
						esc_html__( 'main', 'alpha-core' ) => 'main',
						esc_html__( 'article', 'alpha-core' ) => 'article',
						esc_html__( 'section', 'alpha-core' ) => 'section',
						esc_html__( 'aside', 'alpha-core' ) => 'aside',
						esc_html__( 'nav', 'alpha-core' )  => 'nav',
					),
					'group'       => $section_group,
					'std'         => 'default',
					'admin_label' => true,
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Enable Sticky', 'alpha-core' ),
					'param_name' => 'sticky_allow',
					'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
					'group'      => $section_group,
				),
				array(
					'type'       => 'alpha_number',
					'heading'    => esc_html__( 'Sticky padding on sticky', 'alpha-core' ),
					'param_name' => 'sticky_padding',
					'units'      => array(
						'px',
						'rem',
						'em',
					),
					'group'      => $section_group,
					'dependency' => array(
						'element' => 'sticky_allow',
						'value'   => 'yes',
					),
					'selectors'  => array(
						'{{WRAPPER}}.sticky-content.fixed' => 'padding-top: {{VALUE}}{{UNIT}} !important;padding-bottom: {{VALUE}}{{UNIT}} !important;',
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Sticky Background Color', 'alpha-core' ),
					'param_name' => 'sticky_bg',
					'dependency' => array(
						'element' => 'sticky_allow',
						'value'   => 'yes',
					),
					'group'      => $section_group,
					'selectors'  => array(
						'{{WRAPPER}}.sticky-content.fixed' => 'background-color: {{VALUE}} !important;',
					),
				),
				array(
					'type'       => 'alpha_typography',
					'heading'    => esc_html__( 'Typography', 'alpha-core' ),
					'param_name' => 'section_typography',
					'group'      => $section_group,
					'selectors'  => array(
						'{{WRAPPER}}',
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Text Color', 'alpha-core' ),
					'param_name' => 'section_color',
					'group'      => $section_group,
					'selectors'  => array(
						'{{WRAPPER}}' => 'color: {{VALUE}};',
					),
				),
			)
		);
		vc_add_params(
			'vc_row',
			array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Animation Type', 'alpha-core' ),
					'param_name' => 'animation_type',
					'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
					'value'      => array_flip( $animations ),
					'std'        => 'none',
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
			)
		);
		vc_add_params(
			'vc_row_inner',
			array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Animation Type', 'alpha-core' ),
					'param_name' => 'animation_type',
					'group'      => esc_html__( 'Extra Options', 'alpha-core' ),
					'value'      => array_flip( $animations ),
					'std'        => 'none',
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
			)
		);
		vc_update_shortcode_param(
			'vc_row',
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Columns gap', 'alpha-core' ),
				'param_name'  => 'gap',
				'value'       => array(
					esc_html__( 'Default', 'alpha-core' ) => 'default',
					'0px'  => '0',
					'1px'  => '1',
					'2px'  => '2',
					'3px'  => '3',
					'4px'  => '4',
					'5px'  => '5',
					'10px' => '10',
					'15px' => '15',
					'20px' => '20',
					'25px' => '25',
					'30px' => '30',
					'35px' => '35',
				),
				'std'         => 'default',
				'description' => esc_html__( 'Select gap between columns in row.', 'alpha-core' ),
			)
		);
		vc_update_shortcode_param(
			'vc_row_inner',
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Columns gap', 'alpha-core' ),
				'param_name'  => 'gap',
				'value'       => array(
					esc_html__( 'Default', 'alpha-core' ) => 'default',
					'0px'  => '0',
					'1px'  => '1',
					'2px'  => '2',
					'3px'  => '3',
					'4px'  => '4',
					'5px'  => '5',
					'10px' => '10',
					'15px' => '15',
					'20px' => '20',
					'25px' => '25',
					'30px' => '30',
					'35px' => '35',
				),
				'std'         => 'default',
				'description' => esc_html__( 'Select gap between columns in row.', 'alpha-core' ),
			)
		);
	}
}

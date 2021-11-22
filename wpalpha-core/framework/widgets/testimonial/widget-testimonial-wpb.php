<?php
/**
 * Alpha Testimonial
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' )             => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Name', 'alpha-core' ),
			'param_name' => 'name',
			'std'        => 'John Doe',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Role', 'alpha-core' ),
			'param_name' => 'role',
			'std'        => 'Customer',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'alpha-core' ),
			'param_name' => 'title',
			'std'        => '',
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Content', 'alpha-core' ),
			'param_name' => 'testimonial_content',
			'std'        => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
		),
		esc_html__( 'Avatar', 'alpha-core' ) => array(
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Choose Avatar', 'alpha-core' ),
				'param_name' => 'avatar',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Link', 'alpha-core' ),
				'param_name' => 'link',
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Rating', 'alpha-core' ),
				'param_name' => 'rating',
				'std'        => '',
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Maximum Content Line', 'alpha-core' ),
				'param_name' => 'content_line',
				'std'        => '4',
			),

		),
	),
	esc_html__( 'Layout and Position', 'alpha-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'param_name' => 'testimonial_type',
			'value'      => array(
				esc_html__( 'Simple', 'alpha-core' ) => 'simple',
				esc_html__( 'Boxed', 'alpha-core' )  => 'boxed',
				esc_html__( 'Aside', 'alpha-core' )  => 'aside',
			),
			'std'        => 'simple',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Inversed', 'alpha-core' ),
			'param_name' => 'testimonial_inverse',
			'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'std'        => 'no',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'simple', 'aside' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Avatar Position', 'alpha-core' ),
			'param_name' => 'avatar_pos',
			'value'      => array(
				esc_html__( 'Top', 'alpha-core' )    => 'top',
				esc_html__( 'Bottom', 'alpha-core' ) => 'bottom',
			),
			'std'        => 'top',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'boxed',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Commenter Position', 'alpha-core' ),
			'param_name' => 'commenter_pos',
			'value'      => array(
				esc_html__( 'Before Comment', 'alpha-core' ) => 'before',
				esc_html__( 'After Comment', 'alpha-core' )  => 'after',
			),
			'std'        => 'after',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'boxed',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Rating Position', 'alpha-core' ),
			'param_name' => 'rating_pos',
			'value'      => array(
				esc_html__( 'Before Title', 'alpha-core' ) => 'before_title',
				esc_html__( 'After Title', 'alpha-core' )  => 'after_title',
				esc_html__( 'Before Comment', 'alpha-core' ) => 'before_comment',
				esc_html__( 'After Comment', 'alpha-core' )  => 'after_comment',
			),
			'std'        => 'before',
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'boxed', 'aside' ),
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Vertical Alignment', 'alpha-core' ),
			'param_name' => 'v_align',
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
				'{{WRAPPER}} .testimonial' => 'text-align: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => array( 'boxed', 'aside' ),
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Horizontal Alignment', 'alpha-core' ),
			'param_name' => 'h_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'center',
			'selectors'  => array(
				'{{WRAPPER}} .testimonial, {{WRAPPER}} .commenter' => 'align-items: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'testimonial_type',
				'value'   => 'aside',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )               => array(
		esc_html__( 'Testimonial Style', 'alpha-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'testimonial_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .testimonial:not(.testimonial-simple)' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content::before' => 'background-color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Avatar', 'alpha-core' )            => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'avatar_size',
				'value'      => '',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar img' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .testimonial-simple .content::after' => "{$left}: calc(2rem + {{VALUE}}{{UNIT}} / 2 - 1rem);",
					'{{WRAPPER}} .avatar::before'          => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'avatar_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar:before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'alpha-core' ),
				'param_name' => 'avatar_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'avatar_padding',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'avatar_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial .avatar' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'avatar_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'sp_share_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
				'param_name' => 'avatar_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .avatar' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'avatar_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .avatar > .social-icon' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Title', 'alpha-core' )             => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .comment-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .comment-title',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'title_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .comment-title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Comment', 'alpha-core' )           => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'comment_color',
				'selectors'  => array(
					'{{WRAPPER}} .comment' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
				'param_name' => 'comment_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .testimonial.testimonial-simple .content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .testimonial.testimonial-simple .content::after' => 'background-color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'testimonial_type',
					'value'   => 'simple',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'comment_typography',
				'selectors'  => array(
					'{{WRAPPER}} .content .comment',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Padding', 'alpha-core' ),
				'param_name' => 'comment_padding',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .content' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'comment_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .comment' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Name', 'alpha-core' )              => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'name_color',
				'selectors'  => array(
					'{{WRAPPER}} .name' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'name_typography',
				'selectors'  => array(
					'{{WRAPPER}} .name',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'name_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .name' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Role', 'alpha-core' )              => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'role_color',
				'selectors'  => array(
					'{{WRAPPER}} .role' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'role_typography',
				'selectors'  => array(
					'{{WRAPPER}} .role',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'role_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .role' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Rating', 'alpha-core' )            => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'rating_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Star Spacing', 'alpha-core' ),
				'param_name' => 'rating_sp',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'rating_color',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full span::before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Blank Color', 'alpha-core' ),
				'param_name' => 'rating_blank_color',
				'selectors'  => array(
					'{{WRAPPER}} .ratings-full::before' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Margin', 'alpha-core' ),
				'param_name' => 'rating_margin',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ratings-container' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Testimonial', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_testimonial',
		'icon'            => 'alpha-icon alpha-icon-testimonial',
		'class'           => 'alpha_testimonial',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha testimonial.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Testimonial extends WPBakeryShortCode {}' );
}

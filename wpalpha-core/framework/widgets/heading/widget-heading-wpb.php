<?php
/**
 * Alpha Heading
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'alpha_button_group',
			'heading'     => esc_html__( 'Content', 'alpha-core' ),
			'param_name'  => 'content_type',
			'value'       => array(
				'custom'  => array(
					'title' => esc_html__( 'Custom', 'alpha-core' ),
				),
				'dynamic' => array(
					'title' => esc_html__( 'Dynamic', 'alpha-core' ),
				),
			),
			'std'         => 'custom',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea_raw_html',
			'heading'    => esc_html__( 'Title', 'alpha-core' ),
			'param_name' => 'heading_title',
			'value'      => base64_encode( esc_html__( 'Add Your Heading Text Here', 'alpha-core' ) ),
			'dependency' => array(
				'element' => 'content_type',
				'value'   => 'custom',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Dynamic Content', 'alpha-core' ),
			'param_name' => 'dynamic_content',
			'value'      => array(
				esc_html__( 'Page Title', 'alpha-core' ) => 'title',
				esc_html__( 'Page Subtitle', 'alpha-core' ) => 'subtitle',
				esc_html__( 'Products Count', 'alpha-core' ) => 'product_cnt',
			),
			'dependency' => array(
				'element' => 'content_type',
				'value'   => 'dynamic',
			),
		),
		array(
			'type'        => 'alpha_dropdown',
			'heading'     => esc_html__( 'HTML Tag', 'alpha-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'H1'   => 'h1',
				'H2'   => 'h2',
				'H3'   => 'h3',
				'H4'   => 'h4',
				'H5'   => 'h5',
				'H6'   => 'h6',
				'P'    => 'p',
				'Div'  => 'div',
				'Span' => 'span',
			),
			'std'         => 'h2',
			'admin_label' => true,
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'param_name' => 'decoration',
			'value'      => array(
				'simple'    => array(
					'title' => esc_html__( 'Simple', 'alpha-core' ),
				),
				'cross'     => array(
					'title' => esc_html__( 'Cross', 'alpha-core' ),
				),
				'underline' => array(
					'title' => esc_html__( 'Underline', 'alpha-core' ),
				),
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Title Align', 'alpha-core' ),
			'param_name' => 'title_align',
			'value'      => array(
				'title-left'   => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'title-center' => array(
					'title' => esc_html__( 'Center', 'alpha-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'title-right'  => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'title-left',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Decoration Spacing', 'alpha-core' ),
			'param_name' => 'decoration_spacing',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
				'%',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .title::before' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .title::after'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Decoration Color', 'alpha-core' ),
			'param_name' => 'border_color',
			'selectors'  => array(
				'{{WRAPPER}}.title-cross .title::before, {{WRAPPER}}.title-cross .title::after, {{WRAPPER}}.title-underline::after' => 'background-color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
	),
	esc_html__( 'Link', 'alpha-core' )    => array(
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_link',
			'heading'     => esc_html__( 'Show Link?', 'alpha-core' ),
			'value'       => array( esc_html__( 'Yes, please', 'alpha-core' ) => 'yes' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link Url', 'alpha-core' ),
			'param_name' => 'link_url',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Link Label', 'alpha-core' ),
			'param_name' => 'link_label',
			'value'      => 'Link',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'alpha-core' ),
			'param_name' => 'icon',
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Icon Position', 'alpha-core' ),
			'param_name' => 'icon_pos',
			'value'      => array(
				'before' => array(
					'title' => esc_html__( 'Before', 'alpha-core' ),
				),
				'after'  => array(
					'title' => esc_html__( 'After', 'alpha-core' ),
				),
			),
			'std'        => 'after',
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Spacing', 'alpha-core' ),
			'param_name' => 'icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}}.icon-before i' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}}.icon-after i'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Icon Size', 'alpha-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'alpha_button_group',
			'heading'    => esc_html__( 'Link Align', 'alpha-core' ),
			'param_name' => 'link_align',
			'value'      => array(
				'link-left'  => array(
					'title' => esc_html__( 'Left', 'alpha-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'link-right' => array(
					'title' => esc_html__( 'Right', 'alpha-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
		),
		array(
			'type'       => 'alpha_number',
			'heading'    => esc_html__( 'Link Space', 'alpha-core' ),
			'param_name' => 'link_gap',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .link' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		array(
			'type'       => 'alpha_dimension',
			'heading'    => esc_html__( 'Title Padding', 'alpha-core' ),
			'param_name' => 'title_spacing',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .title' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Title Color', 'alpha-core' ),
			'param_name' => 'title_color',
			'selectors'  => array(
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Title Typography', 'alpha-core' ),
			'param_name' => 'title_typography',
			'selectors'  => array(
				'{{WRAPPER}} .title',
			),
		),
		array(
			'type'       => 'alpha_typography',
			'heading'    => esc_html__( 'Link Typography', 'alpha-core' ),
			'param_name' => 'link_typography',
			'selectors'  => array(
				'{{WRAPPER}} .link',
			),
		),
		array(
			'type'       => 'alpha_color_group',
			'heading'    => esc_html__( 'Link Colors', 'alpha-core' ),
			'param_name' => 'link_colors',
			'group'      => esc_html__( 'General', 'alpha-core' ),
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .link',
				'hover'  => '{{WRAPPER}} .link:hover',
			),
			'choices'    => array( 'color' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Heading', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_heading',
		'icon'            => 'alpha-icon alpha-icon-heading',
		'class'           => 'alpha_heading',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha heading.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Heading extends WPBakeryShortCode {}' );
}

<?php
/**
 * Alpha Single Product Image
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Content', 'alpha-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'alpha-core' ),
			'param_name' => 'sp_type',
			'std'        => 'default',
			'value'      => array(
				esc_html__( 'Default', 'alpha-core' )    => 'default',
				esc_html__( 'Horizontal', 'alpha-core' ) => 'horizontal',
				esc_html__( 'Grid', 'alpha-core' )       => 'grid',
				esc_html__( 'Masonry', 'alpha-core' )    => 'masonry',
				esc_html__( 'Gallery', 'alpha-core' )    => 'gallery',
			),
		),
		array(
			'type'        => 'alpha_number',
			'heading'     => esc_html__( 'Columns', 'alpha-core' ),
			'param_name'  => 'col_cnt',
			'responsive'  => true,
			'value'       => '',
			'description' => 'Type numbers from 1 to 8.',
			'dependency'  => array(
				'element' => 'sp_type',
				'value'   => array( 'grid', 'gallery' ),
			),
		),
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		esc_html__( 'Image', 'alpha-core' )      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'image_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Width', 'alpha-core' ),
				'param_name' => 'image_border_width',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_color_group',
				'heading'    => esc_html__( 'Border Color', 'alpha-core' ),
				'param_name' => 'btn_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .woocommerce-product-gallery__image img',
					'hover'  => '{{WRAPPER}} .woocommerce-product-gallery__image a:hover img',
					'active' => '{{WRAPPER}} .woocommerce-product-gallery__image a:active img',
				),
				'choices'    => array( 'color' ),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'image_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Thumbnails', 'alpha-core' ) => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Type', 'alpha-core' ),
				'param_name' => 'thumbnail_border',
				'value'      => array(
					esc_html__( 'None', 'alpha-core' )   => 'none',
					esc_html__( 'Solid', 'alpha-core' )  => 'solid',
					esc_html__( 'Double', 'alpha-core' ) => 'double',
					esc_html__( 'Dotted', 'alpha-core' ) => 'dotted',
					esc_html__( 'Dashed', 'alpha-core' ) => 'dashed',
					esc_html__( 'Groove', 'alpha-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb img' => 'border-style: {{VALUE}};',
				),
			),
			array(
				'type'       => 'alpha_dimension',
				'heading'    => esc_html__( 'Border Radius', 'alpha-core' ),
				'param_name' => 'thumbnail_border_radius',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb img' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Spacing', 'alpha-core' ),
				'param_name' => 'thumbs_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'selectors'  => array(
					'{{WRAPPER}} .product-thumb' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Image', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_image',
		'icon'            => 'alpha-icon alpha-icon-sp-image',
		'class'           => 'alpha_sp_image',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product image.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Image extends WPBakeryShortCode {}' );
}

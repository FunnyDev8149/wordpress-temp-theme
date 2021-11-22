<?php
/**
 * Alpha Single Product Rating
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'Style', 'alpha-core' ) => array(
		esc_html__( 'General', 'alpha-core' ) => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'alpha-core' ),
				'param_name' => 'sp_type',
				'value'      => array(
					esc_html__( 'Star', 'alpha-core' )   => 'star',
					esc_html__( 'Number', 'alpha-core' ) => 'number',
				),
				'std'        => 'star',
			),
			array(
				'type'       => 'alpha_button_group',
				'heading'    => esc_html__( 'Alignment', 'alpha-core' ),
				'param_name' => 'sp_align',
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
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Number', 'alpha-core' )  => array(
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'sp_number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'number',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'number',
				),
			),
		),
		esc_html__( 'Star', 'alpha-core' )    => array(
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Size', 'alpha-core' ),
				'param_name' => 'icon_size',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .star-rating' => 'font-size: {{VALUE}}{{UNIT}}',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'alpha_number',
				'heading'    => esc_html__( 'Spacing', 'alpha-core' ),
				'param_name' => 'icon_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .star-rating' => 'letter-spacing: {{VALUE}}{{UNIT}}',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'stars_color',
				'selectors'  => array(
					'{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Unmarked Color', 'alpha-core' ),
				'param_name' => 'stars_unmarked_color',
				'selectors'  => array(
					'{{WRAPPER}} .star-rating span:after' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'star',
				),
			),
		),
		esc_html__( 'Reviews', 'alpha-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Reviews Show', 'alpha-core' ),
				'param_name' => 'sp_reviews',
				'value'      => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
				'std'        => 'yes',
			),
			array(
				'type'       => 'alpha_typography',
				'heading'    => esc_html__( 'Typography', 'alpha-core' ),
				'param_name' => 'sp_review_typo',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-review-link',
				),
				'dependency' => array(
					'element' => 'sp_reviews',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'alpha-core' ),
				'param_name' => 'stars_review_color',
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-review-link' => 'color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'sp_reviews',
					'value'   => 'yes',
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Rating', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_sp_rating',
		'icon'            => 'alpha-icon alpha-icon-sp-rating',
		'class'           => 'alpha_sp_rating',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => ALPHA_DISPLAY_NAME . esc_html__( ' Single Product', 'ridoe-core' ),
		'description'     => esc_html__( 'Create alpha single product rating.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Sp_Rating extends WPBakeryShortCode {}' );
}

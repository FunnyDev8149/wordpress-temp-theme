<?php
/**
 * Masonry Item Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'        => 'alpha_number',
			'heading'     => esc_html__( 'Grid Item Width', 'alpha-core' ),
			'param_name'  => 'creative_width',
			'responsive'  => true,
			'units'       => array(
				'%',
			),
			'description' => esc_html( 'Leave it blank to follow creative grid preset.', 'alpha-core' ),
		),
		array(
			'type'       => 'alpha_dropdown',
			'heading'    => esc_html__( 'Grid Item Height', 'alpha-core' ),
			'param_name' => 'creative_height',
			'responsive' => true,
			'value'      => array(
				esc_html__( 'Preset', 'alpha-core' )   => 'preset',
				'1'                                      => '1',
				'1/2'                                    => '1-2',
				'1/3'                                    => '1-3',
				'2/3'                                    => '2-3',
				'1/4'                                    => '1-4',
				'3/4'                                    => '3-4',
				'1/5'                                    => '1-5',
				'2/5'                                    => '2-5',
				'3/5'                                    => '3-5',
				'4/5'                                    => '4-5',
				esc_html__( 'Children', 'alpha-core' ) => 'child',
			),
		),
		array(
			'type'        => 'alpha_dropdown',
			'heading'     => esc_html__( 'Grid Item Order', 'alpha-core' ),
			'param_name'  => 'creative_order',
			'responsive'  => true,
			'value'       => array(
				esc_html__( 'Default', 'alpha-core' ) => '',
				'1'                                     => '1',
				'2'                                     => '2',
				'3'                                     => '3',
				'4'                                     => '4',
				'5'                                     => '5',
				'6'                                     => '6',
				'7'                                     => '7',
				'8'                                     => '8',
				'9'                                     => '9',
				'10'                                    => '10',
			),
			'description' => esc_html( 'Item order option does not work for float grid layout.', 'alpha-core' ),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry Item', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_masonry_item',
		'icon'            => 'alpha-icon alpha-icon-masonry',
		'class'           => 'alpha_masonry_item',
		'as_parent'       => array( 'except' => 'wpb_' . ALPHA_NAME . '_masonry_item' ),
		'as_child'        => array( 'only' => 'wpb_' . ALPHA_NAME . '_masonry' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha creative grid item.', 'alpha-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Masonry_Item extends WPBakeryShortCodesContainer {}' );
}

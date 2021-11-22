<?php
/**
 * Masonry Element
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */


$creative_layout = alpha_creative_preset_imgs();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => ALPHA_CORE_URI . $item,
	);
}

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		array(
			'type'         => 'alpha_button_group',
			'param_name'   => 'creative_mode',
			'heading'      => esc_html__( 'Creative Layout', 'alpha-core' ),
			'std'          => 1,
			'button_width' => '100',
			'value'        => $creative_layout,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Change Grid Height', 'alpha-core' ),
			'param_name' => 'creative_height',
			'value'      => '600',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Grid Mobile Height (%)', 'alpha-core' ),
			'param_name' => 'creative_height_ratio',
			'value'      => '75',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'grid_float',
			'value'       => array( esc_html__( 'Yes', 'alpha-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Use Float Grid', 'alpha-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'alpha-core' ),
		),
		array(
			'type'       => 'alpha_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'alpha-core' ),
			'std'        => apply_filters( 'alpha_col_default', 'md' ),
			'value'      => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'alpha-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'alpha-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'alpha-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'alpha-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'alpha-core' ),
				),
			),
		),
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_masonry',
		'icon'            => 'alpha-icon alpha-icon-masonry',
		'class'           => 'alpha_masonry',
		'as_parent'       => array( 'only' => 'wpb_' . ALPHA_NAME . '_masonry_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha isotope layout.', 'alpha-core' ),
		'default_content' => vc_is_inline() ? '[wpb_' . ALPHA_NAME . '_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_' . ALPHA_NAME . '_masonry_item][wpb_' . ALPHA_NAME . '_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_' . ALPHA_NAME . '_masonry_item][wpb_' . ALPHA_NAME . '_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_' . ALPHA_NAME . '_masonry_item][wpb_' . ALPHA_NAME . '_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_' . ALPHA_NAME . '_masonry_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Masonry extends WPBakeryShortCodesContainer {}' );
}

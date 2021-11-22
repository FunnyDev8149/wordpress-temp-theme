<?php
/**
 * Alpha Products Layout Shortcode
 *
 * - products + banner
 * - products + single product
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$params = array(
	esc_html__( 'General', 'alpha-core' ) => array(
		'alpha_wpb_products_select_controls',
	),
	esc_html__( 'Layout', 'alpha-core' )  => array(
		'alpha_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'alpha-core' )    => array(
		'alpha_wpb_products_type_controls',
	),
	esc_html__( 'Style', 'alpha-core' )   => array(
		'alpha_wpb_products_style_controls',
	),
);

$params = array_merge( alpha_wpb_filter_element_params( $params, 'wpb_' . ALPHA_NAME . '_products_layout' ), alpha_get_wpb_design_controls(), alpha_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Layout', 'alpha-core' ),
		'base'            => 'wpb_' . ALPHA_NAME . '_products_layout',
		'icon'            => 'alpha-icon alpha-icon-layout',
		'class'           => 'alpha_products_layout',
		'as_parent'       => array( 'only' => 'wpb_' . ALPHA_NAME . '_products_banner_item, wpb_alpha_products_single_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => ALPHA_DISPLAY_NAME,
		'description'     => esc_html__( 'Create alpha products layout including products + banner, product + single product and etc.', 'alpha-core' ),
		'params'          => $params,
		'default_content' => '[wpb_alpha_products_banner_item item_no="1" full_screen="" effect_duration="30" creative_item_heading=""][wpb_alpha_banner_layer banner_origin="t-m" layer_pos="{``top``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``50%``},``right``:{``xl``:``5%``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:````},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5%``}}" layer_width="{``xl``:``90``,``unit``:``%``,``xs``:````,``sm``:````,``md``:````,``lg``:````}" layer_height="{``xl``:````,``unit``:``px``,``xs``:````,``sm``:````,``md``:````,``lg``:````}"][wpb_alpha_heading heading_title="QSUyMFNpbXBsZSUyMEJhbm5lcg==" html_tag="h3" decoration="simple" title_align="title-center" link_align="link-left" extra_class="mb-4"][wpb_alpha_heading heading_title="TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCUyQyUyMGNvbnNlY3RldHVlciUyMGFkaXBpc2NpbmclMjBlbGl0JTJDJTIwc2VkJTIwZGlhbSUyMG5vbnVtbXklMjBuaWJoJTIw" html_tag="p" decoration="simple" title_align="title-center" link_align="link-left" title_typography="{``family``:``Default``,``variant``:``Default``,``size``:``14px``,``line_height``:````,``letter_spacing``:````,``text_transform``:``none``}"][/wpb_alpha_banner_layer][/wpb_alpha_products_banner_item]',
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_layout_categories_callback', 'alpha_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_layout_categories_render', 'alpha_wpb_shortcode_product_category_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_layout_product_ids_callback', 'alpha_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_' . ALPHA_NAME . '_products_layout_product_ids_render', 'alpha_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_alpha_products_layout_product_ids_param_value', 'alpha_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	eval( 'class WPBakeryShortCode_WPB_' . ucfirst( ALPHA_NAME ) . '_Products_Layout extends WPBakeryShortCodesContainer {}' );
}

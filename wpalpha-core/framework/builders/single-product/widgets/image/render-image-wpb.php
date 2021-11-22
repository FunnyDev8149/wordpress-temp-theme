<?php
/**
 * Single Prodcut Image Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
			'col_sp'  => 'md',
		),
		$atts
	)
);

$GLOBALS['alpha_wpb_sp_image_settings'] = $atts;
$GLOBALS['alpha_wpb_sp_image_settings'] = array_merge(
	$atts,
	array(
		'col_sp' => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	)
);

// Responsive columns
$GLOBALS['alpha_wpb_sp_image_settings'] = array_merge( $GLOBALS['alpha_wpb_sp_image_settings'], alpha_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $GLOBALS['alpha_wpb_sp_image_settings']['col_cnt'] ) {
	$GLOBALS['alpha_wpb_sp_image_settings']['col_cnt'] = $GLOBALS['alpha_wpb_sp_image_settings']['col_cnt_xl'];
}

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-sp-image-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

	if ( ! function_exists( 'get_gallery_type' ) ) {
		function get_gallery_type() {
			global $alpha_wpb_sp_image_settings;
			return isset( $alpha_wpb_sp_image_settings['sp_type'] ) ? $alpha_wpb_sp_image_settings['sp_type'] : 'default';
		}
	}

	if ( ! function_exists( 'alpha_extend_gallery_class' ) ) {
		function alpha_extend_gallery_class( $classes ) {
			global $alpha_wpb_sp_image_settings;
			$single_product_layout = isset( $alpha_wpb_sp_image_settings['sp_type'] ) ? $alpha_wpb_sp_image_settings['sp_type'] : '';
			$classes[]             = 'pg-custom';

			if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

				foreach ( $classes as $i => $class ) {
					if ( 'cols-sm-2' == $class ) {
						array_splice( $classes, $i, 1 );
					}
				}
				$classes[]        = alpha_get_col_class( alpha_elementor_grid_col_cnt( $alpha_wpb_sp_image_settings ) );
				$grid_space_class = alpha_elementor_grid_space_class( $alpha_wpb_sp_image_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}

			return $classes;
		}
	}

	if ( ! function_exists( 'alpha_extend_gallery_type_class' ) ) {
		function alpha_extend_gallery_type_class( $class ) {
			global $alpha_wpb_sp_image_settings;
			$class            = ' ' . alpha_get_col_class( alpha_elementor_grid_col_cnt( $alpha_wpb_sp_image_settings ) );
			$grid_space_class = alpha_elementor_grid_space_class( $alpha_wpb_sp_image_settings );
			if ( $grid_space_class ) {
				$class .= ' ' . $grid_space_class;
			}
			return $class;
		}
	}

	if ( ! function_exists( 'alpha_extend_gallery_type_attr' ) ) {
		function alpha_extend_gallery_type_attr( $attr ) {
			global $alpha_wpb_sp_image_settings;
			$alpha_wpb_sp_image_settings['show_nav']  = 'yes';
			$alpha_wpb_sp_image_settings['show_dots'] = 'yes';
			$attr                                    .= ' data-slider-options="' . esc_attr(
				json_encode(
					alpha_get_slider_attrs( $alpha_wpb_sp_image_settings, alpha_elementor_grid_col_cnt( $alpha_wpb_sp_image_settings ) )
				)
			) . '"';
			return $attr;
		}
	}

	add_filter( 'alpha_single_product_layout', 'get_gallery_type', 99 );
	add_filter( 'alpha_single_product_gallery_main_classes', 'alpha_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		add_filter( 'alpha_single_product_gallery_type_class', 'alpha_extend_gallery_type_class' );
		add_filter( 'alpha_single_product_gallery_type_attr', 'alpha_extend_gallery_type_attr' );
	}

	woocommerce_show_product_images();

	remove_filter( 'alpha_single_product_layout', 'get_gallery_type', 99 );
	remove_filter( 'alpha_single_product_gallery_main_classes', 'alpha_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		remove_filter( 'alpha_single_product_gallery_type_class', 'alpha_extend_gallery_type_class' );
		remove_filter( 'alpha_single_product_gallery_type_attr', 'alpha_extend_gallery_type_attr' );
	}

	do_action( 'alpha_single_product_builder_unset_preview' );
}
?>
</div>
<?php

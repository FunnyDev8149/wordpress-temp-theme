<?php
/**
 * Brands Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
if ( empty( $atts['col_sp'] ) ) {
	$atts['col_sp'] = 'md';
}
$atts['page_builder'] = 'wpb';

// Columns
if ( ! empty( $atts['col_cnt'] ) ) {

	$columns                = json_decode( str_replace( '``', '"', $atts['col_cnt'] ), true );
	$atts['col_cnt_xl']     = $columns['xl'];
	$atts['col_cnt']        = empty( $columns['lg'] ) ? $columns['xl'] : $columns['lg'];
	$atts['col_cnt_tablet'] = $columns['md'];
	$atts['col_cnt_mobile'] = $columns['sm'];
	$atts['col_cnt_min']    = $columns['xs'];
}

$wrapper_attrs = array(
	'class' => 'alpha-wpb-brands-container ' . $atts['shortcode_class'] . $atts['style_class'] . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Brand Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/brands/render-brands-elementor.php' );
?>
</div>
<?php

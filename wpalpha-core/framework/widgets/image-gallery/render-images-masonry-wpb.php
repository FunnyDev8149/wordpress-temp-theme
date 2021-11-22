<?php
/**
 * Image Gallery Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
$wrapper_attrs = array(
	'class' => 'alpha-wpb-image-gallery-container ' . $atts['shortcode_class'] . $atts['style_class'] . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
if ( ! empty( $atts['images'] ) ) {
	$atts['images'] = explode( ',', $atts['images'] );
	foreach ( $atts['images'] as &$value ) {
		$value = array(
			'id' => $value,
		);
	}
} else {
	$atts['images'] = array();
}

$atts['page_builder']  = 'wpb';
$atts['layout_type']   = 'creative';
$atts['creative_mode'] = isset( $atts['creative_mode'] ) ? $atts['creative_mode'] : 1;
$atts['count']         = isset( $atts['count'] ) ? array( 'size' => $atts['count'] ) : array( 'size' => 4 );
$atts['col_sp']        = isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md';

// Responsive columns
$atts = array_merge( $atts, alpha_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );


?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Image Slider Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/image-gallery/render-image-gallery-elementor.php' );
?>
</div>
<?php

<?php
/**
 * Filter Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-filter-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

global $alpha_wpb_filter;
do_shortcode( $atts['content'] );

$settings = array(
	'align'      => isset( $atts['align'] ) ? $atts['align'] : 'center',
	'btn_label'  => isset( $atts['btn_label'] ) ? $atts['btn_label'] : esc_html__( 'Filter', 'alpha-core' ),
	'btn_skin'   => isset( $atts['btn_skin'] ) ? $atts['btn_skin'] : 'btn-primary',
	'attributes' => $alpha_wpb_filter,
);

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Filter Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/filter/render-filter.php' );
?>
</div>
<?php

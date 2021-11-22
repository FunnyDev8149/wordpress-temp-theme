<?php
/**
 * Header Search Shortcode Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-search-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

$args = array(
	'aria_label' => array(
		'type'             => isset( $atts['type'] ) ? $atts['type'] : 'hs-simple',
		'where'            => 'header',
		'search_post_type' => isset( $atts['search_type'] ) ? $atts['search_type'] : '',
		'search_label'     => isset( $atts['label'] ) ? $atts['label'] : '',
		'placeholder'      => isset( $atts['placeholder'] ) && $atts['placeholder'] ? $atts['placeholder'] : esc_html__( 'Search in...', 'alpha-core' ),
		'search_right'     => false,
		'icon'             => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : ALPHA_ICON_PREFIX . '-icon-search',
	),
);

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Search Render
alpha_search_form( $args );
?>
</div>
<?php

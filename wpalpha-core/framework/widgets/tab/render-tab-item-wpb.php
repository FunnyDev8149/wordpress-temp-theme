<?php
/**
 * Tab Item Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class'          => 'alpha-tab-item-container tab-pane ' . $atts['shortcode_class'] . $atts['style_class'],
	'data-tab-title' => empty( $atts['tab_title'] ) ? 'Tab' : alpha_strip_script_tags( $atts['tab_title'] ),
);

global $alpha_wpb_tab;
if ( ! $alpha_wpb_tab ) {
	$wrapper_attrs['class'] .= ' active';
	$alpha_wpb_tab         = array();
}
$alpha_wpb_tab[] = empty( $atts['tab_title'] ) ? 'Tab' : $atts['tab_title'];

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
echo do_shortcode( $atts['content'] );
?>
</div>
<?php

<?php
/**
 * Accordion Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-accordion-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

global $alpha_wpb_accordion;
$alpha_wpb_accordion = array(
	'accordion_icon'        => isset( $atts['accordion_icon'] ) ? $atts['accordion_icon'] : ALPHA_ICON_PREFIX . '-icon-plus',
	'accordion_active_icon' => isset( $atts['accordion_active_icon'] ) ? $atts['accordion_active_icon'] : ALPHA_ICON_PREFIX . '-icon-minus',
	'index'                 => 0,
);

if ( vc_is_inline() ) {
	$wrapper_attrs['data-accordion-icon']        = $alpha_wpb_accordion['accordion_icon'];
	$wrapper_attrs['data-accordion-active-icon'] = $alpha_wpb_accordion['accordion_active_icon'];
}

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php

$extra_class = ' accordion' . ( isset( $atts['accordion_type'] ) && $atts['accordion_type'] ? ' accordion-' . $atts['accordion_type'] : '' );

echo '<div class="' . $extra_class . '">';
echo do_shortcode( $atts['content'] );
echo '</div>';
?>
</div>
<?php

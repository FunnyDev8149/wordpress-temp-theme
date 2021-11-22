<?php
/**
 * Video Player Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'button_icon'   => '',
			'alignment'     => 'start',
			'button_border' => 'btn-ellipse',
			'button_skin'   => 'btn-primary',
		),
		$atts
	)
);

// Preprocess

$wrapper_attrs = array(
	'class' => 'alpha-videopopup-container video-player text-' . $alignment . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
$class    = 'btn btn-video-player';
$icon_cls = $button_icon ? $button_icon : ALPHA_ICON_PREFIX . '-icon-play';
if ( $button_border ) {
	$class .= ' ' . $button_border;
}
if ( $button_skin ) {
	$class .= ' ' . $button_skin;
}
printf( '<a class="' . esc_attr( $class ) . '"><i class="' . esc_attr( $icon_cls ) . '"></i></a>' );
?>
</div>
<?php

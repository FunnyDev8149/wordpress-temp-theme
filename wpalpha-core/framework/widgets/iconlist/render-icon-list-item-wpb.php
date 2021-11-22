<?php
/**
 * InfoBox Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'text'          => esc_html( 'List Item', 'alpha-core' ),
			'selected_icon' => 'fas fa-check',
			'link'          => '',
			'class'         => '',

		),
		$atts
	)
);

$wrapper_attrs = array(
	'class' => 'alpha-icon-list-item ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

if ( ! empty( $link ) && isset( $link['url'] ) ) {
	$list_url = $link['url'];
} else {
	$list_url = '#';
}
$wrapper_attrs['href'] = esc_url( $list_url );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

echo '<a ' . alpha_escaped( $wrapper_attr_html ) . '>';

if ( ! empty( $selected_icon ) ) {
	echo '<i class="' . esc_attr( $selected_icon ) . '"></i>';
}
echo alpha_escaped( $text );
?>
</a>
<?php

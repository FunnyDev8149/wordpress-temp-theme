<?php
/**
 * Header Contact Shortcode Render
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'alpha-hb-contact-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

if ( ! empty( $atts['contact_telephone_link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['contact_telephone_link'] = vc_build_link( $atts['contact_telephone_link'] );
}

$atts = array(
	'live_chat'      => isset( $atts['contact_link_text'] ) ? $atts['contact_link_text'] : esc_html__( 'Live Chat', 'alpha-core' ),
	'live_chat_link' => isset( $atts['link'] ) ? $atts['link'] : '',
	'tel_num'        => isset( $atts['contact_telephone'] ) ? $atts['contact_telephone'] : esc_html__( '0(800)123-456', 'alpha-core' ),
	'tel_num_link'   => isset( $atts['contact_telephone_link'] ) ? $atts['contact_telephone_link'] : '',
	'delimiter'      => isset( $atts['contact_delimiter'] ) ? $atts['contact_delimiter'] : esc_html__( 'or:', 'alpha-core' ),
	'icon'           => isset( $atts['contact_icon'] ) && $atts['contact_icon'] ? $atts['contact_icon'] : ALPHA_ICON_PREFIX . '-icon-call',
);

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
	<?php require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/contact/render-contact-elementor.php' ); ?>
</div>
<?php

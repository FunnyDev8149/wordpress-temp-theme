<?php
/**
 * Menu Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

if ( isset( $atts['icon'] ) ) {
	$atts['icon'] = array(
		'value' => $atts['icon'],
	);
}

$atts['builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'alpha-menu-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Menu Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/menu/render-menu.php' );
?>
</div>
<?php

<?php
/**
 * Categories Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

$wrapper_attrs = array(
	'class' => 'alpha-wpb-categories-container ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
$atts['page_builder']        = 'wpb';
$atts['layout_type']         = 'slider';
$atts['count']               = isset( $atts['count'] ) ? array( 'size' => $atts['count'] ) : array( 'size' => 4 );
$atts['follow_theme_option'] = isset( $atts['follow_theme_option'] ) ? $atts['follow_theme_option'] : 'yes';
$atts['category_type']       = isset( $atts['category_type'] ) ? $atts['category_type'] : '';
$atts['content_origin']      = isset( $atts['content_origin'] ) ? $atts['content_origin'] : '';

// slider
$atts = array_merge(
	$atts,
	array(
		'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
		'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
		'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
		'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
		'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ?
		$atts['autoplay_timeout'] : 5000,
		'loop'                  => isset( $atts['loop'] ) ? $atts['loop'] : '',
		'pause_onhover'         => isset( $atts['pause_onhover'] ) ? $atts['pause_onhover'] : '',
		'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
		'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
		'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : '',
		'vertical_dots'         => isset( $atts['vertical_dots'] ) ? $atts['vertical_dots'] : '',
		'dots_skin'             => isset( $atts['dots_skin'] ) ? $atts['dots_skin'] : '',
		'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
		'box_shadow_slider'     => isset( $atts['box_shadow_slider'] ) ? $atts['box_shadow_slider'] : '',
		'show_nav'              => isset( $atts['show_nav'] ) ? 'yes' == $atts['show_nav'] : '',
		'show_dots'             => isset( $atts['show_dots'] ) ? 'yes' == $atts['show_dots'] : '',
		'nav_pos'               => isset( $atts['nav_pos'] ) ? $atts['nav_pos'] : 'outer',
	)
);

// Responsive columns
$atts = array_merge( $atts, alpha_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
}
// Responsive nav visibility
$show_nav = alpha_wpb_convert_responsive_values( 'show_nav', $atts );
if ( isset( $show_nav['show_nav'] ) ) {
	$settings['show_nav'] = $show_nav['show_nav'];
}
if ( isset( $show_nav['show_nav_xl'] ) && empty( $show_nav['show_nav'] ) ) {
	$settings['show_nav'] = $show_nav['show_nav_xl'];
}

// Responsive dots visibility
$show_dots = alpha_wpb_convert_responsive_values( 'show_dots', $atts );
if ( isset( $show_dots['show_dots'] ) ) {
	$settings['show_dots'] = $show_dots['show_dots'];
}
?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Categories Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/categories/render-categories.php' );
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $atts['shortcode_class'] );
	?>
		<script>theme.slider('<?php echo alpha_strip_script_tags( $selector ); ?> .slider-wrapper');</script>
	<?php
}

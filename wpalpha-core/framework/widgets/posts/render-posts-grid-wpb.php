<?php
/**
 * Post Shortcode Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
$wrapper_attrs = array(
	'class' => 'alpha-wpb-post-container ' . $atts['shortcode_class'] . $atts['style_class'] . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

// Preprocess
$atts['layout_type']         = 'grid';
$atts['count']               = isset( $atts['count'] ) ? array( 'size' => $atts['count'] ) : array( 'size' => 4 );
$atts['follow_theme_option'] = isset( $atts['follow_theme_option'] ) ? $atts['follow_theme_option'] : 'yes';
$atts['category_type']       = isset( $atts['category_type'] ) ? $atts['category_type'] : '';
$atts['col_sp']              = isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md';
$atts['icon']                = isset( $atts['icon'] ) ? array( 'value' => $atts['icon'] ) : array( 'value' => '' );
$atts['show_label']          = isset( $atts['show_label'] ) ? $atts['show_label'] : 'yes';
$atts['icon_hover_effect']   = isset( $atts['icon_hover_effect'] ) ? $atts['icon_hover_effect'] : '';

// Responsive columns
$atts = array_merge( $atts, alpha_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
}


?>
<div <?php echo alpha_escaped( $wrapper_attr_html ); ?>>
<?php
// Post Render
require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/posts/render-posts.php' );
?>
</div>
<?php

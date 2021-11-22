<?php
/**
 * Heading Shortcode
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

// Preprocess
if ( ! empty( $atts['link_url'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link_url'] = vc_build_link( $atts['link_url'] );
}

if ( ! empty( $atts['heading_title'] ) ) {
	$atts['heading_title'] = rawurldecode( base64_decode( wp_strip_all_tags( $atts['heading_title'] ) ) );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'heading_title'   => esc_html__( 'Add Your Heading Text Here', 'alpha-core' ),
			'html_tag'        => 'h2',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => 'Link',
			'title_align'     => 'title-left',
			'link_align'      => '',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',
		),
		$atts
	)
);


$wrapper_attrs = array(
	'class' => 'title-wrapper ' . $atts['shortcode_class'] . $atts['style_class'],
);

$wrapper_attrs = apply_filters( 'alpha_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$html = '';

if ( 'dynamic' == $content_type ) {
	global $alpha_layout;
	$heading_title = '';

	if ( isset( $alpha_layout ) ) {
		if ( class_exists( 'WooCommerce' ) && is_shop() ) { // Shop Page
			$page_id = wc_get_page_id( 'shop' );
		} elseif ( is_home() && get_option( 'page_for_posts' ) ) { // Blog Page
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

		if ( 'title' == $dynamic_content ) {
			Alpha_Layout_Builder::get_instance()->setup_titles();
			$title = get_post_meta( $page_id, 'page_title', true );
			if ( ! $title ) {
				$title = $alpha_layout['title'];
			}
		} elseif ( 'subtitle' == $dynamic_content ) {
			Alpha_Layout_Builder::get_instance()->setup_titles();
			$title = get_post_meta( $page_id, 'page_subtitle', true );
			if ( ! $title ) {
				$title = $alpha_layout['subtitle'];
			}
		} elseif ( 'product_cnt' == $dynamic_content ) {
			if ( function_exists( 'alpha_is_shop' ) && alpha_is_shop() && alpha_wc_get_loop_prop( 'total' ) ) {
				$heading_title = alpha_wc_get_loop_prop( 'total' ) . ' products';
			}
		}
	} else {
		if ( 'title' == $dynamic_content ) {
			$heading_title = esc_html__( 'Page Title', 'alpha-core' );
		} elseif ( 'subtitle' == $dynamic_content ) {
			$heading_title = esc_html__( 'Page Subtitle', 'alpha-core' );
		} elseif ( 'product_cnt' == $dynamic_content ) {
			$heading_title = esc_html__( '* Products', 'alpha-core' );
		}
	}
}

if ( $heading_title || ( 'yes' == $show_link && $link_label ) ) {
	$class = $class ? $class . ' title' : 'title';

	if ( $decoration && 'simple' != $decoration ) {
		$wrapper_attrs['class'] .= ' title-' . $decoration;
	}

	if ( $title_align ) {
		$wrapper_attrs['class'] .= ' ' . $title_align;
	}

	if ( $link_align ) {
		$wrapper_attrs['class'] .= ' ' . $link_align;
	}
	$link_label = '<span>' . esc_html( $link_label ) . '</span>';

	if ( ! empty( $icon ) ) {
		if ( 'before' == $icon_pos ) {
			$wrapper_attrs['class'] .= ' icon-before';
			$link_label              = '<i class="' . $icon . '"></i>' . $link_label;
		} else {
			$wrapper_attrs['class'] .= ' icon-after';
			$link_label             .= '<i class="' . $icon . '"></i>';
		}
	}
	$wrapper_attr_html = '';
	foreach ( $wrapper_attrs as $key => $value ) {
		$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
	}

	$html .= '<div ' . alpha_escaped( $wrapper_attr_html ) . '>';

	if ( $heading_title ) {
		$html .= sprintf( '<%1$s class="' . esc_attr( $class ) . '">%2$s</%1$s>', $html_tag, do_shortcode( $heading_title ) );
	}

	if ( 'yes' == $show_link ) { // If Link is allowed
		if ( 'yes' == $show_divider ) {
			$html .= '<span class="divider"></span>';
		}
		$html .= sprintf( '<a href="%1$s" class="link">%2$s</a>', ! empty( $link_url['url'] ) ? $link_url['url'] : '#', ( $link_label ) );
	}
	$html .= '</div>';
}

echo alpha_escaped( $html );

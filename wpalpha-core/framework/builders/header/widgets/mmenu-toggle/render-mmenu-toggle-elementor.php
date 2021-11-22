<?php
/**
 * Header mobile menu toggle template
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

// disable if mobile menu has no any items
if ( ! function_exists( 'alpha_get_option' ) || ! alpha_get_option( 'mobile_menu_items' ) ) {
	return;
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'icon_class' => ALPHA_ICON_PREFIX . '-icon-hamburger',
		),
		$atts
	)
);
?>
<a href="#" class="mobile-menu-toggle d-lg-none"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></a>
<?php

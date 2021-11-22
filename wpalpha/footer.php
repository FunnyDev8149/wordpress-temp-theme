<?php
/**
 * Footer template
 *
 * @author     FunnyWP
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

?>
			</main>

			<?php do_action( 'alpha_after_main' ); ?>

			<?php

			global $alpha_layout;

			if ( ALPHA_NAME . '_template' == get_post_type() && 'footer' == get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true ) ) {
				/**
				 * View Footer Template
				 */
				?>
				<footer class="footer custom-footer footer-<?php the_ID(); ?>" id="footer">
				<?php
				if ( have_posts() ) :
					the_post();
					the_content();
					wp_reset_postdata();
				endif;
				?>
				</footer>
				<?php
			} elseif ( ! empty( $alpha_layout['footer'] ) && 'elementor_pro' == $alpha_layout['footer'] ) {

				/**
				 * Elementor Pro Footer
				 */
				do_action( 'alpha_elementor_pro_footer_location' );

			} elseif ( ! empty( $alpha_layout['footer'] ) && 'hide' == $alpha_layout['footer'] ) {

				// Hide

			} elseif ( ! empty( $alpha_layout['footer'] ) && 'publish' == get_post_status( intval( $alpha_layout['footer'] ) ) ) {

				/**
				 * Custom Block Footer
				 */
				?>
				<footer class="footer custom-footer footer-<?php echo intval( $alpha_layout['footer'] ); ?>" id="footer">
					<?php alpha_print_template( $alpha_layout['footer'] ); ?>
				</footer>
				<?php

			} else {
				/**
				 * Default Footer
				 */
				?>
				<footer class="footer footer-copyright" id="footer">
					<?php /* translators: date format */ ?>
					<?php printf( ALPHA_DISPLAY_NAME . esc_html__( ' eCommerce &copy; %s. All Rights Reserved', 'alpha' ), date( 'Y' ) ); ?>
				</footer>
				<?php
			}
			?>

		</div>

		<?php do_action( 'alpha_after_page_wrapper' ); ?>

		<?php alpha_print_mobile_bar(); ?>

		<a id="scroll-top" class="scroll-top" href="#top" title="<?php esc_attr_e( 'Top', 'alpha' ); ?>" role="button">
			<i class="<?php echo ALPHA_ICON_PREFIX; ?>-icon-angle-up"></i>
			<svg  version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
				<circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35" r="34"/>
			</svg>
		</a>

		<?php if ( ! empty( alpha_get_option( 'mobile_menu_items' ) ) ) { // if mobile menu has menu items... ?>
			<div class="mobile-menu-wrapper">
				<div class="mobile-menu-overlay"></div>
				<div class="mobile-menu-container" style="height: 100vh;">
					<!-- Need to ajax load mobile menus -->
				</div>
				<a class="mobile-menu-close" href="#"><i class="close-icon"></i></a>
			</div>
		<?php } ?>

		<?php
		// first popup
		if ( function_exists( 'alpha_is_elementor_preview' ) && ! alpha_is_elementor_preview() &&
			! empty( $alpha_layout['popup'] ) && 'hide' != $alpha_layout['popup'] ) {
			wp_enqueue_script( 'jquery-magnific-popup' );
			alpha_print_popup_template( $alpha_layout['popup'], $alpha_layout['popup_delay'] );
		}
		?>

		<?php wp_footer(); ?>
	</body>
</html>

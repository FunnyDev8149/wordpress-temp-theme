<?php
/**
 * Header content template
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */

defined( 'ABSPATH' ) || die;

global $alpha_layout;

if ( ALPHA_NAME . '_template' == get_post_type() && 'header' == get_post_meta( get_the_ID(), ALPHA_NAME . '_template_type', true ) ) {
	/**
	 * View Header Template
	 *
	 * @since 1.0
	 */
	echo '<header class="header custom-header header-' . get_the_ID() . '" id="header">';

	if ( have_posts() ) :
		the_post();
			the_content();
		wp_reset_postdata();
	endif;

	echo '</header>';

} elseif ( ! empty( $alpha_layout['header'] ) && 'elementor_pro' == $alpha_layout['header'] ) {

	/**
	 * Elementor Pro Header
	 *
	 * @since 1.0
	 */
	do_action( 'alpha_elementor_pro_header_location' );

} elseif ( ! empty( $alpha_layout['header'] ) && 'hide' == $alpha_layout['header'] ) {

	// Hide

} elseif ( ! empty( $alpha_layout['header'] ) && 'publish' == get_post_status( intval( $alpha_layout['header'] ) ) ) {

	/**
	 * Custom Block Header
	 *
	 * @since 1.0
	 */
	echo '<header class="header custom-header header-' . intval( $alpha_layout['header'] ) . '" id="header">';
	alpha_print_template( $alpha_layout['header'] );
	echo '</header>';

} else {
	/**
	 * Default Header
	 *
	 * @since 1.0
	 */
	?>
	<header class="header pt-5 pb-5 default-header" id="header">
		<div class="container d-flex align-items-center">
			<a href="<?php echo esc_url( home_url() ); ?>" class="<?php echo is_rtl() ? 'ml-4' : 'mr-4'; ?>">
				<?php if ( alpha_get_option( 'custom_logo' ) ) : ?>
					<img class="logo" src="<?php echo esc_url( str_replace( array( 'http:', 'https:' ), '', wp_get_attachment_url( alpha_get_option( 'custom_logo' ) ) ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<?php else : ?>
					<img class="logo" src="<?php echo ALPHA_ASSETS . '/images/logo.png'; ?>" width="144" height="45" alt="<?php esc_attr_e( 'Logo', 'alpha' ); ?>"/>
				<?php endif; ?>
			</a>
			<?php
			if ( has_nav_menu( 'main-menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'main-menu',
						'container'       => 'nav',
						'container_class' => 'main-menu',
						'items_wrap'      => '<ul id="%1$s" class="menu menu-main-menu">%3$s</ul>',
						'walker'          => new Alpha_Walker_Nav_Menu(),
					)
				);
			}
			?>
		</div>
	</header>
	<?php
}


<?php
/**
 * Activation template
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
$disable_field = '';
$errors        = get_option( 'alpha_register_error_msg' );
update_option( 'alpha_register_error_msg', '' );
$purchase_code = Alpha_Admin::get_instance()->get_purchase_code_asterisk();
$regist_flag   = false;

echo '<h4>' . esc_html__( 'Register Purchase Code', 'alpha' ) . '</h4>';
echo '<div class="alpha-notice-wrapper">';
if ( ! empty( $errors ) ) {
	 echo '<div class="notice-label notice-error"><i class="fas fa-exclamation-triangle"></i>' . esc_html__( 'Error', 'alpha' ) . '</div>';
}
if ( ! empty( $purchase_code ) ) {
	if ( ! empty( $errors ) ) {
		echo '<div class="notice-label notice-warning"><i class="fas fa-exclamation-circle"></i>' . esc_html__( 'Not updated', 'alpha' ) . '</div>';
	} else {
		echo '<div class="notice-label notice-success"><i class="fas fa-check"></i>' . esc_html__( 'Registered', 'alpha' ) . '</div>';
		$regist_flag = true;
	}
} elseif ( empty( $errors ) ) {
	echo '<div class="notice-label notice-normal"><i class="fas fa-lock"></i>' . esc_html__( 'Unregistered', 'alpha' ) . '</div>';
}
	echo '<a class="alpha-buy-action" href="' . esc_attr( apply_filters( 'alpha_buy_theme_link', '#' ) ) . '" rel="noopener noreferer">' . ( $regist_flag ? esc_html__( 'Buy Another', 'alpha' ) : esc_html__( 'Buy Now', 'alpha' ) ) . '</a></div>';
?>
	<form id="alpha_registration" method="post">
		<?php
		if ( $purchase_code && ! empty( $purchase_code ) && Alpha_Admin::get_instance()->is_registered() ) {
			$disable_field = ' disabled=true';
		}
		?>
		<input type="hidden" name="alpha_registration" />
		<?php if ( Alpha_Admin::get_instance()->is_envato_hosted() ) : ?>
			<p class="confirm unregister">
				<?php esc_html_e( 'You are using Envato Hosted, this subscription code can not be deregistered.', 'alpha' ); ?>
			</p>
		<?php else : ?>
			<input type="text" id="alpha_purchase_code" name="code" class="regular-text alpha-input" value="<?php echo esc_attr( $purchase_code ); ?>" placeholder="<?php esc_attr_e( 'Purchase Code', 'alpha' ); ?>" <?php echo alpha_escaped( $disable_field ); ?> />
			<?php if ( Alpha_Admin::get_instance()->is_registered() ) : ?>
				<input type="hidden" name="action" value="unregister" />
				<?php submit_button( esc_html__( 'Deactivate', 'alpha' ), array( 'primary', 'large', 'alpha-large-button' ), '', true ); ?>
			<?php else : ?>
				<input type="hidden" name="action" value="register" />
				<?php submit_button( esc_html__( 'Activate', 'alpha' ), array( 'primary', 'large', 'alpha-large-button' ), '', true ); ?>
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_nonce_field( 'alpha-setup-wizard' ); ?>
	</form>
<?php
if ( ! empty( $errors ) ) {
	echo '<div class="notice-error notice-block"><strong>' . alpha_escaped( $errors ) . '</strong>' . esc_html__( 'Please check purchase code again.', 'alpha' ) . '</div>';
}
if ( ! empty( $purchase_code ) ) {
	if ( ! empty( $errors ) ) {
		echo '<div class="notice-warning notice-block">' . esc_html__( 'Purchase code not updated. We will keep the existing one.', 'alpha' ) . '</div>';
	} else {
		/* translators: $1 and $2 opening and closing strong tags respectively */
		echo '<div class="notice-success notice-block">' . sprintf( esc_html__( '%1$sPurchase code is valid%2$s Welcome! Your product is registered now. Enjoy %3$s Theme and automatic updates.', 'alpha' ), '<strong>', '</strong>', ALPHA_DISPLAY_NAME ) . '</div>';
	}
} elseif ( empty( $errors ) ) {
	echo '<div class="notice-block">' . sprintf( esc_html__( 'Thank you for choosing %s theme from ThemeForest. Please register your purchase and make sure that you have fulfilled all of the requirements.', 'alpha' ), ALPHA_DISPLAY_NAME ) . '</div>';
}

<?php
/**
 * Header template in admin panel
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
$userinfo      = wp_get_current_user();
$errors        = get_option( 'alpha_register_error_msg' );
$purchase_code = Alpha_Admin::get_instance()->get_purchase_code_asterisk();
$is_activated  = false;
if ( ! empty( $purchase_code ) && empty( $errors ) ) {
	$is_activated = true;
}
?>
<div class="alpha-wrap">
	<div class="alpha-admin-header">
		<div class="alpha-header-left">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=alpha' ) ); ?>" class="alpha-admin-logo">
				<img src="<?php echo esc_url( ALPHA_URI . '/assets/images/logo-admin' . ( 'dark' == ALPHA_ADMIN_SKIN ? '' : '-dark' ) . '.png' ); ?>" data-image-src="<?php echo esc_attr( ALPHA_URI . '/assets/images/' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
			</a>
		</div>
		<div class="alpha-header-center">
			<p class="alpha-welcome-text">
				<?php echo sprintf( esc_html__( 'Welcome to %1$s! %1$s is now installed and ready to use!', 'alpha' ), ALPHA_DISPLAY_NAME ); ?>
			</p>
		</div>
		<div class="alpha-header-right">
			<div class="alpha-active-dropdown <?php echo esc_attr( $is_activated ? '' : 'show' ); ?>">
				<a href="#" class="alpha-toggle alpha-active-toggle"><i class="fas fa-key"></i></a>
				<div class="alpha-active-content">
					<?php require_once alpha_framework_path( ALPHA_FRAMEWORK_PATH . '/admin/panel/views/activation.php' ); ?>
				</div>
			</div>
			<div class="alpha-notifications-dropdown">
				<a href="#" class="alpha-toggle alpha-notification-toggle"><i class="fas fa-bell"></i><span>0</span></a>
				<div class="alpha-notification-wrapper">
					<h4>Notifications</h4>
					<div class="alpha-notifications">
						<!-- <div class="alpha-notification notification-warning">
							<label>Another purpose persuade</label>
							<span>Due in 2 Days</span>
						</div>
						<div class="alpha-notification notification-success">
							<label>Another purpose persuade</label>
							<span>Due in 2 Days</span>
						</div>
						<div class="alpha-notification notification-error">
							<label>Another purpose persuade</label>
							<span>Due in 2 Days</span>
						</div>
						<div class="alpha-notification notification-alert">
							<label>Another purpose persuade</label>
							<span>Due in 2 Days</span>
						</div> -->
					</div>
				</div>
			</div>
		</div>
		<span class="alpha-rp-bar"></span>
	</div>
	<div class="alpha-admin-panel">
		<div class="alpha-admin-preloader">
			<div class="alpha-loader">
				<div class="alpha-inner alpha-one"></div>
				<div class="alpha-inner alpha-two"></div>
				<div class="alpha-inner alpha-three"></div>
			</div>
		</div>
		<?php if ( empty( $title ) ) { ?>
			<h2 class="alpha-panel-title"><?php printf( esc_html( '%sGood Morning %s %s!', 'alpha' ), '<span class="greeting">', '</span>', $userinfo->display_name ); ?></h2>
			<p class="alpha-running-info"><?php printf( esc_html( 'You are runnning %s %s.', 'alpha' ), ALPHA_DISPLAY_NAME, ALPHA_VERSION ); ?></p>
		<?php } else { ?>
			<h2 class="alpha-panel-title"><?php echo esc_html( $title['title'] ); ?></h2>
			<p class="alpha-running-info"><?php echo esc_html( $title['desc'] ); ?></p>
		<?php } ?>
		<?php if ( ! empty( $admin_config['admin_navs'] ) ) : ?>
		<nav class="alpha-admin-nav">
			<?php
			foreach ( $admin_config['admin_navs'] as $key => $item ) {
				$url   = isset( $item['url'] ) ? $item['url'] : '#';
				$label = isset( $item['label'] ) ? $item['label'] : '';
				$icon  = isset( $item['icon'] ) ? $item['icon'] : 'fas fa-th-large';
				if ( empty( $item['submenu'] ) ) {
					?>
					<a class="alpha-admin-nav-panel <?php echo esc_attr( $key ); ?>" href="<?php echo esc_url( $url ); ?>">
						<i class="<?php echo esc_attr( $icon ); ?>"></i>
						<label><?php echo esc_html( $label ); ?></label>
					</a>
					<?php
				} elseif ( 1 == count( $item['submenu'] ) ) {
					foreach ( $item['submenu'] as $subkey => $subitem ) {
						$url   = isset( $subitem['url'] ) ? $subitem['url'] : '#';
						$label = isset( $subitem['label'] ) ? $subitem['label'] : '';
						?>
						<a class="alpha-admin-nav-panel <?php echo esc_attr( $subkey ); ?>" href="<?php echo esc_url( $url ); ?>">
							<i class="<?php echo esc_attr( $icon ); ?>"></i>
							<label><?php echo esc_html( $label ); ?></label>
						</a>
						<?php
					}
				} else {
					?>
					<div class="alpha-admin-nav-panel has-menu <?php echo esc_attr( $key ); ?>" href="<?php echo esc_url( $url ); ?>">
						<i class="<?php echo esc_attr( $icon ); ?>"></i>
						<label><?php echo esc_html( $label ); ?></label>
						<div class="alpha-admin-subnavs">
						<?php
						foreach ( $item['submenu'] as $subkey => $subitem ) {
							$url   = isset( $subitem['url'] ) ? $subitem['url'] : '#';
							$label = isset( $subitem['label'] ) ? $subitem['label'] : '';
							$icon  = isset( $subitem['icon'] ) ? $subitem['icon'] : 'fas fa-th-large';
							?>
							<a class="alpha-admin-subnav <?php echo esc_attr( $subkey ); ?>" href="<?php echo esc_url( $url ); ?>">
								<i class="<?php echo esc_attr( $icon ); ?>"></i>
								<label><?php echo esc_html( $label ); ?></label>
							</a>	
							<?php
						}
						?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</nav>
		<?php endif; ?>

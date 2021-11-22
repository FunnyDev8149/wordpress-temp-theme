<?php
/**
 * Demo panel
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 */
defined( 'ABSPATH' ) || die;
?>
<div class="alpha-admin-panel-row">
	<div class="alpha-setup-demo-header">
		<h2><?php esc_html_e( 'Demo Content Installation', 'alpha' ); ?></h2>
		<p><?php esc_html_e( 'In this step you can upload your logo and select a demo from the list.', 'alpha' ); ?></p>
	</div>
	<table class="logo-select">
		<tr>
			<td>
				<label><?php esc_html_e( 'Your Logo:', 'alpha' ); ?></label>
			</td>
			<td>
				<button id="current-logo" class="button button-upload">
				<?php
				$image_id  = alpha_get_option( 'custom_logo' );
				$image_url = '';
				if ( ! empty( $image_id ) ) {
					$image_url = wp_get_attachment_image_url( $image_id, 'full' );
				}

				printf(
					'<img class="site-logo" src="%s" alt="%s" style="max-width:136px; height:auto" />',
					esc_url( $image_url ? $image_url : ALPHA_URI . '/assets/images/logo.png' ),
					get_bloginfo( 'name' )
				);
				?>
				</button>
			</td>
		</tr>
	</table>
</div>
<p style="margin-bottom: 30px;"><a href="#" class="button button-large button-light btn-remove-demo-contents"><?php esc_html_e( 'Uninstall Demo', 'alpha' ); ?><i class="far fa-trash-alt" style="margin-<?php echo is_rtl() ? 'right' : 'left'; ?>: .5rem"></i></a></p>
<div class="alpha-remove-demo mfp-hide">
	<div class="alpha-install-demo-header">
		<h2><span class="alpha-mini-logo"></span><?php esc_html_e( 'Demo Contents Remove', 'alpha' ); ?></h2>
	</div>
	<div class="alpha-install-section alpha-wrap" style="margin: 30px 20px; border: none;">
		<div style="flex: 0 0 40%; max-width: 40%; box-sizing: border-box;">
			<label><input type="checkbox" value="" checked="checked"/> <?php esc_html_e( 'All', 'alpha' ); ?></label>
			<label><input type="checkbox" value="page" checked="checked"/> <?php esc_html_e( 'Pages', 'alpha' ); ?></label>
			<label><input type="checkbox" value="post" checked="checked"/> <?php esc_html_e( 'Posts', 'alpha' ); ?></label>
			<label><input type="checkbox" value="attachment" checked="checked"/> <?php esc_html_e( 'Attachments', 'alpha' ); ?></label>
			<label><input type="checkbox" value="product" checked="checked"/> <?php esc_html_e( 'Products', 'alpha' ); ?></label>
			<label><input type="checkbox" value="<?php echo ALPHA_NAME; ?>_template" checked="checked"/> <?php esc_html_e( 'Builders', 'alpha' ); ?></label>
			<label><input type="checkbox" value="widgets" checked="checked"/> <?php esc_html_e( 'Widgets', 'alpha' ); ?></label>
			<label><input type="checkbox" value="options" checked="checked"/> <?php esc_html_e( 'Theme Options', 'alpha' ); ?></label>
		</div>
		<div style="flex: 0 0 60%; max-width: 60%;  box-sizing: border-box;">
			<div class="notice-warning notice-alt" style="padding: 1rem; margin-bottom: 1.5rem; border-radius: 3px;"><?php printf( esc_html__( 'Please backup your site before uninstalling. All imported and overridden contents from %s demos would be removed.', 'alpha' ), ALPHA_DISPLAY_NAME ); ?></div>
			<div class="remove-status" style="width: 100%"></div>
			<button class="button button-primary button-large" <?php disabled( empty( get_option( 'alpha_demo_history', array() ) ) ); ?> style="width: 100%"><i class="far fa-trash-alt" style="margin-right: .5rem"></i><?php esc_html_e( 'Uninstall', 'alpha' ); ?></button>
		</div>
	</div>
</div>

<h3 style="margin-bottom: 0;"><?php esc_html_e( 'Select Demo', 'alpha' ); ?></h3>
<form method="post" class="alpha-install-demos">
	<input type="hidden" id="current_site_link" value="<?php echo esc_url( home_url() ); ?>">
	<?php
	$demos               = $this->alpha_demo_types();
	$memory_limit        = wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) );
	$alpha_plugins_obj   = new Alpha_TGM_Plugins();
	$required_plugins    = $alpha_plugins_obj->get_plugins_list();
	$uninstalled_plugins = array();
	$all_plugins         = array();
	foreach ( $required_plugins as $plugin ) {
		if ( is_plugin_inactive( $plugin['url'] ) ) {
			$uninstalled_plugins[ $plugin['slug'] ] = $plugin;
		}
		$all_plugins[ $plugin['slug'] ] = $plugin;
	}
	$time_limit    = ini_get( 'max_execution_time' );
	$server_status = $memory_limit >= 268435456 && ( $time_limit >= 600 || 0 == $time_limit );
	?>

	<div class="alpha-install-demo mfp-hide">
		<div class="alpha-install-demo-header">
			<h2><span class="alpha-mini-logo"></span><?php esc_html_e( 'Demo Import', 'alpha' ); ?></h2>
		</div>
		<div class="alpha-install-demo-row">
			<div class="theme">
				<div class="theme-wrapper">
					<a class="theme-link" href="#" target="_blank">
						<img class="theme-screenshot" src="#">
					</a>
				</div>
			</div>
			<div class="theme-import-panel">
				<div id="import-status">
					<div class="alpha-installing-options">
						<div class="alpha-import-options"><span class="alpha-loading"></span><?php esc_html_e( 'Import theme options', 'alpha' ); ?></div>
						<div class="alpha-reset-menus"><span class="alpha-loading"></span><?php esc_html_e( 'Reset menus', 'alpha' ); ?></div>
						<div class="alpha-reset-widgets"><span class="alpha-loading"></span><?php esc_html_e( 'Reset widgets', 'alpha' ); ?></div>
						<div class="alpha-import-dummy"><span class="alpha-loading"></span><?php esc_html_e( 'Import dummy content', 'alpha' ); ?> <span></span></div>
						<div class="alpha-import-widgets"><span class="alpha-loading"></span><?php esc_html_e( 'Import widgets', 'alpha' ); ?></div>
						<div class="alpha-import-subpages"><span class="alpha-loading"></span><?php esc_html_e( 'Import subpages', 'alpha' ); ?></div>
					</div>
					<p class="import-result"></p>
				</div>
				<div id="alpha-install-options" class="alpha-install-options">
					<?php if ( Alpha_Admin::get_instance()->is_registered() ) : ?>
						<div class="alpha-install-editors">
							<?php if ( alpha_get_feature( 'fs_pb_elementor' ) ) : ?>
								<label for="alpha-elementor-demo" class="d-none">
									<input type="radio" id="alpha-elementor-demo" name="alpha-import-editor" value="elementor" checked="checked">
									<img src="<?php echo esc_url( ALPHA_URI . '/assets/images/admin/builder_elementor.png' ); ?>" alt="<?php esc_attr_e( 'Elementor', 'alpha' ); ?>" title="<?php esc_attr_e( 'Elementor', 'alpha' ); ?>">
								</label>
							<?php endif; ?>
							<?php if ( alpha_get_feature( 'fs_pb_wpb' ) ) : ?>
								<label for="alpha-js_composer-demo" class="d-none">
									<input type="radio" id="alpha-js_composer-demo" name="alpha-import-editor" value="js_composer">
									<img src="<?php echo esc_url( ALPHA_URI . '/assets/images/admin/builder_wpbakery.png' ); ?>" alt="<?php esc_attr_e( 'WPBakery Page Builder', 'alpha' ); ?>" title="<?php esc_attr_e( 'WPBakery Page Builder', 'alpha' ); ?>">
								</label>
							<?php endif; ?>
						</div>
						<div class="alpha-install-section">
							<div class="alpha-install-options-section">
								<h3><?php esc_html_e( 'Select Content to Import', 'alpha' ); ?></h3>
								<label for="alpha-import-options"><input type="checkbox" id="alpha-import-options" value="1" checked="checked"/> <?php esc_html_e( 'Import theme options', 'alpha' ); ?></label>
								<input type="hidden" id="alpha-install-demo-type" value="landing"/>
								<label for="alpha-reset-menus"><input type="checkbox" id="alpha-reset-menus" value="1" checked="checked"/> <?php esc_html_e( 'Reset menus', 'alpha' ); ?></label>
								<label for="alpha-reset-widgets"><input type="checkbox" id="alpha-reset-widgets" value="1" checked="checked"/> <?php esc_html_e( 'Reset widgets', 'alpha' ); ?></label>
								<label for="alpha-import-dummy"><input type="checkbox" id="alpha-import-dummy" value="1" checked="checked"/> <?php esc_html_e( 'Import dummy content', 'alpha' ); ?></label>
								<label for="alpha-import-widgets"><input type="checkbox" id="alpha-import-widgets" value="1" checked="checked"/> <?php esc_html_e( 'Import widgets', 'alpha' ); ?></label>
								<label for="alpha-override-contents"><input type="checkbox" id="alpha-override-contents" value="1" checked="checked" /> <?php esc_html_e( 'Override existing contents', 'alpha' ); ?></label>
							<label for="alpha-import-subpages"><input type="checkbox" id="alpha-import-subpages" value="1" checked="checked" /> <?php esc_html_e( 'Import subpages', 'alpha' ); ?></label>
							</div>
							<div>
								<p style="margin-top: 0;"><?php esc_html_e( 'Do you want to install demo? It can also take a minute to complete.', 'alpha' ); ?></p>
								<button class="btn <?php echo ! $server_status ? 'btn-quaternary' : 'btn-primary'; ?> alpha-import-yes"<?php echo ! $server_status ? ' disabled="disabled"' : ''; ?>><?php esc_html_e( 'Standard Import', 'alpha' ); ?></button>
								<?php if ( ! $server_status ) : ?>
									<p><?php printf( esc_html__( 'Your server performance does not satisfy %s demo importer engine\'s requirement. We recommend you to use alternative method to perform demo import without any issues but it may take much time than standard import.', 'alpha' ), ALPHA_DISPLAY_NAME ); ?></p>
								<?php else : ?>
									<p><?php esc_html_e( 'If you have any issues with standard import, please use Alternative mode. But it may take much time than standard import.', 'alpha' ); ?></p>
								<?php endif; ?>
								<button class="btn btn-secondary alpha-import-yes alternative"><?php esc_html_e( 'Alternative Mode', 'alpha' ); ?></button>
							</div>
						</div>
					<?php else : ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=alpha' ) ); ?>" class="btn btn-dark btn-activate" style="display: inline-block; box-sizing: border-box; text-decoration: none; text-align: center; margin-bottom: 20px;"><?php esc_html_e( 'Activate Theme', 'alpha' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="theme-install-demos">
		<?php foreach ( $demos as $demo => $demo_details ) : ?>
			<?php
			$uninstalled_demo_plugins = $uninstalled_plugins;
			if ( ! empty( $demo_details['plugins'] ) ) {
				foreach ( $demo_details['plugins'] as $plugin ) {
					if ( is_plugin_inactive( $all_plugins[ $plugin ]['url'] ) ) {
						$uninstalled_demo_plugins[ $plugin ] = $all_plugins[ $plugin ];
					}
				}
			}

			if ( 'landing' == $demo ) {
			} else {
				$demo_url = $this->alpha_url . $demo;
			}
			?>
			<div class="theme <?php echo esc_attr( $demo_details['filter'] ); ?>">
				<div class="theme-wrapper">
					<img class="theme-screenshot" src="<?php echo esc_url( $demo_details['img'] ); ?>" />
					<h3 class="theme-name" id="<?php echo esc_attr( $demo ); ?>" data-live-url="<?php echo esc_url( $demo_url ); ?>"><?php echo alpha_escaped( $demo_details['alt'] ); ?></h3>
					<a class="demo-button demo-preview fas fa-search" href="<?php echo esc_url( $demo_url ); ?>" target="_blank" title="<?php esc_attr_e( 'Preview', 'alpha' ); ?>"><?php esc_html_e( 'Preview', 'alpha' ); ?></a>
					<a class="demo-button demo-import fas fa-download" href="#" title="<?php esc_attr_e( 'Import', 'alpha' ); ?>"><?php esc_html_e( 'Import', 'alpha' ); ?></a>
					<ul class="plugins-used" data-editor="<?php echo esc_attr( json_encode( $demo_details['editors'] ) ); ?>">
					<?php if ( ! empty( $uninstalled_demo_plugins ) ) : ?>
							<?php foreach ( $uninstalled_demo_plugins as $plugin ) : ?>
								<?php if ( $plugin['required'] || isset( $alpha_plugins_obj->demo_plugin_dependencies[ $demo ][ $plugin['slug'] ] ) ) : ?>
								<li data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>">
									<div class="thumb">
										<img src="<?php echo esc_url( $plugin['image_url'] ); ?>" />
									</div>
									<div>
										<h5><?php echo esc_html( $plugin['name'] ); ?></h5>
										<a href="#" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-callback="install_plugin" class="demo-plugin"><?php esc_html_e( 'Install', 'alpha' ); ?></a>
									</div>
								</li>
							<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php if ( ! empty( $demo_details['editors'] ) ) : ?>
						<?php foreach ( $demo_details['editors'] as $editor ) : ?>
							<?php if ( is_plugin_inactive( $all_plugins[ $editor ]['url'] ) ) : ?>
								<li data-plugin="<?php echo esc_attr( $all_plugins[ $editor ]['slug'] ); ?>" class="plugin-editor">
									<div class="thumb">
										<img src="<?php echo esc_url( $all_plugins[ $editor ]['image_url'] ); ?>" />
									</div>
									<div>
										<h5><?php echo esc_html( $all_plugins[ $editor ]['name'] ); ?></h5>
									<a href="#" data-slug="<?php echo esc_attr( $all_plugins[ $editor ]['slug'] ); ?>" data-callback="install_plugin" class="demo-plugin"><?php esc_html_e( 'Install', 'alpha' ); ?></a>
									</div>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
						</ul>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="info-qt light-info icon-fixed"><?php esc_html_e( 'Installing a demo provides pages, posts, menus, images, theme options, widgets and more.', 'alpha' ); ?>
	<br /><strong><?php esc_html_e( 'IMPORTANT: ', 'alpha' ); ?> </strong><span><?php esc_html_e( 'The included plugins need to be installed and activated before you install a demo.', 'alpha' ); ?></span>
	<?php /* translators: $1: opening A tag which has link to the plugins step $2: closing A tag */ ?>
	<br /><?php printf( esc_html__( 'Please check the %1$sStatus%2$s step to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.', 'alpha' ), '<a href="' . esc_url( $this->get_step_link( 'status' ) ) . '">', '</a>' ); ?></p>

	<input type="hidden" name="new_logo_id" id="new_logo_id" value="">

	<p class="alpha-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-light button-next button-icon-hide"><?php esc_html_e( 'Skip this step', 'alpha' ); ?></a>
		<button type="submit" class="button-dark button button-large button-next" name="save_step"><?php esc_html_e( 'Continue', 'alpha' ); ?></button>
		<?php wp_nonce_field( 'alpha-setup-wizard' ); ?>
	</p>
</form>

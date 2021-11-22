<?php
/**
 * The License Template
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
global $wp_filesystem;
// Initialize the WordPress filesystem, no more using file_put_contents function
if ( empty( $wp_filesystem ) ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
}

$data = array(
	'wp_uploads'     => wp_get_upload_dir(),
	'memory_limit'   => wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ),
	'time_limit'     => ini_get( 'max_execution_time' ),
	'max_input_vars' => ini_get( 'max_input_vars' ),
);

$status = array(
	'uploads'        => wp_is_writable( $data['wp_uploads']['basedir'] ),
	'fs'             => ( $wp_filesystem || WP_Filesystem() ) ? true : false,
	'zip'            => class_exists( 'ZipArchive' ),
	'suhosin'        => extension_loaded( 'suhosin' ),
	'memory_limit'   => $data['memory_limit'] >= 268435456,
	'time_limit'     => ( ( $data['time_limit'] >= 600 ) || ( 0 == $data['time_limit'] ) ) ? true : false,
	'max_input_vars' => $data['max_input_vars'] >= 2000,
);

require_once alpha_framework_path( ALPHA_FRAMEWORK_ADMIN . '/importer/importer-api.php' );
$importer_api  = new Alpha_Importer_API();
$theme_version = $importer_api->get_latest_theme_version();
$core_version  = $importer_api->get_latest_core_version();

?>
<div class="alpha-demos-section">
	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link active" href="#best-selling"><?php echo esc_html__( 'Best Selling', 'alpha' ); ?></a></li>
		<li class="nav-item"><a class="nav-link" href="#top-rated"><?php echo esc_html__( 'Top Rated', 'alpha' ); ?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="best-selling">
			<div class="swiper-container">
				<div class="alpha-demos swiper-wrapper">
					<?php
					foreach ( $admin_config['demos']['best_selling'] as $key => $item ) {
						?>
						<a href="<?php echo esc_url( $item['url'] ); ?>" class="alpha-demo">
							<img src="<?php echo esc_url( $item['image'] ); ?>" width="304" height="181" alt="<?php echo esc_attr( $item['label'] ); ?>" />
							<label><?php echo esc_html( $item['label'] ); ?></label>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="top-rated">
			<div class="swiper-container">
				<div class="alpha-demos swiper-wrapper">
					<?php
					foreach ( $admin_config['demos']['top_rated'] as $key => $item ) {
						?>
						<a href="<?php echo esc_url( $item['url'] ); ?>" class="alpha-demo">
							<img src="<?php echo esc_url( $item['image'] ); ?>" width="304" height="181" alt="<?php echo esc_attr( $item['label'] ); ?>" />
							<label><?php echo esc_html( $item['label'] ); ?></label>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="alpha-info-section">
	<div class="alpha-section-left alpha-whatsnew">
		<h2 class="alpha-section-title"><?php echo esc_html__( 'What\'s New?', 'alpha' ); ?></h2>
		<?php
			$history_type = 'whatsnew';
			require ALPHA_PATH . '/inc/history.php';
		?>
	</div>
	<div class="alpha-section-right alpha-info">
		<h2 class="alpha-section-title"><?php echo esc_html__( 'Theme Updates', 'alpha' ); ?></h2>
		<ul class="alpha-versions">
			<li><i class="fas fa-flag"></i><label><?php echo esc_html__( 'Theme Version', 'alpha' ); ?><span><?php echo esc_html( $theme_version ); ?></span></label></li>
			<li><i class="fas fa-cloud-download-alt"></i><label><?php echo esc_html__( 'Core Version', 'alpha' ); ?><span><?php echo esc_html( $core_version ); ?></span></label></li>
		</ul>
		<div class="alpha-status-wrapper">
			<h2 class="alpha-section-title"><?php echo esc_html__( 'System Requirements', 'alpha' ); ?></h2>
			<ul class="alpha-system-status">
				<li>
					<?php if ( $status['uploads'] ) : ?>
						<i class="fa fa-check"></i>
					<?php else : ?>
						<i class="fa fa-times"></i>
					<?php endif; ?>

					<span class="label"><?php esc_html_e( 'Uploads folder writable', 'alpha' ); ?></span>

					<?php if ( ! $status['uploads'] ) : ?>
					<p class="status-notice status-error"><?php esc_html_e( 'Uploads folder must be writable. Please set write permission to your wp-content/uploads folder.', 'alpha' ); ?></p>
					<?php endif; ?>
				</li>

				<li>
					<?php if ( $status['fs'] ) : ?>
						<i class="fa fa-check"></i>
					<?php else : ?>
						<i class="fa fa-times"></i>
					<?php endif; ?>

					<span class="label"><?php esc_html_e( 'WP File System', 'alpha' ); ?></span>

					<?php if ( ! $status['fs'] ) : ?>
						<p class="status-notice status-error"><?php esc_html_e( 'File System access is required for pre-built websites and plugins installation. Please contact your hosting provider.', 'alpha' ); ?></p>
					<?php endif; ?>

				</li>

				<li>
					<?php if ( $status['zip'] ) : ?>
						<i class="fa fa-check"></i>
					<?php else : ?>
						<i class="fa fa-times"></i>
					<?php endif; ?>

					<span class="label"><?php esc_html_e( 'ZipArchive', 'alpha' ); ?></span>

					<?php if ( ! $status['zip'] ) : ?>
						<p class="status-notice status-error"><?php esc_html_e( 'ZipArchive is required for pre-built websites and plugins installation. Please contact your hosting provider.', 'alpha' ); ?></p>
					<?php endif; ?>
				</li>

				<?php if ( $status['suhosin'] ) : ?>

					<li>
						<span class="status step-id status-info"></span>
						<span class="label"><?php esc_html_e( 'SUHOSIN Installed', 'alpha' ); ?></span>
						<p class="status-notice"><?php esc_html_e( 'Suhosin may need to be configured to increase its data submission limits.', 'alpha' ); ?></p>
					</li>

				<?php else : ?>

					<li>
						<?php if ( $status['memory_limit'] ) : ?>
							<i class="fa fa-check"></i>
						<?php else : ?>
							<?php if ( $data['memory_limit'] < 134217728 ) : ?>
								<i class="fa fa-times"></i>
							<?php else : ?>
								<span class="status step-id status-info"></span>
							<?php endif; ?>
						<?php endif; ?>

						<span class="label"><?php esc_html_e( 'PHP Memory Limit', 'alpha' ); ?></span>

						<?php if ( $status['memory_limit'] ) : ?>
							<span class="desc">(<?php echo size_format( $data['memory_limit'] ); ?>)</span>
						<?php else : ?>
							<?php if ( $data['memory_limit'] < 134217728 ) : ?>
								<span class="desc">(<?php echo size_format( $data['memory_limit'] ); ?>)</span>
								<?php /* translators: opening and closing strong tag */ ?>
								<p class="status-notice status-error"><?php printf( esc_html__( 'Minimum %1$s128 MB%2$s is required, %1$s256 MB%2$s is recommended.', 'alpha' ), '<strong>', '</strong>' ); ?></p>
							<?php else : ?>
								<span class="desc">(<?php echo size_format( $data['memory_limit'] ); ?>)</span>
								<?php /* translators: opening and closing strong tag */ ?>
								<p class="status-notice status-error"><?php printf( esc_html__( 'Current memory limit is OK, however %1$s256 MB%2$s is recommended.', 'alpha' ), '<strong>', '</strong>' ); ?></p>
							<?php endif; ?>
						<?php endif; ?>

					</li>

					<li>
						<?php if ( $status['time_limit'] ) : ?>
							<i class="fa fa-check"></i>
						<?php else : ?>
							<?php if ( $data['time_limit'] < 300 ) : ?>
								<i class="fa fa-times"></i>
							<?php else : ?>
								<i class="fa fa-info"></i>
							<?php endif; ?>
						<?php endif; ?>

						<span class="label"><?php esc_html_e( 'PHP max_execution_time', 'alpha' ); ?></span>

						<?php if ( $status['time_limit'] ) : ?>
							<span class="desc">(<?php echo esc_html( $data['time_limit'] ); ?>)</span>
						<?php else : ?>
							<?php if ( $data['time_limit'] < 300 ) : ?>
								<span class="desc">(<?php echo esc_html( $data['time_limit'] ); ?>)</span>
								<?php /* translators: opening and closing strong tag */ ?>
								<p class="status-notice status-error"><?php printf( esc_html__( 'Minimum %1$s300%2$s is required, %1$s600%2$s is recommended.', 'alpha' ), '<strong>', '</strong>' ); ?></p>
							<?php else : ?>
								<span class="desc">(<?php echo esc_html( $data['time_limit'] ); ?>)</span>
								<?php /* translators: opening and closing strong tag */ ?>
								<p class="status-notice status-error"><?php printf( esc_html__( 'Current time limit is OK, however %1$s600%2$s is recommended.', 'alpha' ), '<strong>', '</strong>' ); ?></p>
							<?php endif; ?>
						<?php endif; ?>

					</li>

					<li>
						<?php if ( $status['max_input_vars'] ) : ?>
							<i class="fa fa-check"></i>
						<?php else : ?>
							<i class="fa fa-times"></i>
						<?php endif; ?>

						<span class="label"><?php esc_html_e( 'PHP max_input_vars', 'alpha' ); ?></span>

						<?php if ( $status['max_input_vars'] ) : ?>
							<span class="desc">(<?php echo esc_html( $data['max_input_vars'] ); ?>)</span>
						<?php else : ?>
							<span class="desc">(<?php echo esc_html( $data['max_input_vars'] ); ?>)</span>
							<p class="status-notice status-error"><?php esc_html_e( 'Minimum 2000 is required', 'alpha' ); ?></p>
						<?php endif; ?>
					</li>

				<?php endif; ?>

			</ul>
		</div>
	</div>
</div>
<div class="alpha-changelog-section">
	<h2 class="alpha-section-title"><?php echo esc_html__( 'Change log', 'alpha' ); ?></h2>
	<div class="alpha-changelog-wrapper">
		<div class="alpha-changelog-versions">
			<?php
				$history_type = 'changelog_menu';
				require ALPHA_PATH . '/inc/history.php';
			?>
		</div>
		<div class="alpha-changelogs scrollable">
			<?php
				$history_type = 'changelog';
				require ALPHA_PATH . '/inc/history.php';
			?>
		</div>
	</div>
</div>
<!-- <div class="alpha-info-section">
	<div class="alpha-section-left alpha-social-links">
		<h2 class="alpha-section-title"><?php echo esc_html__( 'Social Links', 'alpha' ); ?></h2>
		<?php
		if ( ! empty( $admin_config['social_links'] ) ) {
			foreach ( $admin_config['social_links'] as $key => $item ) {
				?>
				<a href="<?php echo esc_attr( $item['url'] ); ?>" class="alpha-social-link" target="_blank" rel="nofollow noreferer noopener">
					<i class="<?php echo esc_attr( $item['icon'] ); ?>" style="background-color: <?php echo esc_attr( $item['color'] ); ?>"></i><label><?php echo esc_html( $item['label'] ); ?><span><?php echo esc_html( $item['link'] ); ?></span></label>
				</a>
				<?php
			}
		}
		?>
	</div>
	<div class="alpha-section-right alpha-changelogs-wrapper">
		<h2 class="alpha-section-title"><?php echo esc_html__( 'Change Log', 'alpha' ); ?></h2>
		<div class="alpha-changelogs scrollable">
			<?php
				$history_type = 'changelog';
				require ALPHA_PATH . '/inc/history.php';
			?>
		</div>
	</div>
</div> -->
<div class="alpha-others-section">
	<h2 class="alpha-section-title"><?php echo esc_html__( 'Made in us', 'alpha' ); ?></h2>
	<div class="swiper-container">
		<div class="alpha-products swiper-wrapper">
			<?php
			foreach ( $admin_config['other_products'] as $key => $item ) {
				if ( '#' != $item['url'] ) {
					?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" class="alpha-product">
						<img src="<?php echo esc_url( $item['image'] ); ?>" width="385" height="250" alt="<?php echo esc_attr( $item['name'] ); ?>" />
						<label><?php echo esc_html( $item['name'] ); ?></label>
					</a>
					<?php
				} else {
					?>
					<div class="alpha-product coming-soon">
						<img src="<?php echo esc_url( 'dark' == ALPHA_ADMIN_SKIN ? $item['image_dark'] : $item['image'] ); ?>" data-image-src="<?php echo esc_attr( $item['image'] ); ?>" data-dark-image-src="<?php echo esc_attr( $item['image_dark'] ); ?>" width="385" height="250" alt="<?php echo esc_attr( $item['name'] ); ?>" />
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

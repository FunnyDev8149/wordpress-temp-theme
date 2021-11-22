<?php
/**
 * Index panel
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

$step_number  = 1;
$output_steps = $this->steps;
$images_url   = apply_filters(
	'alpha_setup_step_svg',
	array(
		'status'          => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_status.svg',
		'customize'       => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_child.svg',
		'default_plugins' => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_plugins.svg',
		'addons'          => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_plugins.svg',
		'demo_content'    => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_import.svg',
		'ready'           => ALPHA_ASSETS . '/images/admin/setup-wizard/wizard_ready.svg',
	)
);
?>
<div class="alpha-admin-panel-view">
	<div class="alpha-admin-panel-row">	
		<div class="alpha-admin-panel-side">
			<nav class="alpha-card-box">
				<ul class="alpha-admin-panel-steps">
					<?php foreach ( $output_steps as $step_key => $step ) : ?>
						<?php
						$show_link        = true;
						$li_class_escaped = '';
						if ( $step_key === $this->step ) {
							$li_class_escaped = 'active';
						} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
							$li_class_escaped = 'done';
						}
						if ( $step_key === $this->step ) {
							$show_link = false;
						}
						?>
						<li class="<?php echo esc_attr( $li_class_escaped ); ?>">
							<?php
							if ( $show_link ) {
								echo '<a href="' . esc_url( $this->get_step_link( $step_key ) ) . '">' . '<img src="' . esc_url( $images_url[ $step_key ] ) . '">' . esc_html( $step['name'] ) . '</a>';
							} else {
								echo '<img src="' . esc_url( $images_url[ $step_key ] ) . '">' . esc_html( $step['name'] );
							}
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
		<div class="alpha-admin-panel-content">
			<div class="alpha-admin-panel-body alpha-card-box alpha-setup-<?php echo esc_attr( str_replace( '_', '-', $this->step ) ); ?>">
				<?php $this->view_step(); ?>
			</div>
		</div>
	</div>
</div>

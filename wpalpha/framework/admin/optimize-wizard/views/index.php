<?php
/**
 * Optimize template
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 *
 */
defined( 'ABSPATH' ) || die;

$step_number  = 1;
$output_steps = $this->steps;
$images_url   = apply_filters(
	'alpha_optimize_step_svg',
	array(
		'resources'   => ALPHA_ASSETS . '/images/admin/optimize-wizard/wizard_resources.svg',
		'lazyload'    => ALPHA_ASSETS . '/images/admin/optimize-wizard/wizard_lazyload.svg',
		'performance' => ALPHA_ASSETS . '/images/admin/optimize-wizard/wizard_performance.svg',
		'plugins'     => ALPHA_ASSETS . '/images/admin/optimize-wizard/wizard_plugins.svg',
		'ready'       => ALPHA_ASSETS . '/images/admin/optimize-wizard/wizard_ready.svg',
	)
);
?>
<div class="alpha-admin-panel-view">
	<div class="alpha-admin-panel-row alpha-optimize-panel">
		<div class="alpha-admin-panel-side">
			<div class="alpha-card-box">
				<ul class="alpha-admin-panel-steps">
					<?php
					$index = 1;
					foreach ( $output_steps as $step_key => $step ) :
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
						<li class="step <?php echo esc_attr( $li_class_escaped ); ?>">
							<?php
							if ( $show_link ) {
								echo '<a href="' . esc_url( $this->get_step_link( $step_key ) ) . '">' . '<img src="' . esc_url( $images_url[ $step_key ] ) . '">' . esc_html( $step['name'] ) . '</a>';
							} else {
								echo '<img src="' . esc_url( $images_url[ $step_key ] ) . '">' . esc_html( $step['name'] );
							}
							?>
						</li>
						<?php
						$index ++;
						endforeach;
					?>
				</ul>
			</div>
		</div>
		<div class="alpha-admin-panel-content">
			<div class="alpha-admin-panel-body alpha-card-box alpha-optimize-<?php echo esc_attr( str_replace( '_', '-', $this->step ) ); ?>">
				<?php $this->view_step(); ?>
			</div>
		</div>
	</div>
</div>

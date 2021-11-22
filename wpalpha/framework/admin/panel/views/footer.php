<?php
/**
 * Footer template in admin panel.
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;
?>
	</div>
</div>
<div class="alpha-admin-notices wrap">
	<?php do_action( 'alpha_admin_notices' ); ?>
</div>
<div class="alpha-admin-sticky-buttons">
	<ul>
		<li><a href="#" class="skin-toggle"><i class="fas fa-paint-brush"></i><span><?php echo esc_html__( 'Dark / Light Skin', 'alpha' ); ?></span></a></li>
		<?php
		foreach ( $admin_config['sticky_links'] as $item ) {
			$url   = empty( $item['url'] ) ? '#' : $item['url'];
			$label = empty( $item['label'] ) ? esc_html__( 'Link', 'alpha' ) : $item['label'];
			$icon  = empty( $item['icon'] ) ? 'fas fa-apps' : $item['icon'];
			?>
				<li><a href="<?php echo esc_url( $url ); ?>" target="_blank"><i class="<?php echo esc_attr( $icon ); ?>"></i><span><?php echo esc_html( $label ); ?></span></a></li>
			<?php
		}
		?>
	</ul>
</div>

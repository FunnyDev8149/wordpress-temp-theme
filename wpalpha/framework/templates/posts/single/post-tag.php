<?php
/**
 * Post Tag
 *
 * @author     FunnyWP
 * @package    WP Alpha Framework
 * @subpackage Theme
 * @since      1.0
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

$tags = get_the_tag_list();

if ( $tags ) :
	?>
	<div class="post-tags">
		<label><?php esc_html_e( 'Tags:', 'alpha' ); ?></label>
		<?php echo alpha_strip_script_tags( $tags ); ?>
	</div>
	<?php
endif;

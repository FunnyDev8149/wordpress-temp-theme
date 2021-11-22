<?php

// direct load is not allowed
defined( 'ABSPATH' ) || die;

class Alpha_Filter_Clean_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-filter-clean',
			'description' => esc_html__( 'Display filter clean button in shop sidebar.', 'alpha-core' ),
		);

		$control_ops = array( 'id_base' => 'filter-clean-widget' );

		parent::__construct( 'filter-clean-widget', ALPHA_DISPLAY_NAME . esc_html__( ' - Filter Clean', 'alpha-core' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		if ( ! function_exists( 'alpha_is_shop' ) || ! alpha_is_shop() ) {
			return;
		}

		global $alpha_layout;
		if ( ! empty( $alpha_layout['top_sidebar'] ) && 'hide' != $alpha_layout['top_sidebar'] ) {
			return;
		}

		extract( $args ); // @codingStandardsIgnoreLine

		?>

		<div class="filter-actions">
			<label><?php esc_html_e( 'Filter :', 'alpha-core' ); ?></label>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean"><?php esc_html_e( 'Clean All', 'alpha-core' ); ?></a>
		</div>

		<?php
	}


	public function form( $instance ) {
		?>
		<p><?php esc_html_e( 'Display filter clean button in shop sidebar.', 'alpha-core' ); ?></p>
		<?php
	}
}

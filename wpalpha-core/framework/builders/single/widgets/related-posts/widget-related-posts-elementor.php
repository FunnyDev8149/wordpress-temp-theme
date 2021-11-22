<?php
/**
 * Alpha Elementor Single Post Linked Posts Widget
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Alpha_Single_Related_Posts_Elementor_Widget extends Alpha_Posts_Elementor_Widget {

	public function get_name() {
		return ALPHA_NAME . '_single_related_posts';
	}

	public function get_title() {
		return esc_html__( 'Alpha Related Posts', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-posts-carousel';
	}

	public function get_categories() {
		return array( 'alpha_single_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'post', 'related', 'related posts' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {
		parent::_register_controls();
		$this->remove_control( 'post_ids' );
		$this->remove_control( 'categories' );
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_builder_set_preview', false ) ) {
			$atts           = $this->get_settings_for_display();
			$atts['status'] = 'related';
			require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/posts/render-posts.php' );
			do_action( 'alpha_single_builder_unset_preview' );
		}
	}
}

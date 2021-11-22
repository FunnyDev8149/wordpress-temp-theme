<?php
/**
 * Alpha Elementor Archive Post Title Widget
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Alpha_Archive_Title_Elementor_Widget extends Alpha_Heading_Elementor_Widget {

	public function get_name() {
		return ALPHA_NAME . '_archive_title';
	}

	public function get_title() {
		return esc_html__( 'Post Title', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-post-title';
	}

	public function get_categories() {
		return array( 'alpha_archive_widget' );
	}

	public function get_keywords() {
		return array( 'archive', 'custom', 'layout', 'post', 'name', 'title' );
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

		$this->remove_control( 'title' );
	}

	protected function render() {

		$is_template = ALPHA_NAME . '_template' == get_post_type();

		if ( apply_filters( 'alpha_archive_builder_set_preview', false ) ) {

			$atts          = $this->get_settings_for_display();
			$atts['title'] = esc_html__( 'Archive Title', 'alpha-core' );
			if ( ! $is_template && isset( $GLOBALS['alpha_layout']['title'] ) ) {
				$atts['title'] = $GLOBALS['alpha_layout']['title'];
			}

			$this->add_inline_editing_attributes( 'link_label' );

			require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/heading/render-heading-elementor.php' );

			do_action( 'alpha_archive_builder_unset_preview' );
		}
	}
}

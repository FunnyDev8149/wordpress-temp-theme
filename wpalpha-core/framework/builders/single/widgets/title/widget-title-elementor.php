<?php
/**
 * Alpha Elementor Single Post Title Widget
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

class Alpha_Single_Title_Elementor_Widget extends Alpha_Heading_Elementor_Widget {

	public function get_name() {
		return ALPHA_NAME . '_single_title';
	}

	public function get_title() {
		return esc_html__( 'Post Title', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-post-title';
	}

	public function get_categories() {
		return array( 'alpha_single_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'post', 'name', 'title' );
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
		if ( apply_filters( 'alpha_single_builder_set_preview', false ) ) {
			$atts          = $this->get_settings_for_display();
			$atts['title'] = get_the_title();
			$atts['class'] = 'post-title page-title';
			$this->add_inline_editing_attributes( 'link_label' );
			require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/heading/render-heading-elementor.php' );
			do_action( 'alpha_single_builder_unset_preview' );
		}
	}
}

<?php
/**
 * Alpha Elementor Single Post Excerpt Widget
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

class Alpha_Single_Excerpt_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_single_excerpt';
	}

	public function get_title() {
		return esc_html__( 'Post Excerpt', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-post-excerpt';
	}

	public function get_categories() {
		return array( 'alpha_single_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'post', 'excerpt' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_single_excerpt',
			array(
				'label' => esc_html__( 'Style', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'alpha-core' ),
					'selector' => '.elementor-element-{{ID}} p',
				)
			);

			$this->add_control(
				'sp_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'alpha-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'alpha-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'alpha-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'alpha-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justify', 'alpha-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} p' => 'text-align: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_builder_set_preview', false ) ) {
			alpha_get_template_part( 'posts/loop/post', 'content' );
			do_action( 'alpha_single_builder_unset_preview' );
		}
	}
}

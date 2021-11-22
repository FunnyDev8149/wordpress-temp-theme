<?php
/**
 * Alpha Elementor Single Post Price Widget
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Alpha_Single_Date_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_single_date';
	}

	public function get_title() {
		return esc_html__( 'Post Date & Category', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-date';
	}

	public function get_categories() {
		return array( 'alpha_single_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'post', 'date', 'category' );
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
			'section_single_meta',
			array(
				'label' => esc_html__( 'Style', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'alpha-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'0 auto 0 0' => array(
							'title' => esc_html__( 'Left', 'alpha-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'0 auto'     => array(
							'title' => esc_html__( 'Center', 'alpha-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'0 0 0 auto' => array(
							'title' => esc_html__( 'Right', 'alpha-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .post-cats-date' => 'margin: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-cats-date' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => 'border',
					'selector' => '.elementor-element-{{ID}} .post-cats-date',
				)
			);

			$this->add_control(
				'heading_text_style',
				array(
					'label'     => esc_html__( 'Text', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'alpha-core' ),
					'selector' => '.elementor-element-{{ID}} .post-cats-date',
				)
			);

			$this->add_control(
				'text_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-cats-date' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_link_style',
				array(
					'label'     => esc_html__( 'Link', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'link_typography',
					'selector' => '.elementor-element-{{ID}} a',
				)
			);

			$this->add_control(
				'link_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} a' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'alpha_single_builder_set_preview', false ) ) {
			alpha_get_template_part( 'posts/single/post', 'date-in-category' );
			do_action( 'alpha_single_builder_unset_preview' );
		}
	}
}

<?php
/**
 * Alpha Elementor Single Author Box Widget
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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Single_Author_Box_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_single_author_box';
	}

	public function get_title() {
		return esc_html__( 'Author Box', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-person';
	}

	public function get_categories() {
		return array( 'alpha_single_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'post', 'author', 'author info', 'author box' );
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
			'section_single_author',
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
						'.elementor-element-{{ID}} .post-author-detail' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'author_shadow',
					'selector' => '.elementor-element-{{ID}} .post-author-detail',
				]
			);

			$this->add_control(
				'heading_name_style',
				array(
					'label'     => esc_html__( 'Author Name', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'author_name',
					'selector' => '.elementor-element-{{ID}} .author-name',
				)
			);

			$this->add_control(
				'author_name_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .author-name' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_desc_style',
				array(
					'label'     => esc_html__( 'Author Description', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'author_desc',
					'selector' => '.elementor-element-{{ID}} .author-content',
				)
			);

			$this->add_control(
				'author_desc_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .author-content' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_link_style',
				array(
					'label'     => esc_html__( 'Author Link', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'author_link',
					'selector' => '.elementor-element-{{ID}} .author-link',
				)
			);

			$this->add_control(
				'author_link_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .author-link' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'author_link_h_color',
				array(
					'label'     => esc_html__( 'Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .author-link:hover, .elementor-element-{{ID}} .author-link:focus' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {

		if ( apply_filters( 'alpha_single_builder_set_preview', false ) ) {

			alpha_get_template_part( 'posts/single/post', 'author' );

			do_action( 'alpha_single_builder_unset_preview' );
		}
	}
}

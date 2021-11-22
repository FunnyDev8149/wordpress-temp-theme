<?php
/**
 * Alpha Header Elementor Compare
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Header_Compare_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_header_compare';
	}

	public function get_title() {
		return esc_html__( 'Compare', 'alpha-core' );
	}

	public function get_icon() {
		return ALPHA_ICON_PREFIX . '-icon-compare alpha-elementor-widget-icon';
	}

	public function get_categories() {
		return array( 'alpha_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'alpha', 'compare', 'shop' );
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
			'section_compare_content',
			array(
				'label' => esc_html__( 'Compare', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Compare Type', 'alpha-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'alpha-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'alpha-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'minicompare',
				array(
					'label'   => esc_html__( 'Mini Compare List', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''          => esc_html__( 'Do not show', 'alpha-core' ),
						'dropdown'  => esc_html__( 'Dropdown', 'alpha-core' ),
						'offcanvas' => esc_html__( 'Off-Canvas', 'alpha-core' ),
					),
				)
			);

			$this->add_control(
				'show_icon',
				array(
					'label'   => esc_html__( 'Show Icon', 'alpha-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Icon', 'alpha-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-compare',
						'library' => 'alpha-icons',
					),
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'     => esc_html__( 'Show Count', 'alpha-core' ),
					'default'   => 'yes',
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_label',
				array(
					'label'   => esc_html__( 'Show Label', 'alpha-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'label',
				array(
					'label'       => esc_html__( 'Compare Label', 'alpha-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Compare', 'alpha-core' ),
					'condition'   => array(
						'show_label' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_compare_style',
			array(
				'label' => esc_html__( 'Compare', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'compare_typography',
					'selector' => '.elementor-element-{{ID}} .compare-open',
				)
			);

			$this->add_responsive_control(
				'compare_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare-open i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'compare_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_compare_color' );
				$this->start_controls_tab(
					'tab_compare_normal',
					array(
						'label' => esc_html__( 'Normal', 'alpha-core' ),
					)
				);

				$this->add_control(
					'compare_color',
					array(
						'label'     => esc_html__( 'Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .compare-open' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_compare_hover',
					array(
						'label' => esc_html__( 'Hover', 'alpha-core' ),
					)
				);

				$this->add_control(
					'compare_hover_color',
					array(
						'label'     => esc_html__( 'Hover Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .compare-open:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'compare_count_heading',
				array(
					'label'     => esc_html__( 'Count', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare-open .compare-count' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'badge_h_position',
				array(
					'label'      => esc_html__( 'Horizontal Position', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare-open .compare-count' => 'left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'badge_v_position',
				array(
					'label'      => esc_html__( 'Vertical Position', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare-open .compare-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .compare-open .compare-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_color',
				array(
					'label'     => esc_html__( 'Count Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .compare-open .compare-count' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'compare_dropdown_heading',
				array(
					'label'     => esc_html__( 'Dropdown Compare List', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'minicompare' => 'dropdown',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'      => esc_html__( 'Dropdown Position', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-box' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
					),
					'condition'  => array(
						'minicompare' => 'dropdown',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'type'        => $settings['type'],
			'show_icon'   => 'yes' == $settings['show_icon'],
			'show_count'  => 'yes' == $settings['show_count'],
			'show_label'  => 'yes' == $settings['show_label'],
			'icon'        => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : ALPHA_ICON_PREFIX . '-icon-compare',
			'label'       => isset( $settings['label'] ) && $settings['label'] ? $settings['label'] : esc_html__( 'Compare', 'alpha-core' ),
			'minicompare' => $settings['minicompare'],
		);
		require alpha_core_framework_path( ALPHA_BUILDERS . '/header/widgets/compare/render-compare-elementor.php' );
	}
}

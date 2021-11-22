<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alpha Elementor CountTo Widget
 *
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Alpha_Controls_Manager;

class Alpha_Hotspot_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_hotspot';
	}

	public function get_title() {
		return esc_html__( 'Hotspot', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-image-hotspot';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'hotspot', 'dot' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'alpha-core' ),
			)
		);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Icon', 'alpha-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => ALPHA_ICON_PREFIX . '-icon-plus',
						'library' => '',
					),
				)
			);

			$this->add_responsive_control(
				'horizontal',
				array(
					'label'      => esc_html__( 'Horizontal', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'%',
						'vw',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'vertical',
				array(
					'label'      => esc_html__( 'Vertical', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'size_units' => array(
						'px',
						'%',
						'vw',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'effect',
				array(
					'label'   => esc_html__( 'Hotspot Effect', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'type1',
					'options' => array(
						''      => esc_html__( 'None', 'alpha-core' ),
						'type1' => esc_html__( 'Spread', 'alpha-core' ),
						'type2' => esc_html__( 'Twinkle', 'alpha-core' ),
					),
				)
			);

			$this->add_control(
				'el_class',
				array(
					'label' => esc_html__( 'Custom Class', 'alpha-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Popup Content', 'alpha-core' ),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Type', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'html',
				'options' => array(
					'html'    => esc_html__( 'Custom Html', 'alpha-core' ),
					'block'   => esc_html__( 'Block', 'alpha-core' ),
					'product' => esc_html__( 'Product', 'alpha-core' ),
					'image'   => esc_html__( 'Image', 'alpha-core' ),
				),
			)
		);

		$this->add_control(
			'html',
			array(
				'label'     => esc_html__( 'Custom Html', 'alpha-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => array( 'type' => 'html' ),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose Image', 'alpha-core' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array( 'type' => 'image' ),
			)
		);

			$this->add_control(
				'block',
				array(
					'label'       => esc_html__( 'Select a Block', 'alpha-core' ),
					'type'        => Alpha_Controls_Manager::AJAXSELECT2,
					'options'     => 'block',
					'label_block' => true,
					'condition'   => array( 'type' => 'block' ),
				)
			);

		$this->add_control(
			'link',
			array(
				'label'     => esc_html__( 'Link Url', 'alpha-core' ),
				'type'      => Controls_Manager::URL,
				'default'   => array(
					'url' => '',
				),
				'condition' => array( 'type!' => 'product' ),
			)
		);

		$this->add_control(
			'product',
			array(
				'label'       => esc_html__( 'Product', 'alpha-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'product',
				'label_block' => true,
				'condition'   => array( 'type' => 'product' ),
			)
		);

		$this->add_control(
			'popup_position',
			array(
				'label'   => esc_html__( 'Popup Position', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'none'   => esc_html__( 'Do not display', 'alpha-core' ),
					'top'    => esc_html__( 'Top', 'alpha-core' ),
					'left'   => esc_html__( 'Left', 'alpha-core' ),
					'right'  => esc_html__( 'Right', 'alpha-core' ),
					'bottom' => esc_html__( 'Bottom', 'alpha-core' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'size',
			array(
				'label'      => esc_html__( 'Hotspot Size', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .hotspot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 14,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'em',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'em' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .hotspot i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .hotspot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'spread_color',
			array(
				'label'     => esc_html__( 'Spread Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => array(
					'effect' => 'type1',
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .hotspot-type1:not(:hover):before' => 'background: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_hotspot' );

		$this->start_controls_tab(
			'tab_btn_normal',
			array(
				'label' => esc_html__( 'Normal', 'alpha-core' ),
			)
		);

		$this->add_control(
			'btn_color',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .hotspot' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .hotspot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_hover',
			array(
				'label' => esc_html__( 'Hover', 'alpha-core' ),
			)
		);

		$this->add_control(
			'btn_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_popup',
			array(
				'label' => esc_html__( 'Popup', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'popup_width',
				array(
					'label'      => esc_html__( 'Width', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'%',
						'rem',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 10,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hotspot-box' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/hotspot/render-hotspot-elementor.php' );
	}
}

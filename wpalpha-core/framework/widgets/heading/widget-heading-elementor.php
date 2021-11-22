<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Heading Widget
 *
 * Alpha Widget to display heading.
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;


class Alpha_Heading_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'alpha-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'heading', 'title', 'subtitle', 'text', 'alpha', 'dynamic' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-heading';
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_heading_title',
			array(
				'label' => esc_html__( 'Title', 'alpha-core' ),
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Content', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'custom'  => esc_html__( 'Custom Text', 'alpha-core' ),
					'dynamic' => esc_html__( 'Dynamic Content', 'alpha-core' ),
				),
				'default' => 'custom',
			)
		);

		$this->add_control(
			'dynamic_content',
			array(
				'label'     => esc_html__( 'Dynamic Content', 'alpha-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'title'        => esc_html__( 'Page Title', 'alpha-core' ),
					'subtitle'     => esc_html__( 'Page Subtitle', 'alpha-core' ),
					'product_cnt'  => esc_html__( 'Products Count', 'alpha-core' ),
					'site_tagline' => esc_html__( 'Site Tag Line', 'alpha-core' ),
					'site_title'   => esc_html__( 'Site Title', 'alpha-core' ),
					'date'         => esc_html__( 'Current Date Time', 'alpha-core' ),
				),
				'default'   => 'title',
				'condition' => array(
					'content_type' => 'dynamic',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'alpha-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Add Your Heading Text Here', 'alpha-core' ),
				'placeholder' => esc_html__( 'Enter your title', 'alpha-core' ),
				'condition'   => array(
					'content_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'decoration',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Type', 'alpha-core' ),
				'default' => '',
				'options' => array(
					''          => esc_html__( 'Simple', 'alpha-core' ),
					'cross'     => esc_html__( 'Cross', 'alpha-core' ),
					'underline' => esc_html__( 'Underline', 'alpha-core' ),
				),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'   => esc_html__( 'Title Align', 'alpha-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'title-left',
				'options' => array(
					'title-left'   => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'title-center' => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'title-right'  => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			array(
				'label'      => esc_html__( 'Decoration Spacing', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title::before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .title::after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Decoration Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title-cross .title::before, .elementor-element-{{ID}} .title-cross .title::after, .elementor-element-{{ID}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'show_link',
			array(
				'label'   => esc_html__( 'Show Link?', 'alpha-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link',
			array(
				'label'     => esc_html__( 'Link', 'alpha-core' ),
				'condition' => array(
					'show_link' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'   => esc_html__( 'Link Url', 'alpha-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'link_label',
			array(
				'label'   => esc_html__( 'Link Label', 'alpha-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'link',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'alpha-core' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'   => esc_html__( 'Icon Position', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'after'  => esc_html__( 'After', 'alpha-core' ),
					'before' => esc_html__( 'Before', 'alpha-core' ),
				),
			)
		);

		$this->add_control(
			'icon_space',
			array(
				'label'     => esc_html__( 'Icon Spacing (px)', 'alpha-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .icon-before i' => "margin-{$right}: {{SIZE}}px;",
					'.elementor-element-{{ID}} .icon-after i'  => "margin-{$left}: {{SIZE}}px;",
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Icon Size (px)', 'alpha-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_responsive_control(
			'link_align',
			array(
				'label'   => esc_html__( 'Link Align', 'alpha-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'link-left'  => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'link-right' => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'link-right',
			)
		);

		$this->add_responsive_control(
			'show_divider',
			array(
				'label'     => esc_html__( 'Show Divider?', 'donad-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'link_align' => 'link-left',
				),
			)
		);

		$this->add_control(
			'link_gap',
			array(
				'label'      => esc_html__( 'Link Space', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -50,
						'max'  => 50,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .link' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Title Padding', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '.elementor-element-{{ID}} .title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link_style',
			array(
				'label' => esc_html__( 'Link', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'link_spacing',
			array(
				'label'      => esc_html__( 'Link Spacing', 'alpha-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '.elementor-element-{{ID}} .link',
			)
		);

		$this->start_controls_tabs( 'tabs_heading_link' );

		$this->start_controls_tab(
			'tab_link_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'alpha-core' ),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'alpha-core' ),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'link_label' );
		if ( 'custom' == $atts['content_type'] ) {
			$this->add_inline_editing_attributes( 'title' );
		}
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/heading/render-heading-elementor.php' );
	}
}

<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Button Widget
 *
 * Alpha Widget to display button.
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;


class Alpha_Button_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'alpha-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'Button', 'link', 'alpha' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-button';
	}

	public function get_script_depends() {
		return array();
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button Options', 'alpha-core' ),
			)
		);

		$this->add_control(
			'label',
			array(
				'label'   => esc_html__( 'Label', 'alpha-core' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
				'default' => esc_html__( 'Click here', 'alpha-core' ),
			)
		);

		$this->add_control(
			'button_expand',
			array(
				'label' => esc_html__( 'Expand', 'alpha-core' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'     => esc_html__( 'Alignment', 'alpha-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'.elementor-element-{{ID}} .elementor-widget-container' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'button_expand!' => 'yes',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => esc_html__( 'Link Url', 'alpha-core' ),
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url' => '',
				),
			)
		);

		alpha_elementor_button_layout_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_button',
			array(
				'label' => esc_html__( 'Video Options', 'alpha-core' ),
			)
		);

		$this->add_control(
			'play_btn',
			array(
				'label'       => esc_html__( 'Use as a play button in section', 'alpha-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'alpha-core' ),
				'label_on'    => esc_html__( 'On', 'alpha-core' ),
				'description' => esc_html__( 'You can play video whenever you set video in parent section', 'alpha-core' ),
				'condition'   => array(
					'video_btn' => '',
				),
			)
		);

		$this->add_control(
			'video_btn',
			array(
				'label'       => esc_html__( 'Use as video button', 'alpha-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'alpha-core' ),
				'label_on'    => esc_html__( 'On', 'alpha-core' ),
				'default'     => '',
				'description' => esc_html__( 'You can play video on lightbox.', 'alpha-core' ),
				'condition'   => array(
					'play_btn' => '',
				),
			)
		);

		$this->add_control(
			'vtype',
			array(
				'label'     => esc_html__( 'Source', 'alpha-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'youtube',
				'options'   => array(
					'youtube' => esc_html__( 'YouTube', 'alpha-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'alpha-core' ),
					'hosted'  => esc_html__( 'Self Hosted', 'alpha-core' ),
				),
				'condition' => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'     => esc_html__( 'Video url', 'alpha-core' ),
				'type'      => Controls_Manager::URL,
				'separator' => 'after',
				'condition' => array(
					'video_btn' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		alpha_elementor_button_style_controls( $this );
	}

	public function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		$this->add_inline_editing_attributes( 'label' );
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/button/render-button-elementor.php' );
	}
}

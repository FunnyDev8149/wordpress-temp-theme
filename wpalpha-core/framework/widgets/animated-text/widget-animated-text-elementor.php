<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Highlight Widget
 *
 * Alpha Widget to display WC breadcrumb.
 *
 * @author     FunnyWP
 * @package    Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Animated_Text_Elementor_Widget extends Elementor\Widget_Heading {

	public function get_name() {
		return ALPHA_NAME . '_widget_animated_text';
	}

	public function get_title() {
		return esc_html__( 'Animated Text', 'alpha-core' );
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-animated-headline';
	}

	public function get_keywords() {
		return array( 'animation', 'animated', 'heading', 'text', 'alpha' );
	}

	public function get_script_depends() {
		wp_register_script( 'alpha-animated-text', alpha_core_framework_uri( '/widgets/animated-text/animated-text' . ALPHA_JS_SUFFIX ), array( 'jquery-core' ), ALPHA_CORE_VERSION, true );
		return array( 'alpha-animated-text' );
	}

	protected function _register_controls() {

		parent::_register_controls();

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'alpha-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => alpha_get_option( 'primary_color' ),
				'selectors' => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'custom_class',
			array(
				'label' => esc_html__( 'Custom Class', 'alpha-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'title_after',
			array(
				'label'   => esc_html__( 'Title After', 'alpha-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Theme', 'alpha-core' ),
				'dynamic' => array(
					'active' => true,
				),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$presets = array(
			array(
				'text' => esc_html__( 'Business', 'alpha-core' ),
			),
			array(
				'text' => esc_html__( 'Portfolio', 'alpha-core' ),
			),
			array(
				'text' => esc_html__( 'Education', 'alpha-core' ),
			),
			array(
				'text' => esc_html__( 'E-Commerce', 'alpha-core' ),
			),
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Animated Texts', 'alpha-core' ),
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ text }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => $presets,
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$this->add_control(
			'title_before',
			array(
				'label'   => esc_html__( 'Title Before', 'alpha-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Truly', 'alpha-core' ),
				'dynamic' => array(
					'active' => true,
				),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'title',
				),
			)
		);

		$this->remove_control( 'title' );
		$this->remove_control( 'link' );
		$this->remove_control( 'size' );

		$this->start_controls_section(
			'section_animation',
			array(
				'label' => esc_html__( 'Animation', 'alpha-core' ),
			)
		);

			$this->add_control(
				'animation_type',
				array(
					'label'   => esc_html__( 'Animation Type', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'joke',
					'options' => array(
						'joke'     => esc_html__( 'Joke', 'alpha-core' ),
						'fall'     => esc_html__( 'Fall', 'alpha-core' ),
						'rotation' => esc_html__( 'Rotation', 'alpha-core' ),
						'croco'    => esc_html__( 'Croco', 'alpha-core' ),
						'scaling'  => esc_html__( 'Scaling', 'alpha-core' ),
						'typing'   => esc_html__( 'Typing', 'alpha-core' ),
					),
				)
			);

			$this->add_control(
				'animation_delay',
				array(
					'label'       => esc_html__( 'Animation Delay (ms)', 'alpha-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => '3000',
				)
			);

			$this->add_control(
				'split_type',
				array(
					'label'   => esc_html__( 'Split Type', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'letter',
					'options' => array(
						'letter' => esc_html__( 'Letters', 'alpha-core' ),
						'word'   => esc_html__( 'Words', 'alpha-core' ),
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts         = $this->get_settings_for_display();
		$atts['self'] = $this;
		require ALPHA_CORE_FRAMEWORK_PATH . '/widgets/animated-text/render-animated-text-elementor.php';
	}

	protected function content_template() {
	}
}

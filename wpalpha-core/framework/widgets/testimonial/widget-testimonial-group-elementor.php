<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alpha Testimonial Widget
 *
 * Alpha Widget to display testimonial.
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Testimonial_Group_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_testimonial_group';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer', 'slider', 'grid', 'group' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_testimonial_group',
			array(
				'label' => esc_html__( 'Testimonials', 'alpha-core' ),
			)
		);

			$repeater = new Repeater();

			alpha_elementor_testimonial_content_controls( $repeater );

			$presets = array(
				array(
					'name'    => esc_html__( 'John Doe', 'alpha-core' ),
					'role'    => esc_html__( 'Programmer', 'alpha-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'alpha-core' ),
				),
				array(
					'name'    => esc_html__( 'Henry Harry', 'alpha-core' ),
					'role'    => esc_html__( 'Banker', 'alpha-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'alpha-core' ),
				),
				array(
					'name'    => esc_html__( 'Tom Jakson', 'alpha-core' ),
					'role'    => esc_html__( 'Vendor', 'alpha-core' ),
					'title'   => '',
					'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'alpha-core' ),
				),
			);

			$this->add_control(
				'testimonial_group_list',
				array(
					'label'   => esc_html__( 'Testimonial Group', 'alpha-core' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => $presets,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_layout',
			array(
				'label' => esc_html__( 'Testimonials Layout', 'alpha core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Testimonials Layout', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'alpha-core' ),
						'slider' => esc_html__( 'Slider', 'alpha-core' ),
					),
				)
			);

			alpha_elementor_grid_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_general',
			array(
				'label' => esc_html__( 'Testimonial Type', 'alpha-core' ),
			)
		);

			alpha_elementor_testimonial_type_controls( $this );

			$this->add_control(
				'content_line',
				array(
					'label'     => esc_html__( 'Maximum Content Line', 'alpha-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '4',
					'selectors' => array(
						'.elementor-element-{{ID}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'star_icon',
				array(
					'label'   => esc_html__( 'Star Icon', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''        => 'Theme',
						'fa-icon' => 'Font Awesome',
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_testimonial_style_controls( $this );

		alpha_elementor_slider_style_controls( $this, 'layout_type' );
	}


	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/testimonial/render-testimonial-group-elementor.php' );
	}
}

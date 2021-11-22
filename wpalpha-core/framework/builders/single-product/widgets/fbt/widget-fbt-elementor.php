<?php
/**
 * Alpha Elementor Single Product Data_tab Widget
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

class Alpha_Single_Product_FBT_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_sproduct_fbt';
	}

	public function get_title() {
		return esc_html__( 'Product Frequently Bought Together', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-product-upsell';
	}

	public function get_categories() {
		return array( 'alpha_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'frequently', 'product', 'woocommerce', 'shop', 'bought', 'together' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
			//          $depends[] = 'alpha-product-frequently-bought-together-js';
		}
		return $depends;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}


	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_fbt',
			array(
				'label' => esc_html__( 'Content', 'alpha-core' ),
			)
		);

			$this->add_control(
				'sp_fbt_title',
				array(
					'type'        => Controls_Manager::TEXTAREA,
					'label'       => esc_html__( 'Tab title', 'alpha-core' ),
					'rows'        => 3,
					'placeholder' => esc_html__( 'Frequently Bought Together', 'alpha-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_fbt_typo',
					'label'    => esc_html__( 'Title Typography', 'alpha-core' ),
					'selector' => '.elementor-element-{{ID}} .product-fbt .title',
				)
			);

			$this->add_control(
				'sp_fbt_title_color',
				array(
					'label'     => esc_html__( 'Title Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'seperator' => 'after',
					'selectors' => array(
						'.elementor-element-{{ID}} .product-fbt .title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'sp_fbt_content_dimen',
				array(
					'label'      => esc_html__( 'Content Margin', 'alpha-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-fbt .products'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}

	public function get_tab_title( $title ) {
		$sp_title = $this->get_settings_for_display( 'sp_fbt_title' );
		if ( $sp_title ) {
			$title = $sp_title;
		}
		return $title;
	}

	protected function render() {

		if ( apply_filters( 'alpha_single_product_builder_set_preview', false ) ) {

			add_filter( 'alpha_single_product_fbt_title', array( $this, 'get_tab_title' ), 20 );

			if ( class_exists( 'Alpha_Product_Frequently_Bought_Together' ) ) {
				Alpha_Product_Frequently_Bought_Together::get_instance()->alpha_fbt_product();

			}
			remove_filter( 'alpha_single_product_fbt_title', array( $this, 'get_tab_title' ), 20 );

			do_action( 'alpha_single_product_builder_unset_preview' );
		}
	}
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alpha Vendors Widget
 *
 * Widget to display vendors
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

if ( ! class_exists( 'WeDevs_Dokan' ) && ! class_exists( 'WC_Vendors' ) && ! class_exists( 'WCMp' ) && ! class_exists( 'WC_Vendors' ) ) {
	return;
}

use Elementor\Controls_Manager;
use Elementor\Alpha_Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Alpha_Vendor_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return ALPHA_NAME . '_widget_vendors';
	}

	public function get_title() {
		return esc_html__( 'Vendors', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-person';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'vendors', 'dokan', 'wcfm', 'wcvendor', 'customer' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function _register_controls() {

		// Select Vendors
		$this->start_controls_section(
			'section_vendors_selector',
			array(
				'label' => esc_html__( 'Select Vendors', 'alpha-core' ),
			)
		);

		$this->add_control(
			'vendor_select_type',
			array(
				'label'   => esc_html__( 'Select', 'alpha-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'individual',
				'options' => array(
					'individual' => esc_html__( 'Individually', 'alpha-core' ),
					'group'      => esc_html__( 'Group', 'alpha-core' ),
				),
			)
		);

		$this->add_control(
			'vendor_ids',
			array(
				'label'       => esc_html__( 'Select Vendors', 'alpha-core' ),
				'type'        => Alpha_Controls_Manager::AJAXSELECT2,
				'options'     => 'vendors',
				'label_block' => true,
				'multiple'    => 'true',
				'condition'   => array(
					'vendor_select_type' => array( 'individual' ),
				),
			)
		);

		$this->add_control(
			'vendor_category',
			array(
				'label'     => esc_html__( 'Vendor Type', 'alpha-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''       => esc_html__( 'General', 'alpha-core' ),
					'sale'   => esc_html__( 'Top Selling Vendors', 'alpha-core' ),
					'rating' => esc_html__( 'Top Rating Vendors', 'alpha-core' ),
					// 'featured' => esc_html__( 'Featured Vendors', 'alpha-core' ),
					'recent' => esc_html__( 'Newly Added Vendors', 'alpha-core' ),
				),
				'condition' => array(
					'vendor_select_type' => array( 'group' ),
				),
			)
		);

		$this->add_control(
			'vendor_count',
			array(
				'label'     => esc_html( 'Vendor Count', 'alpha-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '4',
				'condition' => array(
					'vendor_select_type' => array( 'group' ),
				),
			)
		);

		$this->end_controls_section();

		// Select Vendor Layouts
		$this->start_controls_section(
			'section_vendors_layout',
			array(
				'label' => esc_html__( 'Vendors Layout', 'alpha-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Vendors Layout', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'alpha-core' ),
						'slider' => esc_html__( 'Slider', 'alpha-core' ),
					),
				)
			);

			alpha_elementor_grid_layout_controls( $this, 'layout_type', false, 'has_rows' );

			$this->end_controls_section();

			// Select Vendor Display Type
			$this->start_controls_section(
				'section_display_type',
				array(
					'label' => esc_html__( 'Vendors Type', 'alpha-core' ),
				)
			);

			$this->add_control(
				'vendor_type',
				array(
					'label'   => esc_html__( 'Display Type', 'alpha-core' ),
					'type'    => Alpha_Controls_Manager::IMAGE_CHOOSE,
					'default' => 'vendor-1',
					'options' => array(
						'vendor-1' => 'assets/images/vendors/type-1.jpg',
						'vendor-2' => 'assets/images/vendors/type-2.jpg',
						'vendor-3' => 'assets/images/vendors/type-3.jpg',
					),
					'width'   => 1,
				)
			);

			$this->add_control(
				'vendor_show_info',
				array(
					'label'    => esc_html__( 'Show Information', 'alpha-core' ),
					'type'     => Controls_Manager::SELECT2,
					'multiple' => true,
					'default'  => array(
						'name',
						'avatar',
						'rating',
						'product_count',
						'products',
					),
					'options'  => array(
						'name'          => esc_html__( 'Name', 'alpha-core' ),
						'avatar'        => esc_html__( 'Avatar', 'alpha-core' ),
						'rating'        => esc_html__( 'Rating', 'alpha-core' ),
						'product_count' => esc_html__( 'Products Count', 'alpha-core' ),
						// 'total_sale'    => esc_html__( 'Total Earns', 'alpha-core' ),
						'products'      => esc_html__( 'Products', 'alpha-core' ),
					),
				)
			);

			$this->add_control(
				'show_total_sale',
				array(
					'label'     => esc_html__( 'Show Total Sale', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'vendor_category' => array( 'sale' ),
					),
				)
			);

			$this->add_control(
				'show_vendor_link',
				array(
					'label'     => esc_html__( 'Show Visit Vendor Link', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'condition' => array(
						'vendor_type' => array( 'vendor-1', 'vendor-3' ),
					),
				)
			);

			$this->add_control(
				'vendor_link_text',
				array(
					'label'     => esc_html__( 'Link Text', 'alpha-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'Browse This Vendor', 'alpha-core' ),
					'condition' => array(
						'vendor_type'      => array( 'vendor-1', 'vendor-3' ),
						'show_vendor_link' => array( 'yes' ),
					),
				)
			);

		$this->end_controls_section();

		// Vendor Product type
		$this->start_controls_section(
			'section_vendor_product',
			array(
				'label' => esc_html__( 'Vendor Products', 'alpha-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
				'exclude' => [ 'custom' ],
				'default' => 'woocommerce_thumbnail',
			)
		);

		$this->end_controls_section();

		// Vendor Widget Style
		$this->start_controls_section(
			'section_vendor_style',
			array(
				'label' => esc_html__( 'Vendor Style', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			// Vendor name
			$this->add_control(
				'style_vendor_name',
				array(
					'label' => esc_html__( 'Vendor Name', 'alpha-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->start_controls_tabs( 'vendor_name_tabs' );
				$this->start_controls_tab(
					'vendor_name_default_style',
					array(
						'label' => esc_html__( 'default', 'alpha-core' ),
					)
				);

					$this->add_control(
						'vendor_name_default_color',
						array(
							'label'     => esc_html__( 'Color', 'alpha-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .vendor-name a' => 'color: {{VALUE}};',
							),
						)
					);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'vendor_name_hover_style',
					array(
						'label' => esc_html__( 'Hover', 'alpha-core' ),
					)
				);

					$this->add_control(
						'vendor_name_hover_color',
						array(
							'label'     => esc_html__( 'Hover Color', 'alpha-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .vendor-name:hover a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'vendor_name_typo',
					'selector' => '.elementor-element-{{ID}} .vendor-name',
				)
			);

			// Vendor products count
			$this->add_control(
				'style_vp_count',
				array(
					'label'     => esc_html__( 'Vendor Products Count', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			// Add typography for vendor products count
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'vendor_product_count_typo',
					'selector' => '.elementor-element-{{ID}} .vendor-products-count',
				)
			);

			// Vendor Logo Style
			$this->add_control(
				'style_vendor_avatar',
				array(
					'label'     => esc_html__( 'Vendor Logo Style', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);
			$this->add_control(
				'style_va_size',
				array(
					'label'     => esc_html__( 'Logo Size (px)', 'alpha-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'unit' => 'px',
						'size' => 70,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 70,
							'max'  => 130,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .vendor-widget .vendor-logo' => 'max-width: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .vendor-widget .vendor-personal' => 'max-width: calc( 100% - {{SIZE}}{{UNIT}} );',
					),
					'condition' => array(
						'vendor_type' => array( 'vendor-1', 'vendor-2' ),
					),
				)
			);

			$this->add_control(
				'style_va_size_3',
				array(
					'label'     => esc_html__( 'Logo Size (px)', 'alpha-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'unit' => 'px',
						'size' => 90,
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 70,
							'max'  => 150,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .vendor-widget-3 .vendor-logo' => 'max-width: {{SIZE}}{{UNIT}};
			height: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .vendor-widget-3 .vendor-details' => 'margin-top: calc( -{{SIZE}}{{UNIT}} / 2 );',
					),
					'condition' => array(
						'vendor_type' => array( 'vendor-3' ),
					),
				)
			);
		$this->end_controls_section();

		alpha_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/vendor/render-vendor.php' );
	}

	protected function content_template() {}
}

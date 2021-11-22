<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Single Product Widget
 *
 * Alpha Widget to display products.
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;

class Alpha_Singleproducts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_widget_single_product';
	}

	public function get_title() {
		return esc_html__( 'Single Product', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-single-product';
	}

	public function get_categories() {
		return array( 'alpha_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'product', 'flipbook', 'lookbook', 'carousel', 'slider', 'shop', 'woocommerce' );
	}

	public function get_style_depends() {
		return array();
	}

	public function get_script_depends() {
		$depends = array();
		if ( alpha_is_elementor_preview() ) {
			$depends[] = 'alpha-elementor-js';
		}
		return $depends;
	}

	protected function _register_controls() {

		alpha_elementor_products_select_controls( $this );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'alpha-core' ),
			)
		);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'   => esc_html__( 'Title Tag', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default' => 'h2',
				)
			);

			$this->add_control(
				'sp_gallery_type',
				array(
					'label'   => esc_html__( 'Gallery Type', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => apply_filters(
						'alpha_sp_types',
						array(
							''           => esc_html__( 'Default', 'alpha-core' ),
							'vertical'   => esc_html__( 'Vertical', 'alpha-core' ),    // @feature: fs_spt_vertical
							'horizontal' => esc_html__( 'Horizontal', 'alpha-core' ),  // @feature: fs_spt_horizontal
							'grid'       => esc_html__( 'Grid Images', 'alpha-core' ), // @feature: fs_spt_grid
							'gallery'    => esc_html__( 'Gallery', 'alpha-core' ),     // @feature: fs_spt_gallery
						),
						'elementor'
					),
				)
			);

			$this->add_control(
				'sp_vertical',
				array(
					'label'     => esc_html__( 'Show Vertical', 'alpha-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'sp_gallery_type!' => 'gallery',
					),
				)
			);

			$this->add_control(
				'sp_show_info',
				array(
					'type'     => Controls_Manager::SELECT2,
					'label'    => esc_html__( 'Show Information', 'alpha-core' ),
					'multiple' => true,
					'default'  => array( 'gallery', 'title', 'meta', 'price', 'rating', 'excerpt', 'addtocart_form', 'share', 'wishlist', 'compare', 'divider' ),
					'options'  => array(
						'gallery'        => esc_html__( 'Gallery', 'alpha-core' ),
						'title'          => esc_html__( 'Title', 'alpha-core' ),
						'meta'           => esc_html__( 'Meta', 'alpha-core' ),
						'price'          => esc_html__( 'Price', 'alpha-core' ),
						'rating'         => esc_html__( 'Rating', 'alpha-core' ),
						'excerpt'        => esc_html__( 'Description', 'alpha-core' ),
						'addtocart_form' => esc_html__( 'Add To Cart Form', 'alpha-core' ),
						'divider'        => esc_html__( 'Divider In Cart Form', 'alpha-core' ),
						'share'          => esc_html__( 'Share', 'alpha-core' ),
						'wishlist'       => esc_html__( 'Wishlist', 'alpha-core' ),
						'compare'        => esc_html__( 'Compare', 'alpha-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'sp_col_cnt',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Columns', 'alpha-core' ),
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'alpha-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_xl',
				array(
					'label'     => esc_html__( 'Columns ( >= 1200px )', 'alpha-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'alpha-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_min',
				array(
					'label'     => esc_html__( 'Columns ( < 576px )', 'alpha-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'alpha-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_sp',
				array(
					'label'     => esc_html__( 'Spacing', 'alpha-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'md',
					'options'   => apply_filters(
						'alpha_col_sp',
						array(
							'no' => esc_html__( 'No space', 'alpha-core' ),
							'xs' => esc_html__( 'Extra Small', 'alpha-core' ),
							'sm' => esc_html__( 'Small', 'alpha-core' ),
							'md' => esc_html__( 'Medium', 'alpha-core' ),
							'lg' => esc_html__( 'Large', 'alpha-core' ),
						),
						'elementor'
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		alpha_elementor_single_product_style_controls( $this );

		alpha_elementor_slider_style_controls(
			$this,
			'',
			array(
				'show_dots' => true,
				'show_nav'  => true,
			)
		);
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

	protected function render() {
		$atts = $this->get_settings_for_display();
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/singleproducts/render-singleproducts.php' );
	}

}

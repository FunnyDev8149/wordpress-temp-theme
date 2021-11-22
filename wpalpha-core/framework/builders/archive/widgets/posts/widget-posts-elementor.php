<?php
/**
 * Alpha Elementor Archive Post Linked Posts Widget
 *
 * @author     FunnyWP
 * @package    Alpha Core Framework
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Alpha_Archive_Posts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return ALPHA_NAME . '_archive_posts';
	}

	public function get_title() {
		return esc_html__( 'Alpha Archive Posts', 'alpha-core' );
	}

	public function get_icon() {
		return 'alpha-elementor-widget-icon eicon-archive-posts';
	}

	public function get_categories() {
		return array( 'alpha_archive_widget' );
	}

	public function get_keywords() {
		return array( 'archive', 'custom', 'layout', 'posts', 'cpt', 'loop', 'query', 'cards', 'custom post type' );
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
			'section_archive_posts',
			array(
				'label' => esc_html__( 'Content', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_responsive_control(
				'ap_column',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Columns', 'alpha-core' ),
					'options' => array(
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
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_nothing',
			array(
				'label' => esc_html__( 'Nothing Found', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'no_heading',
				array(
					'label'       => esc_html__( 'Heading', 'alpha-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Nothing Found', 'alpha-core' ),
				)
			);

			$this->add_control(
				'no_description',
				array(
					'label'       => esc_html__( 'Description', 'alpha-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'placeholder' => esc_html__( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'alpha-core' ),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {

		$preview_mode = apply_filters( 'alpha_archive_builder_set_preview', false );

		if ( $preview_mode ) {

			if ( apply_filters( 'alpha_archive_builder_can_render_posts', true, $preview_mode ) ) {

				$settings = $this->get_settings_for_display();

				$atts = array(
					'is_builder_rendering' => true,
					'no_heading'           => $settings['no_heading'],
					'no_description'       => $settings['no_description'],
					'column'               => $settings['ap_column'],
				);

				if ( 'product' === $preview_mode ) {
					global $alpha_layout;

					$this->original['products_column'] = $alpha_layout['products_column'];
					if ( (int) $atts['column'] ) {
						$alpha_layout['products_column'] = (int) $atts['column'];
					}

					if ( woocommerce_product_loop() ) {

						/**
						 * Hook: woocommerce_before_shop_loop.
						 *
						 * @hooked woocommerce_output_all_notices - 10
						 * @removed woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );

						woocommerce_product_loop_start();

						if ( $GLOBALS['wp_query']->max_num_pages ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						$total    = alpha_wc_get_loop_prop( 'total', 0 );
						$per_page = alpha_wc_get_loop_prop( 'per_page', 0 );
						if ( ! ( 1 == $total || $total <= $per_page || -1 == $per_page || ( ! empty( $alpha_layout['loadmore_type'] ) && 'page' != $alpha_layout['loadmore_type'] ) ) ) {
							?>

							<div class="toolbox toolbox-pagination">

								<?php
								/**
								 * Hook: alpha_result_count.
								 *
								 * @added woocommerce_result_count
								 */
								do_action( 'alpha_wc_result_count' );

								/**
								 * Hook: woocommerce_after_shop_loop.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action( 'woocommerce_after_shop_loop' );
								?>

							</div>

							<?php
						}
					} else {
						alpha_wc_shop_top_sidebar();

						woocommerce_product_loop_start();

						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );

						woocommerce_product_loop_end();
					}

					$alpha_layout['products_column'] = $this->original['products_column'];
				} else {
					alpha_get_template_part( 'posts/archive', null, $atts );
				}
			}

			do_action( 'alpha_archive_builder_unset_preview' );
		}
	}
}

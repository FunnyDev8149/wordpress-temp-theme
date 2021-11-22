<?php
/**
 * Banner Partial
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register banner controls.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_controls' ) ) {

	function alpha_elementor_banner_controls( $self, $mode = '', $is_pb = false ) {

		$self->start_controls_section(
			'section_banner',
			array(
				'label' => esc_html__( 'Banner', 'alpha-core' ),
			)
		);

		if ( 'insert_number' == $mode ) {
			$self->add_control(
				'banner_insert',
				array(
					'label'   => esc_html__( 'Banner Index', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '2',
					'options' => array(
						'1'    => '1',
						'2'    => '2',
						'3'    => '3',
						'4'    => '4',
						'5'    => '5',
						'6'    => '6',
						'7'    => '7',
						'8'    => '8',
						'9'    => '9',
						'last' => esc_html__( 'At last', 'alpha-core' ),
					),
				)
			);
		}

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_banner_btn_cat' );

			$repeater->start_controls_tab(
				'tab_banner_content',
				array(
					'label' => esc_html__( 'Content', 'alpha-core' ),
				)
			);

				$repeater->add_control(
					'banner_item_type',
					array(
						'label'   => esc_html__( 'Type', 'alpha-core' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'text',
						'options' => array(
							'text'    => esc_html__( 'Text', 'alpha-core' ),
							'button'  => esc_html__( 'Button', 'alpha-core' ),
							'image'   => esc_html__( 'Image', 'alpha-core' ),
							'divider' => esc_html__( 'Divider', 'alpha-core' ),
						),
					)
				);

				/* Text Item */
				$repeater->add_control(
					'banner_text_content',
					array(
						'label'     => esc_html__( 'Content', 'alpha-core' ),
						'type'      => Controls_Manager::TEXTAREA,
						'default'   => esc_html__( 'Add Your Text Here', 'alpha-core' ),
						'condition' => array(
							'banner_item_type' => 'text',
						),
					)
				);

				$repeater->add_control(
					'banner_text_tag',
					array(
						'label'     => esc_html__( 'Tag', 'alpha-core' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'h2',
						'options'   => array(
							'h1'   => esc_html__( 'H1', 'alpha-core' ),
							'h2'   => esc_html__( 'H2', 'alpha-core' ),
							'h3'   => esc_html__( 'H3', 'alpha-core' ),
							'h4'   => esc_html__( 'H4', 'alpha-core' ),
							'h5'   => esc_html__( 'H5', 'alpha-core' ),
							'h6'   => esc_html__( 'H6', 'alpha-core' ),
							'p'    => esc_html__( 'p', 'alpha-core' ),
							'div'  => esc_html__( 'div', 'alpha-core' ),
							'span' => esc_html__( 'span', 'alpha-core' ),
						),
						'condition' => array(
							'banner_item_type' => 'text',
						),
					)
				);

				/* Button */
				$repeater->add_control(
					'banner_btn_text',
					array(
						'label'     => esc_html__( 'Text', 'alpha-core' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => esc_html__( 'Click here', 'alpha-core' ),
						'condition' => array(
							'banner_item_type' => 'button',
						),
					)
				);

				$repeater->add_control(
					'banner_btn_link',
					array(
						'label'     => esc_html__( 'Link Url', 'alpha-core' ),
						'type'      => Controls_Manager::URL,
						'default'   => array(
							'url' => '',
						),
						'condition' => array(
							'banner_item_type' => 'button',
						),
					)
				);

				alpha_elementor_button_layout_controls( $repeater, 'banner_item_type', 'button' );

				/* Image */
				$repeater->add_control(
					'banner_image',
					array(
						'label'     => esc_html__( 'Choose Image', 'alpha-core' ),
						'type'      => Controls_Manager::MEDIA,
						'default'   => array(
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
						'condition' => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_group_control(
					Group_Control_Image_Size::get_type(),
					array(
						'name'      => 'banner_image',
						'exclude'   => [ 'custom' ],
						'default'   => 'full',
						'separator' => 'none',
						'condition' => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_control(
					'img_link_to',
					array(
						'label'     => esc_html__( 'Link', 'alpha-core' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'none',
						'options'   => array(
							'none'   => esc_html__( 'None', 'alpha-core' ),
							'custom' => esc_html__( 'Custom URL', 'alpha-core' ),
						),
						'condition' => array(
							'banner_item_type' => 'image',
						),
					)
				);

				$repeater->add_control(
					'img_link',
					array(
						'label'       => esc_html__( 'Link', 'alpha-core' ),
						'type'        => Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'alpha-core' ),
						'condition'   => array(
							'img_link_to'      => 'custom',
							'banner_item_type' => 'image',
						),
						'show_label'  => false,
					)
				);

				$repeater->add_responsive_control(
					'banner_divider_width',
					array(
						'label'      => esc_html__( 'Width', 'alpha-core' ),
						'type'       => Controls_Manager::SLIDER,
						'default'    => array(
							'size' => 50,
						),
						'size_units' => array(
							'px',
							'%',
						),
						'range'      => array(
							'px' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
							'%'  => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
						),
						'condition'  => array(
							'banner_item_type' => 'divider',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_divider_height',
					array(
						'label'      => esc_html__( 'Height', 'alpha-core' ),
						'type'       => Controls_Manager::SLIDER,
						'default'    => array(
							'size' => 4,
						),
						'size_units' => array(
							'px',
							'%',
						),
						'range'      => array(
							'px' => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
							'%'  => array(
								'step' => 1,
								'min'  => 0,
								'max'  => 100,
							),
						),
						'condition'  => array(
							'banner_item_type' => 'divider',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-top-width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				$repeater->add_control(
					'banner_item_display',
					array(
						'label'     => esc_html__( 'Inline Item', 'alpha-core' ),
						'separator' => 'before',
						'type'      => Controls_Manager::SWITCHER,
					)
				);

				$repeater->add_control(
					'banner_item_aclass',
					array(
						'label' => esc_html__( 'Custom Class', 'alpha-core' ),
						'type'  => Controls_Manager::TEXT,
					)
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_banner_style',
				array(
					'label' => esc_html__( 'Style', 'alpha-core' ),
				)
			);

				$repeater->add_control(
					'banner_text_color',
					array(
						'label'     => esc_html__( 'Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'banner_item_type' => 'text',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text' => 'color: {{VALUE}};',
						),
					)
				);
				$repeater->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'      => 'banner_text_typo',
						'condition' => array(
							'banner_item_type!' => array( 'image', 'divider' ),
						),
						'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text, .elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn',
					)
				);

				$repeater->add_control(
					'divider_color',
					array(
						'label'     => esc_html__( 'Color', 'alpha-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'banner_item_type' => 'divider',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-color: {{VALUE}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_image_width',
					array(
						'label'      => esc_html__( 'Width', 'alpha-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array(
							'px',
							'%',
						),
						'condition'  => array(
							'banner_item_type' => 'image',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .banner-item{{CURRENT_ITEM}}.image, .elementor-element-{{ID}} .banner-item{{CURRENT_ITEM}} .image' => 'width: {{SIZE}}{{UNIT}}',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_btn_border_radius',
					array(
						'label'      => esc_html__( 'Border Radius', 'alpha-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array(
							'px',
							'%',
							'em',
						),
						'condition'  => array(
							'banner_item_type!' => 'text',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn,  .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn, .elementor-element-{{ID}} {{CURRENT_ITEM}}.image, .elementor-element-{{ID}} {{CURRENT_ITEM}} .image, .elementor-element-{{ID}} {{CURRENT_ITEM}}.divider-wrap, .elementor-element-{{ID}} {{CURRENT_ITEM}} .divider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_btn_border_width',
					array(
						'label'      => esc_html__( 'Border Width', 'alpha-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%', 'em' ),
						'condition'  => array(
							'banner_item_type' => 'button',
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_item_margin',
					array(
						'label'      => esc_html__( 'Margin', 'alpha-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%', 'em' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'banner_item_padding',
					array(
						'label'      => esc_html__( 'Padding', 'alpha-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'default'    => array(
							'unit' => 'px',
						),
						'condition'  => array(
							'banner_item_type!' => 'divider',
						),
						'size_units' => array( 'px', 'em', 'rem', '%' ),
						'selectors'  => array(
							'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn,  .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn, .elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text, .elementor-element-{{ID}} {{CURRENT_ITEM}}.image, .elementor-element-{{ID}} {{CURRENT_ITEM}} .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$repeater->add_responsive_control(
					'_animation',
					array(
						'label'              => esc_html__( 'Entrance Animation', 'alpha-core' ),
						'type'               => Controls_Manager::ANIMATION,
						'frontend_available' => true,
						'separator'          => 'before',
					)
				);

				$repeater->add_control(
					'animation_duration',
					array(
						'label'        => esc_html__( 'Animation Duration', 'alpha-core' ),
						'type'         => Controls_Manager::SELECT,
						'default'      => '',
						'options'      => array(
							'slow' => esc_html__( 'Slow', 'alpha-core' ),
							''     => esc_html__( 'Normal', 'alpha-core' ),
							'fast' => esc_html__( 'Fast', 'alpha-core' ),
						),
						'prefix_class' => 'animated-',
						'condition'    => array(
							'_animation!' => '',
						),
					)
				);

				$repeater->add_control(
					'_animation_delay',
					array(
						'label'              => esc_html__( 'Animation Delay', 'alpha-core' ) . ' (ms)',
						'type'               => Controls_Manager::NUMBER,
						'default'            => '',
						'min'                => 0,
						'step'               => 100,
						'condition'          => array(
							'_animation!' => '',
						),
						'render_type'        => 'none',
						'frontend_available' => true,
					)
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'banner_item_floating',
				array(
					'label' => esc_html__( 'Floating', 'alpha-core' ),
				)
			);

				alpha_elementor_addon_controls( $repeater, true );

			$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$presets = array(
			array(
				'banner_item_type'    => 'text',
				'banner_item_display' => '',
				'banner_text_content' => esc_html__( 'This is a simple banner', 'alpha-core' ),
				'banner_text_tag'     => 'h3',
			),
			array(
				'banner_item_type'    => 'text',
				'banner_item_display' => '',
				'banner_text_content' => sprintf( esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nummy nibh %seuismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'alpha-core' ), '<br/>' ),
				'banner_text_tag'     => 'p',
			),
			array(
				'banner_item_type'    => 'button',
				'banner_item_display' => 'yes',
				'banner_btn_text'     => esc_html__( 'Click here', 'alpha-core' ),
				'button_type'         => '',
				'button_skin'         => 'btn-white',
			),
		);

		$self->add_control(
			'banner_background_heading',
			array(
				'label' => esc_html__( 'Background', 'alpha-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'banner_background_color',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eee',
				'selectors' => array(
					'.elementor-element-{{ID}} .banner' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'banner_background_image',
			array(
				'label'   => esc_html__( 'Choose Image', 'alpha-core' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => defined( 'ALPHA_ASSETS' ) ? ( ALPHA_ASSETS . '/images/placeholders/banner-placeholder.jpg' ) : \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$self->add_control(
			'banner_items_heading',
			array(
				'label'     => esc_html__( 'Content', 'alpha-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'banner_text_color',
			array(
				'label'     => esc_html__( 'Color', 'alpha-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .banner' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_text_align',
			array(
				'label'     => esc_html__( 'Text Align', 'alpha-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'alpha-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'alpha-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'alpha-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'alpha-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .banner-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'banner_item_list',
			array(
				'label'       => esc_html__( 'Content Items', 'alpha-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $presets,
				'title_field' => sprintf( '{{{ banner_item_type == "text" ? \'%1$s\' : ( banner_item_type == "image" ? \'%2$s\' : ( banner_item_type == "button" ? \'%3$s\' : \'%4$s\' ) ) }}}  {{{ banner_item_type == "text" ? banner_text_content : ( banner_item_type == "image" ? banner_image[\'url\'] : ( banner_item_type == "button" ?  banner_btn_text : \'%5$s\' ) ) }}}', '<i class="eicon-t-letter"></i>', '<i class="eicon-image"></i>', '<i class="eicon-button"></i>', '<i class="eicon-divider"></i>', esc_html__( 'Divider', 'alpha-core' ) ),
			)
		);

		$self->end_controls_section();

		/* Banner Style */
		$self->start_controls_section(
			'section_banner_style',
			array(
				'label' => esc_html__( 'Banner Wrapper', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'stretch_height',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Stretch Height', 'alpha-core' ),
					'description' => esc_html__( 'You can make your banner height full of its parent', 'alpha-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_img_pos',
				array(
					'label'     => esc_html__( 'Image Position (%)', 'alpha-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'%' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .banner-img img' => 'object-position: {{SIZE}}%;',
					),
				)
			);

			$self->add_responsive_control(
				'banner_max_height',
				array(
					'label'      => esc_html__( 'Max Height', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
					),
					'selectors'  => array(
						$is_pb ? '.elementor-element-{{ID}} .banner' : '{{WRAPPER}}, .elementor-element-{{ID}} .banner, .elementor-element-{{ID}} img' => 'max-height:{{SIZE}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$self->add_responsive_control(
				'banner_min_height',
				array(
					'label'      => esc_html__( 'Min Height', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'unit' => 'px',
						'size' => 450,
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vh'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner' => 'min-height:{{SIZE}}{{UNIT}};',
					),
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'banner_layer_layout',
			array(
				'label' => esc_html__( 'Banner Content', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'banner_origin',
				array(
					'label'   => esc_html__( 'Origin X, Y', 'alpha-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 't-mc',
					'options' => array(
						't-none' => esc_html__( '---------- ----------', 'alpha-core' ),
						't-m'    => esc_html__( '---------- Center', 'alpha-core' ),
						't-c'    => esc_html__( 'Center ----------', 'alpha-core' ),
						't-mc'   => esc_html__( 'Center Center', 'alpha-core' ),
					),
				)
			);

			$self->start_controls_tabs(
				'banner_position_tabs',
				array()
			);

			$self->start_controls_tab(
				'banner_pos_left_tab',
				array(
					'label' => esc_html__( 'Left', 'alpha-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_left',
				array(
					'label'      => esc_html__( 'Left Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'left:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_top_tab',
				array(
					'label' => esc_html__( 'Top', 'alpha-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_top',
				array(
					'label'      => esc_html__( 'Top Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'top:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_right_tab',
				array(
					'label' => esc_html__( 'Right', 'alpha-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_right',
				array(
					'label'      => esc_html__( 'Right Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'right:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_bottom_tab',
				array(
					'label' => esc_html__( 'Bottom', 'alpha-core' ),
				)
			);

			$self->add_responsive_control(
				'banner_bottom',
				array(
					'label'      => esc_html__( 'Bottom Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->end_controls_tabs();

			$self->add_control(
				'banner_wrap',
				array(
					'label'     => esc_html__( 'Wrap with', 'alpha-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'separator' => 'before',
					'options'   => array(
						''                => esc_html__( 'None', 'alpha-core' ),
						'container'       => esc_html__( 'Container', 'alpha-core' ),
						'container-fluid' => esc_html__( 'Container Fluid', 'alpha-core' ),
					),
				)
			);

			$self->add_responsive_control(
				'banner_width',
				array(
					'label'      => esc_html__( 'Width', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'max-width:{{SIZE}}{{UNIT}}; width: 100%',
					),
				)
			);

			$self->add_responsive_control(
				'banner_content_padding',
				array(
					'label'      => esc_html__( 'Padding', 'alpha-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'banner_effect',
			array(
				'label' => esc_html__( 'Banner Effect', 'alpha-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$self->add_control(
				'banner_image_effect',
				array(
					'label' => esc_html__( 'Image Effect', 'alpha-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$self->add_control(
				'overlay',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Hover Effect', 'alpha-core' ),
					'options' => array(
						''           => esc_html__( 'No', 'alpha-core' ),
						'light'      => esc_html__( 'Light', 'alpha-core' ),
						'dark'       => esc_html__( 'Dark', 'alpha-core' ),
						'zoom'       => esc_html__( 'Zoom', 'alpha-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'alpha-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'alpha-core' ),
						'effect-1'   => esc_html__( 'Effect 1', 'alpha-core' ),
						'effect-2'   => esc_html__( 'Effect 2', 'alpha-core' ),
						'effect-3'   => esc_html__( 'Effect 3', 'alpha-core' ),
						'effect-4'   => esc_html__( 'Effect 4', 'alpha-core' ),
					),
				)
			);

			$self->add_control(
				'banner_overlay_color',
				array(
					'label'     => esc_html__( 'Hover Effect Color', 'alpha-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .banner:before, .elementor-element-{{ID}} .banner:after, .elementor-element-{{ID}} .banner figure:before, .elementor-element-{{ID}} .banner figure:after' => 'background: {{VALUE}};',
						'.elementor-element-{{ID}} .overlay-dark:hover figure:after' => 'opacity: .5;',
					),
					'condition' => array(
						'overlay!' => '',
					),
				)
			);

			$self->add_control(
				'overlay_filter',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Hover Filter Effect', 'alpha-core' ),
					'options'   => array(
						''                   => esc_html__( 'No', 'alpha-core' ),
						'blur(4px)'          => esc_html__( 'Blur', 'alpha-core' ),
						'brightness(1.5)'    => esc_html__( 'Brightness', 'alpha-core' ),
						'contrast(1.5)'      => esc_html__( 'Contrast', 'alpha-core' ),
						'grayscale(1)'       => esc_html__( 'Greyscale', 'alpha-core' ),
						'hue-rotate(270deg)' => esc_html__( 'Hue Rotate', 'alpha-core' ),
						'opacity(0.5)'       => esc_html__( 'Opacity', 'alpha-core' ),
						'saturate(3)'        => esc_html__( 'Saturate', 'alpha-core' ),
						'sepia(0.5)'         => esc_html__( 'Sepia', 'alpha-core' ),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .banner img' => 'transition: filter .3s;',
						'.elementor-element-{{ID}} .banner:hover img' => 'filter: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'background_effect',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Backgrund Effect', 'alpha-core' ),
					'options'     => array(
						''                   => esc_html__( 'No', 'alpha-core' ),
						'kenBurnsToRight'    => esc_html__( 'kenBurnsRight', 'alpha-core' ),
						'kenBurnsToLeft'     => esc_html__( 'kenBurnsLeft', 'alpha-core' ),
						'kenBurnsToLeftTop'  => esc_html__( 'kenBurnsLeftTop', 'alpha-core' ),
						'kenBurnsToRightTop' => esc_html__( 'kenBurnsRightTop', 'alpha-core' ),
					),
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Please avoid giving %2$sHover Effect%3$s and %2$sBackground Effect%3$s together.%4$s', 'alpha-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
				)
			);

			$self->add_control(
				'background_effect_duration',
				array(
					'label'      => esc_html__( 'Background Effect Duration (s)', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						's',
					),
					'default'    => array(
						'size' => 30,
						'unit' => 's',
					),
					'range'      => array(
						's' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 60,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .background-effect' => 'animation-duration:{{SIZE}}s;',
					),
					'condition'  => array(
						'background_effect!' => '',
					),
				)
			);

			$self->add_control(
				'particle_effect',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Particle Effects', 'alpha-core' ),
					'options' => array(
						''         => esc_html__( 'No', 'alpha-core' ),
						'snowfall' => esc_html__( 'Snowfall', 'alpha-core' ),
						'sparkle'  => esc_html__( 'Sparkle', 'alpha-core' ),
					),
				)
			);

			$self->add_control(
				'parallax',
				array(
					'type'  => Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Enable Parallax', 'alpha-core' ),
				)
			);

			$self->add_control(
				'banner_content_effect',
				array(
					'label'     => esc_html__( 'Content Effect', 'alpha-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$self->add_responsive_control(
				'_content_animation',
				array(
					'label'              => esc_html__( 'Content Entrance Animation', 'alpha-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
				)
			);

			$self->add_control(
				'content_animation_duration',
				array(
					'label'        => esc_html__( 'Animation Duration', 'alpha-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						'slow' => esc_html__( 'Slow', 'alpha-core' ),
						''     => esc_html__( 'Normal', 'alpha-core' ),
						'fast' => esc_html__( 'Fast', 'alpha-core' ),
					),
					'prefix_class' => 'animated-',
					'condition'    => array(
						'_content_animation!' => '',
					),
				)
			);

			$self->add_control(
				'_content_animation_delay',
				array(
					'label'              => esc_html__( 'Animation Delay', 'alpha-core' ) . ' (ms)',
					'type'               => Controls_Manager::NUMBER,
					'default'            => '',
					'min'                => 0,
					'step'               => 100,
					'condition'          => array(
						'_content_animation!' => '',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

		$self->end_controls_section();

		$self->start_controls_section(
			'parallax_options',
			array(
				'label'     => esc_html__( 'Parallax', 'alpha-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'parallax' => 'yes',
				),
			)
		);

			$self->add_control(
				'parallax_speed',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Parallax Speed', 'alpha-core' ),
					'condition' => array(
						'parallax' => 'yes',
					),
					'default'   => array(
						'size' => 1,
						'unit' => 'px',
					),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
				)
			);

			$self->add_control(
				'parallax_offset',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Parallax Offset', 'alpha-core' ),
					'condition'  => array(
						'parallax' => 'yes',
					),
					'default'    => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
				)
			);

			$self->add_control(
				'parallax_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Parallax Height (%)', 'alpha-core' ),
					'condition'  => array(
						'parallax' => 'yes',
					),
					'separator'  => 'after',
					'default'    => array(
						'size' => 200,
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
				)
			);

		$self->end_controls_section();
	}
}

/**
 * Render banner.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_products_render_banner' ) ) {
	function alpha_products_render_banner( $self, $atts ) {
		$atts['self'] = $self;
		require alpha_core_framework_path( ALPHA_CORE_FRAMEWORK_PATH . '/widgets/banner/render-banner-elementor.php' );
	}
}


/**
 * Register elementor layout controls for section & column banner.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_layout_controls' ) ) {
	function alpha_elementor_banner_layout_controls( $self, $condition_key ) {

		$self->add_responsive_control(
			'banner_min_height',
			array(
				'label'      => esc_html__( 'Min Height', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'condition'  => array(
					$condition_key => 'banner',
				),
				'selectors'  => array(
					'.elementor .elementor-element-{{ID}}' => 'min-height:{{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} > .elementor-container' => 'min-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_max_height',
			array(
				'label'      => esc_html__( 'Max Height', 'alpha-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'condition'  => array(
					$condition_key => 'banner',
				),
				'selectors'  => array(
					'.elementor .elementor-element-{{ID}}' => 'max-height:{{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} > .elementor-container' => 'max-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'banner_img_pos',
			array(
				'label'     => esc_html__( 'Image Position (%)', 'alpha-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'condition' => array(
					$condition_key => 'banner',
				),
				'selectors' => array(
					'{{WRAPPER}} .banner-img img' => 'object-position: {{SIZE}}%;',
				),
			)
		);

		$self->add_control(
			'overlay',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Banner Overlay', 'alpha-core' ),
				'options'   => array(
					''           => esc_html__( 'No', 'alpha-core' ),
					'light'      => esc_html__( 'Light', 'alpha-core' ),
					'dark'       => esc_html__( 'Dark', 'alpha-core' ),
					'zoom'       => esc_html__( 'Zoom', 'alpha-core' ),
					'zoom_light' => esc_html__( 'Zoom and Light', 'alpha-core' ),
					'zoom_dark'  => esc_html__( 'Zoom and Dark', 'alpha-core' ),
				),
				'condition' => array(
					$condition_key => 'banner',
				),
			)
		);
	}
}


/**
 * Register elementor layout controls for column banner layer.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_elementor_banner_layer_layout_controls' ) ) {
	function alpha_elementor_banner_layer_layout_controls( $self, $condition_key ) {

		$self->start_controls_section(
			'banner_layer_layout',
			array(
				'label'     => esc_html__( 'Banner Layer', 'alpha-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					$condition_key => 'banner_layer',
				),
			)
		);
			$self->add_control(
				'banner_text_align',
				array(
					'label'     => esc_html__( 'Text Align', 'alpha-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'alpha-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'alpha-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'alpha-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justify', 'alpha-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_control(
				'banner_origin',
				array(
					'label'     => esc_html__( 'Origin', 'alpha-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						't-m'  => array(
							'title' => esc_html__( 'Vertical Center', 'alpha-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						't-c'  => array(
							'title' => esc_html__( 'Horizontal Center', 'alpha-core' ),
							'icon'  => 'eicon-h-align-center',
						),
						't-mc' => array(
							'title' => esc_html__( 'Center', 'alpha-core' ),
							'icon'  => 'eicon-frame-minimize',
						),
					),
					'default'   => 't-mc',
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->start_controls_tabs( 'banner_position_tabs' );

			$self->start_controls_tab(
				'banner_pos_left_tab',
				array(
					'label'     => esc_html__( 'Left', 'alpha-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_left',
				array(
					'label'      => esc_html__( 'Left Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'left:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_top_tab',
				array(
					'label'     => esc_html__( 'Top', 'alpha-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_top',
				array(
					'label'      => esc_html__( 'Top Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'size' => 50,
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'top:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_right_tab',
				array(
					'label'     => esc_html__( 'Right', 'alpha-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_right',
				array(
					'label'      => esc_html__( 'Right Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'banner_pos_bottom_tab',
				array(
					'label'     => esc_html__( 'Bottom', 'alpha-core' ),
					'condition' => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_bottom',
				array(
					'label'      => esc_html__( 'Bottom Offset', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->end_controls_tab();

			$self->end_controls_tabs();

			$self->add_responsive_control(
				'banner_width',
				array(
					'label'      => esc_html__( 'Width', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
					),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'max-width:{{SIZE}}{{UNIT}};width: 100%;',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

			$self->add_responsive_control(
				'banner_height',
				array(
					'label'      => esc_html__( 'Height', 'alpha-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 1000,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'default'    => array(
						'unit' => '%',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'height:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						$condition_key => 'banner_layer',
					),
				)
			);

		$self->end_controls_section();
	}
}

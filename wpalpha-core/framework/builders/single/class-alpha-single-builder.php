<?php
/**
 * Alpha Single Builder
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

define( 'ALPHA_SINGLE_BUILDER', ALPHA_BUILDERS . '/single' );

use Elementor\Controls_Manager;

class Alpha_Template_Single_Builder extends Alpha_Base {

	/**
	 * Widgets
	 *
	 * @access protected
	 * @var array[string] $widgets
	 * @since 1.0
	 */
	protected $widgets = array();

	/**
	 * The post
	 *
	 * @access protected
	 * @var object $post
	 * @since 1.0
	 */
	protected $post;

	/**
	 * Preview Mode
	 *
	 * @access protected
	 * @var string $preview_mode
	 * @since 1.0
	 */
	protected $preview_mode = '';

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->widgets = apply_filters(
			'alpha_single_widgets',
			array(
				'title',
				'date',
				'excerpt',
				'content',
				'image',
				'author_box',
				'comments',
				'navigation',
				'related_posts',
				'meta',
				'tags',
			)
		);
		// setup builder
		add_action( 'init', array( $this, 'find_preview' ) );  // for editor preview
		add_action( 'wp', array( $this, 'find_preview' ), 1 ); // for template view
		add_filter( 'alpha_run_single_builder', array( $this, 'run_template' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );

		// setup or unset preview
		add_action( 'alpha_before_template', array( $this, 'set_preview' ) );
		add_filter( 'alpha_single_builder_set_preview', array( $this, 'set_preview' ) );
		add_action( 'alpha_single_builder_unset_preview', array( $this, 'unset_preview' ) );

		// apply preview
		add_action( 'wp_ajax_alpha_single_builder_preview_apply', array( $this, 'apply_preview' ) );

		// Add controls
		add_filter( 'alpha_layout_get_controls', array( $this, 'add_layout_builder_control' ) );
		add_filter( 'alpha_layout_builder_display_parts', array( $this, 'add_layout_builder_display_parts' ) );
		add_filter( 'alpha_layout_builder_block_parts', array( $this, 'add_layout_builder_block_parts' ) );
		add_action( 'elementor/documents/register_controls', array( $this, 'register_elementor_preview_controls' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
	}

	/**
	 * Find a post for preview in editors and template view.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function find_preview() {

		global $post;
		if ( ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'elementor_ajax' == $_REQUEST['action'] ) || ( doing_action( 'wp' ) && ALPHA_NAME . '_template' == get_post_type() && 'single' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ||
			doing_action( 'init' ) && ( alpha_is_elementor_preview() || alpha_is_wpb_preview() ) &&
			isset( $_GET['post'] ) && ALPHA_NAME . '_template' == get_post_type( (int) $_GET['post'] ) && 'single' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) ) ) {

			$post_id = 0;

			if ( ! empty( $_REQUEST['post'] ) ) {
				$post_id = (int) $_REQUEST['post'];
			}
			if ( defined( 'ELEMENTOR_VERSION' ) && ! empty( $_REQUEST['editor_post_id'] ) ) {
				$post_id = (int) $_REQUEST['editor_post_id'];
			}
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$preview_mode       = get_post_meta( $post_id, 'preview', true );
			$this->preview_mode = $preview_mode ? $preview_mode : 'post';

			$posts = get_posts(
				array(
					'post_type'           => $this->preview_mode,
					'post_status'         => 'publish',
					'numberposts'         => 1,
					'ignore_sticky_posts' => true,
				)
			);

			if ( ! empty( $posts ) ) {
				$this->post = $posts[0];
			}
		}
	}

	/**
	 * Run builder template
	 *
	 * @since 1.0
	 * @access public
	 * @param boolean $run
	 * @return boolean $run
	 */
	public function run_template( $run ) {

		global $post;
		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'single' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			the_content();
			return true;

		} else {

			global $alpha_layout;
			if ( ! empty( $alpha_layout['single_content'] ) && is_numeric( $alpha_layout['single_content'] ) ) {

				$template = (int) $alpha_layout['single_content'];
				do_action( 'alpha_before_single_template', $template );
				alpha_print_template( $template );
				do_action( 'alpha_after_single_template', $template );

				return true;
			}
		}

		return $run;
	}

	/**
	 * Apply preview mode in ajax
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function apply_preview() {
		if ( check_ajax_referer( 'alpha-core-nonce', 'nonce' ) ) {
			update_post_meta( (int) $_REQUEST['post_id'], 'preview', sanitize_title( $_REQUEST['mode'] ) );
		}
		die;
	}

	public function enqueue_scripts() {
		if ( $this->post ) {
			wp_enqueue_style( 'alpha-theme-single-post' );
		}
	}

	/**
	 * Get preview id
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_preview() {
		if ( $this->post ) {
			return $this->post;
		}
		return false;
	}

	/**
	 * Setup environment
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_preview() {
		if ( $this->post ) {
			$GLOBALS['post'] = $this->post;
			setup_postdata( $this->post );
		}
		return true;
	}

	/**
	 * Clear environment
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function unset_preview() {
		if ( $this->post ) {
			wp_reset_postdata();
		}
	}

	/**
	 * Add single content template control for layout builder.
	 *
	 * @see alpha_layout_builder_controls
	 * @since 1.0.0
	 * @access public
	 * @param array $controls
	 * @return array $controls
	 */
	public function add_layout_builder_control( $controls ) {

		$single_value         = array(
			'type'  => 'block_single',
			'label' => esc_html__( 'Single Content Template', 'alpha-core' ),
		);
		$post_types_exclude   = apply_filters( 'alpha_condition_exclude_post_types', array( ALPHA_NAME . '_template', 'attachment', 'elementor_library' ) );
		$available_post_types = get_post_types( array( 'public' => true ), 'objects' );

		foreach ( $available_post_types as $post_type => $post_type_data ) {
			if ( ! in_array( $post_type, $post_types_exclude ) && apply_filters( 'alpha_layout_builder_is_available_single', true, $post_type ) && ! in_array( $post_type, array( 'page', 'product' ) ) ) {

				// Add single content template
				if ( empty( $controls[ 'content_single_' . $post_type ] ) || ! is_array( $controls[ 'content_single_' . $post_type ] ) ) {
					$controls[ 'content_single_' . $post_type ] = array();
				}
				$controls[ 'content_single_' . $post_type ] = array_merge(
					array( 'single_content' => $single_value ),
					$controls[ 'content_single_' . $post_type ]
				);
			}
		}

		return $controls;
	}

	/**
	 * Add single content template display parts for layout builder.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @see alpha_layout_builder_display_parts
	 * @param array $controls
	 * @return array $controls
	 */
	public function add_layout_builder_display_parts( $slugs ) {
		$slugs['single_content'] = array(
			'name'   => esc_html__( 'Single Content Template', 'alpha-core' ),
			'parent' => 'content_single_' . get_post_type(),
		);
		return $slugs;
	}

	/**
	 * Add archive single template block part for layout builder.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @see alpha_layout_builder_display_parts
	 * @param array $controls
	 * @return array $controls
	 */
	public function add_layout_builder_block_parts( $blocks ) {
		$blocks[] = 'single_content';
		return $blocks;
	}

	/**
	 * Add archive template's preview controls for elementor
	 *
	 * @since 1.0
	 * @access public
	 * @param object $document
	 */
	public function register_elementor_preview_controls( $document ) {
		if ( ! $document instanceof Elementor\Core\DocumentTypes\PageBase && ! $document instanceof Elementor\Modules\Library\Documents\Page ) {
			return;
		}

		// Add Template Builder Controls
		$id = (int) $document->get_main_id();

		if ( $id && ALPHA_NAME . '_template' == get_post_type( $id ) && 'single' == get_post_meta( $id, ALPHA_NAME . '_template_type', true ) ) {

			$options              = array();
			$post_types_exclude   = apply_filters( 'alpha_condition_exclude_post_types', array( ALPHA_NAME . '_template', 'attachment', 'elementor_library' ) );
			$available_post_types = get_post_types(
				array(
					'public'            => true,
					'show_in_nav_menus' => true,
				),
				'objects'
			);

			foreach ( $available_post_types as $post_type => $post_type_data ) {
				if ( ! in_array( $post_type, $post_types_exclude ) && apply_filters( 'alpha_layout_builder_is_available_single', true, $post_type ) && ! in_array( $post_type, array( 'page' ) ) ) {
					$options[ $post_type ] = $post_type_data->labels->singular_name;
				}
			}

			$document->start_controls_section(
				'single_preview_settings',
				array(
					'label' => esc_html__( 'Preview Settings', 'alpha-core' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				)
			);

			$document->add_control(
				'single_preview_type',
				array(
					'label'       => esc_html__( 'Preview Dynamic Content as', 'alpha-core' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'default'     => 'post',
					'groups'      => array(
						'single' => array(
							'label'   => esc_html__( 'Single', 'alpha-core' ),
							'options' => $options,
						),
					),
					'export'      => false,
				)
			);

			$document->add_control(
				'single_preview_apply',
				array(
					'type'        => Controls_Manager::BUTTON,
					'label'       => esc_html__( 'Apply & Preview', 'alpha-core' ),
					'label_block' => true,
					'show_label'  => false,
					'text'        => esc_html__( 'Apply & Preview', 'alpha-core' ),
					'separator'   => 'none',
				)
			);

			$document->end_controls_section();
		}
	}

	/**
	 * Register elementor category.
	 *
	 * @since 1.0
	 */
	public function register_elementor_category( $self ) {
		global $post;

		if ( $post && ALPHA_NAME . '_template' == $post->post_type && 'single' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true ) ) {
			$self->add_category(
				'alpha_single_widget',
				array(
					'title'  => ALPHA_DISPLAY_NAME . esc_html__( ' Single', 'alpha-core' ),
					'active' => true,
				)
			);
		}
	}

	/**
	 * Register elementor widgets.
	 *
	 * @since 1.0
	 */
	public function register_elementor_widgets( $self ) {
		global $post, $alpha_layout;

		$register = $post && ALPHA_NAME . '_template' == $post->post_type && 'single' == get_post_meta( $post->ID, ALPHA_NAME . '_template_type', true );

		if ( ! $register ) {
			global $alpha_layout;
			$register           = ! empty( $alpha_layout['single_content'] ) && is_numeric( $alpha_layout['single_content'] );
			$this->preview_mode = true;
		}

		if ( $register ) {
			foreach ( $this->widgets as $widget ) {
				require_once alpha_core_framework_path( ALPHA_BUILDERS . '/single/widgets/' . str_replace( '_', '-', $widget ) . '/widget-' . str_replace( '_', '-', $widget ) . '-elementor.php' );
				$class_name = 'Alpha_Single_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
				$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}
}

Alpha_Template_Single_Builder::get_instance();

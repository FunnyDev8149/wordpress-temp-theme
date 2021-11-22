<?php
/**
 * Alpha Admin Meta Boxes
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */
defined( 'ABSPATH' ) || die;

class Alpha_Admin_Meta_Boxes extends Alpha_Base {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Load meta box extensions
		if ( ! class_exists( 'MB_Tabs' ) ) {
			require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-tabs/meta-box-tabs.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/mb-rest-api/mb-rest-api.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/mb-settings-page/mb-settings-page.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/mb-term-meta/mb-term-meta.php' );
			require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-columns/meta-box-columns.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-conditional-logic/meta-box-conditional-logic.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-group/meta-box-group.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-include-exclude/meta-box-include-exclude.php' );
			// require_once alpha_core_framework_path( ALPHA_CORE_PLUGINS . '/meta-box/extensions/meta-box-show-hide/meta-box-show-hide.php' );
		}

		// Add video and more images to post
		add_filter( 'rwmb_meta_boxes', array( $this, 'add_meta_box' ) );

		// Add product category icon meta form fields.
		if ( class_exists( 'WooCommerce' ) ) {
			add_action( 'product_cat_edit_form_fields', array( $this, 'add_product_cat_fields' ), 100 );
			add_action( 'product_cat_add_form_fields', array( $this, 'add_product_cat_fields' ), 100 );
			add_action( 'created_term', array( $this, 'save_term_meta_box' ), 10, 3 );
			add_action( 'edit_term', array( $this, 'save_term_meta_box' ), 100, 3 );
		}
	}


	/**
	 * Comparison function for priority
	 *
	 * @since 1.0
	 */
	public function sort_priority( $a, $b ) {
		$ap = isset( $a['priority'] ) ? (int) $a['priority'] : 10;
		$bp = isset( $b['priority'] ) ? (int) $b['priority'] : 10;
		return $ap - $bp;
	}

	/**
	 * Add meta box.
	 *
	 * video and more images to post
	 *
	 * @since 1.0
	 */
	public function add_meta_box( $meta_boxes ) {
		// Get current edit page's post type.
		$post_type = '';
		if ( 'post-new.php' == $GLOBALS['pagenow'] ) {
			$post_type = empty( $_GET['post_type'] ) ? 'post' : $_GET['post_type'];
		} elseif ( 'post.php' == $GLOBALS['pagenow'] && isset( $_GET['action'] ) && ! empty( $_GET['post'] ) ) {
			$post_type = get_post_type( (int) $_GET['post'] );
		} else {
			return $meta_boxes;
		}

		if ( alpha_is_elementor_preview() && ALPHA_NAME . '_template' == $post_type && ( 'single' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) || 'archive' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) ) ) {
			do_action( 'alpha_core_dynamic_before_render', $post_type, (int) $_GET['post'] );
			$post_type = get_post_type();
		}

		// Define meta box tabs
		$meta_tabs = array(
			'titles'  => array(
				'label' => __( 'Page Titles', 'alpha-core' ),
				'icon'  => 'dashicons-heading',
			),
			'scripts' => array(
				'label' => __( 'Custom Scripts', 'alpha-core' ),
				'icon'  => 'dashicons-editor-code',
			),
		);

		// Define meta box fields
		$meta_fields = array(
			'page_title'    => array(
				'id'      => 'page_title',
				'name'    => __( 'Page Title', 'alpha-core' ),
				'desc'    => '',
				'type'    => 'text',
				'std'     => '',
				'columns' => 12,
				'tab'     => 'titles',
			),
			'page_subtitle' => array(
				'id'      => 'page_subtitle',
				'name'    => __( 'Page Subtitle', 'alpha-core' ),
				'desc'    => '',
				'type'    => 'text',
				'std'     => '',
				'columns' => 12,
				'tab'     => 'titles',
			),
			'page_css'      => array(
				'id'      => 'page_css',
				'name'    => __( 'Custom CSS', 'alpha-core' ),
				'type'    => 'textarea',
				'columns' => 12,
				'rows'    => 10,
				'tab'     => 'scripts',
			),
		);
		if ( current_user_can( 'unfiltered_html' ) ) {
			$meta_fields['page_js'] = array(
				'id'      => 'page_js',
				'name'    => __( 'Custom JS', 'alpha-core' ),
				'type'    => 'textarea',
				'columns' => 12,
				'rows'    => 10,
				'tab'     => 'scripts',
			);
		}

		// Fields for Posts
		if ( 'post' == $post_type ) {
			$meta_tabs['post']               = array(
				'label'    => __( 'Post Options', 'alpha-core' ),
				'icon'     => 'dashicons-admin-post',
				'priority' => 5,
			);
			$meta_fields['supported_images'] = array(
				'id'                => 'supported_images',
				'type'              => 'file_advanced',
				'name'              => esc_html__( 'Supported Images', 'alpha-core' ),
				'save_field'        => true,
				'label_description' => esc_html__( 'These images will be shown as slider with Featured Image.', 'alpha-core' ),
				'tab'               => 'post',
			);
			$meta_fields['featured_video']   = array(
				'id'                => 'featured_video',
				'type'              => 'textarea',
				'name'              => esc_html__( 'Featured Video', 'alpha-core' ),
				'save_field'        => true,
				'label_description' => esc_html__( 'Input embed code or use shortcodes. ex) iframe-tag or', 'alpha-core' ) . ' [video src="url.mp4"]',
				'tab'               => 'post',
			);
		}

		$meta_tabs   = apply_filters( 'alpha_metabox_tabs', $meta_tabs, $post_type );
		$meta_fields = apply_filters( 'alpha_metabox_fields', $meta_fields, $post_type );

		uasort( $meta_tabs, array( $this, 'sort_priority' ) );
		usort( $meta_fields, array( $this, 'sort_priority' ) );

		$meta_boxes[] = array(
			'title'      => sprintf( esc_html__( '%s Options', 'alpha-core' ), ALPHA_DISPLAY_NAME ),
			'post_types' => get_post_types(),
			'tabs'       => $meta_tabs,
			'tab_style'  => 'left',
			'fields'     => $meta_fields,
		);

		if ( alpha_is_elementor_preview() && ALPHA_NAME . '_template' == $post_type && ( 'single' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) || 'archive' == get_post_meta( (int) $_GET['post'], ALPHA_NAME . '_template_type', true ) ) ) {
			do_action( 'alpha_core_dynamic_after_render', $post_type, (int) $_GET['post'] );
		}

		return $meta_boxes;
	}

	/**
	 * Add more form fields to product category.
	 *
	 * @since 1.0
	 */
	public function add_product_cat_fields( $tag ) {
		if ( is_object( $tag ) ) : ?>
			<tr class="form-field">
				<th scope="row"><label for="product_cat_icon"><?php esc_html_e( 'Category Icon', 'alpha-core' ); ?></label></th>
				<td>
					<input name="product_cat_icon" id="product_cat_icon" type="text" value="<?php echo esc_html( get_term_meta( $tag->term_id, 'product_cat_icon', true ) ); ?>" placeholder="<?php esc_attr_e( 'Input icon class here...', 'alpha-core' ); ?>">
				</td>
			</tr>
		<?php else : ?>
			<div class="form-field">
				<label for="product_cat_icon"><?php esc_html_e( 'Category Icon', 'alpha-core' ); ?></label>
				<input name="product_cat_icon" id="product_cat_icon" type="text" placeholder="<?php esc_attr_e( 'Input icon class here...', 'alpha-core' ); ?>">
			</div>
			<?php
		endif;
	}

	/**
	 * save form field meta box
	 *
	 * @since 1.0
	 */
	public function save_term_meta_box( $term_id, $tt_id, $taxonomy ) {
		if ( 'product_cat' == $taxonomy ) {
			if ( isset( $_POST['product_cat_icon'] ) ) {
				update_term_meta( $term_id, 'product_cat_icon', $_POST['product_cat_icon'] );
			} else {
				delete_term_meta( $term_id, 'product_cat_icon' );
			}
		}
	}
}

Alpha_Admin_Meta_Boxes::get_instance();

<?php
/**
 * The base configuration for Alpha Core FrameWork
 *
 * The framework/config.php defines framework_path and
 * adds all framework feature.
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */

/**
 * Defines Alpha Core FrameWork Version
 * Defines Alpha Core FrameWork Path
 */
define( 'ALPHA_CORE_FRAMEWORK_VERSION', '1.0.0-beta.1' );
define( 'ALPHA_CORE_FRAMEWORK_PATH', ALPHA_CORE_PATH . '/framework' );
define( 'ALPHA_CORE_FRAMEWORK_URI', ALPHA_CORE_URI . '/framework' );

/**
 * For theme developers
 *
 * You can override framework file by helping this function.
 * If you want to override framework/init.php, create 'inc' directory just inside of theme
 * and here you create init.php too. As a result inc/init.php is called by below function.
 *
 *
 * @param  string $path Full path of php, js, css file which is required.
 * @return string Returns filtered path if $path exists in inc directory, raw path otherwise.
 */
if ( ! function_exists( 'alpha_core_framework_path' ) ) {
	function alpha_core_framework_path( $path ) {
		return file_exists( str_replace( '/framework/', '/inc/', $path ) ) ? str_replace( '/framework/', '/inc/', $path ) : $path;
	}
}

/**
 * For theme developers
 *
 * You can override framework file by helping this function.
 * If you want to override framework/admin/admin.css, create 'inc' directory just inside of theme
 * and here you create admin/admin.css too. As a result inc/admin/admin.css is called by below function.
 *
 *
 * @param  string $short_path  Path in framework folder.
 * @return string Returns filtered uri if path exists in inc directory, raw uri otherwise.
 */
if ( ! function_exists( 'alpha_core_framework_uri' ) ) {
	function alpha_core_framework_uri( $short_path ) {
		return file_exists( ALPHA_CORE_PATH . '/inc' . $short_path ) ? ALPHA_CORE_URI . '/inc' . $short_path : ALPHA_CORE_FRAMEWORK_URI . $short_path;
	}
}

/**
 * Registers framework support for a given feature.
 *
 * Framework consists of features. If woocommerce feature isn't registered in theme,
 * framework doesn't require feature related file.
 *
 * @param array|string $features Features for framework. Likely core values include:
 *                      framework_support_pb_elementor
 *                      framework_support_pb_wpb
 *                      framework_support_plugin_woocommerce
 *                      framework_support_plugin_dokan
 *                      framework_support_admin_setup_wizard
 *                      ...
 */
if ( ! function_exists( 'alpha_add_feature' ) ) {
	function alpha_add_feature( $features ) {
		if ( empty( $features ) ) {
			return false;
		}
		if ( is_array( $features ) ) {
			foreach ( $features as $feature ) {
				add_theme_support( $feature );
			}
		} else {
			add_theme_support( $features );
		}
	}
}

/**
 * Allows a framework to de-register its support of a certain feature.
 *
 * Framework consists of features. If woocommerce feature isn't registered in theme,
 * framework doesn't require feature related file.
 *
 * @see alpha_add_feature()
 * @param array|string $features Features for framework.
 */
if ( ! function_exists( 'alpha_remove_feature' ) ) {
	function alpha_remove_feature( $features ) {
		if ( empty( $features ) ) {
			return false;
		}
		if ( is_array( $features ) ) {
			foreach ( $features as $feature ) {
				remove_theme_support( $feature );
			}
		} else {
			remove_theme_support( $features );
		}
	}
}

/**
 * Gets the framework support arguments passed when registering that support.
 *
 * Framework consists of features. If woocommerce feature isn't registered in theme,
 * framework doesn't require feature related file.
 *
 * @see alpha_add_feature()
 * @param string $feature The feature to check.
 */
if ( ! function_exists( 'alpha_get_feature' ) ) {
	function alpha_get_feature( $feature ) {
		if ( ! empty( $feature ) ) {
			return get_theme_support( $feature );
		}
	}
}

/**
 * Alpha FrameWork Setup Configuration
 *
 * Adds all framework supports. As you can see below, features are splitted by service.
 * You can filter features or remove framework supports. fs stands for framework support.
 *
 * @since 1.0
 */
if ( ! function_exists( 'alpha_setup' ) ) {
	function alpha_setup() {
		$addon_features   = apply_filters(
			'alpha_addon_features',
			array(
				'fs_addon_walker',
				'fs_addon_skeleton',
				'fs_addon_lazyload_image',
				'fs_addon_lazyload_menu',
				'fs_addon_live_search',
				'fs_addon_studio',
				'fs_addon_product_advanced_swatch',
				'fs_addon_product_custom_tabs',
				'fs_addon_product_frequently_bought_together',
				'fs_addon_product_catalog',
				'fs_addon_share',
				'fs_addon_vendors',
				'fs_addon_product_helpful_comments',
				'fs_addon_product_ordering',
				'fs_addon_product_brand',
				'fs_addon_product_360_gallery',
				'fs_addon_product_video_popup',
				'fs_addon_product_image_comments',
				'fs_addon_product_compare',
				'fs_addon_product_attribute_guide',
				'fs_addon_comments_pagination',
				'fs_addon_product_buy_now',
				'fs_addon_minicart_quantity_input',
				'fs_addon_gdpr',
			)
		);
		$pb_features      = apply_filters(
			'alpha_pb_features',
			array(
				'fs_pb_elementor',
				// 'fs_pb_wpb',
				'fs_pb_gutenberg',
			)
		);
		$plugin_features  = apply_filters(
			'alpha_plugin_features',
			array(
				'fs_plugin_dokan',
				'fs_plugin_woocommerce',
				'fs_plugin_wc-vendors',
				'fs_plugin_wcfm',
				'fs_plugin_wcmp',
			)
		);
		$builder_features = apply_filters(
			'alpha_builder_features',
			array(
				'fs_builder_block',
				'fs_builder_header',
				'fs_builder_footer',
				'fs_builder_popup',
				'fs_builder_sidebar',
				'fs_builder_singleproduct',
				'fs_builder_single',
				'fs_builder_archive',
			)
		);
		$admin_features   = apply_filters(
			'alpha_admin_features',
			array(
				'fs_admin_customize',
			)
		);
		// Product type features
		$pt_features = apply_filters(
			'alpha_pt_features',
			array(
				'fs_pt_1',
				'fs_pt_2',
				'fs_pt_3',
				'fs_pt_4',
				'fs_pt_5',
				'fs_pt_6',
				'fs_pt_7',
				'fs_pt_8',
				'fs_pt_list',
				'fs_pt_widget',
			)
		);
		// Product category type features
		$pct_features = apply_filters(
			'alpha_pct_features',
			array(
				'fs_pct_default',
				'fs_pct_frame',
				'fs_pct_banner',
				'fs_pct_simple',
				'fs_pct_icon',
				'fs_pct_classic',
				'fs_pct_classic-2',
				'fs_pct_ellipse',
				'fs_pct_ellipse-2',
				'fs_pct_group',
				'fs_pct_group-2',
				'fs_pct_label',
			)
		);
		// Single product type features
		$spt_features = apply_filters(
			'alpha_spt_features',
			array(
				'fs_spt_horizontal',
				'fs_spt_vertical',
				'fs_spt_grid',
				'fs_spt_masonry',
				'fs_spt_gallery',
				'fs_spt_sticky-info',
				'fs_spt_sticky-thumbs',
				'fs_spt_sticky-both',
			)
		);
		// Blog type features
		$bt_features = apply_filters(
			'alpha_bt_features',
			array(
				'fs_bt_default',
				'fs_bt_mask',
				'fs_bt_list',
				'fs_bt_list-xs',
				'fs_bt_widget',
			)
		);
		//For developers
		$extra_features     = apply_filters( 'alpha_extra_features', array() );
		$framework_features = array_merge(
			$addon_features,
			$pb_features,
			$plugin_features,
			$admin_features,
			$builder_features,
			$pt_features,
			$pct_features,
			$spt_features,
			$bt_features,
			$extra_features
		);
		alpha_add_feature( $framework_features );
	}
}

alpha_setup();
/**
 * Fires after setup Alpha Core FrameWork configuration.
 *
 * @since 1.0
 */
do_action( 'alpha_after_core_framework_config' );

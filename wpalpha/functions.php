<?php
/**
 * Theme Functions
 *
 * To use a child theme:
 *   @see http://codex.wordpress.org/Theme_Development
 *   @see http://codex.wordpress.org/Child_Themes
 *
 * To override certain functions (wrapped in a function_exists call):
 *   define them in child theme's functions.php file.
 *
 * For more information on hooks, actions, and filters:
 *   @see http://codex.wordpress.org/Plugin_API
 *
 * @author     FunnyWP
 * @package    WP Alpha
 * @subpackage Theme
 * @since      1.0
 */

// Direct load is not allowed
defined( 'ABSPATH' ) || die;

// Theme Name, Version and icon prefix
defined( 'ALPHA_NAME' ) || define( 'ALPHA_NAME', 'wpalpha' );
defined( 'ALPHA_DISPLAY_NAME' ) || define( 'ALPHA_DISPLAY_NAME', 'WP Alpha' );
defined( 'ALPHA_ICON_PREFIX' ) || define( 'ALPHA_ICON_PREFIX', 'w' );
define( 'ALPHA_ENVATO_CODE', '28487727' );
define( 'ALPHA_ADMIN_SKIN', 'dark' );
define( 'ALPHA_VERSION', ( is_child_theme() ? wp_get_theme( wp_get_theme()->template ) : wp_get_theme() )->version );
define( 'ALPHA_GAP', '10px' );
// Define script debug
defined( 'ALPHA_JS_SUFFIX' ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? define( 'ALPHA_JS_SUFFIX', '.js' ) : define( 'ALPHA_JS_SUFFIX', '.min.js' ) );
// Defines core name and slug if not defined.
define( 'ALPHA_CORE_NAME', 'WP Alpha Core' );
define( 'ALPHA_CORE_SLUG', 'wpalpha-core' );
define( 'ALPHA_CORE_PLUGIN_URI', 'wpalpha-core/alpha-core.php' );

// Define Constants
define( 'ALPHA_PATH', get_parent_theme_file_path() );                      // Template directory path
define( 'ALPHA_URI', get_parent_theme_file_uri() );                        // Template directory uri
define( 'ALPHA_SERVER_URI', 'http://funny-wp.com/wordpress/framework/' ); // Server uri
define( 'ALPHA_ASSETS', ALPHA_URI . '/assets' );                           // Template assets directory uri
define( 'ALPHA_CSS', ALPHA_ASSETS . '/css' );                              // Template css uri
define( 'ALPHA_JS', ALPHA_ASSETS . '/js' );                                // Template javascript uri
define( 'ALPHA_PART', 'templates' );                                       // Template parts


// FrameWork Config
require_once ALPHA_PATH . '/framework/config.php';
// Theme EntryPoint
require_once ALPHA_PATH . '/inc/theme-setup.php';
// FrameWork EntryPoint
require_once alpha_framework_path( ALPHA_FRAMEWORK_PATH . '/init.php' );

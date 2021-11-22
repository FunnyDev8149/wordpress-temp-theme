<?php
defined( 'ABSPATH' ) || die;

/**
 * Alpha Breadcrumb Widget Render
 *
 * @author     FunnyWP
 * @package    WP Alpha Core FrameWork
 * @subpackage Core
 * @since      1.0
 */


global $alpha_breadcrumb;

$alpha_breadcrumb = $atts;
do_action( 'alpha_breadcrumb', $atts );

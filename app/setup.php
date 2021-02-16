<?php
/**
 * Setup Projects
 */

namespace WBL_Projects;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	// Register Post type
	add_action( 'init', __NAMESPACE__ . '\register_post_type' );

	// Options page
	add_action( 'admin_menu', __NAMESPACE__ . '\add_settings_page_to_menu' );

	// Admin page archive indicator
	add_filter( 'display_post_states', __NAMESPACE__ . '\add_archive_indicator_in_admin_page_list', 10, 2);

}, 10);


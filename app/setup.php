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

	add_filter( 'post_type_archive_title', __NAMESPACE__ . '\set_archive_page_title', 10, 2 );
	add_filter( 'get_the_archive_description', __NAMESPACE__ . '\set_archive_page_description' );

}, 10);

/**
 *
 */
function set_archive_page_title( $title, $post_type ) {

	if ( $post_type == get_post_type() ) {
		if ( $post_id = get_post_type_archive_page() ) {
			$title = get_post_field( 'post_title', $post_id );
			$title = apply_filters( 'the_title', $title );
		}
	}

	return $title;
}
/**
 *
 */
function set_archive_page_description( $content ) {

	if ( is_projects_post_type_archive() ) {
		if ( $post_id = get_post_type_archive_page() ) {
			$content = get_post_field( 'post_content', $post_id );
			$content = apply_filters( 'the_content', $content );
		}
	}

	return $content;
}

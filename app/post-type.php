<?php

Namespace WBL_Projects;

/**
 * Get post type
 */
function get_post_type() {
	return 'wbl_project';
}

/**
 * Get default post type handle
 */
function get_post_type_handle() {
	return 'projects';
}

/**
 * Get post type name
 */
function get_post_type_name() {
	return __('Projects', 'wbl-projects');
}

/**
 * Register the Post Type
 *
 * @link https://github.com/johnbillion/extended-cpts
 */
function register_post_type() {

	register_extended_post_type(
		get_post_type(),
		[
			// Interface
			'labels' => [
				'name' => get_post_type_name(),
				'menu_name' => get_post_type_name()
			],
			'menu_icon'     => 'dashicons-calendar-alt',
			'menu_position' => 25,

			// Engine
			'has_archive'   => get_post_type_archive_slug(),
			'rewrite' => [
				'permastruct' => '/' . get_post_type_single_item_slug() . '/%' . get_post_type() . '%'
			],
			'show_in_rest' => true,
		],
		[
			# Override the base names used for labels:
			'singular' => __('Event', 'wbl-projects'),
			'plural'   => __('Events', 'wbl-projects'),
			'slug'     => 'project'
		]
	);
}

function get_post_type_archive_page() {
	return get_setting( 'post_type_archive_page' ) ?? null;
}

/**
 * Get archive slug for archive permalink
 */
function get_post_type_archive_slug() {

	// Set default slug
	$archive_slug = get_post_type_handle();

	/**
	 * If we have an archive page, overwrite the default archive slug
	 */
	if ( $archive_page = get_post_type_archive_page() ) {

		// Make sure archive page is not "page on front"
		if ( \get_option('page_on_front') != $archive_page ) {

			// Get page slug (including parent pages)
			$archive_page_slug = get_page_uri($archive_page);

			$archive_slug = $archive_page_slug ? $archive_page_slug : $archive_slug;
		}
	}

	return trim($archive_slug, '/');
}

/**
 * Get single item slug for permalink
 */
function get_post_type_single_item_slug() {

	$item_slug = get_setting( 'post_type_single_item_slug' ) ?? get_post_type();

	// We don't want no slashes at the outsides
	return trim($item_slug, '/');
}

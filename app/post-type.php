<?php

Namespace WBL_Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	# Register Post type
	add_action( 'init', __NAMESPACE__ . '\register_post_type' );

});

/**
 * Register the Post Type
 *
 * @link https://github.com/johnbillion/extended-cpts
 */
function register_post_type() {

	register_extended_post_type(
		get_post_type(),
		[
			# Interface
			'labels' => [
				'name' => get_post_type_name(),
				'menu_name' => get_post_type_name()
			],
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 25,

			# Engine
			'rewrite' => [
				'permastruct' => '/' . get_post_type_single_item_slug() . '/%' . get_post_type() . '%'
			],
			'show_in_rest' => true,
			'admin_cols' => apply_filters( 'wbl_projects_admin_cols', [
				'title',
				'date'
			] ),
		],
		[
			# Override the base names used for labels:
			'singular' => apply_filters( 'wbl_projects_post_type_singular_name', __('Project', 'wbl-projects') ),
			'plural'   => apply_filters( 'wbl_projects_post_type_plural_name', get_post_type_name() ),
			'slug'     => get_post_type_archive_slug()
		]
	);
}

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
	return apply_filters( 'wbl_projects_post_type_handle', 'projects' );
}

/**
 * Get post type name
 */
function get_post_type_name() {
	return apply_filters( 'wbl_projects_post_type_name', __('Projects', 'wbl-projects') );
}

/**
 * Get archive slug for archive permalink
 */
function get_post_type_archive_slug() {

	# Set default slug
	$archive_slug = get_post_type_handle();

	/**
	 * If we have an archive page, overwrite the default archive slug
	 */
	if ( $archive_page = get_post_type_archive_page() ) {

		# Make sure archive page is not "page on front"
		if ( \get_option('page_on_front') != $archive_page ) {

			# Get page slug (including parent pages)
			$archive_page_slug = get_page_uri($archive_page);

			$archive_slug = $archive_page_slug ? $archive_page_slug : $archive_slug;
		}
	}

	# We don't want no slashes at the outsides
	$archive_slug = trim($archive_slug, '/');

	# Allow theme to override the selected archive slug
	$archive_slug = apply_filters( 'wbl_projects_post_type_archive_slug', $archive_slug );

	return $archive_slug;
}

/**
 * Get single item slug for permalink
 */
function get_post_type_single_item_slug() {

	$item_slug = get_post_type_handle();

	return apply_filters( 'wbl_projects_post_type_single_item_slug', $item_slug );
}

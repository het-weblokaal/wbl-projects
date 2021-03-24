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
 * Get post type
 */
function get_post_type() {
	return 'wbl_project';
}

/**
 * Get post type name
 */
function get_post_type_name() {
	return apply_filters( 'wbl_projects_post_type_name', __('Projects', 'wbl-projects') );
}

/**
 * Get post type singular name
 */
function get_post_type_singular_name() {
	return apply_filters( 'wbl_projects_post_type_singular_name', __('Project', 'wbl-projects') );
}

/**
 * Get post type plural name
 */
function get_post_type_plural_name() {
	return apply_filters( 'wbl_projects_post_type_plural_name', get_post_type_name() );
}

/**
 * Get archive slug for archive permalink
 */
function get_post_type_archive_slug( $language = null ) {

	# Set default slug
	$archive_slug = sanitize_title(get_post_type_plural_name());

	/**
	 * If we have an archive page, overwrite the default archive slug
	 */
	if ( $archive_page = get_post_type_archive_page( $language ) ) {

		# Make sure archive page is not "page on front"
		if ( \get_option('page_on_front') != $archive_page ) {

			# Get page slug (including parent pages)
			if ( $archive_page_slug = get_page_uri($archive_page) ) {
				$archive_slug = $archive_page_slug;

				# We don't want no slashes at the outsides
				$archive_slug = trim($archive_slug, '/');
			}
		}
	}

	# Allow theme to override the archive slug
	return apply_filters( 'wbl_projects_post_type_archive_slug', $archive_slug );
}

/**
 * Get single item slug for permalink
 */
function get_post_type_single_item_slug() {

	$item_slug = sanitize_title(get_post_type_singular_name());



	# Allow theme to override the item slug
	return apply_filters( 'wbl_projects_post_type_single_item_slug', $item_slug );
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
			# Interface
			
			'labels' => [
				'name' => get_post_type_name(),
				'menu_name' => get_post_type_name()
			],
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 21,

			# Engine

			'rewrite' => [
				'slug' => get_post_type_single_item_slug()
			],
			'has_archive' => get_post_type_archive_slug(),
			'show_in_rest' => true,
			'admin_cols' => apply_filters( 'wbl_projects_admin_cols', [
				'title',
				'date' => [
					'title'    => 'Date',
					'default'  => 'DESC',
				]
			] ),
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'excerpt',
			]
		],
		[
			# Override the base names used for labels:
			'singular' => get_post_type_singular_name(),
			'plural'   => get_post_type_plural_name(),
		]
	);
}

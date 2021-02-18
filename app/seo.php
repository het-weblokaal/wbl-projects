<?php
/**
 * Setup support for SEO
 */

namespace WBL_Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	/**
	 * Slim SEO
	 *
	 * @link https://github.com/elightup/slim-seo/
	 */
	add_filter( 'slim_seo_meta_title', __NAMESPACE__ . '\manage_page_meta_title' );
	add_filter( 'slim_seo_meta_description', __NAMESPACE__ . '\manage_page_meta_description' );


}, 5 );

/**
 * Manage the Page Meta Title
 *
 * @return string
 */
function manage_page_meta_title( $meta_title ) {

	# Post archive page
	if ( is_post_type_archive() ) {

		# Set the meta title of the selected archive page
		if ( $post_id = get_post_type_archive_page() ) {
			$meta_title = get_seo_meta( $post_id, 'title' );
		}
	}

	return $meta_title;
}

/**
 * Manage the Page Meta Description
 *
 * @return string
 */
function manage_page_meta_description( $meta_description ) {

	if ( is_post_type_archive() ) {

		# Set the meta description of the selected archive page
		if ( $post_id = get_post_type_archive_page() ) {
			$meta_description = get_seo_meta( $post_id, 'description' );
		}
	}

	return $meta_description;
}

/**
 * Helper function for getting Slim SEO meta data
 *
 * @param int $post_id
 * @param string $meta_type (title or description)
 * @return string
 */
function get_seo_meta( $post_id, $meta_type ) {
	$seo_meta = '';
	$seo_data = get_post_meta( $post_id, 'slim_seo', true );

	if ($meta_type == 'title') {
		$seo_meta = $seo_data['title'] ?? wp_get_document_title();
	}
	elseif ($meta_type == 'description') {
		$seo_meta = $seo_data['description'] ?? '';
	}

	return $seo_meta;
}

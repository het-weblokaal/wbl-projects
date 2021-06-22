<?php
/**
 * Setup support for SEO
 * 
 * Currently we support: 
 * - Slim SEO (https://github.com/elightup/slim-seo/)
 */

namespace WBL\Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	// Slim SEO
	if (has_slim_seo()) {
		add_filter( 'slim_seo_meta_title', __NAMESPACE__ . '\slim_seo_meta_title_on_archive_page' );
		add_filter( 'slim_seo_meta_description', __NAMESPACE__ . '\slim_seo_meta_description_on_archive_page' );
	}
		
	// Default document title for archive page
	add_filter( 'document_title_parts', __NAMESPACE__ . '\set_document_title_on_projects_archive_page' );


}, 5 );

/**
 * Check for slim_seo
 *
 * @return boolean
 */
function has_slim_seo() {
	return defined('SLIM_SEO_FILE');
}

/**
 * Slim SEO Meta Title on archive page
 *
 * @return string
 */
function slim_seo_meta_title_on_archive_page( $title, $title_obj ) {

	// Check if we are on archive page and if we have an assigned page
	if ( is_post_type_archive( get_post_type() ) && has_post_type_archive_page() ) {
	
		$title = $title_obj->get_singular_value( get_post_type_archive_page_id() );
	}

	return $title;
}

/**
 * Slim SEO Meta Title on archive page
 *
 * @return string
 */
function slim_seo_meta_description_on_archive_page( $description, $description_obj ) {

	// Check if we are on archive page and if we have an assigned page
	if ( is_post_type_archive( get_post_type() ) && has_post_type_archive_page() ) {
	
		$description = $description_obj->get_singular_value( get_post_type_archive_page_id() );
	}

	return $description;
}

/**
 * Set the archive page document title
 * 
 * @link https://developer.wordpress.org/reference/functions/wp_get_document_title/
 * @return array
 */
function set_document_title_on_projects_archive_page( $document_title_parts ) {

	// Check if we are on archive page and if we have an assigned page
	if ( is_post_type_archive( get_post_type() ) && has_post_type_archive_page() ) {

		// Assign the archive page title
		$document_title_parts['title'] = get_the_title( get_post_type_archive_page_id() );
	}	

	return $document_title_parts;
}
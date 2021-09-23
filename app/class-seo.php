<?php

namespace WBL\Projects;

/**
 * Class SEO
 */
class SEO {

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		// Slim SEO
		add_filter( 'slim_seo_meta_title', __CLASS__ . '::slim_seo_meta_title_on_archive_page', 10, 2 );
		add_filter( 'slim_seo_meta_description', __CLASS__ . '::slim_seo_meta_description_on_archive_page', 10, 2 );
			
		// Default document title for archive page
		add_filter( 'document_title_parts', __CLASS__ . '::set_document_title_on_projects_archive_page' );
	}

	/**
	 * Slim SEO Meta Title on archive page
	 *
	 * @return string
	 */
	public static function slim_seo_meta_title_on_archive_page( $title, $title_obj ) {

		// Check if we are on archive page and if we have an assigned page
		if ( is_post_type_archive( PostType::get_post_type() ) && PostType::get_page_for_projects() ) {
		
			$title = $title_obj->get_singular_value( PostType::get_page_for_projects() );
		}

		return $title;
	}

	/**
	 * Slim SEO Meta Title on archive page
	 *
	 * @return string
	 */
	public static function slim_seo_meta_description_on_archive_page( $description, $description_obj ) {

		// Check if we are on archive page and if we have an assigned page
		if ( is_post_type_archive( PostType::get_post_type() ) && PostType::get_page_for_projects() ) {
		
			$description = $description_obj->get_singular_value( PostType::get_page_for_projects() );
		}

		return $description;
	}

	/**
	 * Set the archive page document title
	 * 
	 * @link https://developer.wordpress.org/reference/functions/wp_get_document_title/
	 * @return array
	 */
	public static function set_document_title_on_projects_archive_page( $document_title_parts ) {

		// Check if we are on archive page and if we have an assigned page
		if ( is_post_type_archive( PostType::get_post_type() ) && PostType::get_page_for_projects() ) {

			// Assign the archive page title
			$document_title_parts['title'] = get_the_title( PostType::get_page_for_projects() );
		}	

		return $document_title_parts;
	}


	/**
	 * Check for slim_seo
	 *
	 * @return boolean
	 */
	public static function has_slim_seo() {
		return defined('SLIM_SEO_FILE');
	}
}
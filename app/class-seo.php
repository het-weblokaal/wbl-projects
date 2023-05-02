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
	 * Get Slim SEO title
	 * 
	 * Copied from slim-seo/src/MetaTags/Title.php
	 */
	public static function slim_seo_get_title( $post_id = null ) {
		$post_id = $post_id ?: $this->get_queried_object_id();
		$data    = get_post_meta( $post_id, 'slim_seo', true );
		return $data['title'] ?? '';
	}

	/**
	 * Get Slim SEO description
	 * 
	 * Copied from slim-seo/src/MetaTags/Description.php
	 */
	public static function slim_seo_get_description( $post_id = null ) {
		$post_id = $post_id ?: $this->get_queried_object_id();
		$post    = get_post( $post_id );
		if ( ! $post ) {
			return '';
		}

		// Prevent showing description on password protected posts
		if ( post_password_required( $post ) ) {
			return __( 'There is no excerpt because this is a protected post.', 'slim-seo' );
		}

		// Use manual entered meta description if available.
		$data = get_post_meta( $post_id, 'slim_seo', true );
		if ( ! empty( $data['description'] ) ) {
			$this->is_manual = true;
			return $data['description'];
		}

		// Use post excerpt if available.
		if ( $post->post_excerpt ) {
			return $post->post_excerpt;
		}

		// Use post content (which page builders can change) at last.
		return apply_filters( 'slim_seo_meta_description_generated', $post->post_content, $post );
	}

	/**
	 * Slim SEO Meta Title on archive page
	 *
	 * @return string
	 */
	public static function slim_seo_meta_title_on_archive_page( $title ) {

		// Check if we are on archive page and if we have an assigned page
		if ( is_post_type_archive( PostType::get_post_type() ) ) {

			// Get the assigned archive page
			$archive_post_id = PostType::get_archive_page();

			if ($archive_post_id) {

				$title = self::slim_seo_get_title($archive_post_id);
			}
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
		if ( is_post_type_archive( PostType::get_post_type() ) ) {

			// Get the assigned archive page
			$archive_post_id = PostType::get_archive_page();

			if ($archive_post_id) {
					
				$description = self::slim_seo_get_description($archive_post_id);
			}
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
		if ( is_post_type_archive( PostType::get_post_type() ) && PostType::get_archive_page() ) {

			// Assign the archive page title
			$document_title_parts['title'] = get_the_title( PostType::get_archive_page() );
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
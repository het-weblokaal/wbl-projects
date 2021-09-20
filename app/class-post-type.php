<?php

namespace WBL\Projects;

/**
 * Class Admin
 */
class PostType {

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		add_action( 'init', __CLASS__.'::register_post_type' );
		
		// Admin page archive indicator
		add_filter( 'display_post_states', __CLASS__.'::add_archive_indicator_in_admin_page_list', 10, 2);
	}	

	/**
	 * Get the post type id
	 * 
	 * @return string
	 */
	public static function get_post_type()	{
		return 'wbl_project';
	}

	/**
	 * Get the post type name
	 * 
	 * @return string
	 */
	public static function get_name()	{
		return static::get_labels()['name'];
	}

	/**
	 * Get slug for the projects archive permalink
	 * 
	 * @return string
	 */
	public static function get_archive_slug()	{

		// Default archive slug
		$archive_slug = static::get_labels()['name'];

		// If we have an archive page, overwrite the archive slug
		if ( static::has_page_for_projects() ) {

			// Get archive page
			$archive_page = static::get_page_for_projects();

			// Make sure archive page is not "page on front"
			if ( $archive_page && \get_option('page_on_front') != $archive_page ) {

				// Get page slug (including parent pages)
				$archive_slug = get_page_uri($archive_page);
			}
		}

		// Allow themes to overwrite the slug
		$archive_slug = apply_filters( 'wbl/projects/post_type/archive_slug', $archive_slug );

		return sanitize_title( $archive_slug );
	}

	/**
	 * Get slug for single project permalink
	 * 
	 * @return string
	 */
	public static function get_single_slug() {

		// Allow themes to overwrite the slug
		$single_slug = apply_filters('wbl/projects/post_type/single_slug', static::get_labels()['singular_name'] );

		return sanitize_title( $single_slug );
	}

	/**
	 * Get the page assigned to the post-type archive
	 * 
	 * @return string
	 */
	public static function get_page_for_projects() {

		return Settings::get( 'page_for_projects' );
	}

	/**
	 * Get the post type labels
	 * 
	 * @return array
	 */
	public static function get_labels() {

		$labels = [
			'name'                     => _x( 'Projects', 'post type general name', 'wbl-projects' ),
			'menu_name'                => _x( 'Projects', 'post type general name', 'wbl-projects' ),
			'singular_name'            => _x( 'Project', 'post type singular name', 'wbl-projects' ),
			'add_new'                  => _x( 'Add New', 'post', 'wbl-projects' ),
			'add_new_item'             => __( 'Add New Project', 'wbl-projects' ),
			'edit_item'                => __( 'Edit Project', 'wbl-projects' ),
			'new_item'                 => __( 'New Project', 'wbl-projects' ),
			'view_item'                => __( 'View Project', 'wbl-projects' ),
			'view_items'               => __( 'View Projects', 'wbl-projects' ),
			'search_items'             => __( 'Search Projects', 'wbl-projects' ),
			'not_found'                => __( 'No projects found.', 'wbl-projects' ),
			'not_found_in_trash'       => __( 'No projects found in Trash.', 'wbl-projects' ),
			'parent_item_colon'        => null,
			'all_items'                => __( 'All Projects', 'wbl-projects' ),
			'archives'                 => __( 'Project Archives', 'wbl-projects' ),
			'attributes'               => __( 'Project Attributes', 'wbl-projects' ),
			'insert_into_item'         => __( 'Insert into project', 'wbl-projects' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this project', 'wbl-projects' ),
			'featured_image'           => _x( 'Featured image', 'post', 'wbl-projects' ),
			'set_featured_image'       => _x( 'Set featured image', 'post', 'wbl-projects' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'post', 'wbl-projects' ),
			'use_featured_image'       => _x( 'Use as featured image', 'post', 'wbl-projects' ),
			'filter_items_list'        => __( 'Filter projects list', 'wbl-projects' ),
			'filter_by_date'           => __( 'Filter by date', 'wbl-projects' ),
			'items_list_navigation'    => __( 'Projects list navigation', 'wbl-projects' ),
			'items_list'               => __( 'Projects list', 'wbl-projects' ),
			'item_published'           => __( 'Project published.', 'wbl-projects' ),
			'item_published_privately' => __( 'Project published privately.', 'wbl-projects' ),
			'item_reverted_to_draft'   => __( 'Project reverted to draft.', 'wbl-projects' ),
			'item_scheduled'           => __( 'Project scheduled.', 'wbl-projects' ),
			'item_updated'             => __( 'Project updated.', 'wbl-projects' ),
		];

		return apply_filters( 'wbl/projects/post_type/labels', $labels );
	}

	/**
	 * Get the admin columns
	 * 
	 * @return array
	 */
	private static function get_admin_columns() {

		$admin_columns = [
			'title',
			'date' => [
				'title'    => 'Date',
				'default'  => 'DESC',
			]
		];

		return apply_filters( 'wbl/projects/post_type/admin_columns', $admin_columns );
	}

	/**
	 * Get the supporting features
	 * 
	 * @return array
	 */
	private static function get_feature_support() {

		$feature_support = [
			'title',
			'editor',
			'thumbnail',
			'excerpt',
		];

		return apply_filters( 'wbl/projects/post_type/feature_support', $feature_support );
	}
	

	/**
	 * Register post type using Extended Post Type library
	 * 
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Registering-Post-Types
	 * @link https://developer.wordpress.org/reference/functions/register_post_type/
	 * @return void
	 */
	public static function register_post_type() {

		$args = [

			// Interface
			'labels'        => static::get_labels(),
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 21,

			// Engine
			'rewrite' => [
				'slug' => static::get_single_slug()
			],
			'has_archive'  => static::get_archive_slug(),
			'show_in_rest' => true,
			'admin_cols'   => static::get_admin_columns(),
			'supports' 	   => static::get_feature_support()
		];

		// Register
		register_extended_post_type( static::get_post_type(), $args );
	}


	/*--------------------------------------------------------------
	# Utilities 
	--------------------------------------------------------------*/

	/**
	 * Check if there is a page assigned to the post-type archive
	 * 
	 * @return boolean
	 */
	public static function has_page_for_projects() {

		return !! static::get_page_for_projects();
	}

	/**
	 * Show indicator which page is the projects archive page in page overview
	 */
	public static function add_archive_indicator_in_admin_page_list( $post_states, $post ) {

	    if ( static::get_page_for_projects() == $post->ID ) {
	        $post_states[static::get_archive_slug()] = sprintf( _x( '%s page','Indicator for archive in admin page list', 'wbl-projects' ), PostType::get_name() );
	    }

	    return $post_states;
	}

}
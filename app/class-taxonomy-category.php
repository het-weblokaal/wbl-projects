<?php

namespace WBL\Projects;

/**
 * Class Admin
 */
class TaxCategory {

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		/**
		 * Register before post_type to fix problem with permalinks
		 * 
		 * @link https://cnpagency.com/blog/the-right-way-to-do-wordpress-custom-taxonomy-rewrites/
		 */
		add_action( 'init', __CLASS__.'::register_taxonomy', 9 );
		
		// Add taxonomy to the list of projects in the admin
		add_filter( 'wbl/projects/post_type/admin_columns', __CLASS__.'::add_admin_cols' );
	}

	/**
	 * Get the taxonomy
	 * 
	 * @return string
	 */
	public static function get_taxonomy()	{
		return 'project_category';
	}

	/**
	 * Get the post type labels
	 * 
	 * @return array
	 */
	public static function get_labels() {

		$labels = [
			'name'                       => _x( 'Categories', 'taxonomy general name' ),
			'menu_name'                  => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' ),
			'popular_items'              => null,
			'all_items'                  => __( 'All Categories' ),
			'parent_item'                => __( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Category' ),
			'view_item'                  => __( 'View Category' ),
			'update_item'                => __( 'Update Category' ),
			'add_new_item'               => __( 'Add New Category' ),
			'new_item_name'              => __( 'New Category Name' ),
			'separate_items_with_commas' => null,
			'add_or_remove_items'        => null,
			'choose_from_most_used'      => null,
			'not_found'                  => __( 'No categories found.' ),
			'no_terms'                   => __( 'No categories' ),
			'filter_by_item'             => __( 'Filter by category' ),
			'items_list_navigation'      => __( 'Categories list navigation' ),
			'items_list'                 => __( 'Categories list' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'categories' ),
			'back_to_items'              => __( '&larr; Go to Categories' ),
		];

		return apply_filters( 'wbl/projects/taxonomy/'.static::get_taxonomy().'/labels', $labels );
	}

	/**
	 * Register taxonomies
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki/Registering-taxonomies
	 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
	 */
	public static function register_taxonomy() {

		// Add archive slug and taxonomy name to the taxonomy slug
		$tax_slug = PostType::get_archive_slug() . '/' . sanitize_title( static::get_labels()['singular_name'] );

		// Allow themes to override the taxonomy slug (for example to remove the archive slug from start)
		$tax_slug = apply_filters('wbl/projects/taxonomy/'.static::get_taxonomy().'/slug', $tax_slug );

		$args = [
			'labels' => static::get_labels(),
			'hierarchical' => false,
			'meta_box' => 'simple',
			'rewrite' => [
				'slug' => $tax_slug,
				'with_front' => false
			],
		];

		// Register the taxonomy
		register_extended_taxonomy( static::get_taxonomy(), PostType::get_post_type(), $args );
	}

	/*--------------------------------------------------------------
	# Utilities 
	--------------------------------------------------------------*/

	/**
	 * Add taxonomy to the list of projects in the admin
	 */
	public static function add_admin_cols( $admin_cols ) {

		$admin_cols[static::get_taxonomy()] = [
			'taxonomy' => static::get_taxonomy()
		];

		return $admin_cols;
	}
}
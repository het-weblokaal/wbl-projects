<?php
/**
 * Setup Projects
 */

namespace WBL\Projects;


/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	/**
	 * Inform WordPress of custom language directory
	 */
	add_action( 'init', function() {
		load_plugin_textdomain( 'wbl-projects', false, App::get_slug() . '/' . App::get_lang_dir() );
	} );

	// Fire classes
	PostType::setup();
	TaxCategory::setup();
	Admin::setup();
	Multilanguage::setup();
	SEO::setup();

	// Set archive title and description
	add_filter( 'post_type_archive_title', __NAMESPACE__ . '\set_archive_page_title', 10, 2 );
	add_filter( 'get_the_archive_description', __NAMESPACE__ . '\set_archive_page_description' );

	/**
	 * The filter is named rest_{post_type}_collection_params. So you need to hook a new filter for each 
	 * of the custom post types you need to sort.
	 * @link https://www.timrosswebdevelopment.com/wordpress-rest-api-post-order/
	 */
	add_filter( 'rest_' . PostType::get_post_type() . '_collection_params', __NAMESPACE__ . '\filter_add_rest_orderby_params', 10, 1 );

}, 10);


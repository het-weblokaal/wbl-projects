<?php

namespace WBL\Projects;

/**
 * Class Admin
 */
class Admin {

	/**
	 * Nonce value for security
	 */
	public static $nonce_value = 'save_wbl_projects_settings';

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		// Options page
		add_action( 'admin_menu', __CLASS__.'::register_menu_page' );

		// Admin page archive indicator
		add_filter( 'display_post_states', __CLASS__.'::add_archive_indicator_in_page_list', 10, 2);
	}	

	/**
	 * Register the menu page for the settings
	 */
	public static function register_menu_page() {

		add_submenu_page(
			'edit.php?post_type='.PostType::get_post_type(), // parent slug
			sprintf( _x('Settings for %s', 'wbl_project', 'wbl-projects'), PostType::get_name() ),
			__('Settings', 'wbl-projects'), // menu name
			'manage_options', // capability
			PostType::get_post_type() . '-settings', // page slug
			function () {
				require_once 'settings-page.php';
			},
		);
	}

	/**
	 * Save options page
	 */
	public static function try_save() {

		// Abort if no POST-data or no valid referer
		if ( empty($_POST) || !check_admin_referer(static::$nonce_value) ) {
			return false;
		}

		// Only save when we have a value
		if ($_POST[Settings::name('page_for_projects')]) {

			// Get value
			$page_for_projects = $_POST[Settings::name('page_for_projects')];

			// Sanitize
			$page_for_projects = sanitize_key($page_for_projects);

			// Save
			Settings::save('page_for_projects', $page_for_projects);

			// Flush
			flush_rewrite_rules();

			// Tell the world
			return true;
		}

		return false;
	}

	/**
	 * Show indicator which page is the projects archive page in page overview
	 */
	public static function add_archive_indicator_in_page_list( $post_states, $post ) {

	    $archive_pages = [ Settings::get('page_for_projects') ];

	    if (Multilanguage::has_polylang()) {
	    	foreach (pll_languages_list() as $language) {
	    		
	    		if ( $translated_archive_page = Multilanguage::get_translated_achive_page($language) ) {
	    			$archive_pages[] = $translated_archive_page;
	    		}
	    	}
	    }

	    if ( in_array( $post->ID, $archive_pages ) ) {
	        $post_states['page_for_projects'] = sprintf( _x( '%s page','Indicator for archive in admin page list', 'wbl-projects' ), PostType::get_name() );
	    }

	    return $post_states;
	}
}
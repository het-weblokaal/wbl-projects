<?php

namespace WBL\Projects;

/**
 * Class Admin
 */
class Settings {

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		// Options page
		add_action( 'admin_menu', __CLASS__.'::register_menu_page' );

	}	

	/**
	 * Get the setting
	 * 
	 * @return mixed
	 */
	public static function get( $key ) {

		$name = static::name($key);

		return get_option( $name, false );
	}

	/**
	 * Save the setting
	 * 
	 * @return void
	 */
	public static function save( $key, $value ) {

		$name = static::name($key);

		update_option( $name, $value );
	}

	/**
	 * Make the setting name
	 * 
	 * @return string
	 */
	private static function name( $key ) {

		return "wbl_projects_{$key}";
	}

	/**
	 * Nonce for checking admin pages
	 * 
	 * @return string
	 */
	public static function get_nonce_value() {
		return 'save_wbl_projects_settings';
	}

	// /**
	//  * Add a settings link to the the plugin on the plugin page
	//  *
	//  * @param array $links An array of plugin action links.
	//  *
	//  * @return array
	//  */
	// public static function settings_link( array $links ): array {
	// 	$href          = admin_url( 'edit.php?post_type='.PostType::get_post_type() );
	// 	$settings_link = '<a href="' . $href . '">' . __( 'Settings', 'wbl-projects' ) . '</a>'; // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
	// 	array_unshift( $links, $settings_link );

	// 	return $links;
	// }

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
				require_once App::inc_path( 'admin-settings-page.php' );
			},
		);
	}

	/**
	 * Save options page
	 */
	public static function try_save() {

		// Abort if no POST-data or no valid referer
		if ( empty($_POST) || !check_admin_referer(static::get_nonce_value()) ) {
			return false;
		}

		// Get options
		$page_for_projects = $_POST[static::name('page_for_projects')] ?? null;

		// Only save when we have a value
		if ($page_for_projects) {

			// Sanitize
			$page_for_projects = sanitize_key($page_for_projects);

			// Save
			static::save('page_for_projects', $page_for_projects);

			// Flush
			flush_rewrite_rules();

			// Saving succesful
			return true;
		}

		return false;
	}
}
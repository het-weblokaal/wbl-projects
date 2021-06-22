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
	public static function get_setting( $key ) {

		return get_option( static::setting_name($key), false );
	}

	/**
	 * Save the setting
	 * 
	 * @return void
	 */
	public static function save_setting( $key, $value ) {

		update_option( static::setting_name($key), $value );
	}

	/**
	 * Make the setting name
	 * 
	 * @return string
	 */
	private static function setting_name( $key ) {

		$setting_name = "wbl_projects_{$key}";

		// Add language prefix if applicable
		if ( Helpers::has_polylang() ) {

			$current_language = Helpers::get_current_language();

			if ( ! Helpers::is_default_language( $current_language ) ) {
				$setting_name .= '_' . $current_language;
			}
		}

		return $setting_name;
	}

	/**
	 * Nonce for checking admin pages
	 * 
	 * @return string
	 */
	public static function get_settings_nonce_value() {
		return 'save_wbl_projects_settings';
	}

	/**
	 * Add a settings link to the the plugin on the plugin page
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array
	 */
	public static function settings_link( array $links ): array {
		$href          = admin_url( 'edit.php?post_type='.PostType::get_post_type() );
		$settings_link = '<a href="' . $href . '">' . __( 'Settings', 'wbl-projects' ) . '</a>'; // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Register the menu page for the settings
	 */
	public static function register_menu_page() {

		add_submenu_page(
			'edit.php?post_type='.PostType::get_post_type(), // parent slug
			__('Project Settings', 'wbl-projects'), // page name
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
	public static function try_save_settings() {

		// Abort if no POST-data or no valid referer
		if ( empty($_POST) || !check_admin_referer(static::get_settings_nonce_value()) ) {
			return false;
		}

		// Get options
		$page_for_projects = $_POST[static::setting_name('page_for_projects')] ?? false;

		// Sanitize
		$page_for_projects = sanitize_key($page_for_projects);

		// Save
		static::save_setting('page_for_projects', $page_for_projects);

		// Flush
		flush_rewrite_rules();

		// Saving succesful
		return true;
	}
}
<?php
/**
 * WordPress App Class for Themes and Plugins
 *
 * Version: 1.0-alpha-4
 * Author: Erik Joling | Het Weblokaal <erik.info@hetweblokaal.nl>
 * Author URI: https://www.hetweblokaal.nl/
 *
 * This class offers an API for WordPress themes and plugins to standardize code organization.
 *
 *
 * Usage:
 * 1. Copy this file in the vendor folder (or wherever)
 * 2. Match the namespace to the theme/plugin
 * 3. Load the file
 * 4. Make use of the methods through static::<method>
 */

namespace WBL_Projects;

/**
 * App Class
 *
 * This is the base class which a WP Theme or Plugin App Class will use
 */
final class App {

	/**
	 * The Type of app. i.e. theme or plugin
	 *
	 * @var string
	 */
	private static $type;

	/**
	 * Sets the app file. The file which holds the metadata of this app (plugin or theme)
	 *
	 * @var string
	 */
	private static $meta_file;

	/**
	 * The id of the app. i.e. the handle, the directoryname
	 *
	 * @var string
	 */
	private static $id;

	/**
	 * The name of the app to show to endusers
	 *
	 * @var string
	 */
	private static $name;

	/**
	 * Directory path with trailing slash.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Directory URI with trailing slash.
	 *
	 * @var string
	 */
	private static $uri;

	/**
	 * Version
	 *
	 * @var string
	 */
	private static $version;

	/**
	 * Includes folder (relative to plugin/theme) for app setup and includes
	 *
	 * @var string
	 */
	private static $inc_dir;

	/**
	 * Public folder (relative to plugin/theme)
	 *
	 * @var string
	 */
	private static $assets_dir;

	/**
	 * Resource folder (relative to plugin/theme) for uncompiled code
	 *
	 * @var string
	 */
	private static $src_dir;

	/**
	 * Template folder (relative to plugin/theme)
	 *
	 * @var string
	 */
	private static $template_dir;

	/**
	 * Blocks folder (relative to plugin/theme)
	 *
	 * @var string
	 */
	private static $blocks_dir;

	/**
	 * Language folder (relative to plugin/theme)
	 *
	 * @var string
	 */
	private static $lang_dir;

	/**
	 * Vendor folder (relative to plugin/theme)
	 *
	 * @var string
	 */
	private static $vendor_dir;

	/**
	 * Laravel mix manifest
	 *
	 * @var string
	 */
	private static $mix_manifest = null;

	/**
	 * Constructor method.
	 *
	 * @return void
	 */
	private function __construct() {}


	/*=============================================================*/
	/**                        Getters                             */
	/*=============================================================*/

	/**
	 * Gets the app type
	 *
	 * @return string $type (theme or plugin)
	 */
	public static function get_type() {

		if ( is_null(static::$type) ) {
			static::set_type();
		}

		return static::$type;
	}

	/**
	 * Gets the app directory path with trailing slash.
	 *
	 * @return string
	 */
	public static function get_meta_file() {

		if ( is_null(static::$meta_file) ) {
			static::set_meta_file();
		}

		return static::$meta_file;
	}

	/**
	 * Gets the app id
	 *
	 * @return string $id
	 */
	public static function get_id() {

		if ( is_null(static::$id) ) {
			static::set_id();
		}

		return static::$id;
	}

	/**
	 * Gets the app name
	 *
	 * @return string $name
	 */
	public static function get_name() {

		if ( is_null(static::$name) ) {
			static::set_name();
		}

		return static::$name;
	}

	/**
	 * Gets the app directory path with trailing slash.
	 *
	 * @return string
	 */
	public static function get_dir() {

		if ( is_null(static::$dir) ) {
			static::set_dir();
		}

		return static::$dir;
	}

	/**
	 * Gets the app uri path with trailing slash.
	 *
	 * @return string
	 */
	public static function get_uri() {

		if ( is_null(static::$uri) ) {
			static::set_uri();
		}

		return static::$uri;
	}

	/**
	 * Gets the app version
	 *
	 * @return string
	 */
	public static function get_version() {

		if ( is_null(static::$version) ) {
			static::set_version();
		}

		return static::$version;
	}

	/**
	 * Gets the includes directory name
	 *
	 * @return string
	 */
	public static function get_inc_dir() {

		if ( is_null(static::$inc_dir) ) {
			static::set_inc_dir();
		}

		return static::$inc_dir;
	}

	/**
	 * Gets the app asset directory name
	 *
	 * @return string
	 */
	public static function get_assets_dir() {

		if ( is_null(static::$assets_dir) ) {
			static::set_assets_dir();
		}

		return static::$assets_dir;
	}

	/**
	 * Gets the app src directory name
	 *
	 * @return string
	 */
	public static function get_src_dir() {

		if ( is_null(static::$src_dir) ) {
			static::set_src_dir();
		}

		return static::$src_dir;
	}

	/**
	 * Gets the app template directory name
	 *
	 * @return string
	 */
	public static function get_template_dir() {

		if ( is_null(static::$template_dir) ) {
			static::set_template_dir();
		}

		return static::$template_dir;
	}

	/**
	 * Gets the app blocks directory name
	 *
	 * @return string
	 */
	public static function get_blocks_dir() {

		if ( is_null(static::$blocks_dir) ) {
			static::set_blocks_dir();
		}

		return static::$blocks_dir;
	}

	/**
	 * Gets the app language directory name
	 *
	 * @return string
	 */
	public static function get_lang_dir() {

		if ( is_null(static::$lang_dir) ) {
			static::set_lang_dir();
		}

		return static::$lang_dir;
	}

	/**
	 * Gets the app vendor directory name
	 *
	 * @return string
	 */
	public static function get_vendor_dir() {

		if ( is_null(static::$vendor_dir) ) {
			static::set_vendor_dir();
		}

		return static::$vendor_dir;
	}

	/**
	 * Gets the mix manifest content
	 *
	 * @return array | false
	 */
	private static function get_mix_manifest() {

		// Get manifest
		if ( is_null(static::$mix_manifest) ) {
			static::set_mix_manifest();
		}

		// Set manifest
		return static::$mix_manifest;
	}


	/*=============================================================*/
	/**                        Setters                             */
	/*=============================================================*/

	/**
	 * Sets the app file (root file)
	 *
	 * @return void
	 */
	private static function set_type() {
		$type = null;

		if ( strpos( __FILE__, '/themes/' ) !== false ) {
			$type = 'theme';
		}
		else {
			$type = 'plugin';
		}

		static::$type = $type;
	}

	/**
	 * Sets the app file (root file)
	 *
	 * @return void
	 */
	private static function set_meta_file() {

		if (static::is_theme()) {
			$meta_file = get_theme_file_path('style.css');
		}

		else {

			/** Get plugin file by looking up plugin folder and checking for index.php or <plugin-slug>.php */

			// Get relative plugin path
			$relative_file_path = (strpos(__FILE__, WP_PLUGIN_DIR) !== false) ? str_replace(WP_PLUGIN_DIR, '', __FILE__) : false;

			// Get plugin slug
			$plugin_slug = explode('/', $relative_file_path)[1] ?? false; // record 1 because of leading slash and explode

			if ($plugin_slug) {
				if ( file_exists( trailingslashit(WP_PLUGIN_DIR) . "{$plugin_slug}/{$plugin_slug}.php" ) ) {
					$meta_file = trailingslashit(WP_PLUGIN_DIR) . "{$plugin_slug}/{$plugin_slug}.php";
				}
				elseif ( file_exists( trailingslashit(WP_PLUGIN_DIR) . "{$plugin_slug}/index.php" ) ) {
					$meta_file = trailingslashit(WP_PLUGIN_DIR) . "{$plugin_slug}/index.php";
				}
			}
		}

		static::$meta_file = $meta_file;
	}

	/**
	 * Sets the app id
	 *
	 * @return void
	 */
	private static function set_id() {

		// Try to get from config and fallback to default
		$id = static::config( 'app', 'id' );

		if ( ! $id ) {

			// Automattically assign id based on the name of the folder
			$id = basename(dirname(static::get_meta_file()));
		}

		static::$id = $id;
	}

	/**
	 * Sets the app name
	 *
	 * @return voname
	 */
	private static function set_name() {

		// Try to get from config and fallback to default
		$name = static::config( 'app', 'name' ) ?? __NAMESPACE__;

		static::$name = $name;
	}

	/**
	 * Sets the app directory (with trailing slash)
	 *
	 * @return void
	 */
	private static function set_dir() {

		if (static::is_theme()) {
			static::$dir = trailingslashit( get_theme_file_path() );
		}
		else {
			static::$dir = plugin_dir_path( static::get_meta_file() );
		}
	}

	/**
	 * Sets the app URI (with trailing slash)
	 *
	 * @return void
	 */
	private static function set_uri() {

		if (static::is_theme()) {
			static::$uri = trailingslashit( get_theme_file_uri() );
		}
		else {
			static::$uri = plugin_dir_url( static::get_meta_file() );
		}
	}

	/**
	 * Sets the app version
	 *
	 * @return void
	 */
	private static function set_version() {

		if (static::is_theme()) {
			static::$version = wp_get_theme()->get('Version') ?? null;
		}
		else {
			static::$version = get_file_data( dirname(static::get_meta_file()) . '/' . basename(static::get_meta_file()), array('Version' => 'Version') ) ?? null;
			// Note: Can't use `get_plugin_data()` because it doesn't work on the frontend
		}
	}

	/**
	 * Sets the app includes directory
	 *
	 * @return void
	 */
	private static function set_inc_dir() {

		// Try to get from config and fallback to default
		$inc_dir = static::config( 'app', 'inc_dir' ) ?? 'app';

		// Not leading and trailing slashes
		$inc_dir = trim($inc_dir, '/');

		static::$inc_dir = $inc_dir;
	}

	/**
	 * Sets the app asset directory
	 *
	 * @return void
	 */
	private static function set_assets_dir() {

		// Try to get from config and fallback to default
		$assets_dir = static::config( 'app', 'assets_dir' ) ?? 'assets';

		// Not leading and trailing slashes
		$assets_dir = trim($assets_dir, '/');

		static::$assets_dir = $assets_dir;
	}

	/**
	 * Sets the app src directory
	 *
	 * @return void
	 */
	private static function set_src_dir() {

		// Try to get from config and fallback to default
		$src_dir = static::config( 'app', 'src_dir' ) ?? 'src';

		// Not leading and trailing slashes
		$src_dir = trim($src_dir, '/');

		static::$src_dir = $src_dir;
	}

	/**
	 * Sets the app template directory
	 *
	 * @return void
	 */
	private static function set_template_dir() {

		// Try to get from config and fallback to default
		$template_dir = static::config( 'app', 'template_dir' ) ?? static::get_inc_dir() . '/template';

		// Not leading and trailing slashes
		$template_dir = trim($template_dir, '/');

		static::$template_dir = $template_dir;
	}

	/**
	 * Sets the app blocks directory
	 *
	 * @return void
	 */
	private static function set_blocks_dir() {

		// Try to get from config and fallback to default
		$blocks_dir = static::config( 'app', 'blocks_dir' ) ?? 'blocks';

		// Not leading and trailing slashes
		$blocks_dir = trim($blocks_dir, '/');

		static::$blocks_dir = $blocks_dir;
	}

	/**
	 * Sets the app language directory
	 *
	 * @return void
	 */
	private static function set_lang_dir() {

		// Try to get from config and fallback to default
		$lang_dir = static::config( 'app', 'lang_dir' ) ?? 'lang';

		// Not leading and trailing slashes
		$lang_dir = trim($lang_dir, '/');

		static::$lang_dir = $lang_dir;
	}

	/**
	 * Sets the app vendor directory
	 *
	 * @return void
	 */
	private static function set_vendor_dir() {

		// Try to get from config and fallback to default
		$vendor_dir = static::config( 'app', 'vendor_dir' ) ?? 'vendor';

		// Not leading and trailing slashes
		$vendor_dir = trim($vendor_dir, '/');

		static::$vendor_dir = $vendor_dir;
	}

	/**
	 * Sets the mix manifest content
	 *
	 * @return void
	 */
	private static function set_mix_manifest() {

		// Get mix manifest file
		$manifest = static::asset_path( 'mix-manifest.json' );

		// Get the contents of the manifest
		$manifest = file_exists( $manifest ) ? json_decode( file_get_contents( $manifest ), true ) : false;

		// Set manifest
		static::$mix_manifest = $manifest;
	}


	/*=============================================================*/
	/**                       Utilities                            */
	/*=============================================================*/

	/**
	 * Check if this app is a theme
	 *
	 * @return boolean
	 */
	public static function is_theme() {
		return static::get_type() == 'theme';
	}

	/**
	 * Check if this app is a plugin
	 *
	 * @return boolean
	 */
	public static function is_plugin() {
		return static::get_type() == 'plugin';
	}

	/**
	 * Includes and returns a given PHP config file. The file must return
	 * an array.
	 *
	 * @param  string  $name
	 * @return array
	 */
	public static function config( $name, $key = null, $key_2 = null ) {

		// Get config file
		$file = static::file_path( "config/{$name}.php" );

		// Get config data
		$config = file_exists( $file ) ? include( $file ) : [];

		// Get key value
		if ($key) {

			// Get nested key value
			if ($key_2) {
				$config = $config[$key][$key_2] ?? null;
			}

			// Just get key value
			else {
				$config = $config[$key] ?? null;
			}
		}

		return $config;
	}

	/**
	 * Get the file-path within this app
	 *
	 * @param string $relative_file relative to this app root
	 * @return string filepath
	 */
	public static function file_uri( $relative_file = '' ) {
		return static::get_uri() . $relative_file;
	}

	/**
	 * Get the file-path within this app
	 *
	 * @param string $relative_file relative to this app root
	 * @return string filepath
	 */
	public static function file_path( $relative_file = '' ) {
		return static::get_dir() . $relative_file;
	}

	/**
	 * Get the includes path
	 *
	 * @param string $relative_file relative to the includes directory
	 * @return string filepath
	 */
	public static function inc_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_inc_dir() . $relative_file );
	}

	/**
	 * Get the asset uri
	 *
	 * @param string $relative_file relative to the asset directory
	 * @return string filepath
	 */
	public static function asset_uri( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_uri( static::get_assets_dir() . $relative_file );
	}

	/**
	 * Get the asset path
	 *
	 * @param string $relative_file relative to the asset directory
	 * @return string filepath
	 */
	public static function asset_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_assets_dir() . $relative_file );
	}

	/**
	 * Get the src path
	 *
	 * @param string $relative_file relative to the src directory
	 * @return string filepath
	 */
	public static function src_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_src_dir() . $relative_file );
	}

	/**
	 * Get the template path
	 *
	 * @param string $relative_file relative to the template directory
	 * @return string filepath
	 */
	public static function template_path( $relative_file = '' ) {

		// Add relative template path
		$relative_file = static::template( $relative_file );

		return static::file_path( $relative_file );
	}

	/**
	 * Get the blocks path
	 *
	 * @param string $relative_file relative to the blocks directory
	 * @return string filepath
	 */
	public static function blocks_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_blocks_dir() . $relative_file );
	}

	/**
	 * Get the language path
	 *
	 * @param string $relative_file relative to the language directory
	 * @return string filepath
	 */
	public static function lang_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_lang_dir() . $relative_file );
	}

	/**
	 * Get the vendor path
	 *
	 * @param string $relative_file relative to the vendor directory
	 * @return string filepath
	 */
	public static function vendor_path( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::file_path( static::get_vendor_dir() . $relative_file );
	}

	/**
	 * Generate handle
	 *
	 * @return string $handle
	 */
	public static function handle( $append = '' ) {

		return static::get_id() . '-' . $append;
	}

	/**
	 * Get asset with cachebusting if it's enabled by laravel mix
	 *
	 * @param string $file relative to the asset folder
	 * @return string filepath
	 */
	public static function asset( $file ) {

		// Make sure to trim any slashes from the front of the path.
		$file = '/' . ltrim( $file, '/' );

		// Get manifest
		$manifest = static::get_mix_manifest();

		// If a file is in the manifest, add the cache-busting path
		if ( $manifest && isset( $manifest[ $file ] ) ) {
			$file = $manifest[ $file ];
		}

		return static::asset_uri( $file );
	}

	/**
	 * Get SVG markup
	 *
	 * @param string name of the SVG icon
	 * @return string svg-markup
	 */
	public static function svg( $name = '' ) {

		$svg = file_get_contents( static::asset( "svg/{$name}.svg" ) );

		return ($svg) ? $svg : '';
	}

	/**
	 * Get the template relative path
	 *
	 * @param string $relative_file relative to the template directory
	 * @return string relative filepath
	 */
	public static function template( $relative_file = '' ) {

		// Make sure we have a slash at the front of the path.
		$relative_file = '/' . ltrim( $relative_file, '/' );

		return static::get_template_dir() . $relative_file;
	}

	/**
	 * Render template file
	 */
	public static function render_template( $template, $name = null, $args = null ) {

		ob_start();

		static::display_template( $template, $name, $args);

		return ob_get_clean();
	}

	/**
	 * Display template file
	 */
	public static function display_template( $template, $name = null, $args = null ) {

		// Add relative template path
		$template = static::template( $template );

		get_template_part( $template, $name, $args );
	}

	/**
	 * Check whether the site is in debug mode.
	 */
	public static function is_debug_mode() {

		$environment = wp_get_environment_type();

		$is_debug_mode = ($environment == 'development' || $environment == 'local');

		/**
		 * In the future I could also flag environment as development on 'staging' and 'production'
		 * when the logged-in user is developer or designer (check for Het Weblokaal email)
		 */

		return $is_debug_mode;
	}

	/**
	 * Log data to wp-content/debug.log
	 *
	 * It doesn't matter if WP_DEBUG is true because I also want to be able
	 * to log on production environment (which has WP_DEBUG disabled)
	 */
	public static function log( $data, $show_namespace = false )  {

	    if ( is_array( $data ) || is_object( $data ) ) {

			if ($show_namespace) {
				error_log( '[' . __NAMESPACE__ . '] ...' );
			}

	        error_log( print_r( $data, true ) );
	    } else {

	    	if ($show_namespace) {
	    		$data = '[' . __NAMESPACE__ . '] ' . $data;
	    	}

	        error_log( $data );
	    }
	}

	/**
	 * Dump (print) data somewhere on the website
	 */
	public static function dump( $data, $show_namespace = false )  {
	    if ( static::is_debug_mode() ) {
	        if ( is_array( $data ) || is_object( $data ) ) {
	            print_r( $data, true );
	        } else {
	            echo $data;
	        }
	    }
	}

	/**
	 * Log data to wp-content/debug.log
	 *
	 * It doesn't matter if WP_DEBUG is true because I also want to be able
	 * to log on production environment (which has WP_DEBUG disabled)
	 */
	public static function status_log( $show_namespace = false )  {

	    // Set properties
		static::log( '', $show_namespace);
		static::log( 'STATUS LOG', $show_namespace);
		static::log( '> type: ' . static::get_type(), $show_namespace);
		static::log( '> meta_file: ' . static::get_meta_file(), $show_namespace);
		static::log( '> id: ' . static::get_id(), $show_namespace);
		static::log( '> version: ' . static::get_version(), $show_namespace);
		static::log( '---', $show_namespace);
		static::log( '> dir: ' . static::get_dir(), $show_namespace);
		static::log( '> uri: ' . static::get_uri(), $show_namespace);
		static::log( '> inc_dir: ' . static::get_inc_dir(), $show_namespace);
		static::log( '> assets_dir: ' . static::get_assets_dir(), $show_namespace);
		static::log( '> src_dir: ' . static::get_src_dir(), $show_namespace);
		static::log( '> vendor_dir: ' . static::get_vendor_dir(), $show_namespace);
		static::log( '> template_dir: ' . static::get_template_dir(), $show_namespace);
		static::log( '> blocks_dir: ' . static::get_blocks_dir(), $show_namespace);
		static::log( 'END STATUS LOG', $show_namespace);
		static::log( '', $show_namespace);
	}
}

/****

Changelog

1.0-alpha-4
- Add function to get relative template file path

1.0-alpha-3
- Add support for App name
- Allow id to be loaded from config

1.0-alpha-2
- Add support for language directory
- Add changelog to bottom of file

****/

<?php
/**
 * Plugin Name:  WBL Projects
 * Plugin URI:   https://github.com/het-weblokaal/wbl-projects
 * Description:  Basis projecten functionaliteit die we gebruiken voor meerdere projecten
 * Version:      0.1
 * Author:       Author: Het Weblokaal <erik.info@hetweblokaal.nl>
 * Author URI:   https://www.hetweblokaal.nl/
 * Text Domain:  wbl-projects
 * Domain Path:  /resources/languages
 * Requires PHP: 7
 * License:      GPLv3
 *
 * GitHub Plugin URI:  https://github.com/het-weblokaal/wbl-projects
 * GitHub Branch:      main
 */

namespace WBL_Projects;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# ------------------------------------------------------------------------------
# Load Dependencies
# ------------------------------------------------------------------------------

/**
 * App Class
 */
if ( file_exists( __DIR__ . '/vendor/wbl-app.php' ) ) {
	require_once( __DIR__ . '/vendor/wbl-app.php' );
}
else {
	exit;
}

/**
 * Composer Dependancies
 */
if ( file_exists( App::vendor_path( 'autoload.php' ) ) ) {
	require_once( App::vendor_path( 'autoload.php' ) );
}

# ------------------------------------------------------------------------------
# Autoload functions files.
# ------------------------------------------------------------------------------

array_map( function( $file ) {
	require_once( App::inc_path( "{$file}.php" ) );
}, [
	'setup',
	'post-type',
	'settings',
	'functions',
	'seo',
] );

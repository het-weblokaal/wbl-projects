<?php
/**
 * Plugin Name:  WBL Projects
 * Plugin URI:   https://github.com/het-weblokaal/wbl-projects
 * Description:  Robust projects plugin by Het Weblokaal
 * Version:      0.2.1
 * Author:       Author: Het Weblokaal <erik.info@hetweblokaal.nl>
 * Author URI:   https://www.hetweblokaal.nl/
 * Text Domain:  wbl-projects
 * Domain Path:  /resources/lang
 * Requires PHP: 7
 * License:      GPLv3
 *
 * GitHub Plugin URI:  https://github.com/het-weblokaal/wbl-projects
 * GitHub Branch:      main
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( wp_get_environment_type() == 'local' && file_exists( '/srv/www/local/wbl-projects/app/bootstrap.php' ) ) {

    // Local plugin bootstrap
    require_once( '/srv/www/local/wbl-projects/app/bootstrap.php' );
}
else {

    // Normal plugin bootstrap
    require_once( __DIR__ . '/app/bootstrap.php' );
}

<?php
/**
 * Bootstrap
 */

namespace WBL\Projects;

# ------------------------------------------------------------------------------
# Load Dependencies
# ------------------------------------------------------------------------------

/**
 * App Class
 */
require_once( __DIR__ . '/../vendor/wbl-app.php' );

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
    'class-post-type',
    'class-taxonomy-category',
    'class-settings',
    'class-multilanguage',
    'admin/class-admin',
    'setup',
    'filters',
    // 'extensions/seo',
] );


# ------------------------------------------------------------------------------
# Autoload block files.
# ------------------------------------------------------------------------------

array_map( function( $file ) {
    require_once( App::blocks_path( "{$file}.php" ) );
}, [
    'projects/index',
] );

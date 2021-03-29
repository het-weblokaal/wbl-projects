<?php
/**
 * Setup Projects
 */

namespace WBL_Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	// Set archive title and description
	add_filter( 'post_type_archive_title', __NAMESPACE__ . '\set_archive_page_title', 10, 2 );
	add_filter( 'get_the_archive_description', __NAMESPACE__ . '\set_archive_page_description' );

	// Set the correct translated archive page slug
	add_filter( 'pll_translated_slugs', __NAMESPACE__ . '\pll_set_archive_page_slug_translation', 10, 3 );
}, 10);

/**
 * Setup at later hook
 */
add_action( 'init', function() {

	// Inform WordPress of custom language directory
	load_plugin_textdomain( 'wbl-projects', false, App::get_slug() . '/' . App::get_lang_dir() );
} );


/**
 *
 */
function set_archive_page_title( $title, $post_type ) {

	if ( $post_type == get_post_type() ) {
		if ( $post_id = get_post_type_archive_page() ) {
			$title = get_post_field( 'post_title', $post_id );
			$title = apply_filters( 'the_title', $title );
		}
	}

	return $title;
}
/**
 *
 */
function set_archive_page_description( $content ) {

	if ( is_post_type_archive( get_post_type() ) ) {
		if ( $post_id = get_post_type_archive_page() ) {
			$content = get_post_field( 'post_content', $post_id );
			$content = apply_filters( 'the_content', $content );
		}
	}

	return $content;
}

/**
 * Manage archive page slug translation for Polylang
 *
 * We want the selected archive page to determine the slug.
 * And otherwise let it fallback to plugin or theme internationalisation
 *
 * @param array        $slugs    Translated slugs.
 * @param PLL_Language $language Language object.
 * @param PLL_MO       $mo       Strings translations object.
 * @return array
 */
function pll_set_archive_page_slug_translation( $slugs, $language, &$mo ) {

	$post_type = get_post_type();

	// Hide translation from String Translations settings 
	$slugs["archive_{$post_type}"]['hide'] = true;

	// Set the correct archive page
	$slugs["archive_{$post_type}"]['translations'][$language->slug] = get_post_type_archive_slug($language->slug);

	return $slugs;
}
<?php
/**
 * Helper functions for multilanguage
 *
 * Currently we support Polylang
 */

namespace WBL\Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	// Set the correct translated archive page slug
	add_filter( 'pll_translated_slugs', __NAMESPACE__ . '\pll_set_archive_page_slug_translation', 10, 3 );

}, 5 );



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

	$post_type = PostType::get_post_type();

	// Hide translation from String Translations settings 
	$slugs["archive_{$post_type}"]['hide'] = true;

	// Set the correct archive page
	$slugs["archive_{$post_type}"]['translations'][$language->slug] = get_post_type_archive_slug($language->slug);

	return $slugs;
}
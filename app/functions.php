<?php
/**
 * Setup Projects
 */

namespace WBL_Projects;

function get_post_type_archive_page( $language = null ) {

	$archive_page = get_setting( 'post_type_archive_page', $language );

	return $archive_page;
}

/**
 * Helper functions for multilanguage
 *
 * Currently we support Polylang
 */

/**
 * Check for polylang
 *
 * @return boolean
 */
function has_polylang() {

	if ( function_exists('pll_default_language') ) {
		return true;
	}
	
	return false;
}


/**
 * Get current language
 */
function get_current_language() {

	$language = false;

	if ( has_polylang() ) {
		$language = pll_current_language();
	}

	return $language;
}

/**
 * Check if default language
 * 
 * If no language is give we assume it's the default language
 */
function is_default_language( $language = null ) {

	$is_default_language = true;

	# Fallback to current language
	$language = ($language) ? $language : get_current_language();

	# Check if we have language and polylang is active
	if ( $language && has_polylang() ) {

		# Check if it's the default language
		if ( $language !== pll_default_language() ) {
			$is_default_language = false;
		}
	}

	return $is_default_language;
}

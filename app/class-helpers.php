<?php

namespace WBL\Projects;

/**
 * Class Admin
 */
class Helpers {

	/**
	 * Check for polylang
	 *
	 * @return boolean
	 */
	public static function has_polylang() {

		if ( function_exists('pll_default_language') ) {
			return true;
		}
		
		return false;
	}

	/**
	 * Get current language
	 */
	public static function get_current_language() {

		if ( ! static::has_polylang() ) {
			return false;
		}
		
		return pll_current_language();
	}

	/**
	 * Check if default language
	 * 
	 * If no language is give we assume it's the default language
	 */
	public static function is_default_language( $language = null ) {

		$is_default_language = true;

		if ( ! static::has_polylang() ) {
			return true;
		}

		// The language to check
		$language = $language ?? static::get_current_language();

		// If we have a language, test it against the default language
		if ($language) {

			// Check if it's the default language
			if ( $language !== pll_default_language() ) {
				$is_default_language = false;
			}
		}

		return $is_default_language;
	}
}
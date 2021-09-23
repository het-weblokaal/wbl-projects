<?php

namespace WBL\Projects;

/**
 * Class Multilanguage
 */
class Multilanguage {

	/**
	 * Setup
	 * 
	 * @return void
	 */
	public static function setup()	{

		// Set the correct translated archive page slug
		add_action( 'pll_translated_slugs', __CLASS__.'::set_translated_slugs_for_archive', 10, 3 );
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
	public static function set_translated_slugs_for_archive( $slugs, $language, &$mo ) {

		$post_type = PostType::get_post_type();

		// Hide translation from String Translations settings 
		$slugs["archive_{$post_type}"]['hide'] = true;

		// Set the correct archive page
		$slugs["archive_{$post_type}"]['translations'][$language->slug] = static::get_archive_slug( $language->slug );

		return $slugs;
	}

	/**
	 * Get the archive page for a given language
	 * 
	 * @return string
	 */
	public static function get_translated_achive_page( $language = null ) {

	    $translated_archive_page = false;
	    
	    if ( ! static::is_default_language( $language ) ) {
	        $translated_archive_page = pll_get_post( Settings::get('page_for_projects'), $language );
	    }

	    return $translated_archive_page;
	}

	/**
	 * Get the archive slug for a given language
	 * 
	 * @return string
	 */
	public static function get_archive_slug( $language = null ) {

	    $archive_slug = PostType::get_archive_slug();

	    if ( $translated_archive_page = static::get_translated_achive_page( $language ) ) {
	        $archive_slug = get_page_uri($translated_archive_page);
	    }

	    return $archive_slug;
	}

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
		$language = $language ?? pll_current_language();

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
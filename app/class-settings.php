<?php

namespace WBL\Projects;

/**
 * Class Settings
 */
class Settings {

	/**
	 * Get the setting
	 * 
	 * @return mixed
	 */
	public static function get( $key ) {

		$name = static::name($key);

		return get_option( $name, false );
	}

	/**
	 * Save the setting
	 * 
	 * @return void
	 */
	public static function save( $key, $value ) {

		$name = static::name($key);

		update_option( $name, $value );
	}

	/**
	 * Make the setting name
	 * 
	 * @return string
	 */
	public static function name( $key ) {

		return "wbl_projects_{$key}";
	}
}
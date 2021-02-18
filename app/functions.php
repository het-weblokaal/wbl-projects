<?php
/**
 * Setup Projects
 */

namespace WBL_Projects;

function get_post_type_archive_page() {
	return get_setting( 'post_type_archive_page' ) ?? null;
}

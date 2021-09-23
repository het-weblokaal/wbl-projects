<?php
/**
 * Filter
 */

namespace WBL\Projects;


/**
 *
 */
function set_archive_page_title( $title, $post_type ) {

	if ( $post_type == PostType::get_post_type() ) {
		if ( $post_id = PostType::get_page_for_projects() ) {
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

	if ( is_post_type_archive( PostType::get_post_type() ) ) {
		if ( $post_id = PostType::get_page_for_projects() ) {
			$content = get_post_field( 'post_content', $post_id, 'raw' );
		}
	}

	return $content;
}


/**
 * Add menu_order to the list of permitted orderby values
 */
function filter_add_rest_orderby_params( $params ) {
	$params['orderby']['enum'][] = 'menu_order';
	return $params;
}




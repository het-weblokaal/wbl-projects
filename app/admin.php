<?php

Namespace WBL_Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	# Admin page archive indicator
	add_filter( 'display_post_states', __NAMESPACE__ . '\add_archive_indicator_in_admin_page_list', 10, 2);

});

/**
 * Show indicator which page is the projects archive page in page overview
 */
function add_archive_indicator_in_admin_page_list( $post_states, $post ) {

    if ( get_post_type_archive_page() == $post->ID ) {
        $post_states[get_post_type_archive_slug()] = get_post_type_name() . __( 'pagina', 'wbl-projects' );
    }

    return $post_states;
}

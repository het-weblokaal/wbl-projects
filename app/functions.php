<?php
/**
 * Setup Projects
 */

namespace WBL_Projects;

/**
 * Show indicator which page is the projects archive page in page overview
 */
function add_archive_indicator_in_admin_page_list( $post_states, $post ) {

    if ( get_post_type_archive_page() == $post->ID ) {
        $post_states[get_post_type_handle()] = get_post_type_name() . __( 'pagina', 'wbl-projects' );
    }

    return $post_states;
}

function is_projects_post_type_archive() {
	return \is_post_type_archive(get_post_type());
}

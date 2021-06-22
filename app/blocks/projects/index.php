<?php
/**
 * Projects
 */

namespace WBL\Projects;

/**
 * Registers the Projects block.
 */
function register_projects_block() {
	register_block_type_from_metadata( App::blocks_path( "projects" ), [
		'render_callback' => __NAMESPACE__ . '\render_projects_block',
	] );
}

/**
 * Renders the Projects block.
 *
 * @param array $attributes The block attributes.
 * @return string
 */
function render_projects_block( $attributes ) {

	$args = array(
		'posts_per_page'   => $attributes['postsToShow'],
		'post_type'        => 'wbl_project',
		// 'post_status'      => 'publish',
		// 'order'            => $attributes['order'],
		// 'orderby'          => $attributes['orderBy'],
		// 'suppress_filters' => false,
	);

	$render = apply_filters( 'wbl/projects/block', false, $args );

	if ( ! $render ) {
		$render = render_block_template( 'projects/template.php', $args );
	}
	
	return $render;
}

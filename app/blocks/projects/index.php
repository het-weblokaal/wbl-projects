<?php
/**
 * Projects
 */

namespace WBL\Projects;

/**
 * Registers the Projects block.
 */
function register_projects_block() {

	// Allow block to be disabled
	if ( apply_filters( 'wbl/projects/blocks/projects', true ) ) {

		register_block_type_from_metadata( App::blocks_path( "projects" ), [
			'render_callback' => __NAMESPACE__ . '\render_projects_block',
		] );

	}
}

/**
 * Renders the Projects block.
 *
 * @param array $attributes The block attributes.
 * @return string
 */
function render_projects_block( $attributes ) {

	$render = apply_filters( 'wbl/projects/block/render', false, $attributes );

	if ( ! $render ) {
		$render = render_block_template( 'projects/template.php', $attributes );
	}
	
	return $render;
}

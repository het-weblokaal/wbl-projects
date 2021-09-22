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

	// If no render provided by theme, then default projects template
	if ( ! $render ) {
		$render = render_default_projects_block( 'projects/template.php', $attributes );
	}
	
	return $render;
}


/**
 * Renders default block template
 * 
 * @param string $template 	relative path to block-folder i.e. `block/template.php`
 * @param array  $args 		the arguments to pass to the template
 * @return string
 */
function render_default_projects_block( $template, $args = [] ) {

	$template_path = App::blocks_path($template);

	ob_start();

	if ( file_exists( $template_path ) ) {
		load_template( $template_path, false, $args );
	}
	else {
		echo "Cannot find $template_path";
	}

	return ob_get_clean();
}
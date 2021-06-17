<?php 

namespace WBL_Projects;

function render_block_template( $template, $args = [] ) {
	ob_start();

	display_block_template( $template, $args);

	return ob_get_clean();
}

/**
 * Displays a block template
 * 
 * @param string $template 	relative path to block-folder i.e. `block/template.php`
 * @param array  $args 		the arguments to pass to the template
 */
function display_block_template( $template, $args = [] ) {

	$template_path = App::blocks_path($template);

	if ( file_exists( $template_path ) ) {
		App::log($template_path);
		load_template( $template_path, false, $args );
	}
	else {
		echo "Cannot find $template_path";
	}
}

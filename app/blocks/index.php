<?php 

namespace WBL\Projects;


// Register dynamic blocks
add_action( 'init', 					   __NAMESPACE__ . '\register_projects_block' );

// Register blocks
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\register_blocks_script' );

/**
 * Add the blocks script to the editor
 */
function register_blocks_script() {

	// Allow projects block to be disabled
	if ( apply_filters( 'wbl/projects/blocks/projects', true ) ) {

		// Scripts.
		wp_enqueue_script(
			App::handle('blocks'),
			App::asset( 'js/blocks.js' ),
			[
				'lodash',
				'wp-blocks',
				'wp-components',
				'wp-data',
				'wp-editor',
				'wp-element',
				'wp-i18n',
			],
			null,
			true // Enqueue the script in the footer.
		);
	}
}

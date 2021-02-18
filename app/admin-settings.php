<?php

Namespace WBL_Projects;

/**
 * Setup at regular hook
 */
add_action( 'plugins_loaded', function() {

	# Options page
	add_action( 'admin_menu', __NAMESPACE__ . '\add_settings_page_to_menu' );

});

function get_setting( $key ) {
	return get_option( get_setting_name($key), false );
}

function get_setting_name( $key ) {
	return "wbl_projects_{$key}";
}

function get_settings_nonce_value() {
	return 'save_wbl_projects_settings';
}

/**
 * Add options page to submenu of project
 */
function add_settings_page_to_menu() {

	$handle = \add_submenu_page(
		'edit.php?post_type='.get_post_type(), # parent slug
		sprintf( __('%s settings', 'wbl-projects'), get_post_type_name() ), # page name
		__('Settings', 'wbl-projects'), # menu name
		'manage_options', # capability
		'wbl_projects-settings', # page slug
		__NAMESPACE__ . '\display_settings_page'
	);
}

function display_settings_page() {
?>

<div class="wrap">

	<h1><?= get_admin_page_title() ?></h1>

	<?php $settings_saved = try_save_settings(); ?>

	<?php if ($settings_saved): ?>
		<div id="message" class="updated notice is-dismissible">
			<p><strong><?= __('Settings saved.', 'wbl-projects') ?></strong></p>
		</div>
	<?php endif ?>

	<form method="post" action="">
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="<?= get_setting_name('post_type_archive_page') ?>">Archive Page</label></th>
				<td>
					<?php

					wp_dropdown_pages( [
						'id'                => get_setting_name('post_type_archive_page'),
						'name'              => get_setting_name('post_type_archive_page'),
						'show_option_none'  => __( '&mdash; Select &mdash;' ),
						'option_none_value' => '0',
						'selected'          => get_post_type_archive_page(),
					]);

					?>
					<p class="help"><span class="description"><?= sprintf( __('Set the archive page for %s. This allows the theme to use the data of this page on the archive.', 'wbl-projects'), get_post_type_name() ) ?></span></p>
				</td>
			</tr>
		</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?= __('Save Changes', 'wbl-projects') ?>">
		</p>

		<?php wp_nonce_field( get_settings_nonce_value() ) ?>
	</form>

</div>

<?php
}


/**
 * Save options page
 */
function try_save_settings() {

	# Abort if no POST-data or no valid referer
	if ( empty($_POST) || !check_admin_referer(get_settings_nonce_value()) ) {
		return false;
	}

	# Get options
	$post_type_archive_page = $_POST[get_setting_name('post_type_archive_page')] ?? false;

	# Sanitize
	$post_type_archive_page = sanitize_key($post_type_archive_page);

	# Update database
	update_option( get_setting_name('post_type_archive_page'), $post_type_archive_page );

	# Flush
	flush_rewrite_rules();

	# Saving succesful
	return true;
}

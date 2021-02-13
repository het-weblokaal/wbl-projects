<?php

Namespace WBL_Projects;

/**
 * Get the settings_name
 */
function get_settings_name() {
    return 'wbl_projects';
}

/**
 * Get settings from database
 */
function get_settings() {

	return get_option(get_settings_name(), []);
}

function get_setting( $setting_name ) {

	$settings = get_settings();

	return $settings[$setting_name] ?? null;
}

function get_settings_nonce_value() {
    return 'save_projects_settings';
}


function settings_form_field_name( $key ) {
	return get_settings_name() . "[$key]";
}

/**
 * Add options page to submenu of project
 */
function add_settings_page_to_menu() {

    $handle = \add_submenu_page(
        'edit.php?post_type='.get_post_type(), // parent slug
        sprintf( __('%s settings', 'wbl-projects'), get_post_type_name() ), // page name
        __('Settings', 'wbl-projects'), // menu name
        'manage_options', // capability
        get_post_type_handle().'-settings', // page slug
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
				<th scope="row"><label for="<?= settings_form_field_name('post_type_archive_page') ?>">Archive Page</label></th>
				<td>
					<?php

					wp_dropdown_pages( [
						'id'                => settings_form_field_name('post_type_archive_page'),
						'name'              => settings_form_field_name('post_type_archive_page'),
						'show_option_none'  => __( '&mdash; Select &mdash;' ),
						'option_none_value' => '0',
						'selected'          => get_post_type_archive_page(),
					]);

					?>
					<p class="help"><span class="description"><?= sprintf( __('Set the archive page for %s.', 'wbl-projects'), get_post_type_name() ) ?> Current: <code><?= get_site_url() . '/' .get_post_type_archive_slug() ?>/</code></span></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="<?= settings_form_field_name('post_type_single_item_slug') ?>">Single Item Slug</label></th>
				<td>
					<input name="<?= settings_form_field_name('post_type_single_item_slug') ?>" type="text" id="<?= settings_form_field_name('post_type_single_item_slug') ?>" value="<?= get_setting('post_type_single_item_slug') ?>" class="medium-text">
					<p class="help"><span class="description"><?= __('Set the slug for a single project.', 'wbl-projects') ?> Current: <code><?= get_site_url() . '/' .get_post_type_single_item_slug() ?>/slug-of-a-project</code></span></p>
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

    // Check if this is a post request
    if (empty($_POST)) return false;

    // Check the nonce
    check_admin_referer(get_settings_nonce_value());

    // Get options
    $settings = $_POST[get_settings_name()] ?? false;

    if ($settings) {

        /**
         * Remove slashes
         *
         * WordPress adds slashes to $_POST/$_GET/$_REQUEST/$_COOKIE regardless of what get_magic_quotes_gpc() returns.
         * @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
         */
        $settings = stripslashes_deep($settings);

   //      // Sanitize archive slug
   //      if ( isset($settings['post_type']['item_slug']) ) {

   //          // Force slashes
   //          $settings['post_type']['item_slug'] = '/' . trim($settings['post_type']['item_slug'], '/') . '/';
   //      }

   //      // ?
   //      // $settings = array_filter($settings, function($value){ return $value == '0' || !empty($value); });

    	// Update database
        update_option(get_settings_name(), $settings);

        flush_rewrite_rules();
    }

    return $settings;
}

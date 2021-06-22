<?php 

use WBL\Projects\PostType;
use WBL\Projects\Settings;

?>
<div class="wrap">

	<h1><?= get_admin_page_title() ?></h1>

	<?php $settings_saved = Settings::try_save_settings(); ?>

	<?php if ($settings_saved): ?>
		<div id="message" class="updated notice is-dismissible">
			<p><strong><?= __('Settings saved.', 'wbl-projects') ?></strong></p>
		</div>
	<?php endif ?>

	<form method="post" action="">
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="<?= Settings::setting_name('page_for_projects') ?>"><?= __('Archive Page', 'wbl-projects') ?></label></th>
				<td>
					<?php

					wp_dropdown_pages( [
						'id'                => Settings::setting_name('page_for_projects'),
						'name'              => Settings::setting_name('page_for_projects'),
						'show_option_none'  => __( '&mdash; Select &mdash;' ),
						'option_none_value' => '0',
						'selected'          => PostType::get_page_for_projects(),
					]);

					?>
					<p class="help"><span class="description"><?= __('Set the archive page for projects. This allows the theme to use the data of this page on the archive.', 'wbl-projects') ?></span></p>
				</td>
			</tr>
		</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?= __('Save Changes', 'wbl-projects') ?>">
		</p>

		<?php wp_nonce_field( Settings::get_settings_nonce_value() ) ?>
	</form>

</div>
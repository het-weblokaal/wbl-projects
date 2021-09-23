<?php 

use WBL\Projects\Admin;
use WBL\Projects\Settings;
use WBL\Projects\PostType;
use WBL\Projects\Multilanguage;

?>
<div class="wrap">

	<h1><?= get_admin_page_title() ?></h1>

	<?php $settings_saved = Admin::try_save(); ?>

	<?php if ($settings_saved): ?>
		<div id="message" class="updated notice is-dismissible">
			<p><strong><?= __('Settings saved.', 'wbl-projects') ?></strong></p>
		</div>
	<?php endif ?>

	<form method="post" action="">
		<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="<?= Settings::name('page_for_projects') ?>"><?= __('Archive Page', 'wbl-projects') ?></label></th>
				<td>
					<?php

					// Get archive page for projects
					$page_for_projects = Settings::get( 'page_for_projects' );

					if ( Multilanguage::is_default_language() ) :

						wp_dropdown_pages( [
							'id'                => Settings::name('page_for_projects'),
							'name'              => Settings::name('page_for_projects'),
							'show_option_none'  => __( '&mdash; Select &mdash;' ),
							'option_none_value' => '0',
							'selected'          => $page_for_projects,
						]);

						?>
						<p class="help"><span class="description"><?= __('Set the archive page for projects. This allows the theme to use the data of this page on the archive.', 'wbl-projects') ?></span></p>

					<?php else : ?>

						<select disabled="disabled"><option><?= get_the_title($page_for_projects); ?></option></select>

						<p class="help"><span class="description"><?= __('You can only set the archive page for the default language. Create a translation for that page.', 'wbl-projects') ?></span></p>

					<?php endif; ?>

				</td>
			</tr>
		</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?= __('Save Changes', 'wbl-projects') ?>">
		</p>

		<?php wp_nonce_field( Admin::$nonce_value ) ?>
	</form>

</div>
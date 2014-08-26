<?php require_once('header.php'); ?>

	<div id="wpsite_plugin_content">

		<div id="wpsite_plugin_settings">

			<h1><?php _e('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

			<form method="post" id="wpsite_twitter_reshare_exclude_posts_form">

				<table>
					<tbody>

						<!-- Filter by Category -->

						<tr>
							<th class="wpsite_twitter_reshare_admin_table_th">
								<label><?php _e('Category', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
								<td class="wpsite_twitter_reshare_admin_table_td">
									<select id="wpsite_twitter_reshare_exclude_posts_category">
										<option value="<?php echo null; ?>"><?php echo '-- All --'; ?></option>

										<?php

										/* Get all categories */

										foreach ($categories as $category) {
											$category_name = strtolower(str_replace(' ','',$category->name)); ?>
											<option value="<?php echo $category->cat_ID; ?>"><?php echo $category_name; ?></option>
										<?php } ?>

									</select>
								</td>
							</th>
						</tr>

						<!-- Exclude Posts -->

						<?php

						$posts = get_posts(array('posts_per_page' => -1, 'post_type' => 'any'));

						foreach ($posts as $post) {

							$post_categories = wp_get_post_categories($post->ID);

							?>
							<tr class="wpsite_twitter_reshare_exclude_posts_general <?php foreach ($post_categories as $cat) { echo 'wpsite_twitter_reshare_cat_' . $cat . ' '; } ?>">
								<th class="wpsite_twitter_reshare_admin_table_th">
									<label><?php _e($post->post_title, WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
									<td class="wpsite_twitter_reshare_admin_table_td">
										<input id="wps_settings_exclude_posts_<?php echo $post->ID; ?>" name="wps_settings_exclude_posts_<?php echo $post->ID; ?>" type="checkbox" <?php echo isset($settings_exclude_posts[$post->ID]) && $settings_exclude_posts[$post->ID] ? 'checked="checked"' : ''; ?>>
										<input id="wpsite_twitter_reshare_categories_exclude_posts_<?php echo $post->ID; ?>" style="display:none;" value="<?php echo isset($post_categories) && is_array($post_categories) ? serialize($post_categories) : null; ?>">
									</td>
									<td>

									</td>
								</th>
							</tr>

						<?php } ?>
					</tbody>
				</table>

				<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_exclude_posts_edit'); ?>

				<?php submit_button(); ?>
			</form>

		</div> <!-- wpsite_plugin_settings -->

		<?php require_once('sidebar.php'); ?>

	</div> <!-- /wpsite_plugin_content -->

<?php require_once('footer.php'); ?>
<form method="post" id="wpsite_twitter_reshare_message_form">

	<table id="wpsite_twitter_reshare_messages_add_edit_table">
		<tbody>

			<!-- ID -->

			<tr>
				<th class="wpsite_twitter_reshare_admin_table_th">
					<label><?php _e('Message ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					<td class="wpsite_twitter_reshare_admin_table_td">
						<input id="wps_settings_message_id" name="wps_settings_message_id" type="text" size="40" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" readonly>
					</td>
				</th>
			</tr>

			<!-- Message -->

			<tr>
				<th class="wpsite_twitter_reshare_admin_table_th">
					<label><?php _e('Message Text', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					<td class="wpsite_twitter_reshare_admin_table_td">
						<input id="wps_settings_message_text" name="wps_settings_message_text" type="text" size="40" value="<?php echo isset($settings['message']) ? $settings['message'] : ''; ?>" placeholder="<?php _e('Check this out:', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>">
					</td>
				</th>
			</tr>

			<!-- Place -->

			<tr>
				<th class="wpsite_twitter_reshare_admin_table_th">
					<label><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					<td class="wpsite_twitter_reshare_admin_table_td">
						<select id="wps_settings_message_place" name="wps_settings_message_place">

							<option value="before" <?php echo isset($settings['place']) && $settings['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

							<option value="after" <?php echo isset($settings['place']) && $settings['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
						</select>
					</td>
				</th>
			</tr>

			<!-- Preview -->


			<tr>
				<th class="wpsite_twitter_reshare_admin_table_th">
					<label><?php _e('Preview', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					<td class="wpsite_twitter_reshare_admin_table_td">

					<label id="wps_settings_message_preview_before" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>

					<a href="http://wpsite.net" target="_blank"><label><?php _e('http://wpsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label></a>

					<label><?php _e('Post Title: Content of the post (if included)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>

					<label id="wps_settings_message_preview_after" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					</td>
				</th>
			</tr>
		</tbody>
	</table>

	<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>

	<?php submit_button(); ?>

</form>
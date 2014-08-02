<form method="post" id="wpsite_twitter_reshare_message_form">

	<!-- ID -->

	<div class="form-field">
		<label for="wps_settings_message_id"><?php _e('Message ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<input id="wps_settings_message_id" name="wps_settings_message_id" type="text" size="40" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" readonly><br/>
		<em class="wps_settings_message_description"><?php _e('This is the unique ID for the message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<!-- Message -->

	<div class="form-field">
		<label for="wps_settings_message_text"><?php _e('Message Text', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<input id="wps_settings_message_text" name="wps_settings_message_text" type="text" size="40" value="<?php echo isset($settings['message']) ? $settings['message'] : ''; ?>" placeholder="<?php _e('Check this out:', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>"><br/>
		<em class="wps_settings_message_description"><?php _e('The message that will be included in the reshare content.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<!-- Place -->

	<div class="form-field">
		<label for="wps_settings_message_place"><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<select id="wps_settings_message_place" name="wps_settings_message_place">
			<option value="before" <?php echo isset($settings['place']) && $settings['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

			<option value="after" <?php echo isset($settings['place']) && $settings['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
		</select><br/>
		<em class="wps_settings_message_description"><?php _e('Where the message will be include, before or after the content.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<!-- Preview -->

	<div class="form-field">
		<label><?php _e('Preview', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<span id="wps_settings_message_preview_before" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<a href="http://wpsite.net" target="_blank"><label><?php _e('http://wpsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label></a>

		<span><?php _e('Post Title: Content of the post (if included)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<span id="wps_settings_message_preview_after" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span><br/>

		<em class="wps_settings_message_description"><?php _e('An example content for the reshare.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>

	<?php submit_button(); ?>

</form>
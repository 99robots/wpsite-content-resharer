<form method="post">

	<!-- ID -->

	<div class="form-group">
		<label for="wps_settings_message_id" class="control-label"><?php _e('Message ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<input id="wps_settings_message_id" name="wps_settings_message_id" type="text" class="form-control" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" readonly>
		<em class="help-block"><?php _e('This is the unique ID for the message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<!-- Message -->

	<div class="form-field">
		<label for="wps_settings_message_text" class="control-label"><?php _e('Message Text', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<input id="wps_settings_message_text" name="wps_settings_message_text" type="text" class="form-control" value="<?php echo isset($settings['message']) ? $settings['message'] : ''; ?>" placeholder="<?php _e('Check this out:', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>">
		<em class="help-block"><?php _e('The message that will be included in the reshare content.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<!-- Place -->

	<div class="form-field">
		<label for="wps_settings_message_place" class="control-label"><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<select id="wps_settings_message_place" name="wps_settings_message_place" class="form-control">
			<option value="before" <?php echo isset($settings['place']) && $settings['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

			<option value="after" <?php echo isset($settings['place']) && $settings['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
		</select>
		<em class="help-block"><?php _e('Where the message will be included, before or after the content.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e('Preview', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		</div>
		<div class="panel-body">
			<span id="wps_settings_message_preview_before" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
			<a href="http://wpsite.net" target="_blank"><?php _e('http://wpsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
			<span><?php _e('Post Title: Content of the post (if included)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
			<span id="wps_settings_message_preview_after" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		</div>
	</div>

	<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="btn btn-info" value="Save Changes">
	</p>

</form>
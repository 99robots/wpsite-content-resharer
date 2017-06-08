<form method="post">

	<!-- ID -->

	<div class="form-group">
		<label for="wps_settings_message_id" class="control-label"><?php _e('Message ID', 'wpsite-twitter-reshare'); ?></label>
		<input id="wps_settings_message_id" name="wps_settings_message_id" type="text" class="form-control" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_message', 'wpsite-twitter-reshare'); ?>" readonly>
		<em class="help-block"><?php _e('This is the unique ID for the message', 'wpsite-twitter-reshare'); ?></em>
	</div>

	<!-- Message -->

	<div class="form-field">
		<label for="wps_settings_message_text" class="control-label"><?php _e('Message Text', 'wpsite-twitter-reshare'); ?></label>
		<input id="wps_settings_message_text" name="wps_settings_message_text" type="text" class="form-control" value="<?php echo isset($settings['message']) ? $settings['message'] : ''; ?>" placeholder="<?php _e('Check this out:', 'wpsite-twitter-reshare'); ?>">
		<em class="help-block"><?php _e('The message that will be included in the reshare content.', 'wpsite-twitter-reshare'); ?></em>
	</div>

	<!-- Place -->

	<div class="form-field">
		<label for="wps_settings_message_place" class="control-label"><?php _e('Place', 'wpsite-twitter-reshare'); ?></label>
		<select id="wps_settings_message_place" name="wps_settings_message_place" class="form-control">
			<option value="before" <?php echo isset($settings['place']) && $settings['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', 'wpsite-twitter-reshare'); ?></option>

			<option value="after" <?php echo isset($settings['place']) && $settings['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', 'wpsite-twitter-reshare'); ?></option>
		</select>
		<em class="help-block"><?php _e('Where the message will be included, before or after the content.', 'wpsite-twitter-reshare'); ?></em>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e('Preview', 'wpsite-twitter-reshare'); ?></h3>
		</div>
		<div class="panel-body">
			<span id="wps_settings_message_preview_before" class="wps_settings_message_preview" style="color:red"><?php _e('Message', 'wpsite-twitter-reshare'); ?></span>
			<a href="http://wpsite.net" target="_blank"><?php _e('http://wpsite.net', 'wpsite-twitter-reshare'); ?></a>
			<span><?php _e('Post Title: Content of the post (if included)', 'wpsite-twitter-reshare'); ?></span>
			<span id="wps_settings_message_preview_after" class="wps_settings_message_preview" style="color:red"><?php _e('Message', 'wpsite-twitter-reshare'); ?></span>
		</div>
	</div>

	<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="btn btn-info" value="Save Changes">
	</p>

</form>
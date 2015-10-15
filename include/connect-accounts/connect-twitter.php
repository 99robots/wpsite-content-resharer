<?php
require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/api_src/twitteroauth/twitteroauth.php');

if (isset($_GET['oauth_verifier'])) {

	$connection = new TwitterOAuth(self::$api_key, self::$api_secret);

	$token_credentials = $connection->getAccessToken($_GET['oauth_verifier'], $_GET['oauth_token']);

	$hook = self::$prefix . 'twitter';
	$args = $settings;
	wp_clear_scheduled_hook($hook, array($args));

	$settings['twitter']['token'] = $token_credentials['oauth_token'];
	$settings['twitter']['token_secret'] = $token_credentials['oauth_token_secret'];

	$settings_all['accounts']['twitter'] = $settings;

	update_option('wpsite_twitter_reshare_settings', $settings_all);

	$hook = self::$prefix . 'twitter';
	$args = $settings;

	self::wpsite_twitter_reshare_schedule_reshare_event($hook, array($args));

	?>
	<script type="text/javascript">
		window.location = "<?php echo get_admin_url() . 'admin.php?page=' . self::$account_dashboard_page . '&action=edit&account=twitter'; ?>";
	</script>
	<?php

}

if (isset($settings['twitter']['profile_image']) && $settings['twitter']['profile_image'] != '') {
	?>
	<div class="<?php echo self::$prefix_dash; ?>container">
		<div class="<?php echo self::$prefix_dash; ?>profile-image">
			<img src="<?php echo $settings['twitter']['profile_image']; ?>" />
		</div>
		<div class="<?php echo self::$prefix_dash; ?>screen-name">
			<a href="https://twitter.com/<?php echo $settings['twitter']['screen_name']; ?>" target="_blank"><?php echo $settings['twitter']['screen_name']; ?></a>
		</div>
		<div class="<?php echo self::$prefix_dash; ?>remove">
			<a href="<?php echo wp_nonce_url(get_admin_url() . 'admin.php?page=' . self::$account_dashboard_page . '&action=remove&account=twitter&type=twitter', 'wpsite_twitter_reshare_admin_settings_remove'); ?>"></a>
		</div>
	</div>
	<?php
}

else {

	$connection = new TwitterOAuth(self::$api_key, self::$api_secret, $settings['twitter']['token'], $settings['twitter']['token_secret']);

	$account = $connection->get('account/verify_credentials');

	if (isset($account) && !isset($account->errors)) {
		?>
		<div class="<?php echo self::$prefix_dash; ?>container">
			<div class="<?php echo self::$prefix_dash; ?>profile-image">
				<img src="<?php echo $account->profile_image_url; ?>" />
			</div>
			<div class="<?php echo self::$prefix_dash; ?>screen-name">
				<a href="https://twitter.com/<?php echo $account->screen_name; ?>" target="_blank"><?php echo $account->screen_name; ?></a>
			</div>
			<div class="<?php echo self::$prefix_dash; ?>remove">
				<a href="<?php echo wp_nonce_url(get_admin_url() . 'admin.php?page=' . self::$account_dashboard_page . '&action=remove&account=twitter&type=twitter', 'wpsite_twitter_reshare_admin_settings_remove'); ?>"></a>
			</div>
		</div>
		<?php

		$hook = self::$prefix . 'twitter';
		$args = $settings;
		wp_clear_scheduled_hook($hook, array($args));

		$settings['twitter']['profile_image'] = $account->profile_image_url;
		$settings['twitter']['screen_name'] = $account->screen_name;

		$settings_all['accounts']['twitter'] = $settings;

		update_option('wpsite_twitter_reshare_settings', $settings_all);

		$hook = self::$prefix . 'twitter';
		$args = $settings;

		self::wpsite_twitter_reshare_schedule_reshare_event($hook, array($args));
	} else {

		$sign_in = new TwitterOAuth(self::$api_key, self::$api_secret);

		$temporary_credentials = $sign_in->getRequestToken(get_admin_url() . 'admin.php?page=' . self::$account_dashboard_page . '&action=edit&account=twitter');

		$redirect_url = $sign_in->getAuthorizeURL($temporary_credentials);

		?><a href="<?php echo $redirect_url; ?>"><button class="btn btn-default" type="button"><?php _e('Sign In', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></button></a><?php
	}

}
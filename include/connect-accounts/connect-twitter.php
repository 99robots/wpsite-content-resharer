<?php
require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/api_src/twitteroauth/twitteroauth.php');

if (!isset($settings['twitter']['token']) || $settings['twitter']['token'] == '') {
	$connection = new TwitterOAuth(self::$api_key, self::$api_secret);

	$temporary_credentials = $connection->getRequestToken('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

	$redirect_url = $connection->getAuthorizeURL($temporary_credentials);

	?><a href="<?php echo $redirect_url; ?>"><input class="button" type="button" value="<?php _e('Sign In', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>"/></a><?php

	$settings['twitter']['token'] = $temporary_credentials['oauth_token'];
	$settings['twitter']['token_secret'] = $temporary_credentials['oauth_token_secret'];

	$settings_all['accounts']['twitter'] = $settings;

	update_option('wpsite_twitter_reshare_settings', $settings_all);

} else if (isset($_GET['oauth_verifier'])) {

	$connection = new TwitterOAuth(self::$api_key, self::$api_secret, $settings['twitter']['token'],
	$settings['twitter']['token_secret']);

	$token_credentials = $connection->getAccessToken($_GET['oauth_verifier']);

	$settings['twitter']['token'] = $token_credentials['oauth_token'];
	$settings['twitter']['token_secret'] = $token_credentials['oauth_token_secret'];

	$settings_all['accounts']['twitter'] = $settings;

	update_option('wpsite_twitter_reshare_settings', $settings_all);

	?>
	<script type="text/javascript">
		window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$account_dashboard_page; ?>";
	</script>
	<?php

} else {

	$sign_in = new TwitterOAuth(self::$api_key, self::$api_secret);

	$temporary_credentials = $sign_in->getRequestToken('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

	$redirect_url = $sign_in->getAuthorizeURL($temporary_credentials);

	$connection = new TwitterOAuth(self::$api_key, self::$api_secret, $settings['twitter']['token'],
	$settings['twitter']['token_secret']);

	$account = $connection->get('account/verify_credentials');

	if (isset($account)) {

		if (isset($account->errors)) {
			$settings['twitter']['token'] = '';
			$settings['twitter']['token_secret'] = '';

			$settings_all['accounts']['twitter'] = $settings;

			update_option('wpsite_twitter_reshare_settings', $settings_all);

			?><a href="<?php echo $redirect_url; ?>"><input class="button" type="button" value="<?php _e('Sign In', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>"/></a><?php
		} else {
			?>
			<div class="<?php echo self::$prefix_dash; ?>container">
				<div class="<?php echo self::$prefix_dash; ?>profile-image">
					<img src="<?php echo $account->profile_image_url; ?>" />
				</div>
				<div class="<?php echo self::$prefix_dash; ?>screen-name">
					<a href="https://twitter.com/<?php echo $account->screen_name; ?>" target="_blank"><?php echo $account->screen_name; ?></a>
				</div>
				<div class="<?php echo self::$prefix_dash; ?>remove">
					<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=remove&account=' . $settings['id'] . '&type=twitter', 'wpsite_twitter_reshare_admin_settings_remove'); ?>"></a>
				</div>
			</div>
			<?php
		}
	} else {
		$settings['twitter']['token'] = '';
		$settings['twitter']['token_secret'] = '';

		$settings_all['accounts']['twitter'] = $settings;

		update_option('wpsite_twitter_reshare_settings', $settings_all);

		?><a href="<?php echo $redirect_url; ?>"><input class="button" type="button" value="<?php _e('Sign In', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>"/></a><?php
	}
}
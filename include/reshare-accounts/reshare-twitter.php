<?php
require_once(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . self::$api_twitter_dir);

\Codebird\Codebird::setConsumerKey(WPsite_Content_Resharer::$api_key, WPsite_Content_Resharer::$api_secret);
$cb = \Codebird\Codebird::getInstance();
$cb->setToken($account['twitter']['token'], $account['twitter']['token_secret']);

if (isset($account['general']['featured_image']) && isset($featured_image) && $featured_image != ''/* && (isset($params['media[]']) && $params['media[]'] != '') */) {
	$params = array(
	    'status' 	=> strip_tags(substr($content, 0, 279)),
	    'media[]' 	=> file_get_contents($featured_image)
	);

	$reply = $cb->statuses_updateWithMedia($params);
} else {
	$reply = $cb->statuses_update('status=' . strip_tags(substr($content, 0, 279)));
}

//error_log(serialize($reply));

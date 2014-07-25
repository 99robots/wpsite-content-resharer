<?php
require_once(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . self::$api_twitter_dir);

\Codebird\Codebird::setConsumerKey(WPsiteTwitterReshare::$api_key, WPsiteTwitterReshare::$api_secret);
$cb = \Codebird\Codebird::getInstance();
$cb->setToken($account['twitter']['token'], $account['twitter']['token_secret']);

if ($account['general']['featured_image'] && (isset($params['media[]']) && $params['media[]'] != '')) {
	$params = array(
	    'status' 	=> $args['message']['text'],
	    'media[]' 	=> file_get_contents($featured_image)
	);

	$reply = $cb->statuses_updateWithMedia($params);
} else {
	$reply = $cb->statuses_update('status=' . $content);
}
<?php
/**
 * WPsite Twitter Reshare main class
 *
 * @since 1.0.0
 */

class WPsiteTwitterResharePost {

	/**
	 * prefix
	 *
	 * (default value: 'wpsite_twitter_reshare_')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $prefix = 'wpsite_twitter_reshare_';

	/**
	 * api_twitter_dir
	 *
	 * (default value: 'include/api_src/twitter/codebird.php')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $api_twitter_dir = '/include/api_src/twitter/codebird.php';

	/**
	 * Posts to all channels
	 * Setups up all reshares
	 *
	 * @param	array	$account
	 * @param	array	$args for the reshare
	 *
	 * @since 1.0.0
	 */
	static function wpsite_post_to_channel($account, $args) {

		/* Create reshare content */

		$temp_image = wp_get_attachment_image_src(get_post_thumbnail_id($args['post']->ID),'single-post-thumbnail');

		$content = '';
		$featured_image = isset($temp_image) && is_array($temp_image) ? $temp_image[0] : null;
		$post_link = get_permalink($args['post']->ID);
		$post_title = $args['post']->post_title;
		$post_data = '';

		//Include Link

		if ($account['general']['include_link']) {

			//require_once(plugin_dir_path( __FILE__ ) . self::$api_bitly_dir);

			if (isset($account['general']['bitly_url_shortener']) && $account['general']['bitly_url_shortener'] != '') {

				$result = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=' . $account['general']['bitly_url_shortener'] . '&longUrl=' . urlencode($post_link) . '&format=json');

				if (isset(json_decode($result)->data->url)) {
					$post_link = json_decode($result)->data->url;
				}
			}

			$post_data .= $post_link . ' ';
		}

		//Post Data

		if ($account['general']['reshare_content'] == 'title') {
			$post_data .= $post_title;
		} else if ($account['general']['reshare_content'] == 'title_content') {
			$post_data .= $post_title . ' ' . apply_filters( 'the_content', $args['post']->post_content);
		} else if ($account['general']['reshare_content'] == 'content') {
			$post_data .= $args['post']->post_content;
		}

		//Message Place

		if ($args['message']['place'] == 'before') {
			$content = $args['message']['text'] . ' ' .  $post_data;
		} else {
			$content = $post_data . ' ' . $args['message']['text'];
		}

		//Hashtags

		if ($account['general']['hashtag_type'] == 'custom_field') {

			$hashtags = get_post_meta($args['post']->ID, 'wpsite-twitter-reshare-meta-box-hashtags', true);

			$hashtags = explode(',', $hashtags);

			foreach ($hashtags as $hashtag) {
				$new_hashtags[] = '#' . str_replace(' ', '', $hashtag);
			}

			$hashtags = implode(' ', $new_hashtags);

			$content .= ' ' . $hashtags;
		} else if ($account['general']['hashtag_type'] == 'category') {

			$categories = get_the_category($args['post']->ID);

			foreach ($categories as $category) {
				$hashtag = '#' . str_replace(' ', '', $category->name);

				break;
			}

			$content .= ' ' . $hashtag;
		} else if ($account['general']['hashtag_type'] == 'specific_hashtags') {
			$hashtags = $account['general']['specific_hashtags'];

			$hashtags = explode(',', $hashtags);

			foreach ($hashtags as $hashtag) {
				$new_hashtags[] = '#' . str_replace(' ', '', $hashtag);
			}

			$hashtags = implode(' ', $new_hashtags);

			$content .= ' ' . $hashtags;
		}

		/* Determine type of post */

		switch ($account['type']) {

			/* Twitter */

			case 'twitter' :

				require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/reshare-accounts/reshare-twitter.php');

			break;

			/* Facebook */

			case 'facebook' :

			break;

			/* LinkedIn */

			case 'linkedin' :

			break;

			/* Pinterest */

			case 'pinterest' :

			break;

			/* Google */

			case 'google' :

			break;
		}
	}

	/**
	 * Hooks to 'wp_footer'
	 *
	 * Setups up all reshares
	 *
	 * @since 1.0.0
	 */
	static function wpsite_setup_all_reshares($args = null, $test = false) {

		/* Single account */

		if (!empty($args)) {

			$reshare_args = array();
			$reshare_args = self::wpsite_get_rand_post_and_message($args);
			$reshare_args['test'] = $test;

			if (isset($reshare_args['post']) && isset($reshare_args['message'])) {
				self::wpsite_post_to_channel($args, $reshare_args);
			}
		}
	}

	/**
	 * Returns a valid random post and message for a specifc account
	 *
	 * @param	array	$account
	 *
	 * @return	array	(post => $post, message => $message)
	 *
	 * @since 1.0.0
	 */
	static function wpsite_get_rand_post_and_message($account) {

		/* Get a random post */

		if ($account['post_filter']['min_age'] > 0 && $account['post_filter']['min_age'] < 1) {
			$min_age = mktime(date("H") - (24 * $account['post_filter']['min_age']), date("i"), date("s"), date("m"), date("d"), date("Y"));
		} else {
			$min_age = mktime(date("H"), date("i"), date("s"), date("m")  , date("d") - $account['post_filter']['min_age'], date("Y"));
		}

		if ($account['post_filter']['max_age'] == 0) {
			$max_age = 0;
		} else {
			if ($account['post_filter']['max_age'] > 0 && $account['post_filter']['max_age'] < 1) {
				$max_age = mktime(date("H") - (24 * $account['post_filter']['max_age']), date("i"), date("s"), date("m"), date("d"), date("Y"));
			} else {
				$max_age = mktime(date("H"), date("i"), date("s"), date("m"), date("d") - $account['post_filter']['max_age'], date("Y"));
			}
		}



		$settings = get_option('wpsite_twitter_reshare_settings');

		if (isset($settings['exclude_posts']) && is_array($settings['exclude_posts']) && count($settings['exclude_posts']) > 0) {
			$exclude_posts = array();

			foreach ($settings['exclude_posts'] as $post_id => $exclude_post) {
				if ($exclude_post) {
					$exclude_posts[] = $post_id;
				}
			}
		}

		$post_args = array(
			'posts_per_page'   	=> -1,
			'category__not_in' 	=> $account['post_filter']['exclude_categories'],
			'orderby'          	=> 'rand',
			'post_type'        	=> $account['post_filter']['post_types'],
			'post__not_in'		=> isset($exclude_posts) ? $exclude_posts : array(),
			'date_query' 		=> array(
				array(
					'after'     => array(
						'year'  => (int) date('Y',$max_age),
						'month' => (int) date('m',$max_age),
						'day'   => (int) date('d',$max_age),
						'hour'  => (int) date('H',$max_age)
					)
				)
			)
		);

		if ($max_age != 0) {
			$post_args['date_query'][0]['before'] = array(
				'year'  => (int) date('Y',$min_age),
				'month' => (int) date('m',$min_age),
				'day'   => (int) date('d',$min_age),
				'hour'  => (int) date('H',$min_age)
			);

			$post_args['date_query'][0]['inclusive'] = true;
		}

		$posts = get_posts($post_args);

		if (isset($posts) && count($posts) > 0) {

			/* Get a radmon message from the randon post */

			$post = $posts[0];

			$messages = get_post_meta($post->ID, 'wpsite_twitter_reshare_meta_box_' . $account['id'], true);

			if (empty($messages)) {
				$settings = get_option('wpsite_twitter_reshare_settings');

				if ($settings === false)
					return null;

				$messages = $settings['messages'];
				$valid_messages = array();

				foreach ($messages as $message) {
					$valid_messages[] = array(
						'text' 	=> $message['message'],
						'place'	=> $message['place']
					);
				}
			}else {
				$valid_messages = array();

				$temp_messages = $messages;
				$messages = isset($temp_messages['messages']) ? $temp_messages['messages'] : null;
				$cus_messages = isset($temp_messages['custom_messages']) ? $temp_messages['custom_messages'] : null;

				if (!empty($cus_messages) && is_array($cus_messages)) {
					foreach ($cus_messages as $cus_message) {
						if (isset($cus_message['message']) && $cus_message['message'] != '') {
							$valid_messages[] = array(
								'text' 	=> $cus_message['message'],
								'place'	=> $cus_message['place']
							);
						}
					}
				}

				if (count($valid_messages) < 1 && isset($messages)) {
					foreach ($messages as $message) {
						if (isset($message['val']) && $message['val']) {
							$valid_messages[] = array(
								'text' 	=> $message['message'],
								'place'	=> $message['place']
							);
						}
					}
				}
			}

			if (isset($valid_messages) && is_array($valid_messages) && count($valid_messages) > 0) {
				$randmon_message = $valid_messages[rand(0, count($valid_messages) - 1)];
			}else {
				$randmon_message = array('text' => '', 'place' => 'before');
			}

			return array('post' => $post,'message' => $randmon_message);
		} else {
			return null;
		}
	}
}
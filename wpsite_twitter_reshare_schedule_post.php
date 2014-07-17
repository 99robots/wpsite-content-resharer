<?php
/**
 * This class is used to post to all social media channels based on the user's settings
 *
 * Was built originally to work with the WPsite Twitter Reshare plugin, but can be used in any context
 *	by calling the wpsite_setup_all_reshares() function with and $args parameter. An example args
 *	parameter could look like this.
 * 		$args = array(
 *			'type' 		=> 'twitter',
 *			'twitter'	=> array(
 *				'consumer_key'		=> 'your_consumer_key',
 *				'consumer_secret'	=> 'your_consumer_secret',
 *				'token'				=> 'your_token',
 *				'token_secret'		=> 'your_token_secret'
 *			),
 *			'general' 		=> array(
 *				'reshare_content'		=> 'title', //title, title_content, or content
 * 				'featured_image'		=> false,
 *				'include_link'			=> false,
 *				'min_interval'			=> '6', 	//hours
 *			),
 *			'post_filter'	=> array(
 *				'min_age'		=> '30',			//days
 *				'max_age'		=> '60',			//days
 *				'post_types'	=> array('post', 'page'),
 *				'exclude_categories'	=> array('category_1', 'category_2')
 *			)
 *		)
 *
 * @author Kyle Benk <kjbenk@gmail.com>
 */

 /* Notes
  *
  * Twitter
  *		Make sure that the callback Url is set to anything it doesnt matter.
  * 	Make sure that the app is set for post and read and write.
  * Facebook
  *		Set the namespace
  *		Set the action types as publish_stream, photo_upload
 */

/**
 * Hooks / Filter
 */

//add_action('wp_footer', array('WPsiteTwitterResharePost', 'wpsite_setup_all_reshares'));

/**
 * WPsite Twitter Reshare main class
 *
 * @since 1.0.0
 */

class WPsiteTwitterResharePost {

	private static $prefix = 'wpsite_twitter_reshare_';

	//private static $api_bitly_dir = 'include/api_src/bitly/bitly.php';

	private static $api_twitter_dir = 'include/api_src/twitter/codebird.php';

	private static $api_facebook_js_dir = 'js/wpsite_twitter_reshare_facebook.js';

	private static $api_facebook_php_dir = 'include/api_src/facebook/facebook.php';

	private static $api_linkedin_dir = 'js/wpsite_twitter_reshare_linkedin.js';

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

			$result = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=db70e7dc153a834c1b52deb8b0c587511e97b2fb&longUrl=' . urlencode($post_link) . '&format=json');

			if (isset(json_decode($result)->data->url))
				$post_link = json_decode($result)->data->url;

			$post_data .= $post_link . ' ';
		}

		//Post Data

		if ($account['general']['reshare_content'] == 'title') {
			$post_data .= $post_title;
		} else if ($account['general']['reshare_content'] == 'title_content') {
			$post_data .= $post_title . ' ' . $args['post']->post_content;
		} else if ($account['general']['reshare_content'] == 'content') {
			$post_data .= $args['post']->post_content;
		}

		//Message Place

		if ($args['message']['place'] == 'before') {
			$content = $args['message']['text'] . ' ' .  $post_data;
		} else {
			$content = $post_data . ' ' . $args['message']['text'];
		}

		/* Determine type of post */

		switch ($account['type']) {

			/* Twitter */

			case 'twitter' :

				//$content = substr($content, 0, 137) . '...';

				require_once(plugin_dir_path( __FILE__ ) . self::$api_twitter_dir);

				\Codebird\Codebird::setConsumerKey($account['twitter']['consumer_key'], $account['twitter']['consumer_secret']);
				$cb = \Codebird\Codebird::getInstance();
				$cb->setToken($account['twitter']['token'], $account['twitter']['token_secret']);

				//$reply = $cb->help_configuration();

				if ($account['general']['featured_image'] && (isset($params['media[]']) && $params['media[]'] != '')) {
					$params = array(
					    'status' 	=> $args['message']['text'],
					    'media[]' 	=> file_get_contents($featured_image)
					);

					$reply = $cb->statuses_updateWithMedia($params);
				} else {
					$reply = $cb->statuses_update('status=' . $content);
				}

				error_log(serialize($reply));
			break;

			/* Facebook */

			case 'facebook' :

				require_once(plugin_dir_path( __FILE__ ) . self::$api_facebook_php_dir);

				$facebook = new Facebook(array(
				  'appId'  		=> $account['facebook']['app_id'],
				  'secret' 		=> $account['facebook']['app_secret'],
				  'fileUpload' 	=> true,
				  'cookie'		=> true
				));

				// Page

				if (!$args['test']) {
					if ($account['facebook']['type'] == 'page') {

						//$access_token = $facebook->api('/' . $account['facebook']['page_id'] . '/?fields=access_token', 'GET');

						if ($account['general']['featured_image'] && (isset($featured_image) && $featured_image != '')) {
							$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/photos', 'POST',
								array(
	                            	'source' 		=> '@' . realpath(get_attached_file(get_post_thumbnail_id($args['post']->ID))),
									'message'		=> $content,
									'access_token'	=> $account['facebook']['access_token']
							));
						}else {
							$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/feed', 'POST',
	                            array(
	                              'message' 		=> $content,
	                              'access_token'	=> $account['facebook']['access_token']
	                         ));
						}

						error_log($ret_obj['id']);
					}
				}



				/* If reshare test than get the page access token */

				if ($args['test']) {

					$user = $facebook->getUser();

					if($user) {

						try {

							// User

							if ($account['facebook']['type'] == 'user') {

								if ($account['general']['featured_image'] && (isset($featured_image) && $featured_image != '')) {
									$ret_obj = $facebook->api('/me/photos', 'POST',
										array(
			                            	'source' 	=> '@' . realpath(get_attached_file(get_post_thumbnail_id($args['post']->ID))),
											'message'	=> $content
									));
								}else {
									$ret_obj = $facebook->api('/me/feed', 'POST',
			                            array(
			                              'message' => $content
			                         ));
								}

								error_log($ret_obj['id']);
							}


							// Page

							if ($account['facebook']['type'] == 'page') {

								//Get Permenant access token for page

								$access_token = $facebook->api('/' . $account['facebook']['page_id'] . '/?fields=access_token', 'GET');

								$temp_access_token = file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=' . $account['facebook']['app_id'] . '&client_secret=' . $account['facebook']['app_secret'] . '&fb_exchange_token=' . $access_token['access_token']);


								if (isset($temp_access_token)) {
									//error_log('temp ->' . $temp_access_token);
									$temp_access_token = substr($temp_access_token, 13);

									$access_token = $facebook->api('/' . $account['facebook']['page_id'] . '/?fields=access_token', 'GET',
										array(
											'access_token'	=> $temp_access_token
									));

									$settings = get_option('wpsite_twitter_reshare_settings');

									wp_clear_scheduled_hook('wpsite_twitter_reshare_' . $account['id'], array($account));

									$settings['accounts'][$account['id']]['facebook']['access_token'] = $access_token['access_token'];
									$account['facebook']['access_token'] = $access_token['access_token'];

									wp_schedule_event(time(), 'wpsite_twitter_reshare_' . $account['id'] . '_recurrence', 'wpsite_twitter_reshare_' . $account['id'], array($account));

									update_option('wpsite_twitter_reshare_settings', $settings);
								}

								//Use the permenat access token

								if ($account['general']['featured_image'] && (isset($featured_image) && $featured_image != '')) {
									$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/photos', 'POST',
										array(
			                            	'source' 		=> '@' . realpath(get_attached_file(get_post_thumbnail_id($args['post']->ID))),
											'message'		=> $content,
											'access_token'	=> $access_token['access_token']
									));
								}else {
									$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/feed', 'POST',
			                            array(
			                              'message' 		=> $content,
			                              'access_token'	=> $access_token['access_token']
			                         ));
								}

								error_log($ret_obj['id']);
							}

						} catch(FacebookApiException $e) {
							// If the user is logged out, you can have a
							// user ID even though the access token is invalid.
							// In this case, we'll get an exception, so we'll
							// just ask the user to login again here.
							$login_url = $facebook->getLoginUrl( array(
				               'scope' => 'publish_stream, manage_pages, photo_upload'
				               ));

							//echo 'Please <a href="' . $login_url . '">login.</a>';
							error_log($e->getType());
							error_log($e->getMessage());

							echo $e->getType();
							echo $e->getMessage();
						}
				    } else {

				      // No user, so print a link for the user to login
				      // To post to a user's wall, we need publish_stream permission
				      // We'll use the current URL as the redirect_uri, so we don't
				      // need to specify it here.
				      $login_url = $facebook->getLoginUrl( array( 'scope' => 'publish_stream, manage_pages,photo_upload' ) );
				      error_log('no user');


				      	// Page

						if ($account['facebook']['type'] == 'page') {

							//Get Permenant access token for page

							$access_token = $facebook->api('/' . $account['facebook']['page_id'] . '/?fields=access_token', 'GET');

							$temp_access_token = file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=' . $account['facebook']['app_id'] . '&client_secret=' . $account['facebook']['app_secret'] . '&fb_exchange_token=' . $access_token['access_token']);


							if (isset($temp_access_token)) {
								//error_log('temp ->' . $temp_access_token);
								$temp_access_token = substr($temp_access_token, 13);

								$access_token = $facebook->api('/' . $account['facebook']['page_id'] . '/?fields=access_token', 'GET',
									array(
										'access_token'	=> $temp_access_token
								));

								$settings = get_option('wpsite_twitter_reshare_settings');

								wp_clear_scheduled_hook('wpsite_twitter_reshare_' . $account['id'], array($account));

								$settings['accounts'][$account['id']]['facebook']['access_token'] = $access_token['access_token'];
								$account['facebook']['access_token'] = $access_token['access_token'];

								wp_schedule_event(time(), 'wpsite_twitter_reshare_' . $account['id'] . '_recurrence', 'wpsite_twitter_reshare_' . $account['id'], array($account));

								update_option('wpsite_twitter_reshare_settings', $settings);
							}

							//Use the permenat access token

							if ($account['general']['featured_image'] && (isset($featured_image) && $featured_image != '')) {
								$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/photos', 'POST',
									array(
						            	'source' 		=> '@' . realpath(get_attached_file(get_post_thumbnail_id($args['post']->ID))),
										'message'		=> $content,
										'access_token'	=> $access_token['access_token']
								));
							}else {
								$ret_obj = $facebook->api('/' . $account['facebook']['page_id'] . '/feed', 'POST',
						            array(
						              'message' 		=> $content,
						              'access_token'	=> $access_token['access_token']
						         ));
							}

							error_log($ret_obj['id']);
						}
				    }

					?>
					<div id="fb-root"></div>
					<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true" data-scope="publish_stream,photo_upload,manage_pages"></div><?php

					$wpsite_facebook = array(
						'app_id'	=> $account['facebook']['app_id'],
						'message'	=> $content,
						'type'		=> $account['facebook']['type'],
						'test'		=> $args['test']
					);

					wp_enqueue_script('wpsite_twitter_reshare_facebook_src', plugins_url(self::$api_facebook_js_dir, __FILE__ ));
					wp_localize_script('wpsite_twitter_reshare_facebook_src', 'wpsite_facebook', $wpsite_facebook);
				}

			break;

			/* LinkedIn */

			case 'linkedin' :

				?><script type="IN/Login"></script><?php

				$wpsite_linkedin = array(
					'api_key'	=> $account['linkedin']['api_key'],
					'message'	=> $content,
					'url'		=> $post_link,
					'image_url'	=> $featured_image,
					'image'		=> $account['general']['featured_image'],
					'test'		=> $args['test']
				);

				// Change these
/*
				define('API_KEY',      'YOUR_API_KEY_HERE'                                          );
				define('API_SECRET',   'YOUR_API_SECRET_HERE'                                       );
				define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
				define('SCOPE',        'r_fullprofile r_emailaddress rw_nus'                        );

				// You'll probably use a database
				session_name('linkedin');
				session_start();

				// OAuth 2 Control Flow
				if (isset($_GET['error'])) {
				    // LinkedIn returned an error
				    print $_GET['error'] . ': ' . $_GET['error_description'];
				    exit;
				} elseif (isset($_GET['code'])) {
				    // User authorized your application
				    if ($_SESSION['state'] == $_GET['state']) {
				        // Get token so you can make API calls
				        getAccessToken();
				    } else {
				        // CSRF attack? Or did you mix up your states?
				        exit;
				    }
				} else {
				    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
				        // Token has expired, clear the state
				        $_SESSION = array();
				    }
				    if (empty($_SESSION['access_token'])) {
				        // Start authorization process
				        getAuthorizationCode();
				    }
				}

				// Congratulations! You have a valid token. Now fetch your profile
				$user = fetch('GET', '/v1/people/~:(firstName,lastName)');
				print "Hello $user->firstName $user->lastName.";
				exit;

				function getAuthorizationCode() {
				    $params = array('response_type' => 'code',
				                    'client_id' => API_KEY,
				                    'scope' => SCOPE,
				                    'state' => uniqid('', true), // unique long string
				                    'redirect_uri' => REDIRECT_URI,
				              );

				    // Authentication request
				    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);

				    // Needed to identify request when it returns to us
				    $_SESSION['state'] = $params['state'];

				    // Redirect user to authenticate
				    header("Location: $url");
				    exit;
				}

				function getAccessToken() {
				    $params = array('grant_type' => 'authorization_code',
				                    'client_id' => API_KEY,
				                    'client_secret' => API_SECRET,
				                    'code' => $_GET['code'],
				                    'redirect_uri' => REDIRECT_URI,
				              );

				    // Access Token request
				    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);

				    // Tell streams to make a POST request
				    $context = stream_context_create(
				                    array('http' =>
				                        array('method' => 'POST',
				                        )
				                    )
				                );

				    // Retrieve access token information
				    $response = file_get_contents($url, false, $context);

				    // Native PHP object, please
				    $token = json_decode($response);

				    // Store access token and expiration time
				    $_SESSION['access_token'] = $token->access_token; // guard this!
				    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
				    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

				    return true;
				}

				function fetch($method, $resource, $body = '') {
				    $params = array('oauth2_access_token' => $_SESSION['access_token'],
				                    'format' => 'json',
				              );

				    // Need to use HTTPS
				    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
				    // Tell streams to make a (GET, POST, PUT, or DELETE) request
				    $context = stream_context_create(
				                    array('http' =>
				                        array('method' => $method,
				                        )
				                    )
				                );


				    // Hocus Pocus
				    $response = file_get_contents($url, false, $context);

				    // Native PHP object, please
				    return json_decode($response);
				}
*/

				//wp_enqueue_script('wpsite_rehare_jquery', self::$jquery);
				//wp_enqueue_script('wpsite_twitter_reshare_linkedin_src', plugins_url(self::$api_linkedin_dir, __FILE__ ));
				//wp_localize_script('wpsite_twitter_reshare_linkedin_src', 'wpsite_linkedin', $wpsite_linkedin);

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

		/* All accounts */

		/*
else {
			$settings = get_option('wpsite_twitter_reshare_settings');

			if ($settings === false)
				return null;

			foreach ($settings['accounts'] as $account) {

				if ($account['status'] == 'active') {

					$reshare_args = array();
					$reshare_args = self::wpsite_get_rand_post_and_message($account);
					$reshare_args['test'] = false;

					if (isset($reshare_args['post']) && isset($reshare_args['message']) && is_array($reshare_args['post']) && is_array($reshare_args['message'])) {
						self::wpsite_post_to_channel($account, $reshare_args);
					}
				}
			}
		}
*/
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

		$min_age = mktime(0, 0, 0, date("m")  , date("d") - $account['post_filter']['min_age'], date("Y"));

		$max_age = mktime(0, 0, 0, date("m")  , date("d") - $account['post_filter']['max_age'], date("Y"));

		$settings = get_option('wpsite_twitter_reshare_settings');

		if (isset($settings['exclude_posts']) && is_array($settings['exclude_posts']) && count($settings['exclude_posts']) > 0) {
			$exclude_posts = array();

			foreach ($settings['exclude_posts'] as $post_id => $exclude_post) {
				if ($exclude_post) {
					$exclude_posts[] = $post_id;
				}
			}
		}

		$posts = get_posts(array(
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
						'day'   => (int) date('d',$max_age)
					),
					'before'    => array(
						'year'  => (int) date('Y',$min_age),
						'month' => (int) date('m',$min_age),
						'day'   => (int) date('d',$min_age)
					),
					'inclusive' => true,
				),
			)
		));

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

	/**
	 * Returns a valid shortened url
	 *
	 * @param	string	$url
	 *
	 * @return	string	shortened url
	 *
	 * @since 1.0.0
	 */
	static function wpsite_get_shortened_url($url)  {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
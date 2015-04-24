<?php
/*
Plugin Name: 99 Robots Content Resharer
plugin URI: http://www.99robots.com/content-resharer
Description: This plugin allows site owners to reshare their content automatically on a schedule to bring new life to existing posts and increase traffic.
version: 1.1.4
Author: 99 Robots
Author URI: http://www.99robots.com
License: GPL2
*/

/**
 * Global Definitions
 */

/* Plugin Name */

if (!defined('WPSITE_TWITTER_RESHARE_PLUGIN_NAME'))
    define('WPSITE_TWITTER_RESHARE_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('WPSITE_TWITTER_RESHARE_PLUGIN_DIR'))
    define('WPSITE_TWITTER_RESHARE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPSITE_TWITTER_RESHARE_PLUGIN_NAME);

/* Plugin url */

if (!defined('WPSITE_TWITTER_RESHARE_PLUGIN_URL'))
    define('WPSITE_TWITTER_RESHARE_PLUGIN_URL', WP_PLUGIN_URL . '/' . WPSITE_TWITTER_RESHARE_PLUGIN_NAME);

/* Plugin text-domain */

if (!defined('WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN'))
    define('WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN', 'wpsite-twitter-reshare');

/* Plugin verison */

if (!defined('WPSITE_TWITTER_RESHARE_VERSION_NUM'))
    define('WPSITE_TWITTER_RESHARE_VERSION_NUM', '1.1.4');


/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('WPsiteTwitterReshare', 'wpsite_register_activation'));
register_deactivation_hook( __FILE__, array('WPsiteTwitterReshare', 'wpsite_register_deactivation'));

/**
 * Hooks / Filter
 */

add_action('init', array('WPsiteTwitterReshare', 'wpsite_load_textdoamin'));
add_action('admin_menu', array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_menu_page'));
add_filter('cron_schedules', array('WPsiteTwitterReshare','wpsite_twitter_reshare_create_schedule_intervals'));

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('WPsiteTwitterReshare', 'plugin_links'));

$wpsite_twitter_reshare_settings = get_option('wpsite_twitter_reshare_settings');

if ($wpsite_twitter_reshare_settings !== false) {

	foreach ($wpsite_twitter_reshare_settings['accounts'] as $account) {
		add_action('wpsite_twitter_reshare_' . $account['id'], array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_schedule_post'), 10 ,1);
	}
}

/**
 * WPsite Twitter Reshare main class
 *
 * @since 1.0.0
 * @author Kyle Benk <kjbenk@gmail.com>
 */

class WPsiteTwitterReshare {

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
	 * prefix_dash
	 *
	 * (default value: 'wpsite_twitter_reshare_')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $prefix_dash = 'wpsite-twitter-reshare-';

	/**
	 * text_domain
	 *
	 * (default value: WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN)
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $text_domain = WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN;

	/**
	 * default
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $default = array(
		'accounts'		=> array(),
		'messages'		=> array(),
		'exclude_posts'	=> array()
	);

	/**
	 * default_account
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $default_account = array(
		'id'			=> 'twitter',
		'type'			=> 'twitter',
		'label'			=> 'twitter',
		'status'		=> 'active',
		'twitter'		=> array(
			'consumer_key'		=> '',
			'consumer_secret'	=> '',
			'token'				=> '',
			'token_secret'		=> '',
			'profile_image'		=> '',
			'screen_name'		=> ''
		),
		'general' 		=> array(
			'reshare_content'		=> 'title',
			'bitly_url_shortener'	=> '',
			'hashtag_type'			=> 'none',
			'specific_hashtags'		=> '',
			'featured_image'		=> false,
			'include_link'			=> false,
			'min_interval'			=> '6', 	//hours
		),
		'post_filter'	=> array(
			'min_age'		=> '30',			//days
			'max_age'		=> '60',			//days
			'post_types'	=> array(
			),
			'exclude_categories'	=> array(
			)
		)
	);

	/**
	 * default_message
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $default_message = array(
		'id'		=> '',
		'message'	=> '',
		'place'		=> 'before'
	);

	/**
	 * default_exclude_posts
	 *
	 * (default value: array())
	 *
	 * @var array
	 * @access private
	 * @static
	 */
	private static $default_exclude_posts = array();

	/**
	 * min_interval
	 *
	 * (default value: 2)
	 *
	 * @var int
	 * @access private
	 * @static
	 */
	private static $min_interval = 2;

	/**
	 * account_dashboard_page
	 *
	 * (default value: 'wpsite-twitter-reshare-account-dashboard')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $account_dashboard_page = 'wpsite-twitter-reshare-account-dashboard';

	/**
	 * message_dashboard_page
	 *
	 * (default value: 'wpsite-twitter-reshare-settings-messages')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $message_dashboard_page = 'wpsite-twitter-reshare-settings-messages';

	/**
	 * exclude_posts_page
	 *
	 * (default value: 'wpsite-twitter-reshare-settings-exclude-posts')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $exclude_posts_page = 'wpsite-twitter-reshare-settings-exclude-posts';

	/**
	 * help_page
	 *
	 * (default value: 'wpsite-twitter-reshare-settings-help')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $help_page = 'wpsite-twitter-reshare-settings-help';

	/**
	 * faq_page
	 *
	 * (default value: 'wpsite-twitter-reshare-settings-faq')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $faq_page = 'wpsite-twitter-reshare-settings-faq';

	/**
	 * api_key
	 *
	 * (default value: 'kEKsMXElcPUvMFIRq9nJuTGoe')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $api_key = 'kEKsMXElcPUvMFIRq9nJuTGoe';

	/**
	 * api_secret
	 *
	 * (default value: '1EQWMgveYs4Zok50xhb2ThQAn4SH29Hjk76oXEFfvVsMWlZBne')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $api_secret = '1EQWMgveYs4Zok50xhb2ThQAn4SH29Hjk76oXEFfvVsMWlZBne';

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function wpsite_load_textdoamin() {
		load_plugin_textdomain(WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN, false, WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/languages');
		require_once('wpsite_twitter_reshare_schedule_post.php');
		require_once('wpsite_twitter_add_post_meta_box.php');
	}

	/**
	 * Hooks to 'register_activation_hook'
	 *
	 * @since 1.0.0
	 */
	static function wpsite_register_activation() {

		/* Adds version number to database */

		if (function_exists("is_multisite") && is_multisite()) {
			add_site_option(self::$prefix . 'version', WPSITE_TWITTER_RESHARE_VERSION_NUM);

			global $wpdb;

			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

		    foreach ( $blog_ids as $blog_id ) {
		        switch_to_blog( $blog_id );

		        $settings = get_option('wpsite_twitter_reshare_settings');

				/* Default values */

				if ($settings === false) {
					$settings = array(
						'accounts'		=> array(
							'twitter' 	=> array(
								'id'			=> 'twitter',
								'type'			=> 'twitter',
								'label'			=> 'twitter',
								'status'		=> 'active',
								'twitter'		=> array(
									'consumer_key'		=> '',
									'consumer_secret'	=> '',
									'token'				=> '',
									'token_secret'		=> ''
								),
								'general' 		=> array(
									'reshare_content'		=> 'title',
									'bitly_url_shortener'	=> '',
									'hashtag_type'			=> 'none',
									'specific_hashtags'		=> '',
									'featured_image'		=> false,
									'include_link'			=> false,
									'min_interval'			=> '6', 	//hours
								),
								'post_filter'	=> array(
									'min_age'		=> '30',			//days
									'max_age'		=> '60',			//days
									'post_types'	=> array(
									),
									'exclude_categories'	=> array(
									)
								)
							)
						),
						'messages'		=> array(
							'message' => array(
								'id'		=> 'message',
								'message'	=> '',
								'place'		=> 'front'
							)
						),
						'exclude_posts'	=> array()
					);

					update_option('wpsite_twitter_reshare_settings', $settings);
				}
		    }

			restore_current_blog();

		} else {
			add_option(self::$prefix . 'version', WPSITE_TWITTER_RESHARE_VERSION_NUM);

			$settings = get_option('wpsite_twitter_reshare_settings');

			/* Default values */

			if ($settings === false) {
				$settings = array(
					'accounts'		=> array(
						'twitter' 	=> array(
							'id'			=> 'twitter',
							'type'			=> 'twitter',
							'label'			=> 'twitter',
							'status'		=> 'active',
							'twitter'		=> array(
								'consumer_key'		=> '',
								'consumer_secret'	=> '',
								'token'				=> '',
								'token_secret'		=> ''
							),
							'general' 		=> array(
								'reshare_content'		=> 'title',
								'bitly_url_shortener'	=> '',
								'hashtag_type'			=> 'none',
								'specific_hashtags'		=> '',
								'featured_image'		=> false,
								'include_link'			=> false,
								'min_interval'			=> '6', 	//hours
							),
							'post_filter'	=> array(
								'min_age'		=> '30',			//days
								'max_age'		=> '60',			//days
								'post_types'	=> array(
								),
								'exclude_categories'	=> array(
								)
							)
						)
					),
					'messages'		=> array(
						'message' => array(
							'id'		=> 'message',
							'message'	=> '',
							'place'		=> 'front'
						)
					),
					'exclude_posts'	=> array()
				);

				update_option('wpsite_twitter_reshare_settings', $settings);
			}
		}
	}

	/**
	 * Hooks to 'register_deactivation_hook'
	 *
	 * @since 1.0.0
	 */
	static function wpsite_register_deactivation() {
		$settings = get_option('wpsite_twitter_reshare_settings');

		foreach ($settings['accounts'] as $account) {
			$hook = 'wpsite_twitter_reshare_' . $account['id'];
			$args = $account;
			$args['status'] = 'active';

			wp_clear_scheduled_hook($hook, array($args));
		}
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	static function plugin_links($links) {
		$settings_link = '<a href="admin.php?page=' . self::$account_dashboard_page . '">Dashboard</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Hooks to 'admin_menu'
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_menu_page() {
	    add_menu_page(
			__('Content Resharer', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
			__('Content Resharer', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$account_dashboard_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings'),
	    	plugin_dir_url(__FILE__) . 'img/wpsite-menu-icon.png'
	    );

	    $account_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	__('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$account_dashboard_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings')
	    );
	    add_action("admin_print_scripts-$account_sub_menu_page" , array('WPsiteTwitterReshare', 'inline_script_dashboard_pages'));

	    $messages_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	__('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$message_dashboard_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings_messages')
	    );
	    add_action("admin_print_scripts-$messages_sub_menu_page" , array('WPsiteTwitterReshare', 'inline_script_dashboard_pages'));

	    $exclude_posts_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	__('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$exclude_posts_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings_exclude_posts')
	    );
	    add_action("admin_print_scripts-$exclude_posts_sub_menu_page" , array('WPsiteTwitterReshare', 'inline_script_dashboard_pages'));

	    $help_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	__('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$help_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings_help')
	    );
	    add_action("admin_print_scripts-$help_sub_menu_page" , array('WPsiteTwitterReshare', 'inline_script_dashboard_pages'));

	    /*
$faq_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('FAQ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	__('FAQ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
	    	'manage_options',
	    	self::$faq_page,
	    	array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_settings_faq')
	    );
	    add_action("admin_print_scripts-$faq_sub_menu_page" , array('WPsiteTwitterReshare', 'inline_script_dashboard_pages'));
*/
	}

	/**
	 * Hooks to 'admin_enqueue_scripts'
	 *
	 * @since 1.0.0
	 */
	static function inline_script_dashboard_pages() {

		wp_enqueue_style('wpsite_twitter_reshare_admin_css', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/css/wpsite_twitter_reshare_admin.css');
	}

	/**
	 * Displays HTML for the Settings sub menu page
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings() {

		$settings = get_option('wpsite_twitter_reshare_settings');

		/* Default values */

		if ($settings === false)
			$settings = self::$default;

		/* Save Data */

		if (isset($_POST['submit']) && check_admin_referer('wpsite_twitter_reshare_admin_settings_add_edit')) {

			/* Default values */

			if ($settings === false)
				$settings = self::$default;

			/* Make sure of no duplicates */

			if (!in_array(strtolower(str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_settings_account_id'])))), $settings['accounts'])) {

				/* Determine Post Types */

				$post_types = get_post_types(array('public' => true));

				$post_types_array = array();

				foreach ($post_types as $post_type) {
					if (isset($_POST['wps_post_filter_post_types_' . $post_type]) && $_POST['wps_post_filter_post_types_' . $post_type])
						$post_types_array[] = $post_type;
				}

				/* Determine Categories to exclude */

				$categories = get_categories();

				$exclude_categories_array = array();

				foreach ($categories as $category) {
					if (isset($_POST['wps_post_filter_exclude_categories_' . strtolower(str_replace(' ','',$category->name))]) && $_POST['wps_post_filter_exclude_categories_' . strtolower(str_replace(' ','',$category->name))])
						$exclude_categories_array[] = $category->cat_ID;
				}

				/* Determine max age of eligible posts */

				$max_age = stripcslashes(sanitize_text_field($_POST['wps_post_filter_max_age']));

				if ((double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_max_age'])) <= (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age']))) {

					if ((double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) < 0) {
						$max_age = '1';
					}else {
						$max_age = (string) ((double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) + 1);
					}
				}

				$account_id = strtolower(str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_settings_account_id']))));

				if (isset($_GET['action']) && $_GET['action'] == 'edit') {
					$hook = self::$prefix . $account_id;
					$args = $settings['accounts'][$account_id];
					wp_clear_scheduled_hook($hook, array($args));
				}

				$settings['accounts'][$account_id] = array(
					'id'			=> $account_id,
					'type'			=> 'twitter',
					'label'			=> stripcslashes(sanitize_text_field($_POST['wps_settings_label'])),
					'status'		=> $_POST['wps_settings_status'],
					'twitter'		=> array(
						'consumer_key'		=> $settings['accounts'][$account_id]['twitter']['consumer_key'],
						'consumer_secret'	=> $settings['accounts'][$account_id]['twitter']['consumer_secret'],
						'token'				=> $settings['accounts'][$account_id]['twitter']['token'],
						'token_secret'		=> $settings['accounts'][$account_id]['twitter']['token_secret'],
						'profile_image'		=> $settings['accounts'][$account_id]['twitter']['profile_image'],
						'screen_name'		=> $settings['accounts'][$account_id]['twitter']['screen_name']
					),
					'general' 		=> array(
						'reshare_content'		=> $_POST['wps_general_reshare_content'],
						'bitly_url_shortener' 	=> stripcslashes(sanitize_text_field($_POST['wps_general_bitly_url_shortener'])),
						'hashtag_type'			=> $_POST['wps_general_hashtag_type'],
						'specific_hashtags'		=> str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_general_specific_hashtags']))),
						'featured_image'		=> isset($_POST['wps_general_featured_image']) && $_POST['wps_general_featured_image'] ? true : false,
						'include_link'			=> isset($_POST['wps_general_include_link']) && $_POST['wps_general_include_link'] ? true : false,
						'min_interval'			=> (double) stripcslashes(sanitize_text_field($_POST['wps_general_min_interval'])) > (double) self::$min_interval
 ? stripcslashes(sanitize_text_field($_POST['wps_general_min_interval'])) : self::$min_interval
 					),
					'post_filter'	=> array(
						'min_age'			=> (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) >= 0 ? (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) : 0,
						'max_age'			=> (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_max_age'])) >= 0 ? (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_max_age'])) : 0,
						'post_types'		=> $post_types_array,
						'exclude_categories'=> $exclude_categories_array
					)
				);

				/* Create the transient for keeping track of reshare interval */

				update_option('wpsite_twitter_reshare_settings', $settings);

				if ($_POST['wps_settings_status'] == 'active') {

					$hook = self::$prefix . $account_id;
					$args = $settings['accounts'][$account_id];

					self::wpsite_twitter_reshare_schedule_reshare_event($hook, array($args));
				}

				?>
				<script type="text/javascript">
					window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$account_dashboard_page; ?>";
				</script>
				<?php
			}
		}

		/* Delete account */

		if (isset($_GET['action']) && $_GET['action'] == 'delete' && check_admin_referer('wpsite_twitter_reshare_admin_settings_delete')) {

			/* Delete current cron job for the account */

			$hook = self::$prefix . $settings['accounts'][$_GET['account']]['id'];
			$args = $settings['accounts'][$_GET['account']];
			$args['status'] = 'active';

			wp_clear_scheduled_hook($hook, array($args));

			unset($settings['accounts'][$_GET['account']]);

			update_option('wpsite_twitter_reshare_settings', $settings);

			?>
			<script type="text/javascript">
				window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$account_dashboard_page; ?>";
			</script>
			<?php
		}

		/* Remove account */

		if (isset($_GET['action']) && $_GET['action'] == 'remove' && check_admin_referer('wpsite_twitter_reshare_admin_settings_remove')) {

			/* Delete current cron job for the account */

			$hook = self::$prefix . $settings['accounts'][$_GET['account']]['id'];
			$args = $settings['accounts'][$_GET['account']];
			$args['status'] = 'active';

			wp_clear_scheduled_hook($hook, array($args));

			$settings['accounts'][$_GET['account']][$_GET['type']]['token'] = '';
			$settings['accounts'][$_GET['account']][$_GET['type']]['token_secret'] = '';
			$settings['accounts'][$_GET['account']][$_GET['type']]['profile_image'] = '';
			$settings['accounts'][$_GET['account']][$_GET['type']]['screen_name'] = '';

			update_option('wpsite_twitter_reshare_settings', $settings);

			//delete_transient('wpsite_content_reshare_acccount_verify');

			?>
			<script type="text/javascript">
				window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$account_dashboard_page; ?>";
			</script>
			<?php
		}

		/* Activate / Deactivate */

		if (isset($_GET['action']) && $_GET['action'] == 'activate' && check_admin_referer('wpsite_twitter_reshare_admin_settings_activate')) {

			$hook = self::$prefix . $settings['accounts'][$_GET['account']]['id'];
			$args = $settings['accounts'][$_GET['account']];

			if ($settings['accounts'][$_GET['account']]['status'] == 'active') {
				$settings['accounts'][$_GET['account']]['status'] = 'inactive';

				/* Delete current cron job for the account */

				wp_clear_scheduled_hook($hook, array($args));
			}else {
				$settings['accounts'][$_GET['account']]['status'] = 'active';
				$args['status'] = 'active';

				self::wpsite_twitter_reshare_schedule_reshare_event($hook, array($args));
			}

			update_option('wpsite_twitter_reshare_settings', $settings);

			?>
			<script type="text/javascript">
				window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$account_dashboard_page; ?>";
			</script>
			<?php
		}

		/* Reshare Now */

		if (isset($_GET['action']) && $_GET['action'] == 'reshare' && check_admin_referer('wpsite_twitter_reshare_admin_settings_reshare_now')) {

			require_once('wpsite_twitter_reshare_schedule_post.php');

			if ($settings !== false) {

				$wpsite_reschedule = new WPsiteTwitterResharePost();

				$wpsite_reschedule->wpsite_setup_all_reshares($settings['accounts'][$_GET['account']], true);

				?>
				<script type="text/javascript">
					window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$account_dashboard_page; ?>";
				</script>
				<?php
			}
		}

		/* Display table */

		if (!isset($_GET['action'])) {
			self::wpsite_twitter_reshare_settings_table();
		}

		/* Add new account */

		if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_add_edit')) {
			wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js');
			self::wpsite_twitter_reshare_settings_add_edit();
		}

		/* Edit existing account */

		if (isset($_GET['action']) && $_GET['action'] == 'edit' && check_admin_referer('wpsite_twitter_reshare_admin_settings_add_edit')) {
			wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js');
			self::wpsite_twitter_reshare_settings_add_edit($_GET['account']);
		}
	}

	/**
	 * Displays HTML for the Account sub menu page table
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_table() {

		require_once('admin/account_dashboard.php');

		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js');

		wp_localize_script('wpsite_twitter_reshare_admin_js', 'wpsite_twitter_reshare_accounts_ahref', $wpsite_twitter_reshare_ahref_array);
	}

	/**
	 * Displays HTML for the Account sub menu page add new
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_add_edit($account_id = null) {

		$settings_all = get_option('wpsite_twitter_reshare_settings');

		/* Edit */

		if (isset($account_id)) {
			$settings = $settings_all['accounts'][$account_id];
		} else {
			$settings = self::$default_account;
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-tabs');

		require_once('admin/account_add_edit.php');
	}

	/**
	 * Displays HTML for the Messages sub menu page
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_messages() {

		$settings = get_option('wpsite_twitter_reshare_settings');

		/* Default values */

		if ($settings === false)
			$settings = self::$default;

		/* Save Data */

		if (isset($_POST['submit']) && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) {

			$settings = get_option('wpsite_twitter_reshare_settings');

			/* Default values */

			if ($settings === false)
				$settings = self::$default;

			if (!in_array(strtolower(str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_settings_message_id'])))), $settings['messages'])) {

				$settings['messages'][strtolower(str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_settings_message_id']))))] = array(
					'id'		=> strtolower(str_replace(' ','',stripcslashes(sanitize_text_field($_POST['wps_settings_message_id'])))),
					'message'	=> stripcslashes(sanitize_text_field($_POST['wps_settings_message_text'])),
					'place'		=> $_POST['wps_settings_message_place']
				);

				update_option('wpsite_twitter_reshare_settings', $settings);

				?>
				<script type="text/javascript">
					window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$message_dashboard_page; ?>";
				</script>
				<?php
			}
		}

		/* Delete message */

		if (isset($_GET['action']) && $_GET['action'] == 'delete' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_delete')) {

			$settings = get_option('wpsite_twitter_reshare_settings');

			unset($settings['messages'][$_GET['message']]);

			update_option('wpsite_twitter_reshare_settings', $settings);

			?>
			<script type="text/javascript">
				window.location = "<?php echo get_admin_url(); ?>admin.php?page=<?php echo self::$message_dashboard_page; ?>";
			</script>
			<?php
		}

		require_once('admin/messages_dashboard.php');

		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js');

		wp_localize_script('wpsite_twitter_reshare_admin_js', 'wpsite_twitter_reshare_messages_ahref', $wpsite_twitter_reshare_ahref_array);
	}

	/**
	 * Displays HTML for the Messages sub menu page add / edit
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_messages_add_edit($message_id = null) {

		$settings = get_option('wpsite_twitter_reshare_settings');

		/* Edit */

		if (isset($message_id)) {
			$settings = $settings['messages'][$message_id];
		} else {
			$settings = self::$default_message;
		}

		require('admin/messages_add_edit.php');
	}

	/**
	 * Load the exclude Posts Page
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_exclude_posts() {

		$settings = get_option('wpsite_twitter_reshare_settings');

		/* Default values */

		if ($settings === false)
			$settings = self::$default;

		/* Edit */

		if (!isset($settings['exclude_posts']))
			$settings_exclude_posts = self::$default_exclude_posts;
		else
			$settings_exclude_posts = $settings['exclude_posts'];

		/* Save Data */

		if (isset($_POST['submit']) && check_admin_referer('wpsite_twitter_reshare_admin_settings_exclude_posts_edit')) {

			$settings = get_option('wpsite_twitter_reshare_settings');

			/* Default values */

			if ($settings === false)
				$settings = self::$default;

			if (!isset($settings['exclude_posts']))
				$settings_exclude_posts = self::$default_exclude_posts;
			else
				$settings_exclude_posts = $settings['exclude_posts'];

			$posts = get_posts(array('posts_per_page' => -1, 'post_type' => 'any'));

			foreach ($posts as $post) {

				if (isset($_POST['wps_settings_exclude_posts_' . $post->ID]) && $_POST['wps_settings_exclude_posts_' . $post->ID])
					$settings_exclude_posts[$post->ID] = true;
				else
					$settings_exclude_posts[$post->ID] = false;
			}

			$settings['exclude_posts'] = $settings_exclude_posts;

			update_option('wpsite_twitter_reshare_settings', $settings);
		}

		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js');

		$categories = get_categories();

		$cat_ID = array();

		foreach ($categories as $cat) {
			$cat_ID[] = $cat->cat_ID;
		}

		wp_localize_script('wpsite_twitter_reshare_admin_js', 'categories', $cat_ID);

		require_once('admin/exclude_posts.php');
	}

	/**
	 * Load the Help Page
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_help() {
		require_once('admin/help.php');
	}

	/**
	 * Load the FAQ Page
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_faq() {
		require_once('admin/faq.php');
	}

	/**
	 * Used to schedule cron jobs, will delete the job and then create a new one
	 *
	 * @since 1.0.0
	 *
	 * @param	string	$hook: name of the schedule action
	 * @param	array	$account: holds all account data
	 */
	static function wpsite_twitter_reshare_schedule_reshare_event($hook, $account) {

		/* Delete current cron job for the account */

		$result = wp_schedule_event(time(), $hook . '_recurrence', $hook, $account);

		if ($result === false) {
			error_log('WPsiteRehare:: failed to schedule the cron job using wp_schedule_event()');
		}
	}

	/**
	 * Function used to call the WPsiteTwitterResharePost class
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_schedule_post($account) {

		require_once('wpsite_twitter_reshare_schedule_post.php');

		$wpsite_reschedule = new WPsiteTwitterResharePost();

		$wpsite_reschedule->wpsite_setup_all_reshares($account, false);
	}

	/**
	 * Used to schedule cron jobs, will delete the job and then create a new one
	 *
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_create_schedule_intervals($schedules) {

		$settings = get_option('wpsite_twitter_reshare_settings');

		if ($settings === false)
			$settings = self::$default;

		/* Delete all intervals */

		foreach ($schedules as $schedule_id => $schedule_val) {
			if (substr($schedule_id, 0, strlen(self::$prefix)) == self::$prefix) {
				unset($schedules[$schedule_id]);
			}
		}

		/* Create all intervals */

		foreach ($settings['accounts'] as $account) {
			$schedules[self::$prefix . $account['id'] . '_recurrence'] = array(
		 		'interval' 	=> (double) $account['general']['min_interval'] * 60 * 60,
		 		'display' 	=> __(self::$prefix . $account['id'] . '_recurrence', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN)
		 	);
		}

	 	return $schedules;
	}
}

?>
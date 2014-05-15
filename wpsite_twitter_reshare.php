<?php
/*
Plugin Name: WPsite Twitter Reshare Beta
plugin URI:
Description: Automatically tweets all your posts so you dont have to.
version: 0.9
Author: Kyle Benk
Author URI: http://kylebenkapps.com
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
    define('WPSITE_TWITTER_RESHARE_VERSION_NUM', '0.9.0');
 
 
/** 
 * Activatation / Deactivation 
 */  

register_activation_hook( __FILE__, array('WPsiteTwitterReshare', 'wpsite_register_activation'));

/** 
 * Hooks / Filter 
 */
 
add_action('init', array('WPsiteTwitterReshare', 'wpsite_load_textdoamin'));
add_action('admin_menu', array('WPsiteTwitterReshare', 'wpsite_twitter_reshare_menu_page'));
add_filter('cron_schedules', array('WPsiteTwitterReshare','wpsite_twitter_reshare_create_schedule_intervals'));

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

	private static $class_name = 'WPsiteTwitterReshare';

	private static $prefix = 'wpsite_twitter_reshare_';
	
	private static $default = array(
		'accounts'		=> array(),
		'messages'		=> array(),
		'exclude_posts'	=> array()
	);
	
	private static $default_account = array(
		'id'			=> '',
		'type'			=> 'twitter',
		'label'			=> '',
		'status'		=> 'active',
		'twitter'		=> array(
			'consumer_key'		=> '',
			'consumer_secret'	=> '',
			'token'				=> '',
			'token_secret'		=> ''
		),
		'general' 		=> array(
			'reshare_content'		=> 'title',
			'url_shortener'			=> '',
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
	
	private static $default_message = array(
		'id'		=> '',
		'message'	=> '',
		'place'		=> 'front'
	);
	
	private static $default_exclude_posts = array();
	
	private static $min_interval = 2;
	
	private static $account_dashboard_page = 'wpsite-twitter-reshare-account-dashboard';
	
	private static $message_dashboard_page = 'wpsite-twitter-reshare-settings-messages';
	
	private static $exclude_posts_page = 'wpsite-twitter-reshare-settings-exclude-posts';
	
	private static $help_page = 'wpsite-twitter-reshare-settings-help';
	
	private static $faq_page = 'wpsite-twitter-reshare-settings-faq';

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
	 * Hooks to 'init' 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_register_activation() {
		
		/* Adds version number to database */
		
		if (is_multisite()) {
			add_site_option('wpsite_twitter_reshare_version', WPSITE_TWITTER_RESHARE_VERSION_NUM);
		} else {
			add_option('wpsite_twitter_reshare_version', WPSITE_TWITTER_RESHARE_VERSION_NUM);
		}
		
		add_option('wpsite_twitter_reshare_settings', self::$default);
	}
	
	/**
	 * Hooks to 'admin_menu' 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_menu_page() {
	    add_menu_page(
			__('WPsite Twitter Reshare', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN),
			__('WPsite Twitter Reshare', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$account_dashboard_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings')
	    );
	    
	    $account_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page,
	    	__('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	__('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$account_dashboard_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings')
	    );
	    add_action("admin_print_scripts-$account_sub_menu_page" , array(self::$class_name, 'inline_script_dashboard_pages'));
	    
	    $messages_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page, 
	    	__('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	__('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$message_dashboard_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings_messages')
	    );
	    add_action("admin_print_scripts-$messages_sub_menu_page" , array(self::$class_name, 'inline_script_dashboard_pages'));
	    
	    $exclude_posts_sub_menu_page = add_submenu_page(
	    	self::$account_dashboard_page, 
	    	__('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	__('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$exclude_posts_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings_exclude_posts')
	    );
	    add_action("admin_print_scripts-$exclude_posts_sub_menu_page" , array(self::$class_name, 'inline_script_dashboard_pages'));
	    
	    add_submenu_page(
	    	self::$account_dashboard_page, 
	    	__('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	__('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$help_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings_help')
	    );
	    
	    add_submenu_page(
	    	self::$account_dashboard_page, 
	    	__('FAQ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	__('FAQ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), 
	    	'manage_options', 
	    	self::$faq_page, 
	    	array(self::$class_name, 'wpsite_twitter_reshare_settings_faq')
	    );
	}
	
	/**
	 * Hooks to 'admin_enqueue_scripts' 
	 * 
	 * @since 1.0.0
	 */
	static function inline_script_dashboard_pages() {
	
		wp_enqueue_style('wpsite_twitter_reshare_admin_css', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/css/wpsite_twitter_reshare_admin.css');
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
			
			$settings = get_option('wpsite_twitter_reshare_settings');
			
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
						'consumer_key'		=> stripcslashes(sanitize_text_field($_POST['wps_twitter_consumer_key'])),
						'consumer_secret'	=> stripcslashes(sanitize_text_field($_POST['wps_twitter_consumer_secret'])),
						'token'				=> stripcslashes(sanitize_text_field($_POST['wps_twitter_token'])),
						'token_secret'		=> stripcslashes(sanitize_text_field($_POST['wps_twitter_token_secret']))
					),
					'general' 		=> array(
						'reshare_content'	=> $_POST['wps_general_reshare_content'],
						//'url_shortener'		=> $_POST['wps_general_url_shortener'],
						'featured_image'	=> isset($_POST['wps_general_featured_image']) && $_POST['wps_general_featured_image'] ? true : false,
						'include_link'		=> isset($_POST['wps_general_include_link']) && $_POST['wps_general_include_link'] ? true : false,
						'min_interval'		=> (double) stripcslashes(sanitize_text_field($_POST['wps_general_min_interval'])) > (double) self::$min_interval
 ? stripcslashes(sanitize_text_field($_POST['wps_general_min_interval'])) : '4' 				
 					),
					'post_filter'	=> array(
						'min_age'			=> (double) stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) >= 0 ? stripcslashes(sanitize_text_field($_POST['wps_post_filter_min_age'])) : 0,			
						'max_age'			=> $max_age,			
						'post_types'		=> $post_types_array,
						'exclude_categories'=> $exclude_categories_array
					)
				);
				
				
				//if (!in_array($account_id, $settings['accounts'])) {
						
				/* Create the transient for keeping track of reshare interval */
			
				update_option('wpsite_twitter_reshare_settings', $settings);
			
				if ($_POST['wps_settings_status'] == 'active') {
					$hook = self::$prefix . $account_id;
					$args = $settings['accounts'][$account_id];
					
					self::wpsite_twitter_reshare_schedule_reshare_event($hook, array($args));
				}
				
				//}
				
				?>
				<script type="text/javascript">
					window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$account_dashboard_page; ?>";
				</script>
				<?php
			}
		}
		
		/* Delete account */
		
		if (isset($_GET['action']) && $_GET['action'] == 'delete' && check_admin_referer('wpsite_twitter_reshare_admin_settings_delete')) {
			
			$settings = get_option('wpsite_twitter_reshare_settings');
			
			/* Delete current cron job for the account */
			
			$hook = self::$prefix . $settings['accounts'][$_GET['account']]['id'];
			$args = $settings['accounts'][$_GET['account']];
			$args['status'] = 'active';
			
			wp_clear_scheduled_hook($hook, array($args));
			
			unset($settings['accounts'][$_GET['account']]);
			
			update_option('wpsite_twitter_reshare_settings', $settings);
				
			?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$account_dashboard_page; ?>";
			</script>
			<?php
		}
		
		/* Activate / Deactivate */
		
		if (isset($_GET['action']) && $_GET['action'] == 'activate' && check_admin_referer('wpsite_twitter_reshare_admin_settings_activate')) {
		
			$settings = get_option('wpsite_twitter_reshare_settings');
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
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$account_dashboard_page; ?>";
			</script>
			<?php
		}
		
		/* Reshare Now */
		
		if (isset($_GET['action']) && $_GET['action'] == 'reshare' && check_admin_referer('wpsite_twitter_reshare_admin_settings_reshare_now')) {
			
			require_once('wpsite_twitter_reshare_schedule_post.php');
			
			$settings = get_option('wpsite_twitter_reshare_settings');
			
			if ($settings !== false) {
				
				$wpsite_reschedule = new WPsiteTwitterResharePost();
				
				$wpsite_reschedule->wpsite_setup_all_reshares($settings['accounts'][$_GET['account']], true);
				
				//if ($settings['accounts'][$_GET['account']]['type'] != 'facebook') {
					?>
					<script type="text/javascript">
						window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$account_dashboard_page; ?>";
					</script>
					<?php
				//}
			}
		}
		
		/* Display table */
		
		if (!isset($_GET['action'])) {
			self::wpsite_twitter_reshare_settings_table();
		}
		
		/* Add new account */
		
		if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_add_edit')) {
			wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/js/wpsite_twitter_reshare_admin.js');
			self::wpsite_twitter_reshare_settings_add_edit();
		}
		
		/* Edit existing account */
		
		if (isset($_GET['action']) && $_GET['action'] == 'edit' && check_admin_referer('wpsite_twitter_reshare_admin_settings_add_edit')) {
			wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/js/wpsite_twitter_reshare_admin.js');
			self::wpsite_twitter_reshare_settings_add_edit($_GET['account']);
		}
	}
	
	/**
	 * Displays HTML for the Account sub menu page table 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_table() {
		?>
		<div class="wrap">
			<div id="icon-edit" class="icon32 icon32-posts-post"><br/></div>
			<h2><?php _e('WPsite Twitter Reshare Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=add', 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Add New', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></h2>
		
		<br />
		
		<table class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Min Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Min Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
				</tr>
			</tfoot>
			<tbody><?php
				
				$wpsite_twitter_reshare_ahref_array = array();
				
				$settings = get_option('wpsite_twitter_reshare_settings');
				
				/* Default values */
				
				if ($settings === false) 
					$settings = self::$default;
					
				foreach ($settings['accounts'] as $account) {
					
					$wpsite_twitter_reshare_ahref_array[] = $account['id'];
					
					?> 
					<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
						<!-- This will result in the delete link not showing up on hove, if class must be changed contact kjbenk@gmail.com first -->
					<tr class="wpsite_twitter_reshare_admin_accounts_delete_tr wpsite_twitter_reshare_admin_accounts_delete_tr<?php echo $account['id']; ?>">
					<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
					
						<!-- Status -->
						
						<td>
							<label><?php echo (isset($account['status']) && $account['status'] != '' ? __($account['status'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br />
							<!-- Activate / Deactivate -->
							
							<a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=activate&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_activate'); ?>"><?php echo $account['status'] == 'active' ? __('Deactivate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : __('Activate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
						</td>
					
						<!-- Account ID -->
						
						<td>
							
							<!-- ID Name -->
							
							<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><strong><?php _e($account['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a><br />
							
							<!-- Edit -->
							
							<!-- <a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
						</td>
						
						<!-- Label -->
						
						<td> 
							<label><?php echo (isset($account['label']) && $account['label'] != '' ? __($account['label'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br/>
							<!-- Delete -->
							
							<label class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" style="color:red;"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<label id="wpsite_twitter_reshare_delete_url_<?php echo $account['id']; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=delete&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_delete'); ?></label>
							
							<!-- <a style="color:red" class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=delete&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_delete'); ?>"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
						</td>
						
						
						<!-- Minimun Interval -->
						
						<td> 
							<label><?php echo (isset($account['general']['min_interval']) && $account['general']['min_interval'] != '' ? __($account['general']['min_interval'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br />
							
							<!-- Reshare Now -->
							
							<a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=reshare&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_reshare_now'); ?>"><?php _e('Reshare Now', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> 
						</td>
						
						<!-- Type -->
						
						<td> <?php echo (isset($account['type']) && $account['type'] != '' ? __($account['type'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?> </td>
					</tr><?php
				}
					
			?></tbody>
		</table>
		</div>
		<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		<?php
		
		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/js/wpsite_twitter_reshare_admin.js');
		
		wp_localize_script('wpsite_twitter_reshare_admin_js', 'wpsite_twitter_reshare_accounts_ahref', $wpsite_twitter_reshare_ahref_array);
	}
	
	/**
	 * Displays HTML for the Account sub menu page add new 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_add_edit($account_id = null) {
	
		$settings = get_option('wpsite_twitter_reshare_settings');
		
		/* Edit */
	
		if (isset($account_id)) 
			$settings = $settings['accounts'][$account_id];
		else
			$settings = self::$default_account;
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-tabs');
		?>
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$( "#tabs" ).tabs();
		});
		</script>
		
		<div class="wrap wpsite_admin_panel">
			<div class="wpsite_admin_panel_banner">
				<h1><?php _e('WPsite Twitter Reshare Settings', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
			</div>
					
			<div id="wpsite_admin_panel_settings" class="wpsite_admin_panel_content">
				
				<form method="post" id="wpsite_twitter_reshare_account_form">
				
				<div id="tabs">
						<ul>
							<li><a href="#wpsite_twitter_reshare_keys"><span class="wpsite_admin_panel_content_tabs"><?php _e('ID and Keys', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span></a></li>
							<li><a href="#wpsite_twitter_reshare_general"><span class="wpsite_admin_panel_content_tabs"><?php _e('General', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span></a></li>
							<li><a href="#wpsite_twitter_reshare_content"><span class="wpsite_admin_panel_content_tabs"><?php _e('Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span></a></li>
							<li><a href="#wpsite_twitter_reshare_filters"><span class="wpsite_admin_panel_content_tabs"><?php _e('Filters', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span></a></li>
						</ul>
						
						<div id="wpsite_twitter_reshare_keys">
							
							<h3><?php _e('Required', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						
							<table>
								<tbody>
								
									<!-- ID -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Account ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_settings_account_id" name="wps_settings_account_id" type="text" size="60" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" <?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? "readonly" : ''; ?>>
											</td>
										</th>
									</tr>
									
									<!-- Twitter Consumer Key -->
									
									<tr class="wpsite_api_settings_twitter">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Consumer Key', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_twitter_consumer_key" name="wps_twitter_consumer_key" type="text" size="60" value="<?php echo esc_attr($settings['twitter']['consumer_key']); ?>">
											</td>
										</th>
									</tr>
									
									<!-- Twitter Consumer Secret -->
									
									<tr class="wpsite_api_settings_twitter">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Consumer Secret', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_twitter_consumer_secret" name="wps_twitter_consumer_secret" type="text" size="60" value="<?php echo esc_attr($settings['twitter']['consumer_secret']); ?>">
											</td>
										</th>
									</tr>
									
									<!-- Twitter Token -->
									
									<tr class="wpsite_api_settings_twitter">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Access Token', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_twitter_token" name="wps_twitter_token" type="text" size="60" value="<?php echo esc_attr($settings['twitter']['token']); ?>">
											</td>
										</th>
									</tr>
									
									<!-- Twitter Token Secret -->
									
									<tr class="wpsite_api_settings_twitter">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Access Token Secret', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_twitter_token_secret" name="wps_twitter_token_secret" type="text" size="60" value="<?php echo esc_attr($settings['twitter']['token_secret']); ?>">
											</td>
										</th>
									</tr>
									
								</tbody>
							</table>
						
						</div>
						
						<div id="wpsite_twitter_reshare_general">
						
							<h3><?php _e('General', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						
							<table>
								<tbody>
						
									<!-- Status -->
								
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<select id="wps_settings_status" name="wps_settings_status">
													<option value="active"	<?php echo isset($settings['status']) && $settings['status'] = 'active' ? 'selected' : ''; ?>><?php _e('Active', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
													<option value="inactive" <?php echo isset($settings['status']) && $settings['status'] = 'active' ? 'selected' : ''; ?>><?php _e('Inactive', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
												</select>
											</td>
										</th>
									</tr>
									
									<!-- Label -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_settings_label" name="wps_settings_label" type="text" size="60" value="<?php echo esc_attr($settings['label']); ?>"><br /><label><?php _e('Used for meta box name', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											</td>
										</th>
									</tr>
									
									<!-- Minimun Interval to reshare posts -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Minimun interval to reshare posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_min_interval" name="wps_general_min_interval" type="text" size="60" value="<?php echo esc_attr($settings['general']['min_interval']); ?>"><br /><label><?php _e('Units: hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											</td>
										</th>
									</tr>
								
								</tbody>
							</table>
						
						</div>
						
						<div id="wpsite_twitter_reshare_content">
						
							<h3><?php _e('Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						
							<table>
								<tbody>
								
									<!-- Reshare Content -->
						
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Reshare Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<select id="wps_general_reshare_content" name="wps_general_reshare_content">
													<option value="title" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'title' ? 'selected' : ''; ?>><?php _e('Title', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
													
													<option value="content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'content' ? 'selected' : ''; ?>><?php _e('Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
													
													<option value="title_content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'title_content' ? 'selected' : ''; ?>><?php _e('Title and Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
												</select>
											</td>
										</th>
									</tr>
									
									<!-- Include Link -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Include Link', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_include_link" name="wps_general_include_link" type="checkbox" <?php echo isset($settings['general']['include_link']) && $settings['general']['include_link'] ? 'checked="checked"' : ''; ?>>
											</td>
										</th>
									</tr>
									
									<!-- Type of URL Shortener -->
									
									<!--
					<tr class="wpsite_general_include_link">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Type of URL Shortener', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<select id="wps_general_url_shortener" name="wps_general_url_shortener">
													<option value="title" <?php echo isset($settings['general']['url_shortener']) && $settings['general']['url_shortener'] == 'title' ? 'selected' : ''; ?>><?php _e('Title', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
												</select>
											</td>
										</th>
									</tr>
					-->
									
									<!-- Include Featured Image -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Include Featured Image', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_featured_image" name="wps_general_featured_image" type="checkbox" <?php echo isset($settings['general']['featured_image']) && $settings['general']['featured_image'] ? 'checked="checked"' : ''; ?>>
											</td>
										</th>
									</tr>
								
								</tbody>
							</table>
						
						</div>
						
						<div id="wpsite_twitter_reshare_filters">
						
							<h3><?php _e('Post Filters', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						
							<table>
								<tbody>
						
									<!-- Minimun days for eligible -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Minimun days for eligible', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_post_filter_min_age" name="wps_post_filter_min_age" type="text" size="60" value="<?php echo esc_attr($settings['post_filter']['min_age']); ?>"><br /><label><?php _e('Units: days', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											</td>
										</th>
									</tr>
									
									<!-- Maximun days for eligible -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Maximun days for eligible', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_post_filter_max_age" name="wps_post_filter_max_age" type="text" size="60" value="<?php echo esc_attr($settings['post_filter']['max_age']); ?>"><br /><label><?php _e('Units: days', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											</td>
										</th>
									</tr>
									
									<!-- Include these Post Types -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Include these Post Types', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
											
												<?php
												
												/* Get all post types that are public */
												
												$post_types = get_post_types(array('public' => true));
												
												foreach ($post_types as $post_type) {
												?>
													<input type="checkbox" class="wps_post_filter_post_types_class" id="wps_post_filter_post_types_<?php echo $post_type; ?>" name="wps_post_filter_post_types_<?php echo $post_type; ?>" <?php echo (isset($settings['post_filter']['post_types']) && in_array($post_type, $settings['post_filter']['post_types']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $post_type); ?></label><br />
												<?php } ?>
												
											</td>
										</th>
									</tr>
									
									<!-- Exclude Posts in these Categories -->
									
									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Exclude Post in these Categories', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
											
												<?php
												
												/* Get all categories */
												
												$categories = get_categories();
												
												foreach ($categories as $category) { 
													$category_name = strtolower(str_replace(' ','',$category->name));
												?>
													<input type="checkbox" class="wps_post_filter_exclude_categories_class" id="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" name="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" <?php echo (isset($settings['post_filter']['exclude_categories']) && in_array($category->cat_ID, $settings['post_filter']['exclude_categories']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $category->name); ?></label><br />
												<?php } ?>
												
											</td>
										</th>
									</tr>
						
								</tbody>
							</table>
							
						</div>
						
				</div>
				
				<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_add_edit'); ?>
				
				<?php submit_button(); ?>
				
				</form>
		 
			</div>
					
			<div id="wpsite_admin_panel_sidebar" class="wpsite_admin_panel_content">
				<div class="wpsite_admin_panel_sidebar_img">
					<a target="_blank" href="http://wpsite.net"><img src="http://www.wpsite.net/wp-content/uploads/2011/10/logo-only-100h.png"></a>
				</div>
			</div>
		</div>
		<?php
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
					window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$message_dashboard_page; ?>";
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
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$message_dashboard_page; ?>";
			</script>
			<?php
		}
		
		/* Display HTML */
		
		?><div class="wrap nosubsub"><?php
		
			?><h2><?php _e('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h2><?php
			
			?><div class="col-container"><?php
			
				?><div class="wpsite_twitter_reshare_admin_messages_add_edit"><?php 
					if (isset($_GET['action']) && $_GET['action'] == 'edit' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) 
						self::wpsite_twitter_reshare_settings_messages_add_edit($_GET['message']);
					else if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit'))
						self::wpsite_twitter_reshare_settings_messages_add_edit();
					else
						self::wpsite_twitter_reshare_settings_messages_add_edit();
				?></div><?php
				
				?><div class="wpsite_twitter_reshare_admin_messages_table"><?php 
					self::wpsite_twitter_reshare_settings_messages_table();
				?></div><?php
			?></div><?php
		?></div><?php
	}
	
	/**
	 * Displays HTML for the Messages sub menu page table
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_messages_table() {
		?>
		<table class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					<th><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
				</tr>
			</tfoot>
			<tbody><?php
				
				$wpsite_twitter_reshare_ahref_array = array();
				$settings = get_option('wpsite_twitter_reshare_settings');
				
				/* Default values */
				
				if ($settings === false) 
					$settings = self::$default;
					
				foreach ($settings['messages'] as $message) {
					$wpsite_twitter_reshare_ahref_array[] = $message['id']; 
					
					?> 
					<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
						<!-- This will result in the delete link not showing up on hove, if class must be changed contact kjbenk@gmail.com first -->
					<tr class="wpsite_twitter_reshare_admin_messages_delete_tr wpsite_twitter_reshare_admin_messages_delete_tr<?php echo $message['id']; ?>">
					<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
					
						<!-- Account ID -->
						
						<td>
							
							<!-- ID Name -->
							
							<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><strong><?php _e($message['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a><br />
							
							<!-- Edit -->
							
							<a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $message['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
						</td>
						
						<!-- Message -->
						
						<td> 
							<label><?php echo (isset($message['message']) && $message['message'] != '' ? __($message['message'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br/>
							
							<!-- Delete -->
							
							<label class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $message['id']; ?>" style="color:red;"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<label id="wpsite_twitter_reshare_delete_url_<?php echo $message['id']; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=delete&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_delete'); ?></label>
							
							<!-- <a style="color:red" class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $message['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=delete&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_delete'); ?>"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
						</td>
						
						<!-- Place -->
						
						<td> <?php echo (isset($message['place']) && $message['place'] != '' ? __($message['place'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?> </td>
					
					</tr><?php
				}
					
			?></tbody>
		</table>
			<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
		</div>
		
		<?php
		
		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/js/wpsite_twitter_reshare_admin.js');
		
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
	
		if (isset($message_id)) 
			$settings = $settings['messages'][$message_id];
		else
			$settings = self::$default_message;
			
		?>
		<form method="post" id="wpsite_twitter_reshare_message_form">
		
		<table>
			<tbody>
			
				<!-- ID -->
				
				<tr>
					<th class="wpsite_twitter_reshare_admin_table_th">
						<label><?php _e('Message ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						<td class="wpsite_twitter_reshare_admin_table_td">
							<input id="wps_settings_message_id" name="wps_settings_message_id" type="text" size="40" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" <?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? "readonly" : ''; ?>>
						</td>
					</th>
				</tr>
				
				<!-- Message -->
				
				<tr>
					<th class="wpsite_twitter_reshare_admin_table_th">
						<label><?php _e('Message Text', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						<td class="wpsite_twitter_reshare_admin_table_td">
							<input id="wps_settings_message_text" name="wps_settings_message_text" type="text" size="40" value="<?php echo isset($settings['message']) ? $settings['message'] : ''; ?>" placeholder="<?php _e('Check this out:', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>">
						</td>
					</th>
				</tr>
				
				<!-- Place -->
				
				<tr>
					<th class="wpsite_twitter_reshare_admin_table_th">
						<label><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						<td class="wpsite_twitter_reshare_admin_table_td">
							<select id="wps_settings_message_place" name="wps_settings_message_place">
							
								<option value="before" <?php echo isset($settings['place']) && $settings['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
								
								<option value="after" <?php echo isset($settings['place']) && $settings['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
							</select>
						</td>
					</th>
				</tr>
				
				<!-- Preview -->
				
				
				<tr>
					<th class="wpsite_twitter_reshare_admin_table_th">
						<label><?php _e('Preview', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						<td class="wpsite_twitter_reshare_admin_table_td">
						
						<label id="wps_settings_message_preview_before" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							
						<a href="http://wpsite.net" target="_blank"><label><?php _e('http://wpsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label></a>
						
						<label><?php _e('Post Title: Content of the post (if included)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						
						<label id="wps_settings_message_preview_after" class="wps_settings_message_preview" style="color:red"><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						</td>
					</th>
				</tr>
			</tbody>
		</table>
		
		<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>
		
		<?php submit_button(); ?>
		</form>
		<?php
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
			
		wp_enqueue_script('wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/include/js/wpsite_twitter_reshare_admin.js');
		
		$categories = get_categories();
		
		$cat_ID = array();
		
		foreach ($categories as $cat) {
			$cat_ID[] = $cat->cat_ID;	
		}
		
		wp_localize_script('wpsite_twitter_reshare_admin_js', 'categories', $cat_ID);
		?>
		<h1><?php _e('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
		
		<form method="post" id="wpsite_twitter_reshare_exclude_posts_form">
		
		<table>
			<tbody>
			
				<!-- Filter by Category -->
				
				<tr>
					<th class="wpsite_twitter_reshare_admin_table_th">
						<label><?php _e('Category', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
						<td class="wpsite_twitter_reshare_admin_table_td">
							<select id="wpsite_twitter_reshare_exclude_posts_category">
								<option value="<?php echo null; ?>"><?php echo '-- All --'; ?></option>
				
								<?php
																
								/* Get all categories */
								
								foreach ($categories as $category) { 
									$category_name = strtolower(str_replace(' ','',$category->name)); ?>
									<option value="<?php echo $category->cat_ID; ?>"><?php echo $category_name; ?></option>
								<?php } ?>
				
							</select>
						</td>
					</th>
				</tr>
			
				<!-- Exclude Posts -->
				
				<?php
				
				$posts = get_posts(array('posts_per_page' => -1, 'post_type' => 'any'));
				
				foreach ($posts as $post) { 
					
					$post_categories = wp_get_post_categories($post->ID);
					
				?>
				
					<tr class="wpsite_twitter_reshare_exclude_posts_general <?php foreach ($post_categories as $cat) { echo 'wpsite_twitter_reshare_cat_' . $cat . ' '; } ?>">
						<th class="wpsite_twitter_reshare_admin_table_th">
							<label><?php _e($post->post_title, WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<td class="wpsite_twitter_reshare_admin_table_td">
								<input id="wps_settings_exclude_posts_<?php echo $post->ID; ?>" name="wps_settings_exclude_posts_<?php echo $post->ID; ?>" type="checkbox" <?php echo isset($settings_exclude_posts[$post->ID]) && $settings_exclude_posts[$post->ID] ? 'checked="checked"' : ''; ?>>
								<input id="wpsite_twitter_reshare_categories_exclude_posts_<?php echo $post->ID; ?>" style="display:none;" value="<?php echo isset($post_categories) && is_array($post_categories) ? serialize($post_categories) : null; ?>">
							</td>
						</th>
					</tr>
				
				<?php } ?>
		</table>
		
		<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_exclude_posts_edit'); ?>
		
		<?php submit_button(); ?>
		</form>
		<?php
	}
	
	/**
	 * Load the Help Page 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_help() {
	?>
	
		<div style="float:left;width:45%;padding-right:20px;">
			<h1><?php _e('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
		
			<h3><?php _e('What does WPSite Reshare do for me?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
	 
				<span><?php _e('Do you have a lot of posts on your blog and not enough traffic to them or not enough traffic to old posts that are still very relevant?  Wish you can automatically share all your posts at random to your twitter account at set intervals?  Well with WPSite Reshare all of this is possible and more.  Simply create an account and some messages and your have an automatic reshare engine.  Any questions, go to the FAQ page.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
			
			<h3><?php _e('What is an account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
			
				<span><?php _e('An account is a social media channel that you would like to have WPSite Reshare automatically use to reshare all your posts.  You can have multiple accounts and each with differently settings and intervals in which to automatically post.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
				
			<h3><?php _e('How do I setup my twitter developer account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
				
				<span><?php _e('Before WPSite Reshare can automatically tweet for you, we need you to create a twitter developer account.  By creating this account you can link your site to your twitter account and allow WPSite Reshare to automatically post for you.  Go to this link to create an twitter developer account https://dev.twitter.com. Then create a twitter developer application by going to this link https://dev.twitter.com/apps.  After that is done and you set your Access Level Capabilities to "Read and Write” (see FAQ), then copy and paste all your keys, secrets, and tokens (see FAQ) into your new WPSite Reshare twitter account.  Once that is done set your post filter settings,(see Trouble Shooting section on Help page for Post Filtering) making sure to include some post types and to not exclude all categories.  Finally your ready to test your account!  Go to the Accounts page and hover your newly created account.  Under the “Minimum Interval” column there will be a link that says “reshare now”, click it.  Once this is done check your twitter feed to see your new tweet (if not go to Trouble Shooting section on Help page).', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
				
			
			<h3><?php _e('What are messages?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
			
				<span><?php _e('A message is the text you would like to include in the reshare content.  It is highly recommended to create messages and lots of them to make WPSite Reshare posts seems more humanlike.  When creating a message there is a preview to show you what an example post content could look like.  Messages are totally optional and the plugin will still post to the social channel if you have none.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
				
			<h3><?php _e('How do I share manually?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
			
				<span><?php _e('There is a way to reshare content manually.  Go to the Accounts submenu page and hover over the account you want to manually reshare.  Go to the “Minimum Interval” column and hit the "reshare now” link.  This will manually reshare to that account and will not affect the account’s scheduled reshare intervals.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
			
		</div>
			
			
		
		
		<div style="float:right;width:45%;padding-right:40px;">
		
			<h1><?php _e('Trouble Shooting Twitter Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
			
			<h3><?php _e('My Twitter account has not been tweeting at its intervals or at all.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
			
			<span><?php _e('First check to see if the account is set to active, and all your post filters are valid.  This is a very common problem so go through these steps to make sure your post filter settings are allowing for at least a couple posts to be selected.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
	
	  
			<ol>
				<li><?php _e('Make sure your minimum and maximum age are valid and will return a list of posts.  For example if you put your minimum age as 1 day and maximum age as 2 days, and you have no posts that were published in the last two days, then no posts can be selected and nothing will be reshared.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
				<li><?php _e('Make sure you have selected post types to include.  This is found in the Accounts “Post Filter” section.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
				<li><?php _e('Make sure to check to see if you have at least one box unchecked in the exclude posts in this category setting.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
				<li><?php _e('Go to the Exclude Posts page and make sure that all, if not most posts are included.  All checked posts will be excluded when selecting a post to reshare.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
			</ol>
			
			<span><?php _e('If you have done the steps above and there are valid posts WPSite Reshare can chosen from then go to the Accounts page and make sure the "reshare now" works for the account.  Hovering over the account under the “ Minimum Interval” column there is a "reshare now" link.  More on the “reshare now” go to the Help page in the plugin. Click this link and look on your twitter account to see if anything was tweeted. ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
			
			<span><?php _e('If the "reshare now" worked and something was tweeted then the error is most likely a "duplicate status error" from twitter or a problem with the wordpress CRON job.  The most common issue is that twitter won’t allow duplicate tweets in a set interval of time.  If your blog only has a few of posts and you have only created a few or no messages, then WPSite Reshare could be trying to reshare the same content.  A quick fix could be adding more messages to give your content more variety.  If this doesn’t fix it then try downloading the WP Control plugin http://wordpress.org/plugins/wp-crontrol/.  This shows you all wordpress cron jobs.  Under the “Tools” menu page in your blog admin panel, click on the submenu “Control”.  This page will show all your CRON jobs.  Here there should be CRON jobs with hooks called wpsite_twitter_reshare_*, which are all WPSite Reshare CRON jobs.  If there are none, and the wpsite reshare account is set to active, then the CRON jobs are not scheduling.  If this is so please contact kjbenk@gmail.com for further information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
			
			<span><?php _e('If the "reshare now" didn’t work then there is something wrong with your connection to your twitter account.  First check to see if your Access Level Capabilities are set to "Read and Write” (read more about that in the FAQ).  If these the Access Level Capabilities are set to “Read and Write”, then maybe is has something to do with your Callback URL.  Twitter will complain sometimes if a Callback URL is not set.  This is only a twitter developer application bug and it will not affect your site at all.  You can put a dummy Callback URL in this field which we recommend to be your main url.  To set your Callback URL, go to your twitter application using this link https://dev.twitter.com/apps and go to the “Settings” tab.  Under the “Application Type” section you will see the Callback URL field.  Put your url into this field e.g. http://example.com, and hit “Update this twitter application’s settings”.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
			
			<span><?php _e('All errors should be found in the debug log if you want more information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		</div>
			
	<?php
	}
	
	/**
	 * Load the FAQ Page 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_twitter_reshare_settings_faq() {
	?>			
		<h1><?php _e('Fequently Asked Questions', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
		
		<h3><?php _e('Why do I have to create a twitter developer application to use this plugin? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('Twitter just recently updated its application programming interface (API) to make it more safe for users to retrieve and post information.  This also means that there are now more guidelines to follow and in order to tweet behind the scenes twitter needs to make sure you, are really you.  What this means is that twitter needs for you to register with them as a developer so they know that when you get or post information, using that developer account, to twitter it is 100% you.  What this means for you the end-user is that you need to do a little bit more to create this developer account, and then in turn create an application that will get and post information to twitter on your behalf.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<h3><?php _e('What is the "API Keys and Tokens" section in account settings page?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('This is where you will give WPSite Reshare your Consumer Key and Consumer Secret as well as the created Access Token and Access Token Secret.  This is what will allow WPSite Reshare the ability to post information to twitter automatically on your behalf.  Without this information nothing can be posted to twitter.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<h3><?php _e('Where can I find my Consumer Key, Consumer Secret, Access Token and Access Token Secret?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('All of this information will be available to you once your create a twitter developer account and then create an application.  Once you create an application you can then go to this link https://dev.twitter.com/apps to find all your applications.  Choose the one you want to use and then Go to the “Details" tab.  Under this tab you will see the "OAuth Settings" section.  In this section you will find your Consumer Key and Consumer Secret.  Please copy and paste those to the related fields in the WPSite Reshare account settings page.  Then go to the "Your Access Token” section and first look at the Access Level field.  This must have read and write capabilities, if you don’t have these capabilities then read more about "How do I get read and write Access Level capabilities?".  Once you have read and write capabilities please copy and paste the Access Token and Access Token Secret to the related field in the WPSite Reshare plugin account settings page.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
			
		<h3><?php _e('How do I get read and write Access Level capabilities? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('First go to your twitter developer applications list from this link https://dev.twitter.com/apps.  Once there go to the application you are using with the WPSite Reshare plugin.  Go to the “Settings” tab and then scroll down to the "Application Type" Section. Check the "Read and Write" option and click “Update this Twitter application’s settings”.  Now Go to the “Details” tab and scroll down to the “Your Access Token” section.  Click on the “Recreate my access token” button.  If this new Access Level still says “Read Only” then, please try a again after a few moments because twitter is still updating the settings you changed from the “Settings” tab.  Keeping trying until the Access Level says “Read and Write”.  Now you can copy and paste the Access Token and Access Token Secret into the related accounts settings in the WPSite Reshare plugin.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<h3><?php _e('How do I exclude certain messages from certain posts? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('To exclude a message from a certain post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  Check and uncheck all your messages.  All messages that are unchecked will never be used for that post. ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<h3><?php _e('How do I create a custom message only for a specific post? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
			
			<span><?php _e('To create a custom message related to a specific post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  In this box you can create custom messages only relating to this post.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

		<h3><?php _e('How is the reshare content created? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
			<span><?php _e('The reshare content is created by using the settings in the “Rehare Content" section of your account to determine what the content will consist of.  Posts are first filtered using the settings in the “Post Filter” section in your account.  Then a random post is chosen from these qualified posts.  After that, a random message is chosen by first looking to see if there any custom messages relating to hat post.  If so then randomly choose from those custom messages, if not then get all checked messages relating to this post and randomly chose one.  If there are no checked messages then there will be no message in this reshare content.  After the post and message are chosen, the content is created.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> 
	<?php	
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
	
		error_log('cron job -> ' . $account['id']);
		
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
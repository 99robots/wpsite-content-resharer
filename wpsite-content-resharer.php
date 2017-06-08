<?php
/**
 * Plugin Name:		Content Resharer
 * Plugin URI:		https://99robots.com/docs/wp-content-resharer/
 * Description:		This plugin allows site owners to reshare their content automatically on a schedule to bring new life to existing posts and increase traffic.
 * Version:			2.1.2
 * Author:			99 Robots
 * Author URI:		https://www.99robots.com
 * License:			GPL2
 * Text Domain:		wpsite-twitter-reshare
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Global Definitions
 */
// Plugin Name
if ( ! defined( 'WPSITE_TWITTER_RESHARE_PLUGIN_NAME' ) ) {
	define( 'WPSITE_TWITTER_RESHARE_PLUGIN_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

// Plugin directory
if ( ! defined( 'WPSITE_TWITTER_RESHARE_PLUGIN_DIR' ) ) {
	define( 'WPSITE_TWITTER_RESHARE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin url
if ( ! defined( 'WPSITE_TWITTER_RESHARE_PLUGIN_URL' ) ) {
	define( 'WPSITE_TWITTER_RESHARE_PLUGIN_URL', plugins_url() . '/' . WPSITE_TWITTER_RESHARE_PLUGIN_NAME );
}

/**
 * Include Base Class.
 * From which all other classes are derived.
 */
include_once dirname( __FILE__ ) . '/include/class-resharer-base.php';

/**
 * WPsite Twitter Reshare main class
 *
 * @since 1.0.0
 * @author Kyle Benk <kjbenk@gmail.com>
 */
class WPsite_Content_Resharer extends Resharer_Base {

	/**
	 * Content Resharer version.
	 * @var string
	 */
	public $version = '2.1.2';

	/**
	 * The single instance of the class.
	 * @var WPsite_Content_Resharer
	 */
	protected static $_instance = null;

	/**
	 * Plugin url.
	 * @var string
	 */
	private $plugin_url = null;

	/**
	 * Plugin path.
	 * @var string
	 */
	private $plugin_dir = null;

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
	 * default
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $default = array(
		'accounts'		=> array(),
		'messages'		=> array(),
		'exclude_posts'	=> array(),
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
			'screen_name'		=> '',
		),
		'general' 		=> array(
			'reshare_content'		=> 'title',
			'bitly_url_shortener'	=> '',
			'hashtag_type'			=> 'none',
			'specific_hashtags'		=> '',
			'featured_image'		=> false,
			'include_link'			=> false,
			'min_interval'			=> '6',
		),
		'post_filter'	=> array(
			'min_age'		         => '30',
			'max_age'		         => '60',
			'post_types'	         => array(),
			'exclude_categories'	 => array(),
		),
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
		'place'		=> 'before',
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
	 * api_key
	 *
	 * (default value: 'kEKsMXElcPUvMFIRq9nJuTGoe')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $api_key = '6UPiXRW3RoeoTU8a0ydnw4jvd';

	/**
	 * api_secret
	 *
	 * (default value: '1EQWMgveYs4Zok50xhb2ThQAn4SH29Hjk76oXEFfvVsMWlZBne')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $api_secret = 'TZxeMTLIMenZOOdQEdmke1zvEvwSU1f7Lf2YRSY2RK7L21l5qf';

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wpsite-twitter-reshare' ), $this->version );
	}
	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wpsite-twitter-reshare' ), $this->version );
	}

	/**
	 * Main WPsite_Content_Resharer instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return WPsite_Content_Resharer
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) && ! ( self::$_instance instanceof WPsite_Content_Resharer ) ) {
			self::$_instance = new WPsite_Content_Resharer();
			self::$_instance->includes();
			self::$_instance->hooks();
		}

		return self::$_instance;
	}

	/**
	 * WPsite_Content_Resharer constructor.
	 */
	private function __construct() {

	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * @return void
	 */
	private function includes() {

		include_once $this->plugin_dir() . 'include/class-resharer-schedule-post.php';

		// Admin Only
		if ( is_admin() ) {
			include_once $this->plugin_dir() . 'include/class-resharer-twitter-metabox.php';
		}
	}

	/**
	 * Add hooks to begin.
	 * @return void
	 */
	private function hooks() {

		register_activation_hook( __FILE__, array( 'WPsite_Content_Resharer', 'install' ) );
		register_deactivation_hook( __FILE__, array( 'WPsite_Content_Resharer', 'uninstall' ) );

		$this->add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		$this->add_filter( 'cron_schedules', 'create_schedule_intervals' );

		if ( is_admin() ) {

			$plugin = plugin_basename( __FILE__ );
			$this->add_filter( "plugin_action_links_$plugin", 'plugin_links' );

			$this->add_action( 'admin_notices', 'admin_notices' );
			$this->add_action( 'admin_menu', 'register_pages' );
		}

		$settings = get_option( 'wpsite_twitter_reshare_settings' );
		if ( false !== $settings ) {
			foreach ( $settings['accounts'] as $account ) {
				$this->add_action( 'wpsite_twitter_reshare_' . $account['id'], 'reshare_schedule_post' );
			}
		}
	}

	/**
	 * Used to schedule cron jobs, will delete the job and then create a new one
	 *
	 * @since 1.0.0
	 */
	public function create_schedule_intervals( $schedules ) {

		$settings = $this->get_settings();

		// Delete all intervals
		foreach ( $schedules as $schedule_id => $schedule_val ) {
			if ( substr( $schedule_id, 0, strlen( self::$prefix ) ) === self::$prefix ) {
				unset( $schedules[ $schedule_id ] );
			}
		}

		// Create all intervals
		foreach ( $settings['accounts'] as $account ) {
			$schedules[ self::$prefix . $account['id'] . '_recurrence' ] = array(
				 'interval'	=> (double) $account['general']['min_interval'] * 60 * 60,
				 'display'	=> self::$prefix . $account['id'] . '_recurrence',
			 );
		}

		return $schedules;
	}

	/**
	 * Function used to call the WPsite_Twitter_Reshare_Post class
	 *
	 * @since 1.0.0
	 */
	public function reshare_schedule_post( $account ) {

		require_once( 'wpsite_twitter_reshare_schedule_post.php' );

		$wpsite_reschedule = new WPsite_Twitter_Reshare_Post();

		$wpsite_reschedule->wpsite_setup_all_reshares( $account, false );
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	public function plugin_links( $links ) {

		$settings_link = '<a href="' . $this->get_page_url( 'dashboard' ) . '">' . esc_html__( 'Dashboard', 'wpsite-twitter-reshare' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Load the plugin text domain for translation.
	 * @return void
	 */
	public function load_plugin_textdomain() {

		$locale = apply_filters( 'plugin_locale', get_locale(), 'wpsite-twitter-reshare' );

		load_textdomain(
			'wpsite-twitter-reshare',
			WP_LANG_DIR . '/plugin-name/plugin-name-' . $locale . '.mo'
		);

		load_plugin_textdomain(
			'wpsite-twitter-reshare',
			false,
			$this->plugin_dir() . '/languages/'
		);
	}

	/**
	 * Hooks to 'admin_enqueue_scripts'
	 *
	 * @since 1.0.0
	 */
	public function enqueque_scripts() {

		wp_enqueue_style( 'wpsite_twitter_reshare_settings_css', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/css/settings.css' );
		wp_enqueue_style( 'wpsite_twitter_reshare_bootstrap_css', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/css/nnr-bootstrap.min.css' );
		wp_enqueue_style( 'wpsite_twitter_reshare_fontawesome_css', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/css/font-awesome.min.css' );

		wp_enqueue_script( 'wpsite_twitter_reshare_bootstrap_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/bootstrap.min.js' );
	}

	/**
	 * Admin Notices
	 * Show error message is WP Cron is turned off
	 *
	 * @access public
	 * @return void
	 */
	public function admin_notices() {

		if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) :
			?>
			<div class="error">
				<p>
					<?php echo wp_kses_post( __( '<strong>WP Cron</strong> is <strong>DISABLED</strong>! <strong>Content Resharer</strong> needs WP Cron to be enabled in order to automatically reshare your content. Please read our' , 'wpsite-twitter-reshare' ) ) ?> <a href="https://99robots.com/?post_type=doc&p=9799" target="_blank"><?php esc_html_e( 'post' , 'wpsite-twitter-reshare' ) ?></a> <?php esc_html_e( 'about how to enable WP Cron.' , 'wpsite-twitter-reshare' ) ?>
				</p>
			</div>
			<?php
		endif;
	}

	/**
	 * Register admin pages
	 *
	 * @since 1.0.0
	 */
	public function register_pages() {

		$parent = $this->get_page_id( 'dashboard' );

		add_menu_page(
			esc_html__( 'Content Resharer', 'wpsite-twitter-reshare' ),
			esc_html__( 'Content Resharer', 'wpsite-twitter-reshare' ),
			'manage_options',
			$parent,
			array( $this, 'page_settings' ),
			plugin_dir_url( __FILE__ ) . 'img/logo.png" style="width:20px;padding-top: 6px;'
		);

		$account_sub_menu_page = add_submenu_page(
			$parent,
			esc_html__( 'Accounts', 'wpsite-twitter-reshare' ),
			esc_html__( 'Accounts', 'wpsite-twitter-reshare' ),
			'manage_options',
			$parent,
			array( $this, 'page_settings' )
		);
		add_action( "load-$account_sub_menu_page" , array( $this, 'enqueque_scripts' ) );

		$messages_sub_menu_page = add_submenu_page(
			$parent,
			esc_html__( 'Messages', 'wpsite-twitter-reshare' ),
			esc_html__( 'Messages', 'wpsite-twitter-reshare' ),
			'manage_options',
			$this->get_page_id( 'messages' ),
			array( $this, 'page_messages' )
		);
		add_action( "load-$messages_sub_menu_page" , array( $this, 'enqueque_scripts' ) );

		$exclude_posts_sub_menu_page = add_submenu_page(
			$parent,
			esc_html__( 'Exclude Posts', 'wpsite-twitter-reshare' ),
			esc_html__( 'Exclude Posts', 'wpsite-twitter-reshare' ),
			'manage_options',
			$this->get_page_id( 'exclude-posts' ),
			array( $this, 'page_exclude_posts' )
		);
		add_action( "load-$exclude_posts_sub_menu_page" , array( $this, 'enqueque_scripts' ) );

		$help_sub_menu_page = add_submenu_page(
			$parent,
			esc_html__( 'Help', 'wpsite-twitter-reshare' ),
			esc_html__( 'Help', 'wpsite-twitter-reshare' ),
			'manage_options',
			$this->get_page_id( 'help' ),
			array( $this, 'page_help' )
		);
		add_action( "load-$help_sub_menu_page" , array( $this, 'enqueque_scripts' ) );
	}

	/**
	 * Displays HTML for the Settings sub menu page
	 *
	 * @since 1.0.0
	 */
	static function page_settings() {

		$settings = $this->get_settings();

		// Save Data
		if ( isset( $_POST['submit'] ) && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_add_edit' ) ) {

			// Default values
			if ( false === $settings ) {
				$settings = self::$default;
			}

			// Make sure of no duplicates
			if ( ! in_array( strtolower( str_replace( ' ','', stripcslashes( sanitize_text_field( $_POST['wps_settings_account_id'] ) ) ) ), $settings['accounts'] ) ) {

				// Determine Post Types
				$post_types_array = array();
				$post_types = get_post_types( array( 'public' => true ) );

				foreach ( $post_types as $post_type ) {
					if ( isset( $_POST[ 'wps_post_filter_post_types_' . $post_type ] ) && $_POST[ 'wps_post_filter_post_types_' . $post_type ] ) {
						$post_types_array[] = $post_type;
					}
				}

				// Determine Categories to exclude
				$exclude_categories_array = array();
				$categories = get_categories();

				foreach ( $categories as $category ) {

					$cat = 'wps_post_filter_exclude_categories_' . strtolower( str_replace( ' ', '', $category->name ) );
					if ( isset( $_POST[ $cat ] ) && $_POST[ $cat ] ) {
						$exclude_categories_array[] = $category->cat_ID;
					}
				}

				// Determine max age of eligible posts
				$max_age = (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_max_age'] ) );
				$min_age = (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_min_age'] ) );
				if (  $max_age <= $min_age ) {

					if ( $min_age < 0 ) {
						$max_age = '1';
					} else {
						$max_age = (string) ( $min_age + 1 );
					}
				}

				$account_id = strtolower( str_replace( ' ', '', stripcslashes( sanitize_text_field( $_POST['wps_settings_account_id'] ) ) ) );
				if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
					$hook = self::$prefix . $account_id;
					$args = $settings['accounts'][ $account_id ];
					wp_clear_scheduled_hook( $hook, array( $args ) );
				}

				// Save settings
				$settings['accounts'][ $account_id ] = array(
					'id'			=> $account_id,
					'type'			=> 'twitter',
					'label'			=> stripcslashes( sanitize_text_field( $_POST['wps_settings_label'] ) ),
					'status'		=> $_POST['wps_settings_status'],
					'twitter'		=> array(
						'consumer_key'		=> $settings['accounts'][ $account_id ]['twitter']['consumer_key'],
						'consumer_secret'	=> $settings['accounts'][ $account_id ]['twitter']['consumer_secret'],
						'token'				=> $settings['accounts'][ $account_id ]['twitter']['token'],
						'token_secret'		=> $settings['accounts'][ $account_id ]['twitter']['token_secret'],
						'profile_image'		=> $settings['accounts'][ $account_id ]['twitter']['profile_image'],
						'screen_name'		=> $settings['accounts'][ $account_id ]['twitter']['screen_name'],
					),
					'general' 		=> array(
						'reshare_content'		=> $_POST['wps_general_reshare_content'],
						'bitly_url_shortener' 	=> stripcslashes( sanitize_text_field( $_POST['wps_general_bitly_url_shortener'] ) ),
						'hashtag_type'			=> $_POST['wps_general_hashtag_type'],
						'specific_hashtags'		=> str_replace( ' ', '', stripcslashes( sanitize_text_field( $_POST['wps_general_specific_hashtags'] ) ) ),
						'featured_image'		=> isset( $_POST['wps_general_featured_image'] ) && $_POST['wps_general_featured_image'] ? true : false,
						'include_link'			=> isset( $_POST['wps_general_include_link'] ) && $_POST['wps_general_include_link'] ? true : false,
						'min_interval'			=> (double) stripcslashes( sanitize_text_field( $_POST['wps_general_min_interval'] ) ) > (double) 1 ? stripcslashes( sanitize_text_field( $_POST['wps_general_min_interval'] ) ) : 1,
					),
					'post_filter'	=> array(
						'min_age'			 => (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_min_age'] ) ) >= 0 ? (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_min_age'] ) ) : 0,
						'max_age'			 => (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_max_age'] ) ) >= 0 ? (double) stripcslashes( sanitize_text_field( $_POST['wps_post_filter_max_age'] ) ) : 0,
						'post_types'		 => $post_types_array,
						'exclude_categories' => $exclude_categories_array,
					),
				);

				// Create the transient for keeping track of reshare interval
				update_option( 'wpsite_twitter_reshare_settings', $settings );

				if ( 'active' === $_POST['wps_settings_status'] ) {

					$hook = self::$prefix . $account_id;
					$args = $settings['accounts'][ $account_id ];

					self::schedule_reshare_event( $hook, array( $args ) );
				}
				?>
				<script type="text/javascript">
					window.location = "<?php echo $this->get_page_url( 'dashboard' ) ?>&action=edit&account=twitter";
				</script>
				<?php
			}
		}

		// Delete account
		if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_delete' ) ) {

			// Delete current cron job for the account
			$hook = self::$prefix . $settings['accounts'][ $_GET['account'] ]['id'];
			$args = $settings['accounts'][ $_GET['account'] ];
			$args['status'] = 'active';

			wp_clear_scheduled_hook( $hook, array( $args ) );

			unset( $settings['accounts'][ $_GET['account'] ] );

			update_option( 'wpsite_twitter_reshare_settings', $settings );
			?>
			<script type="text/javascript">
				window.location = "<?php echo $this->get_page_url( 'dashboard' ) ?>";
			</script>
			<?php
		}

		// Remove account
		if ( isset( $_GET['action'] ) && 'remove' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_remove' ) ) {

			// Delete current cron job for the account
			$hook = self::$prefix . $settings['accounts']['twitter']['id'];
			$args = $settings['accounts']['twitter'];
			$args['status'] = 'active';

			wp_clear_scheduled_hook( $hook, array( $args ) );

			$settings['accounts']['twitter']['twitter']['token'] = '';
			$settings['accounts']['twitter']['twitter']['token_secret'] = '';
			$settings['accounts']['twitter']['twitter']['profile_image'] = '';
			$settings['accounts']['twitter']['twitter']['screen_name'] = '';

			update_option( 'wpsite_twitter_reshare_settings', $settings );
			?>
			<script type="text/javascript">
				window.location = "<?php echo $this->get_page_url( 'dashboard' ) ?>";
			</script>
			<?php
		}

		// Activate / Deactivate
		if ( isset( $_GET['action'] ) && 'activate' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_activate' ) ) {

			$hook = self::$prefix . $settings['accounts'][ $_GET['account'] ]['id'];
			$args = $settings['accounts'][ $_GET['account'] ];

			if ( 'active' === $settings['accounts'][ $_GET['account'] ]['status'] ) {
				$settings['accounts'][ $_GET['account'] ]['status'] = 'inactive';

				// Delete current cron job for the account
				wp_clear_scheduled_hook( $hook, array( $args ) );
			} else {
				$settings['accounts'][ $_GET['account'] ]['status'] = 'active';
				$args['status'] = 'active';

				self::schedule_reshare_event( $hook, array( $args ) );
			}

			update_option( 'wpsite_twitter_reshare_settings', $settings );

			?>
			<script type="text/javascript">
				window.location = "<?php echo $this->get_page_url( 'dashboard' ) ?>";
			</script>
			<?php
		}

		// Reshare Now
		if ( isset( $_GET['action'] ) && 'reshare' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_reshare_now' ) ) {

			include_once $this->plugin_dir() . 'include/class-resharer-schedule-post.php';

			if ( false !== $settings ) {

				$wpsite_reschedule = new WPsite_Twitter_Reshare_Post();

				$wpsite_reschedule->wpsite_setup_all_reshares( $settings['accounts'][ $_GET['account'] ], true );
				?>
				<script type="text/javascript">
					window.location = "<?php echo $this->get_page_url( 'dashboard' ) ?>";
				</script>
				<?php
			}
		}

		// Display table
		if ( ! isset( $_GET['action'] ) ) {

			include_once $this->plugin_dir() . 'admin/account_dashboard.php';

			wp_enqueue_script( 'wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js' );
			wp_localize_script( 'wpsite_twitter_reshare_admin_js', 'wpsite_twitter_reshare_accounts_ahref', $wpsite_twitter_reshare_ahref_array );
		}

		// Add new account
		if ( isset( $_GET['action'] ) && 'add' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_add_edit' ) ) {
			wp_enqueue_script( 'wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js' );
			$this->settings_add_edit();
		}

		// Edit existing account
		if ( isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
			wp_enqueue_script( 'wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js' );
			$this->settings_add_edit( $_GET['account'] );
		}
	}

	/**
	 * Displays HTML for the Account sub menu page add new
	 *
	 * @since 1.0.0
	 */
	private function settings_add_edit( $account_id = null ) {

		$settings_all = get_option( 'wpsite_twitter_reshare_settings' );

		// Edit
		if ( isset( $account_id ) ) {
			$settings = $settings_all['accounts'][ $account_id ];
		} else {
			$settings = self::$default_account;
		}

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		require_once( 'admin/account_add_edit.php' );
	}

	/**
	 * Displays HTML for the Messages sub menu page
	 *
	 * @since 1.0.0
	 */
	public function page_messages() {

		// Save Data
		if ( isset( $_POST['submit'] ) && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_messages_add_edit' ) ) {

			$settings = get_option( 'wpsite_twitter_reshare_settings' );
			$msg_id = strtolower( str_replace( ' ', '', stripcslashes( sanitize_text_field( $_POST['wps_settings_message_id'] ) ) ) );

			if ( ! in_array( $msg_id, $settings['messages'] ) ) {

				$settings['messages'][ $msg_id ] = array(
					'id'		=> $msg_id,
					'message'	=> stripcslashes( sanitize_text_field( $_POST['wps_settings_message_text'] ) ),
					'place'		=> $_POST['wps_settings_message_place'],
				);

				update_option( 'wpsite_twitter_reshare_settings', $settings );
				?>
				<script type="text/javascript">
					window.location = "<?php echo $this->get_page_url( 'messages' ) ?>";
				</script>
				<?php
			}
		}

		// Delete message
		if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_messages_delete' ) ) {

			$settings = get_option( 'wpsite_twitter_reshare_settings' );

			unset( $settings['messages'][ $_GET['message'] ] );

			update_option( 'wpsite_twitter_reshare_settings', $settings );
			?>
			<script type="text/javascript">
				window.location = "<?php echo $this->get_page_url( 'messages' ) ?>";
			</script>
			<?php
		}

		require_once( 'admin/messages-dashboard.php' );

		wp_enqueue_script( 'wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js' );
		wp_localize_script( 'wpsite_twitter_reshare_admin_js', 'wpsite_twitter_reshare_messages_ahref', $wpsite_twitter_reshare_ahref_array );
	}

	/**
	 * Displays HTML for the Messages sub menu page add / edit
	 *
	 * @since 1.0.0
	 */
	public function page_messages_add_edit( $message_id = null ) {

		$settings = get_option( 'wpsite_twitter_reshare_settings' );

		// Edit
		if ( isset( $message_id ) ) {
			$settings = $settings['messages'][ $message_id ];
		} else {
			$settings = self::$default_message;
		}

		require( 'admin/messages_add_edit.php' );
	}

	/**
	 * Load the exclude Posts Page
	 *
	 * @since 1.0.0
	 */
	public function page_exclude_posts() {

		$settings = $this->get_settings();

		// Edit
		if ( ! isset( $settings['exclude_posts'] ) ) {
			$settings_exclude_posts = self::$default_exclude_posts;
		} else {
			$settings_exclude_posts = $settings['exclude_posts'];
		}

		// Save Data
		if ( isset( $_POST['submit'] ) && check_admin_referer( 'wpsite_twitter_reshare_admin_settings_exclude_posts_edit' ) ) {

			$settings = $this->get_settings();

			if ( ! isset( $settings['exclude_posts'] ) ) {
				$settings_exclude_posts = self::$default_exclude_posts;
			} else {
				$settings_exclude_posts = $settings['exclude_posts'];
			}

			$posts = get_posts( array(
				'posts_per_page' => -1,
				'post_type' => 'any',
			) );

			foreach ( $posts as $post ) {

				if ( isset( $_POST[ 'wps_settings_exclude_posts_' . $post->ID ] ) && $_POST[ 'wps_settings_exclude_posts_' . $post->ID ] ) {
					$settings_exclude_posts[ $post->ID ] = true;
				} else {
					$settings_exclude_posts[ $post->ID ] = false;
				}
			}

			$settings['exclude_posts'] = $settings_exclude_posts;

			update_option( 'wpsite_twitter_reshare_settings', $settings );
		}

		wp_enqueue_script( 'wpsite_twitter_reshare_admin_js', WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/js/wpsite_twitter_reshare_admin.js' );

		$cat_id = array();
		$categories = get_categories();

		foreach ( $categories as $cat ) {
			$cat_id[] = $cat->cat_ID;
		}

		wp_localize_script( 'wpsite_twitter_reshare_admin_js', 'categories', $cat_id );

		require_once( 'admin/exclude-posts.php' );
	}

	/**
	 * Load the Help Page
	 *
	 * @since 1.0.0
	 */
	public function page_help() {
		require_once( 'admin/help.php' );
	}

	/**
	 * Used to schedule cron jobs, will delete the job and then create a new one
	 *
	 * @since 1.0.0
	 *
	 * @param	string	$hook: name of the schedule action
	 * @param	array	$account: holds all account data
	 */
	public static function schedule_reshare_event( $hook, $account ) {

		$result = wp_schedule_event( time(), $hook . '_recurrence', $hook, $account );

		if ( false === $result ) {
			error_log( 'WPsiteRehare:: failed to schedule the cron job using wp_schedule_event()' );
		}
	}

	// Installer / Uninstaller -------------------------------------------

	/**
	 * Fired during plugin activation.
	 *
	 * @since 1.0.0
	 */
	public static function install() {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			add_site_option( self::$prefix . 'version', $this->get_version() );

			global $wpdb;

			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );

				$this->default_options();
			}

			restore_current_blog();

		} else {
			add_option( self::$prefix . 'version', wpsite_resharer()->get_version() );

			$this->default_options();
		}
	}

	/**
	 * Add default options.
	 */
	private function default_options() {

		$settings = get_option( 'wpsite_twitter_reshare_settings' );

		// Default values
		if ( false === $settings ) {
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
							'token_secret'		=> '',
						),
						'general' 		=> array(
							'reshare_content'		=> 'title',
							'bitly_url_shortener'	=> '',
							'hashtag_type'			=> 'none',
							'specific_hashtags'		=> '',
							'featured_image'		=> false,
							'include_link'			=> false,
							'min_interval'			=> '6',
						),
						'post_filter'	=> array(
							'min_age'		         => '30',
							'max_age'		         => '60',
							'post_types'	         => array(),
							'exclude_categories'	 => array(),
						),
					),
				),
				'messages'		=> array(
					'message' => array(
						'id'		=> 'message',
						'message'	=> '',
						'place'		=> 'front',
					),
				),
				'exclude_posts'	=> array(),
			);

			update_option( 'wpsite_twitter_reshare_settings', $settings );
		}
	}

	/**
	 * Fired during plugin deactivation.
	 *
	 * @since 1.0.0
	 */
	static function uninstall() {

		$settings = get_option( 'wpsite_twitter_reshare_settings' );

		foreach ( $settings['accounts'] as $account ) {
			$hook = 'wpsite_twitter_reshare_' . $account['id'];
			$args = $account;
			$args['status'] = 'active';

			wp_clear_scheduled_hook( $hook, array( $args ) );
		}
	}

	// Helpers -----------------------------------------------------------

	/**
	 * Get plugin settings
	 * @return array
	 */
	private function get_settings() {

		$settings = get_option( 'wpsite_twitter_reshare_settings' );

		if ( false === $settings ) {
			$settings = self::$default;
		}

		return $settings;
	}

	/**
	 * [get_page_id description]
	 * @param  string $page [description]
	 * @return [type]       [description]
	 */
	public function get_page_id( $page = '' ) {
		return 'wpsite-content-resharer-' . $page;
	}

	/**
	 * [get_page_url description]
	 * @param  string $page [description]
	 * @return [type]       [description]
	 */
	public function get_page_url( $page = '' ) {

		$url = admin_url( 'admin.php?page=' . $this->get_page_id( $page ) );

		return esc_url( $url );
	}

	/**
	 * Get plugin directory.
	 * @return string
	 */
	public function plugin_dir() {

		if ( is_null( $this->plugin_dir ) ) {
			$this->plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/';
		}

		return $this->plugin_dir;
	}

	/**
	 * Get plugin uri.
	 * @return string
	 */
	public function plugin_url() {

		if ( is_null( $this->plugin_url ) ) {
			$this->plugin_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/';
		}

		return $this->plugin_url;
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}
}

/**
 * Main instance of WPsite_Content_Resharer.
 *
 * Returns the main instance of WPsite_Content_Resharer to prevent the need to use globals.
 *
 * @return WPsite_Content_Resharer
 */
function wpsite_resharer() {
	return WPsite_Content_Resharer::instance();
}

// Init the plugin.
wpsite_resharer();

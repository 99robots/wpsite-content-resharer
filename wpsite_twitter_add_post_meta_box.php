<?php
/**
 * This class is used to add post meta boxes to side bar of all post types
 *
 * @author Kyle Benk <kjbenk@gmail.com>
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

add_action('add_meta_boxes', array('WPsiteTwitterAddMetaBox', 'wpsite_add_meta_box'), 10, 2 );
add_action('save_post', array('WPsiteTwitterAddMetaBox', 'wpsite_save_meta_data'));

/**
 * Class used to add meta box
 *
 * @since 1.0.0
 */
class WPsiteTwitterAddMetaBox {

	private static $prefix = 'wpsite-twitter-reshare-meta-box-';

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function wpsite_load_textdoamin() {
		load_plugin_textdomain(WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN, false, WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/languages');
	}

	/**
	 * Adds the meta box container.
	 */
	static function wpsite_add_meta_box($post_type, $post) {

		if ($post_type != 'attachment' || $post_type != 'page') {
			add_meta_box(
				self::$prefix . 'hashtags',
				'WPSite Content Resharer Hashtags',
				array('WPsiteTwitterAddMetaBox' , 'wpsite_render_meta_box_content'),
				$post_type,
				'side',
				'low'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	static function wpsite_render_meta_box_content($post) {

		// Use get_post_meta to retrieve an existing value from the database.

		$hashtags = get_post_meta($post->ID, self::$prefix . 'hashtags', true);
		$hashtags = isset($hashtags) ? $hashtags : null;

		// Add an nonce field so we can check for it later.
		wp_nonce_field(self::$prefix . 'meta-box', self::$prefix . 'meta-box-nonce');

		?>
			<input type="text" id="<?php echo self::$prefix . 'hashtags'; ?>" name="<?php echo self::$prefix . 'hashtags'; ?>" value="<?php echo isset($hashtags) ? $hashtags : ''; ?>" placeholder="hashtag,hashtag1" size="18"/><br/>
			<em><?php _e('No spaces (i.e. hashtag,hashtag1) not (hashtag, hashtag1)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
		<?php

	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	static function wpsite_save_meta_data($post_id) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST[self::$prefix . 'meta-box-nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce($_POST[self::$prefix . 'meta-box-nonce'], self::$prefix . 'meta-box') ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST[self::$prefix . 'hashtags'] ) ) {
			return;
		}

		// Sanitize user input.
		$hashtags = sanitize_text_field( $_POST[self::$prefix . 'hashtags'] );

		// Update the meta field in the database.
		if ($hashtags == '') {
			delete_post_meta($post_id, self::$prefix . 'hashtags');
		} else {
			update_post_meta( $post_id, self::$prefix . 'hashtags', str_replace(' ','',$hashtags));
		}
	}
}
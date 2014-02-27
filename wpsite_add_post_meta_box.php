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

if (!defined('WPSITE_RESHARE_PLUGIN_NAME'))
    define('WPSITE_RESHARE_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('WPSITE_RESHARE_PLUGIN_DIR'))
    define('WPSITE_RESHARE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPSITE_RESHARE_PLUGIN_NAME);

/* Plugin url */

if (!defined('WPSITE_RESHARE_PLUGIN_URL'))
    define('WPSITE_RESHARE_PLUGIN_URL', WP_PLUGIN_URL . '/' . WPSITE_RESHARE_PLUGIN_NAME);
    
/* Plugin text-domain */

if (!defined('WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN'))
    define('WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN', 'wpsite-reshare');

add_action('add_meta_boxes', array('WPsiteAddMetaBox', 'wpsite_add_meta_box'), 10, 2 );
add_action('save_post', array('WPsiteAddMetaBox', 'wpsite_save_meta_data'));

/** 
 * Class used to add meta box
 *
 * @since 1.0.0
 */
class WPsiteAddMetaBox {

	private static $prefix = 'wpsite_reshare_meta_box_';

	/**
	 * Load the text domain 
	 * 
	 * @since 1.0.0
	 */
	static function wpsite_load_textdoamin() {
		load_plugin_textdomain(WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN, false, WPSITE_RESHARE_PLUGIN_DIR . '/languages');
	}

	/**
	 * Adds the meta box container.
	 */
	static function wpsite_add_meta_box($post_type, $post) {
	
		$settings = get_option('wpsite_reshare_settings');
		
		if ($settings === false)
			return null;
			
		foreach ($settings['accounts'] as $account) {
		
			$check = true;
			
			foreach ($account['post_filter']['exclude_categories'] as $category) {
				if (in_category($category, $post)) {
					$check = false;
				}
			}
		
			if (in_array($post_type, $account['post_filter']['post_types']) && $check) {
				add_meta_box(
					self::$prefix . $account['id'],
					'WPSite Rehsare ' . $account['label'],
					array('WPsiteAddMetaBox' , 'wpsite_render_meta_box_content'),
					$post_type,
					'side',
					'low',
					array('account_id' => $account['id'], 'messages' => $settings['messages'])
				);
			}
		}
	}
	
	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	static function wpsite_render_meta_box_content($post, $metabox) {

		// Use get_post_meta to retrieve an existing value from the database.
		$post_meta_messages = get_post_meta($post->ID, self::$prefix . $metabox['args']['account_id'], true);
		$post_meta_messages = isset($post_meta_messages['messages']) ? $post_meta_messages['messages'] : null;
		
		$post_cus_meta_messages = get_post_meta($post->ID, self::$prefix . $metabox['args']['account_id'], true);
		$post_cus_meta_messages = isset($post_cus_meta_messages['custom_messages']) ? $post_cus_meta_messages['custom_messages'] : null;
		
		$messages = array();
		
		foreach(get_option('wpsite_reshare_settings')['messages'] as $message) {
		
			if (isset($post_meta_messages) && $post_meta_messages !== false && array_key_exists($message['id'], $post_meta_messages)) {
				$messages[$message['id']] = array(
					'id'		=> $message['id'],
					'message'	=> $message['message'],
					'place'		=> $message['place'],
					'val'		=> $post_meta_messages[$message['id']]['val']
				);
			}else {
				$messages[$message['id']] = array(
					'id'		=> $message['id'],
					'message'	=> $message['message'],
					'place'		=> $message['place'],
					'val'		=> true
				);
			}
		}
		
		for ($i = 1; $i < 4; $i++) {
			if (isset($post_cus_meta_messages) && $post_cus_meta_messages !== false && array_key_exists('custom_' . $i, $post_cus_meta_messages)) {
				$cus_messages['custom_' . $i] = array(
					'id'		=> 'custom_' . $i,
					'message'	=> $post_cus_meta_messages['custom_' . $i]['message'],
					'place'		=> $post_cus_meta_messages['custom_' . $i]['place']
				);
			} else {
				$cus_messages['custom_' . $i] = array(
					'id'		=> 'custom_' . $i,
					'message'	=> '',
					'place'		=> 'before'
				);
			}
		}
		
		
		// Check all custom text input fields
		
		foreach ($cus_messages as $cus_message_id => $cus_message_val) { 
			?>
			<input type="text" id="<?php echo self::$prefix . $metabox['args']['account_id'] . '-custom-message_' . $cus_message_id; ?>" name="<?php echo self::$prefix . $metabox['args']['account_id'] . '-custom-message_' . $cus_message_id; ?>" value="<?php echo isset($cus_message_val['message']) ? $cus_message_val['message'] : ''; ?>" placeholder="custom message" size="18"/>
			<select id="<?php echo self::$prefix . $metabox['args']['account_id'] . '-custom-message-place_' . $cus_message_id; ?>" name="<?php echo self::$prefix . $metabox['args']['account_id'] . '-custom-message-place_' . $cus_message_id; ?>">
				<option value="before" <?php echo isset($cus_message_val['place']) && $cus_message_val['place'] == 'before' ? 'selected' : ''; ?>><?php _e('Before', WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
				<option value="after" <?php echo isset($cus_message_val['place']) && $cus_message_val['place'] == 'after' ? 'selected' : ''; ?>><?php _e('After', WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
			</select><br />
	        <?php
		}

		// Display the form, using the current value.
		
		foreach ($messages as $message_id => $message_val) {
			?>
			<input type="checkbox" id="<?php echo self::$prefix . $metabox['args']['account_id'] . '_' . $message_id; ?>" name="<?php echo self::$prefix . $metabox['args']['account_id'] . '_' . $message_id; ?>" <?php echo isset($message_val['val']) && $message_val['val'] ? 'checked="checked"' :''; ?>/>
			<label><?php _e($message_val['message'], WPSITE_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label><br />
	        <?php
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	static function wpsite_save_meta_data($post_id) {
		
		$settings = get_option('wpsite_reshare_settings');
		
		if ($settings === false)
			return null;
			
		foreach ($settings['accounts'] as $account) {
		
			$check = true;
			
			
			
			foreach ($account['post_filter']['exclude_categories'] as $category) {
				if (in_category($category, $post_id)) {
					$check = false;
				}
			}
		
			if (in_array(get_post_type($post_id), $account['post_filter']['post_types']) && $check) {

				$messages_array = array();
				
				/* New Option */
				
				foreach ($settings['messages'] as $message) {
					$messages_array[$message['id']] = array(
						'id'		=> $message['id'],
						'message'	=> $message['message'],
						'place'		=> $message['place'],
						'val'		=> isset($_POST[self::$prefix . $account['id'] . '_' . $message['id']]) ? stripcslashes(sanitize_text_field($_POST[self::$prefix . $account['id'] . '_' . $message['id']])) : false
					);
				}
				
				for ($i = 1; $i < 4; $i++) {
					$cus_messages_array['custom_' . $i] = array(
						'id'		=> 'custom_' . $i,
						'message'	=> isset($_POST[self::$prefix . $account['id'] . '-custom-message_' . 'custom_' . $i]) ? stripcslashes(sanitize_text_field($_POST[self::$prefix . $account['id'] . '-custom-message_' . 'custom_' . $i])) : false,
						'place'		=>  isset($_POST[self::$prefix . $account['id'] . '-custom-message-place_' . 'custom_' . $i]) ? stripcslashes(sanitize_text_field($_POST[self::$prefix . $account['id'] . '-custom-message-place_' . 'custom_' . $i])) : 'before'
					);
				}
					
				// Update the meta field.
				
				update_post_meta($post_id, self::$prefix . $account['id'], array('messages' => $messages_array, 'custom_messages' => $cus_messages_array));
			}
		}
	}
}
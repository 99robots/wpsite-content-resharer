<div class="wrap nosubsub">

	<h2><?php _e('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=add', 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Add New', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></h2>
	
	<div class="col-container">
	
		<div class="wpsite_twitter_reshare_admin_messages_add_edit"><?php 
			if (isset($_GET['action']) && $_GET['action'] == 'edit' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) 
				self::wpsite_twitter_reshare_settings_messages_add_edit($_GET['message']);
			else if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit'))
				self::wpsite_twitter_reshare_settings_messages_add_edit();
			else
				self::wpsite_twitter_reshare_settings_messages_add_edit();
		?></div>
		
		<div class="wpsite_twitter_reshare_admin_messages_table">
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
								
								<!-- <a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $message['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
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
		</div>
	</div>
</div>
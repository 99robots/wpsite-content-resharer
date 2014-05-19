<div class="wrap">
 
	<div class="wpsite_plugin_wrapper">
	
	<div class="wpsite_plugin_header">
				<!-- ** UPDATE THE UTM LINK BELOW ** -->
				<div class="announcement">
					<h2><?php _e('Check out the all new', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <strong><?php _e('WPsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong> <?php _e('for more WordPress resources, plugins, and news.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h2>
					<a  class="show-me" href="http://www.wpsite.net/?utm_source=follow-us-badges-plugin&amp;utm_medium=announce&amp;utm_campaign=top"><?php _e('Click Here', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
				</div>
 
				<header class="headercontent">
					<!-- ** UPDATE THE NAME ** -->
					<h1 class="logo"><?php _e('Twitter Reshare', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
					<span class="slogan"><?php _e('by', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <a href="http://www.wpsite.com/?utm_source=topadmin&amp;utm_medium=announce&amp;utm_campaign=top"><?php _e('WPsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></span>
					
					<!-- ** UPDATE THE 2 LINKS ** -->
					<div class="top-call-to-actions">
						<a class="tweet-about-plugin" href="https://twitter.com/intent/tweet?text=Neat%20and%20simple%20plugin%20for%20WordPress%20users.%20Check%20out%20the%20Follow%20Us%20plugin%20by%20@WPsite%20-%20&amp;url=http%3A%2F%2Fwpsite.net%2Fplugins%2F&amp;via=wpsite"><span></span><?php _e('Tweet About WPsite', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
						<a class="leave-a-review" href="http://wordpress.org/support/view/plugin-reviews/follow-us-badges#postform" target="_blank"><span></span> <?php _e('Leave A Review', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
					</div><!-- end .top-call-to-actions -->
				</header>
		</div> <!-- /wpsite_plugin_header -->
	
		<div id="wpsite_plugin_content">
		
			<div id="wpsite_plugin_settings">
			
				<h2><?php _e('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=add', 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Add New', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></h2>
			
				<div class="col-container">
	
					<div class="wpsite_twitter_reshare_admin_messages_add_edit"><?php 
						if (isset($_GET['action']) && $_GET['action'] == 'edit' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) 
							self::wpsite_twitter_reshare_settings_messages_add_edit($_GET['message']);
						else if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit'))
							self::wpsite_twitter_reshare_settings_messages_add_edit();
						else
							self::wpsite_twitter_reshare_settings_messages_add_edit();?>
					</div> <!-- wpsite_twitter_reshare_admin_messages_add_edit -->
					
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
						
					</div> <!-- wpsite_twitter_reshare_admin_messages_table -->
					
					<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					
				</div> <!-- col-container -->
			
			</div> <!-- wpsite_plugin_settings -->
			
			<div id="wpsite_plugin_sidebar">
				<div class="wpsite_feed">				
					<h3><?php _e('Must-Read Articles', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
					<script src="http://feeds.feedburner.com/wpsite?format=sigpro" type="text/javascript" ></script><noscript><p><?php _e('Subscribe to WPsite Feed:', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <a href="http://feeds.feedburner.com/wpsite"></a><br/><?php _e('Powered by FeedBurner', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p> </noscript>
				</div>
 
				<div class="mktg-banner">
					<a target="_blank" href="http://www.wpsite.net/custom-wordpress-development/#utm_source=plugin-config&utm_medium=banner&utm_campaign=custom-development-banner"><img src="<?php echo WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/img/ad-custom-development.png' ?>"></a>					
				</div>
			
				<div class="mktg-banner">
					<a target="_blank" href="http://www.wpsite.net/services/#utm_source=plugin-config&utm_medium=banner&utm_campaign=plugin-request-banner"><img src="<?php echo WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/img/ad-plugin-request.png' ?>"></a>					
				</div>
 
				<div class="mktg-banner">
					<a target="_blank" href="http://www.wpsite.net/themes/#utm_source=plugin-config&utm_medium=banner&utm_campaign=themes-banner"><img src="<?php echo WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/img/ad-themes.png' ?>"></a>					
				</div>
				
<!--
				<div class="mktg-banner">
					<a target="_blank" href="http://www.wpsite.net/services/#utm_source=plugin-config&utm_medium=banner&utm_campaign=need-support-banner"><img src="<?php echo WPSITE_TWITTER_RESHARE_PLUGIN_URL . '/img/ad-need-support.png' ?>"></a>					
				</div>
-->
 
			</div> <!-- wpsite_plugin_sidebar -->
	
		</div> <!-- /wpsite_plugin_content -->
	
	</div> 	<!-- /wpsite_plugin_wrapper -->
		
</div> 	<!-- /wrap -->
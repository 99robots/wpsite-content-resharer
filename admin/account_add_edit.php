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
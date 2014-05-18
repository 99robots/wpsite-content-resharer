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
		
			<h1><?php _e('Exclude Posts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
		
			<div id="wpsite_plugin_settings">
			
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
						</tbody>
					</table>
					
					<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_exclude_posts_edit'); ?>
					
					<?php submit_button(); ?>
				</form>
			
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
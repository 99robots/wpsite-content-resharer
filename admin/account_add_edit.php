<script type="text/javascript">
jQuery(document).ready(function($) {
	$( "#tabs" ).tabs();
});
</script>

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

										<tr>
											<th class="wpsite_twitter_reshare_admin_table_th">
												<span><?php _e('Sign In', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
											</th>
											<td class="wpsite_twitter_reshare_admin_table_td">
											<?php require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/connect-accounts/connect-twitter.php'); ?>
											</td>
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

										<!-- Hashtags -->

										<tr>
											<th class="wpsite_twitter_reshare_admin_table_th">
												<label><?php _e('Hashtag Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
												<td class="wpsite_twitter_reshare_admin_table_td">
													<select id="wps_general_hashtag_type" name="wps_general_hashtag_type">
														<option value="none" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'none' ? 'selected' : ''; ?>><?php _e('Do not include hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
														<option value="custom_field" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'custom_field' ? 'selected' : ''; ?>><?php _e('From post custom field (i.e Twitter Reshare Meta Box)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
														<option value="category" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'category' ? 'selected' : ''; ?>><?php _e('First Category', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
														<option value="specific_hashtags" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'specific_hashtags' ? 'selected' : ''; ?>><?php _e('Specific hashtag', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
													</select>
												</td>
											</th>
										</tr>

										<!-- Specific Hashtags -->

										<tr class="wpsite_general_specific_hashtag">
											<th class="wpsite_twitter_reshare_admin_table_th">
												<label><?php _e('Specific Hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
												<td class="wpsite_twitter_reshare_admin_table_td">
													<input id="wps_general_specific_hashtags" name="wps_general_specific_hashtags" type="text" size="60" value="<?php echo esc_attr($settings['general']['specific_hashtags']); ?>" placeholder="hashtag,hashtag1">
													<br /><em><?php _e('These hashtags will alwasy be include in every tweet', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
													<br /><em><?php _e('Spearate tags by commas no spaces', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
												</td>
											</th>
										</tr>

										<!-- Bitly URL Shortener -->

										<tr>
											<th class="wpsite_twitter_reshare_admin_table_th">
												<label><?php _e('Bitly URL Shortener', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
												<td class="wpsite_twitter_reshare_admin_table_td">
													<input id="wps_general_bitly_url_shortener" name="wps_general_bitly_url_shortener" type="text" size="60" value="<?php echo esc_attr($settings['general']['bitly_url_shortener']); ?>">
													<br /><em><?php _e('Your Bitly', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> </em><a href="https://bitly.com/a/oauth_apps"><?php _e('access token', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
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
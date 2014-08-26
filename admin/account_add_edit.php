<script type="text/javascript">
jQuery(document).ready(function($) {
	$( "#tabs" ).tabs();
});
</script>

<?php require_once('header.php'); ?>

	<div id="wpsite_plugin_content">

		<div id="wpsite_plugin_settings">

			<form method="post" id="wpsite_twitter_reshare_account_form">

				<div id="tabs">
						<ul>
							<li><a href="#wpsite_twitter_reshare_keys"><span class="wpsite_admin_panel_content_tabs"><?php _e('Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span></a></li>
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
										</th>
										<td class="wpsite_twitter_reshare_admin_table_td">
											<input id="wps_settings_account_id" name="wps_settings_account_id" type="text" size="60" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" placeholder="<?php _e('social_media_account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?>" <?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? "readonly" : ''; ?>><br/>
											<em><?php _e('A unique name for this account, there are no duplicates allowed.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
										</td>
									</tr>

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<span><?php _e('Connect Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
										</th>
										<td class="wpsite_twitter_reshare_admin_table_td">
											<?php require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/connect-accounts/connect-twitter.php'); ?>
											<div style="float: right;"><em><?php _e('Sign into your twitter account.  If button says "Sign In" then your account is not yet registered with WPsite Content Resharer.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em></div>
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
												</select><br/>
											<em><?php _e('Whether or not the account is active or deactive.  Deactive accounts will not post to social media channel.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Label -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_settings_label" name="wps_settings_label" type="text" size="60" value="<?php echo esc_attr($settings['label']); ?>"><br />
												<em><?php _e('Used for meta box name in edit post screen for custom messages.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Minimum Interval to reshare posts -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_min_interval" name="wps_general_min_interval" type="text" size="60" value="<?php echo esc_attr($settings['general']['min_interval']); ?>"><br />
												<em><?php _e('The interval in which posts are shared.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em><br />
												<em><?php _e('Units: hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
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

													<option value="content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'content' ? 'selected' : ''; ?>><?php _e('Excerpt', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

													<option value="title_content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'title_content' ? 'selected' : ''; ?>><?php _e('Title and Excerpt', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
												</select><br />
												<em><?php _e("Should the content be the a post's title, excerpt, or both?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
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
												</select><br />
												<em><?php _e("Include hashtags or not?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Specific Hashtags -->

									<tr class="wpsite_general_specific_hashtag">
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Specific Hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_specific_hashtags" name="wps_general_specific_hashtags" type="text" size="60" value="<?php echo esc_attr($settings['general']['specific_hashtags']); ?>" placeholder="hashtag,hashtag1">
												<br /><em><?php _e('These hashtags will always be included in every tweet.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
												<br /><em><?php _e('Spearate tags by commas.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Bitly URL Shortener -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Bitly URL Shortener', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_bitly_url_shortener" name="wps_general_bitly_url_shortener" type="text" size="60" value="<?php echo esc_attr($settings['general']['bitly_url_shortener']); ?>">
												<br />
												<em><?php _e("This is optional and is used to shorten the URL of the post.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em><br />
												<em><?php _e('Your Bitly', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> </em><a href="https://bitly.com/a/oauth_apps" target="_blank"><?php _e('access token', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
											</td>
										</th>
									</tr>

									<!-- Include Link -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Include Link', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_include_link" name="wps_general_include_link" type="checkbox" <?php echo isset($settings['general']['include_link']) && $settings['general']['include_link'] ? 'checked="checked"' : ''; ?>>
												<em><?php _e("Should the post's link be included in the post?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Include Featured Image -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Include Featured Image', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_general_featured_image" name="wps_general_featured_image" type="checkbox" <?php echo isset($settings['general']['featured_image']) && $settings['general']['featured_image'] ? 'checked="checked"' : ''; ?>>
												<em><?php _e("Should the post's featured image be included in the post?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
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
												<input id="wps_post_filter_min_age" name="wps_post_filter_min_age" type="text" size="60" value="<?php echo esc_attr($settings['post_filter']['min_age']); ?>"><br />
												<em><?php _e("Only reshare posts that have been published before this many days ago.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em><br />
												<em><?php _e('Units: days', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Maximun days for eligible -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Maximun days for eligible', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">
												<input id="wps_post_filter_max_age" name="wps_post_filter_max_age" type="text" size="60" value="<?php echo esc_attr($settings['post_filter']['max_age']); ?>"><br />
												<em><?php _e("Only reshare posts that have been published after this many days ago. (0 for no max age limit)", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em><br />
												<em><?php _e('Units: days', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Include these Post Types -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Post Types', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">

												<?php

												/* Get all post types that are public */

												$post_types = get_post_types(array('public' => true));

												foreach ($post_types as $post_type) {
												?>
													<input type="checkbox" class="wps_post_filter_post_types_class" id="wps_post_filter_post_types_<?php echo $post_type; ?>" name="wps_post_filter_post_types_<?php echo $post_type; ?>" <?php echo (isset($settings['post_filter']['post_types']) && in_array($post_type, $settings['post_filter']['post_types']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $post_type); ?></label><br />
												<?php } ?>
												<em><?php _e("ONLY reshare posts that are of these post types.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
											</td>
										</th>
									</tr>

									<!-- Exclude Posts in these Categories -->

									<tr>
										<th class="wpsite_twitter_reshare_admin_table_th">
											<label><?php _e('Exclude Categories', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
											<td class="wpsite_twitter_reshare_admin_table_td">

												<?php

												/* Get all categories */

												$categories = get_categories();

												foreach ($categories as $category) {
													$category_name = strtolower(str_replace(' ','',$category->name));
												?>
													<input type="checkbox" class="wps_post_filter_exclude_categories_class" id="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" name="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" <?php echo (isset($settings['post_filter']['exclude_categories']) && in_array($category->cat_ID, $settings['post_filter']['exclude_categories']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $category->name); ?></label><br />
												<?php } ?>
												<em><?php _e("Do NOT reshare posts that are in these categories.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
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

		<?php require_once('sidebar.php'); ?>

	</div> <!-- /wpsite_plugin_content -->

<?php require_once('footer.php'); ?>
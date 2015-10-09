<script type="text/javascript">
jQuery(document).ready(function($) {
	$( "#tabs" ).tabs();
});
</script>

<div class="nnr-wrap">

	<?php require_once('header.php'); ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php _e('Edit Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

			<form method="post" id="wpsite_twitter_reshare_account_form" class="form-horizontal">

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#wpsite_twitter_reshare_keys" role="tab" data-toggle="tab"><?php _e('Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></li>
					<li role="presentation"><a href="#wpsite_twitter_reshare_general" role="tab" data-toggle="tab"><?php _e('General', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></li>
					<li role="presentation"><a href="#wpsite_twitter_reshare_content" role="tab" data-toggle="tab"><?php _e('Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></li>
					<li role="presentation"><a href="#wpsite_twitter_reshare_filters" role="tab" data-toggle="tab"><?php _e('Filters', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></li>
				</ul><br />

				<div class="tab-content">

					<div role="tabpanel" class="tab-pane active" id="wpsite_twitter_reshare_keys">

						<!-- Account ID -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Account ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="wps_settings_account_id" name="wps_settings_account_id" placeholder="Email" value="<?php echo isset($settings['id']) ? $settings['id'] : ''; ?>" readonly>
							</div>
						</div>

						<!-- Connect Account -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Connect Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<?php require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/connect-accounts/connect-twitter.php'); ?>
								<em class="help-block"><?php _e('Sign into your twitter account. If button says "Sign In" then your account is not yet registered with Content Resharer. Upgrade to connect with Facebook and LinkedIn.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

					</div>

					<div role="tabpanel" class="tab-pane" id="wpsite_twitter_reshare_general">

						<!-- Status -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<select id="wps_settings_status" name="wps_settings_status">
									<option value="active"	<?php echo isset($settings['status']) && $settings['status'] = 'active' ? 'selected' : ''; ?>><?php _e('Active', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
									<option value="inactive" <?php echo isset($settings['status']) && $settings['status'] = 'active' ? 'selected' : ''; ?>><?php _e('Inactive', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
								</select>
								<em class="help-block"><?php _e('Whether or not the account is active or deactive.  Deactive accounts will not post to social media channel.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Label -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_settings_label" name="wps_settings_label" type="text" class="form-control" value="<?php echo esc_attr($settings['label']); ?>">
								<em class="help-block"><?php _e('Used for meta box name in edit post screen for custom messages.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Minimum Interval to reshare posts -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_general_min_interval" name="wps_general_min_interval" type="text" class="form-control" value="<?php echo esc_attr($settings['general']['min_interval']); ?>">
								<em class="help-block"><?php _e('The interval in which posts are shared. Units are in hours.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

					</div>

					<div role="tabpanel" class="tab-pane" id="wpsite_twitter_reshare_content">

						<!-- Reshare Content -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Reshare Content', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<select id="wps_general_reshare_content" name="wps_general_reshare_content">
									<option value="title" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'title' ? 'selected' : ''; ?>><?php _e('Title', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

									<option value="content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'content' ? 'selected' : ''; ?>><?php _e('Excerpt', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>

									<option value="title_content" <?php echo isset($settings['general']['reshare_content']) && $settings['general']['reshare_content'] == 'title_content' ? 'selected' : ''; ?>><?php _e('Title and Excerpt', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
								</select>
								<em class="help-block"><?php _e("Should the content be the a post's title, excerpt, or both?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Hashtags -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<select id="wps_general_hashtag_type" name="wps_general_hashtag_type">
									<option value="none" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'none' ? 'selected' : ''; ?>><?php _e('Do not include hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
									<option value="custom_field" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'custom_field' ? 'selected' : ''; ?>><?php _e('From post custom field (i.e Twitter Reshare Meta Box)', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
									<option value="category" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'category' ? 'selected' : ''; ?>><?php _e('First Category', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
									<option value="specific_hashtags" <?php echo isset($settings['general']['hashtag_type']) && $settings['general']['hashtag_type'] == 'specific_hashtags' ? 'selected' : ''; ?>><?php _e('Specific hashtag', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></option>
								</select>
								<em class="help-block"><?php _e("Include hashtags or not?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Specific Hashtags -->

						<div class="form-group wpsite_general_specific_hashtag">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Specific Hashtags', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_general_specific_hashtags" name="wps_general_specific_hashtags" type="text" class="form-control" value="<?php echo esc_attr($settings['general']['specific_hashtags']); ?>" placeholder="hashtag,hashtag1">
								<em class="help-block"><?php _e('These hashtags will always be included in every tweet. Separate tags by commas.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Bitly URL Shortener -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Bitly URL Shortener', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_general_bitly_url_shortener" name="wps_general_bitly_url_shortener" type="text" class="form-control" value="<?php echo esc_attr($settings['general']['bitly_url_shortener']); ?>">
								<em class="help-block"><?php _e("This is optional and is used to shorten the URL of the post.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <?php _e('Your Bitly', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <a href="https://bitly.com/a/oauth_apps" target="_blank"><?php _e('access token', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></em>
							</div>
						</div>

						<!-- Include Link -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Include Link', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_general_include_link" name="wps_general_include_link" type="checkbox" <?php echo isset($settings['general']['include_link']) && $settings['general']['include_link'] ? 'checked="checked"' : ''; ?>>
								<em class="help-block"><?php _e("Should the post's link be included in the post?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Include Featured Image -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Include Featured Image', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_general_featured_image" name="wps_general_featured_image" type="checkbox" <?php echo isset($settings['general']['featured_image']) && $settings['general']['featured_image'] ? 'checked="checked"' : ''; ?>>
								<em class="help-block"><?php _e("Should the post's featured image be included in the post?", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

					</div>

					<div role="tabpanel" class="tab-pane" id="wpsite_twitter_reshare_filters">

						<!-- Minimum days for eligible -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Minimum days to be eligible', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_post_filter_min_age" name="wps_post_filter_min_age" type="text" class="form-control" value="<?php echo esc_attr($settings['post_filter']['min_age']); ?>">
								<em class="help-block"><?php _e("Only reshare posts that have been published before this many days ago. Units are in days.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Maximun days for eligible -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Maximum days to be eligible', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<input id="wps_post_filter_max_age" name="wps_post_filter_max_age" type="text" class="form-control" value="<?php echo esc_attr($settings['post_filter']['max_age']); ?>">
								<em class="help-block"><?php _e("Only reshare posts that have been published after this many days ago (0 for no max age limit). Units are in days.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Include these Post Types -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Post Types', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<?php $post_types = get_post_types(array('public' => true));
								foreach ($post_types as $post_type) { ?>
									<input type="checkbox" class="wps_post_filter_post_types_class" id="wps_post_filter_post_types_<?php echo $post_type; ?>" name="wps_post_filter_post_types_<?php echo $post_type; ?>" <?php echo (isset($settings['post_filter']['post_types']) && in_array($post_type, $settings['post_filter']['post_types']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $post_type); ?></label><br />
								<?php } ?>
								<em class="help-block"><?php _e("ONLY reshare posts that are of these post types.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

						<!-- Exclude Posts in these Categories -->

						<div class="form-group">
							<label for="wps_settings_account_id" class="col-sm-3 control-label"><?php _e('Exclude Categories', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
							<div class="col-sm-9">
								<?php $categories = get_categories();
								foreach ($categories as $category) {
									$category_name = strtolower(str_replace(' ','',$category->name)); ?>
									<input type="checkbox" class="wps_post_filter_exclude_categories_class" id="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" name="wps_post_filter_exclude_categories_<?php echo $category_name; ?>" <?php echo (isset($settings['post_filter']['exclude_categories']) && in_array($category->cat_ID, $settings['post_filter']['exclude_categories']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN), $category->name); ?></label><br />
								<?php } ?>
								<em class="help-block"><?php _e("Do NOT reshare posts that are in these categories.", WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></em>
							</div>
						</div>

					</div>

				</div>

				<?php wp_nonce_field('wpsite_twitter_reshare_admin_settings_add_edit'); ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="btn btn-info" value="Save Changes">
				</p>

			</form>

		</div>

		<?php require_once('sidebar.php'); ?>

	</div>

	<?php require_once('footer.php'); ?>

</div>
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
					<h1 class="logo"><?php _e('Content Resharer', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
					<span class="slogan"><?php _e('by', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <a href="http://www.wpsite.com/?utm_source=topadmin&amp;utm_medium=announce&amp;utm_campaign=top"><?php _e('WPsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></span>

					<!-- ** UPDATE THE 2 LINKS ** -->
					<div class="top-call-to-actions">
						<a class="tweet-about-plugin" href="https://twitter.com/intent/tweet?text=Neat%20and%20simple%20plugin%20for%20WordPress%20users.%20Check%20out%20the%20Content%20Resharer%20plugin%20by%20@WPsite%20-%20&amp;url=http%3A%2F%2Fwpsite.net%2Fplugins%2F&amp;via=wpsite"><span></span><?php _e('Tweet About WPsite', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
						<a class="leave-a-review" href="http://wordpress.org/support/view/plugin-reviews/follow-us-badges#postform" target="_blank"><span></span> <?php _e('Leave A Review', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
					</div><!-- end .top-call-to-actions -->
				</header>
		</div> <!-- /wpsite_plugin_header -->

		<div id="wpsite_plugin_content">

			<div id="wpsite_plugin_settings">

				<h2><?php _e('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h2>

				<table class="wp-list-table widefat fixed posts">
					<thead>
						<tr>
							<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						</tr>
					</tfoot>
					<tbody><?php

						$wpsite_twitter_reshare_ahref_array = array();

						$settings = get_option('wpsite_twitter_reshare_settings');

						/* Default values */

						if ($settings === false)
							$settings = self::$default;

						foreach ($settings['accounts'] as $account) {

							$wpsite_twitter_reshare_ahref_array[] = $account['id'];

							?>
							<tr>
								<!-- Status -->

								<td>
									<label><?php echo (isset($account['status']) && $account['status'] != '' ? __($account['status'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label>

									<div class="row-actions">
										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=activate&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_activate'); ?>"><?php echo $account['status'] == 'active' ? __('Deactivate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : __('Activate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
									</div>
								</td>

								<!-- Account ID -->

								<td>

									<!-- Picture -->

									<?php require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/api_src/twitteroauth/twitteroauth.php');

									if (isset($account['twitter']['profile_image']) && $account['twitter']['profile_image'] != '') {
										?>
										<div class="<?php echo self::$prefix_dash; ?>container">
											<div class="<?php echo self::$prefix_dash; ?>profile-image">
												<img src="<?php echo $account['twitter']['profile_image']; ?>" />
											</div>
										</div>
										<?php
									}?>

									<!-- ID Name -->

									<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><strong><?php _e($account['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a><br />

									<!-- Edit -->

									<div class="row-actions">
										<span class="edit">
											<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
										</span><!--

										|
										<span class="trash">
											<a href="#" class="wpsite_twitter_reshare_admin_settings_add_edit_submitdelete" id="wpsite_twitter_reshare_delete_<?php echo $account['id']; ?>"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>

											<span id="wpsite_twitter_reshare_delete_url_<?php echo $account['id']; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=delete&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_delete'); ?></span>
										</span>
-->
									</div>
								</td>

								<!-- Label -->

								<td>
									<label><?php echo (isset($account['label']) && $account['label'] != '' ? __($account['label'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br/>
								</td>


								<!-- Minimum Interval -->

								<td>
									<label><?php echo (isset($account['general']['min_interval']) && $account['general']['min_interval'] != '' ? __($account['general']['min_interval'] . ' hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br />

									<!-- Reshare Now  -->

									<div class="row-actions">
										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=reshare&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_reshare_now'); ?>"><?php _e('Reshare Now', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
									</div>
								</td>

								<!-- Type -->

								<td> <?php echo (isset($account['type']) && $account['type'] != '' ? __($account['type'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?> </td>
							</tr><?php
						}

					?></tbody>
				</table>
				<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>

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
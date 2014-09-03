<?php require_once('header.php'); ?>

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
			<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Content Resharer accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Content Resharer accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>

		</div> <!-- wpsite_plugin_settings -->

		<?php require_once('sidebar.php'); ?>

	</div> <!-- /wpsite_plugin_content -->

<?php require_once('footer.php'); ?>
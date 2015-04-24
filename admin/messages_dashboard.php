<?php require_once('header.php'); ?>

	<div id="wpsite_plugin_content">

		<div id="wpsite_plugin_settings">

			<div id="icon-edit" class="icon32 icon32-posts-post"><br/></div>
			<!-- <a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=add', 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Add New', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
			<h2><?php _e('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h2>

			<div id="col-container">

				<div id="col-right">
					<div class="col-wrap">

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
								<tr>
									<!-- Account ID -->

									<td>

										<!-- ID Name -->

										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><strong><?php _e($message['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a>

										<div class="row-actions">

											<span class="edit">
												<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
											</span><!--
 |

											<span class="trash">
												<a href="#" class="wpsite_twitter_reshare_message_delete" id="wpsite_twitter_reshare_message_delete_<?php echo $message['id']; ?>" style="color:red;"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
												<span id="wpsite_twitter_reshare_delete_url_<?php echo $message['id']; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$message_dashboard_page . '&action=delete&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_delete'); ?></span>
											</span>
-->

										</div>
									</td>

									<!-- Message -->

									<td>
										<label><?php echo (isset($message['message']) && $message['message'] != '' ? __($message['message'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label>
									</td>

									<!-- Place -->

									<td> <?php echo (isset($message['place']) && $message['place'] != '' ? __($message['place'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?> </td>

								</tr><?php
							}

						?></tbody>
					</table>
					</div>
				</div>

				<div id="col-left">
					<div class="col-wrap"><?php
					//if (isset($_GET['action']) && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) {
						self::wpsite_twitter_reshare_settings_messages_add_edit('message');
					/*
} else if (isset($_GET['action']) && $_GET['action'] == 'add' && check_admin_referer('wpsite_twitter_reshare_admin_settings_messages_add_edit')) {
						self::wpsite_twitter_reshare_settings_messages_add_edit();
					} else {
						self::wpsite_twitter_reshare_settings_messages_add_edit();
					}
*/?>
					</div>
				</div>

				<!-- <label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label> -->

			</div> <!-- col-container -->

		</div> <!-- wpsite_plugin_settings -->

		<?php require_once('sidebar.php'); ?>

	</div> <!-- /wpsite_plugin_content -->

<?php require_once('footer.php'); ?>
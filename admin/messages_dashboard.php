<div class="nnr-wrap">

	<?php require_once('header.php'); ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php _e('Messages', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

			<div id="col-container">

				<div id="col-right">
					<div class="col-wrap">

					<table class="table table-responsive table-striped">
						<thead>
							<tr>
								<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
								<th><?php _e('Message', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
								<th><?php _e('Place', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
							</tr>
						</thead>
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

										<a href="<?php echo wp_nonce_url(get_admin_url() . 'admin.php?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><strong><?php _e($message['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a>

										<div class="row-actions">

											<span class="edit">
												<a href="<?php echo wp_nonce_url(get_admin_url() . 'admin.php?page=' . self::$message_dashboard_page . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
											</span>

										</div>
									</td>

									<!-- Message -->

									<td>
										<span><?php echo (isset($message['message']) && $message['message'] != '' ? __($message['message'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></span>
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
					<div class="col-wrap">
						<?php self::wpsite_twitter_reshare_settings_messages_add_edit('message'); ?>
					</div>
				</div>

			</div> <!-- col-container -->

		</div>

		<?php require_once('sidebar.php'); ?>

	</div>

	<?php require_once('footer.php'); ?>

</div>
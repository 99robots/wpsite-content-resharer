<div class="nnr-wrap">

	<?php require_once('header.php'); ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php _e('Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

			<table class="table table-responsive table-striped">
				<thead>
					<tr>
						<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						<th><?php _e('Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
						<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
					</tr>
				</thead>
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
								<span><?php echo (isset($account['status']) && $account['status'] != '' ? __($account['status'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></span>

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

								<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e($account['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>

								<!-- Edit -->

								<div class="row-actions">
									<span class="edit">
										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
									</span>
								</div>
							</td>

							<!-- Label -->

							<td>
								<span><?php echo (isset($account['label']) && $account['label'] != '' ? __($account['label'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></span>
							</td>

							<!-- Minimum Interval -->

							<td>
								<span><?php echo (isset($account['general']['min_interval']) && $account['general']['min_interval'] != '' ? __($account['general']['min_interval'] . ' hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></span>

								<!-- Reshare Now  -->

								<div class="row-actions">
									<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=reshare&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_reshare_now'); ?>"><?php _e('Reshare Now', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
								</div>
							</td>

							<!-- Type -->

							<td>
								<span><?php echo (isset($account['type']) && $account['type'] != '' ? __(ucfirst($account['type']), WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></span>

							</td>

						</tr><?php
					}

				?>

					<tr class="nnr-upgrade-row">
						<!-- Status -->

						<td>
							<a href="https://99robots.com/products/wp-content-resharer-pro/?utm_source=content-resharer&utm_medium=upgrade-row&utm_term=upgrade&utm_campaign=content-resharer-upgrade" target="_blank"><button class="btn btn-info btn-xs"><?php _e('Upgrade', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></button></a><br/><br/>
						</td>

						<!-- Account ID -->

						<td>
							<span><?php _e('facebook', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Label -->

						<td>
							<span><?php _e('Facebook', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Minimum Interval -->

						<td>
							<span><?php _e('6 hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Type -->

						<td>
							<span><?php _e('Facebook', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

					</tr>

					<tr class="nnr-upgrade-row">
						<!-- Status -->

						<td>
							<a href="https://99robots.com/products/wp-content-resharer-pro/?utm_source=content-resharer&utm_medium=upgrade-row&utm_term=upgrade&utm_campaign=content-resharer-upgrade" target="_blank"><button class="btn btn-info btn-xs"><?php _e('Upgrade', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></button></a><br/><br/>
						</td>

						<!-- Account ID -->

						<td>
							<span><?php _e('linkedin', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Label -->

						<td>
							<span><?php _e('LinkedIn', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Minimum Interval -->

						<td>
							<span><?php _e('6 hours', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

						<!-- Type -->

						<td>
							<span><?php _e('LinkedIn', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</td>

					</tr>

				</tbody>
			</table>

		</div>

		<?php require_once('sidebar.php'); ?>

	</div>

	<?php require_once('footer.php'); ?>

</div>
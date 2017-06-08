<div class="nnr-wrap">

	<?php require_once('header.php'); ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php _e('Accounts', 'wpsite-twitter-reshare'); ?></h1>

			<table class="table table-responsive table-striped">
				<thead>
					<tr>
						<th><?php _e('Status', 'wpsite-twitter-reshare'); ?></th>
						<th><?php _e('ID', 'wpsite-twitter-reshare'); ?></th>
						<th><?php _e('Label', 'wpsite-twitter-reshare'); ?></th>
						<th><?php _e('Interval', 'wpsite-twitter-reshare'); ?></th>
						<th><?php _e('Type', 'wpsite-twitter-reshare'); ?></th>
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
								<span><?php echo (isset($account['status']) && $account['status'] != '' ? __($account['status'], 'wpsite-twitter-reshare') : ''); ?></span>

								<div class="row-actions">
									<a href="<?php echo wp_nonce_url( $this->get_page_url( 'dashboard' ) . '&action=activate&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_activate'); ?>"><?php echo $account['status'] == 'active' ? __('Deactivate', 'wpsite-twitter-reshare') : __('Activate', 'wpsite-twitter-reshare'); ?></a>
								</div>
							</td>

							<!-- Account ID -->

							<td>

								<!-- Picture -->

								<?php require(WPSITE_TWITTER_RESHARE_PLUGIN_DIR . '/include/api_src/twitteroauth/twitteroauth.php');

								if (isset($account['twitter']['profile_image']) && $account['twitter']['profile_image'] != '') {
									?>
									<div class="<?php echo self::$prefix_dash; ?>container" style="float:left;">
										<div class="<?php echo self::$prefix_dash; ?>profile-image">
											<img src="<?php echo $account['twitter']['profile_image']; ?>" />
										</div>
									</div>
									<?php
								}?>

								<!-- ID Name -->

								<a href="<?php echo wp_nonce_url( $this->get_page_url( 'dashboard' ) . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e($account['id'], 'wpsite-twitter-reshare'); ?></a>

								<!-- Edit -->

								<div class="row-actions">
									<span class="edit">
										<a href="<?php echo wp_nonce_url( $this->get_page_url( 'dashboard' ) . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Edit', 'wpsite-twitter-reshare'); ?></a>
									</span>
								</div>
							</td>

							<!-- Label -->

							<td>
								<span><?php echo (isset($account['label']) && $account['label'] != '' ? __($account['label'], 'wpsite-twitter-reshare') : ''); ?></span>
							</td>

							<!-- Minimum Interval -->

							<td>
								<span><?php echo (isset($account['general']['min_interval']) && $account['general']['min_interval'] != '' ? __($account['general']['min_interval'] . ' hours', 'wpsite-twitter-reshare') : ''); ?></span>

								<!-- Reshare Now  -->

								<div class="row-actions">
									<a href="<?php echo wp_nonce_url( $this->get_page_url( 'dashboard' ) . '&action=reshare&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_reshare_now'); ?>"><?php _e('Reshare Now', 'wpsite-twitter-reshare'); ?></a>
								</div>
							</td>

							<!-- Type -->

							<td>
								<span><?php echo (isset($account['type']) && $account['type'] != '' ? __(ucfirst($account['type']), 'wpsite-twitter-reshare') : ''); ?></span>

							</td>

						</tr><?php
					}

				?>

					<tr class="nnr-upgrade-row">
						<!-- Status -->

						<td>
							<a href="https://99robots.com/products/wp-content-resharer-pro/?utm_source=content-resharer&utm_medium=upgrade-row&utm_term=upgrade&utm_campaign=content-resharer-upgrade" target="_blank"><button class="btn btn-info btn-xs"><?php _e('Upgrade', 'wpsite-twitter-reshare'); ?></button></a><br/><br/>
						</td>

						<!-- Account ID -->

						<td>
							<span><?php _e('facebook', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Label -->

						<td>
							<span><?php _e('Facebook', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Minimum Interval -->

						<td>
							<span><?php _e('6 hours', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Type -->

						<td>
							<span><?php _e('Facebook', 'wpsite-twitter-reshare'); ?></span>
						</td>

					</tr>

					<tr class="nnr-upgrade-row">
						<!-- Status -->

						<td>
							<a href="https://99robots.com/products/wp-content-resharer-pro/?utm_source=content-resharer&utm_medium=upgrade-row&utm_term=upgrade&utm_campaign=content-resharer-upgrade" target="_blank"><button class="btn btn-info btn-xs"><?php _e('Upgrade', 'wpsite-twitter-reshare'); ?></button></a><br/><br/>
						</td>

						<!-- Account ID -->

						<td>
							<span><?php _e('linkedin', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Label -->

						<td>
							<span><?php _e('LinkedIn', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Minimum Interval -->

						<td>
							<span><?php _e('6 hours', 'wpsite-twitter-reshare'); ?></span>
						</td>

						<!-- Type -->

						<td>
							<span><?php _e('LinkedIn', 'wpsite-twitter-reshare'); ?></span>
						</td>

					</tr>

				</tbody>
			</table>

		</div>

		<?php require_once('sidebar.php'); ?>

	</div>

	<?php require_once('footer.php'); ?>

</div>

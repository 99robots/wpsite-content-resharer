<div class="nnr-wrap">

	<?php require_once( 'header.php' ) ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php esc_html_e( 'Messages', 'wpsite-twitter-reshare' ) ?></h1>

			<div id="col-container">

				<div id="col-right">
					<div class="col-wrap">

						<table class="table table-responsive table-striped">
							<thead>
								<tr>
									<th><?php esc_html_e( 'ID', 'wpsite-twitter-reshare' ) ?></th>
									<th><?php esc_html_e( 'Message', 'wpsite-twitter-reshare' ) ?></th>
									<th><?php esc_html_e( 'Place', 'wpsite-twitter-reshare' ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$wpsite_twitter_reshare_ahref_array = array();
								$settings = $this->get_settings();

								foreach ( $settings['messages'] as $message ) :
									$wpsite_twitter_reshare_ahref_array[] = $message['id'];
								?>
									<tr>
										<td>
											<a href="<?php echo wp_nonce_url( $this->get_page_url( 'messages' ) . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit' ) ?>"><strong><?php echo $message['id'] ?></strong></a>

											<div class="row-actions">

												<span class="edit">
													<a href="<?php echo wp_nonce_url( $this->get_page_url( 'messages' ) . '&action=edit&message=' . $message['id'], 'wpsite_twitter_reshare_admin_settings_messages_add_edit' ) ?>"><?php esc_html_e( 'Edit', 'wpsite-twitter-reshare' ) ?></a>
												</span>

											</div>
										</td>

										<td>
											<span><?php echo isset( $message['message'] ) && '' !== $message['message'] ? $message['message'] : '' ?></span>
										</td>

										<td>
											<?php echo isset( $message['place'] ) && '' !== $message['place'] ? $message['place'] : '' ?>
										</td>

									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>

				<div id="col-left">
					<div class="col-wrap">
						<?php $this->page_messages_add_edit( 'message' ) ?>
					</div>
				</div>

			</div>

		</div>

		<?php require_once( 'sidebar.php' ) ?>

	</div>

	<?php require_once( 'footer.php' ) ?>

</div>

<div class="nnr-wrap">

	<?php require_once( 'header.php' ) ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php esc_html_e( 'Exclude Posts', 'wpsite-twitter-reshare' ) ?></h1>

			<form method="post" id="wpsite_twitter_reshare_exclude_posts_form" class="form-horizontal">

				<!-- Filter by Category -->
				<div class="form-group">
					<label for="wpsite_twitter_reshare_exclude_posts_category" class="col-sm-3 control-label"><?php esc_html_e( 'Category', 'wpsite-twitter-reshare' ) ?></label>
					<div class="col-sm-9">
						<select id="wpsite_twitter_reshare_exclude_posts_category">
							<option value="<?php echo null; ?>"><?php echo '-- All --'; ?></option>

							<?php
							foreach ( $categories as $category ) :
								$category_name = strtolower( str_replace( ' ', '', $category->name ) );
							?>
								<option value="<?php echo $category->cat_ID; ?>"><?php echo $category_name ?></option>
							<?php endforeach; ?>

						</select>
					</div>
				</div>

				<?php
				$posts = get_posts( array(
					'posts_per_page' => -1,
					'post_type' => 'any',
				) );

				foreach ( $posts as $post ) {

					$post_categories = wp_get_post_categories( $post->ID );
				?>
					<div class="form-group wpsite_twitter_reshare_exclude_posts_general <?php foreach ( $post_categories as $cat ) { echo 'wpsite_twitter_reshare_cat_' . $cat . ' '; } ?>">
						<label for="wps_settings_exclude_posts_<?php echo $post->ID ?>" class="col-sm-3 control-label"><?php echo $post->post_title ?></label>
					    <div class="col-sm-9">
					    	<input id="wps_settings_exclude_posts_<?php echo $post->ID ?>" name="wps_settings_exclude_posts_<?php echo $post->ID ?>" type="checkbox" <?php echo isset( $settings_exclude_posts[ $post->ID ] ) && $settings_exclude_posts[ $post->ID ] ? 'checked="checked"' : ''; ?>>
							<input id="wpsite_twitter_reshare_categories_exclude_posts_<?php echo $post->ID ?>" style="display:none;" value="<?php echo isset( $post_categories ) && is_array( $post_categories ) ? serialize( $post_categories ) : null; ?>">
					    </div>
					</div>

				<?php } ?>

				<?php wp_nonce_field( 'wpsite_twitter_reshare_admin_settings_exclude_posts_edit' ) ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="btn btn-info" value="Save Changes">
				</p>

			</form>

		</div>

		<?php require_once( 'sidebar.php' ) ?>

	</div>

	<?php require_once( 'footer.php' ) ?>

</div>

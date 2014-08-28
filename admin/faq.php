<?php require_once('header.php'); ?>

		<div id="wpsite_plugin_content">

			<div id="wpsite_plugin_settings">

				<div class="wrap metabox-holder">

					<h1><?php _e('Fequently Asked Questions', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

					<div class="postbox">
						<h3><?php _e('What does Content Resharer do for me?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('Do you have a lot of posts on your blog and not enough traffic to them, or not enough traffic to old posts that are still very relevant?  Wish you can automatically share all your posts at random to your twitter account at set intervals?  Well with Content Resharer all of this is possible and more.  Simply link your twitter account to Content Resharer and we will take care of the rest.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is an account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('An account is a social media channel that you would like Content Reshare to use to automatically reshare all your posts.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is a message?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('A message is the text you would like to include in the reshare content.  It is highly recommended to create messages and lots of them to make your reshare content more humanlike.  When creating a message you will see a preview that shows you what an example reshare content could look like.  Messages are totally optional and the plugin will still post to the social channel if you have none.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('How do I edit an account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('On the "Accounts" page, hover over the table account you want to edit and you will see an "Edit" link appear.  Click this link and you will be redirected to the edit screen for that account.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is the Account Tab?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('Under this tab you will be able to name your account and connect a social media account.  The name of the account on for this plugin and will not affect your social media account.  The "Connect Account" button will connect your social media account to the Content Resharer plugin.  This is how we are able ot post on your behalf.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is the General Tab?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('The settings under this tab are basic settings for this account.  Most importantly is the interval setting, which controls how often Content Resharer will reshare content.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is the Content Tab?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<p><?php _e('All settings under this tab control the content of the reshare.  You may also select your "Hashtag Type". There are several customization options here which include "First Category", which allows you to turn the first category that you assigned a post to into a hashtag. For example, if you write a post about entrepreneurship and you assign it a category "entrepreneurs", if that is the first category you assigned to the post then your reshare will include #entrepreneur along with the content and link. "From post custom field" allows to assign a hashtag directly in your post. To find this custom field, go to the bottom right of your post where you will see that you can assign a hashtag.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p>
						<p><?php _e('You may choose to include a link with your post, and if you assign your reshare with a Bitly access token, the reshare will appear with a Bitly link.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p>
						<p><?php _e('If you would like to include a featured image with all posts, just check off that box as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('What is the Filters Tab?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<p><?php _e('These settings are used to determine the amount of days you want a post to have reshare eligibility. For example, if you do not want a post to be reshared until 3 days after it was originally posted, you would put "3" in the "Minimum days for eligibility" box. You may also decide the maximum amount of days that a post is eligible for reshare. For example, if a post was published 10 days ago and you assign a maximum of 10, that means that the post will not be reshared since it has reached its maximum amount of days.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p>
							<p><?php _e('You may also decide which post categories you want to exclude from being reshared. All of your assigned categories will appear that you can mark to exclude. You may also limit Post Types.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></p>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('How can I customize the reshare content?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('Navigate to the “Content" section under the settings page for your account.  All the settings in this tab control what the reshare will consist of.  Do you want to include a link or an image?  Do you want hashtags?  Next navigate to the "Filters" scetion.  These settings are used to determine which posts are eligible to be reshared.  Do you want to reshare posts with a certaion age, or post type, or category?  Then a random post is chosen from these qualified posts.  After that, the message is added to the content.  Either to beginning or end of the content.  This would conclude how your content is being created.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

					<div class="postbox">
						<h3><?php _e('How do I share manually?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
						<div class="inside">
							<span><?php _e('There is a way to reshare content manually.  Go to the "Accounts" submenu page and hover over the account you want to manually reshare.  Go to the “Interval” column and hit the "reshare now” link.  This will manually reshare content to that account and will not affect the account’s scheduled reshare intervals.  This is a great way to test if your account is setup properly.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
						</div>
					</div>

				</div>

			</div> <!-- wpsite_plugin_settings -->

		<?php require_once('sidebar.php'); ?>

	</div> <!-- /wpsite_plugin_content -->

<?php require_once('footer.php'); ?>
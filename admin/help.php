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
					<span class="slogan"><?php _e('by', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?> <a href="http://www.wpsite.net/?utm_source=topadmin&amp;utm_medium=announce&amp;utm_campaign=top"><?php _e('WPsite.net', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></span>

					<!-- ** UPDATE THE 2 LINKS ** -->
					<div class="top-call-to-actions">
						<a class="tweet-about-plugin" href="https://twitter.com/intent/tweet?text=Neat%20and%20simple%20plugin%20for%20WordPress%20users.%20Check%20out%20the%20Content%20Resharer%20plugin%20by%20@WPsite%20-%20&amp;url=http%3A%2F%2Fwpsite.net%2Fplugins%2F&amp;via=wpsite"><span></span><?php _e('Tweet About WPsite', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
						<a class="leave-a-review" href="http://wordpress.org/support/view/plugin-reviews/follow-us-badges#postform" target="_blank"><span></span> <?php _e('Leave A Review', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
					</div><!-- end .top-call-to-actions -->
				</header>
		</div> <!-- /wpsite_plugin_header -->

		<div id="wpsite_plugin_content">

			<div id="wpsite_plugin_settings">

<div class="wrap metabox-holder">

	<h1><?php _e('Trouble Shooting Twitter Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

	<div class="postbox">
		<h3><?php _e('My Twitter account has not been tweeting at its intervals or at all.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		<div class="inside">
			<span><?php _e('First check to see if the account is set to active, and all your post filters are valid.  This is a very common problem so go through these steps to make sure your post filter settings are allowing for at least a couple posts to be selected.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		</div>
	</div>

	<div class="postbox">

		<div class="inside">
			<ol>
			<li><?php _e('Make sure your minimum and maximum age are valid and will return a list of posts.  For example if you put your minimum age as 1 day and maximum age as 2 days, and you have no posts that were published in the last two days, then no posts can be selected and nothing will be reshared.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
			<li><?php _e('Make sure you have selected post types to include.  This is found in the Accounts “Post Filter” section.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
			<li><?php _e('Make sure to check to see if you have at least one box unchecked in the exclude posts in this category setting.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
			<li><?php _e('Go to the "Exclude Posts" page and make sure that all, if not most posts are included.  All checked posts will be excluded when selecting a post to reshare.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
		</ol>
		</div>
	</div>

	<div class="postbox">

		<div class="inside">
			<span><?php _e('If you have done the steps above and there are valid posts Content Resharer can choose from then go to the "Accounts" page and make sure the "reshare now" works for the account.  Hover over the account and the "reshare now" link will be under the "Interval" column.  Click the "reshare now" link and if nothing has been shared to your twitter account then try to re-connect your account.  If this still does not work then you might be recieving a "Dupliate status error from twitter".  This is safeguard for twitter and it basically means that you cannot post a certain amount of the same tweets within given set of tweets.  Basically, if 4 out of your last 5 tweets were the same then trying to tweet the same thing again could result in a "Duplicate status error".', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <a href="https://dev.twitter.com/discussions/800" target="_blank"><?php _e('Find out more', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
		</div>
	</div>

	<!--
<div class="postbox">

		<div class="inside">
			<span><?php _e('If the "reshare now" worked and something was tweeted then the error is most likely a "duplicate status error" from twitter or a problem with the wordpress CRON job.  The most common issue is that twitter won’t allow duplicate tweets in a set interval of time.  If your blog only has a few of posts and you have only created a few or no messages, then WPSite Reshare could be trying to reshare the same content.  A quick fix could be adding more messages to give your content more variety.  If this doesn’t fix it then try downloading the WP Control plugin http://wordpress.org/plugins/wp-crontrol/.  This shows you all wordpress cron jobs.  Under the “Tools” menu page in your blog admin panel, click on the submenu “Control”.  This page will show all your CRON jobs.  Here there should be CRON jobs with hooks called wpsite_twitter_reshare_*, which are all WPSite Reshare CRON jobs.  If there are none, and the wpsite reshare account is set to active, then the CRON jobs are not scheduling.  If this is so please contact kjbenk@gmail.com for further information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		</div>
	</div>

	<div class="postbox">

		<div class="inside">
			<span><?php _e('If the "reshare now" didn’t work then there is something wrong with your connection to your twitter account.  First check to see if your Access Level Capabilities are set to "Read and Write” (read more about that in the FAQ).  If these the Access Level Capabilities are set to “Read and Write”, then maybe is has something to do with your Callback URL.  Twitter will complain sometimes if a Callback URL is not set.  This is only a twitter developer application bug and it will not affect your site at all.  You can put a dummy Callback URL in this field which we recommend to be your main url.  To set your Callback URL, go to your twitter application using this link https://dev.twitter.com/apps and go to the “Settings” tab.  Under the “Application Type” section you will see the Callback URL field.  Put your url into this field e.g. http://example.com, and hit “Update this twitter application’s settings”.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		</div>
	</div>
-->

	<span><?php _e('All errors should be found in the debug log if you want more information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
</div>

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
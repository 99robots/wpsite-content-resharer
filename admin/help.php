<div style="float:left;width:45%;padding-right:20px;">
	<h1><?php _e('Help', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

	<h3><?php _e('What does WPSite Reshare do for me?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

		<span><?php _e('Do you have a lot of posts on your blog and not enough traffic to them or not enough traffic to old posts that are still very relevant?  Wish you can automatically share all your posts at random to your twitter account at set intervals?  Well with WPSite Reshare all of this is possible and more.  Simply create an account and some messages and your have an automatic reshare engine.  Any questions, go to the FAQ page.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
	
	<h3><?php _e('What is an account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
	
		<span><?php _e('An account is a social media channel that you would like to have WPSite Reshare automatically use to reshare all your posts.  You can have multiple accounts and each with differently settings and intervals in which to automatically post.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		
	<h3><?php _e('How do I setup my twitter developer account?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
		
		<span><?php _e('Before WPSite Reshare can automatically tweet for you, we need you to create a twitter developer account.  By creating this account you can link your site to your twitter account and allow WPSite Reshare to automatically post for you.  Go to this link to create an twitter developer account https://dev.twitter.com. Then create a twitter developer application by going to this link https://dev.twitter.com/apps.  After that is done and you set your Access Level Capabilities to "Read and Write” (see FAQ), then copy and paste all your keys, secrets, and tokens (see FAQ) into your new WPSite Reshare twitter account.  Once that is done set your post filter settings,(see Trouble Shooting section on Help page for Post Filtering) making sure to include some post types and to not exclude all categories.  Finally your ready to test your account!  Go to the Accounts page and hover your newly created account.  Under the “Minimum Interval” column there will be a link that says “reshare now”, click it.  Once this is done check your twitter feed to see your new tweet (if not go to Trouble Shooting section on Help page).', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		
	
	<h3><?php _e('What are messages?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
	
		<span><?php _e('A message is the text you would like to include in the reshare content.  It is highly recommended to create messages and lots of them to make WPSite Reshare posts seems more humanlike.  When creating a message there is a preview to show you what an example post content could look like.  Messages are totally optional and the plugin will still post to the social channel if you have none.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
		
	<h3><?php _e('How do I share manually?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
	
		<span><?php _e('There is a way to reshare content manually.  Go to the Accounts submenu page and hover over the account you want to manually reshare.  Go to the “Minimum Interval” column and hit the "reshare now” link.  This will manually reshare to that account and will not affect the account’s scheduled reshare intervals.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
	
</div>
	
	


<div style="float:right;width:45%;padding-right:40px;">

	<h1><?php _e('Trouble Shooting Twitter Account', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>
	
	<h3><?php _e('My Twitter account has not been tweeting at its intervals or at all.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>
	
	<span><?php _e('First check to see if the account is set to active, and all your post filters are valid.  This is a very common problem so go through these steps to make sure your post filter settings are allowing for at least a couple posts to be selected.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>


	<ol>
		<li><?php _e('Make sure your minimum and maximum age are valid and will return a list of posts.  For example if you put your minimum age as 1 day and maximum age as 2 days, and you have no posts that were published in the last two days, then no posts can be selected and nothing will be reshared.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
		<li><?php _e('Make sure you have selected post types to include.  This is found in the Accounts “Post Filter” section.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
		<li><?php _e('Make sure to check to see if you have at least one box unchecked in the exclude posts in this category setting.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
		<li><?php _e('Go to the Exclude Posts page and make sure that all, if not most posts are included.  All checked posts will be excluded when selecting a post to reshare.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></li>
	</ol>
	
	<span><?php _e('If you have done the steps above and there are valid posts WPSite Reshare can chosen from then go to the Accounts page and make sure the "reshare now" works for the account.  Hovering over the account under the “ Minimum Interval” column there is a "reshare now" link.  More on the “reshare now” go to the Help page in the plugin. Click this link and look on your twitter account to see if anything was tweeted. ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
	
	<span><?php _e('If the "reshare now" worked and something was tweeted then the error is most likely a "duplicate status error" from twitter or a problem with the wordpress CRON job.  The most common issue is that twitter won’t allow duplicate tweets in a set interval of time.  If your blog only has a few of posts and you have only created a few or no messages, then WPSite Reshare could be trying to reshare the same content.  A quick fix could be adding more messages to give your content more variety.  If this doesn’t fix it then try downloading the WP Control plugin http://wordpress.org/plugins/wp-crontrol/.  This shows you all wordpress cron jobs.  Under the “Tools” menu page in your blog admin panel, click on the submenu “Control”.  This page will show all your CRON jobs.  Here there should be CRON jobs with hooks called wpsite_twitter_reshare_*, which are all WPSite Reshare CRON jobs.  If there are none, and the wpsite reshare account is set to active, then the CRON jobs are not scheduling.  If this is so please contact kjbenk@gmail.com for further information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
	
	<span><?php _e('If the "reshare now" didn’t work then there is something wrong with your connection to your twitter account.  First check to see if your Access Level Capabilities are set to "Read and Write” (read more about that in the FAQ).  If these the Access Level Capabilities are set to “Read and Write”, then maybe is has something to do with your Callback URL.  Twitter will complain sometimes if a Callback URL is not set.  This is only a twitter developer application bug and it will not affect your site at all.  You can put a dummy Callback URL in this field which we recommend to be your main url.  To set your Callback URL, go to your twitter application using this link https://dev.twitter.com/apps and go to the “Settings” tab.  Under the “Application Type” section you will see the Callback URL field.  Put your url into this field e.g. http://example.com, and hit “Update this twitter application’s settings”.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span> <br/><br/>
	
	<span><?php _e('All errors should be found in the debug log if you want more information.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
</div>
	
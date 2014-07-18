<h1><?php _e('Fequently Asked Questions', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h1>

<h3><?php _e('Why do I have to create a twitter developer application to use this plugin? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('Twitter just recently updated its application programming interface (API) to make it more safe for users to retrieve and post information.  This also means that there are now more guidelines to follow and in order to tweet behind the scenes twitter needs to make sure you, are really you.  What this means is that twitter needs for you to register with them as a developer so they know that when you get or post information, using that developer account, to twitter it is 100% you.  What this means for you the end-user is that you need to do a little bit more to create this developer account, and then in turn create an application that will get and post information to twitter on your behalf.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('What is the "API Keys and Tokens" section in account settings page?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('This is where you will give WPSite Reshare your Consumer Key and Consumer Secret as well as the created Access Token and Access Token Secret.  This is what will allow WPSite Reshare the ability to post information to twitter automatically on your behalf.  Without this information nothing can be posted to twitter.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('Where can I find my Consumer Key, Consumer Secret, Access Token and Access Token Secret?', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('All of this information will be available to you once your create a twitter developer account and then create an application.  Once you create an application you can then go to this link https://dev.twitter.com/apps to find all your applications.  Choose the one you want to use and then Go to the “Details" tab.  Under this tab you will see the "OAuth Settings" section.  In this section you will find your Consumer Key and Consumer Secret.  Please copy and paste those to the related fields in the WPSite Reshare account settings page.  Then go to the "Your Access Token” section and first look at the Access Level field.  This must have read and write capabilities, if you don’t have these capabilities then read more about "How do I get read and write Access Level capabilities?".  Once you have read and write capabilities please copy and paste the Access Token and Access Token Secret to the related field in the WPSite Reshare plugin account settings page.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('How do I get read and write Access Level capabilities? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('First go to your twitter developer applications list from this link https://dev.twitter.com/apps.  Once there go to the application you are using with the WPSite Reshare plugin.  Go to the “Settings” tab and then scroll down to the "Application Type" Section. Check the "Read and Write" option and click “Update this Twitter application’s settings”.  Now Go to the “Details” tab and scroll down to the “Your Access Token” section.  Click on the “Recreate my access token” button.  If this new Access Level still says “Read Only” then, please try a again after a few moments because twitter is still updating the settings you changed from the “Settings” tab.  Keeping trying until the Access Level says “Read and Write”.  Now you can copy and paste the Access Token and Access Token Secret into the related accounts settings in the WPSite Reshare plugin.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('How do I exclude certain messages from certain posts? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('To exclude a message from a certain post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  Check and uncheck all your messages.  All messages that are unchecked will never be used for that post. ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('How do I create a custom message only for a specific post? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('To create a custom message related to a specific post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  In this box you can create custom messages only relating to this post.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>

<h3><?php _e('How is the reshare content created? ', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></h3>

	<span><?php _e('The reshare content is created by using the settings in the “Rehare Content" section of your account to determine what the content will consist of.  Posts are first filtered using the settings in the “Post Filter” section in your account.  Then a random post is chosen from these qualified posts.  After that, a random message is chosen by first looking to see if there any custom messages relating to hat post.  If so then randomly choose from those custom messages, if not then get all checked messages relating to this post and randomly chose one.  If there are no checked messages then there will be no message in this reshare content.  After the post and message are chosen, the content is created.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></span>
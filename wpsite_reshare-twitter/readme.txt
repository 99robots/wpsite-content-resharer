=== WPSite Reshare Beta ===
Contributors: kjbenk
Donate link: 
Tags:
Requires at least: 3.8
Tested up to: 3.8
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WPSite Reshare is an automatic sharing tool that lets you, the author or admin, worry about writing while we do the sharing.

== Description ==

WPSite Reshare is an automatic sharing tool that lets you, the author or admin, worry about writing while we do the sharing.  This is the free version which only allows for twitter accounts.  Each twitter account is related to a twitter developer app that is created by you, the end-user.  Please go to this link to find out more about becoming a twitter developer https://dev.twitter.com, and this link refers to your twitter developer applications https://dev.twitter.com/apps.  For more help or general questions please email kjbenk@gmail.com.

== Installation ==

1. Upload `wpsite_reshare` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to plugins page to see instructions for setting up your own twitter developer application.

== Frequently Asked Questions ==

= Why do I have to create a twitter developer application to use this plugin? =

Twitter just recently updated its application programming interface (API) to make it more safe for users to retrieve and post information.  This also means that there are now more guidelines to follow and in order to tweet behind the scenes twitter needs to make sure you, are really you.  What this means is that twitter needs for you to register with them as a developer so they know that when you get or post information, using that developer account, to twitter it is 100% you.  What this means for you the end-user is that you need to do a little bit more to create this developer account, and then in turn create an application that will get and post information to twitter on your behalf.

= Why do I have to create a twitter developer application to use this plugin? =


Twitter just recently updated its application programming interface (API) to make it more safe for users to retrieve and post information.  This also means that there are now more guidelines to follow and in order to tweet behind the scenes twitter needs to make sure you, are really you.  What this means is that twitter needs for you to register with them as a developer so they know that when you get or post information, using that developer account, to twitter it is 100% you.  What this means for you the end-user is that you need to do a little bit more to create this developer account, and then in turn create an application that will get and post information to twitter on your behalf. 
  

= What is the "API Keys and Tokens" section in account settings page? =

This is where you will give WPSite Reshare your Consumer Key and Consumer Secret as well as the created Access Token and Access Token Secret.  This is what will allow WPSite Reshare the ability to post information to twitter automatically on your behalf.  Without this information nothing can be posted to twitter.


= Where can I find my Consumer Key, Consumer Secret, Access Token and Access Token Secret? =

All of this information will be available to you once your create a twitter developer account and then create an application.  Once you create an application you can then go to this link https://dev.twitter.com/apps to find all your applications.  Choose the one you want to use and then Go to the “Details" tab.  Under this tab you will see the "OAuth Settings" section.  In this section you will find your Consumer Key and Consumer Secret.  Please copy and paste those to the related fields in the WPSite Reshare account settings page.  Then go to the "Your Access Token” section and first look at the Access Level field.  This must have read and write capabilities, if you don’t have these capabilities then read more about "How do I get read and write Access Level capabilities".  Once you have read and write capabilities please copy and paste the Access Token and Access Token Secret to the related field in the WPSite Reshare plugin account settings page.


= How do I get read and write Access Level capabilities? =

First go to your twitter developer applications list from this link https://dev.twitter.com/apps.  Once there go to the application you are using with the WPSite Reshare plugin.  Go to the “Settings” tab and then scroll down to the "Application Type" Section. Check the "Read and Write" option and click “Update this Twitter application’s settings”.  Now Go to the “Details” tab and scroll down to the “Your Access Token” section.  Click on the “Recreate my access token” button.  If this new Access Level still says “Read Only” then, please try a again after a few moments because twitter is still updating the settings you changed from the “Settings” tab.  Keeping trying until the Access Level says “Read and Write”.  Now you can copy and paste the Access Token and Access Token Secret into the related accounts settings in the WPSite Reshare plugin.


= How do I exclude certain messages from certain posts? =

To exclude a message from a certain post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  Check and uncheck all your messages.  All messages that are unchecked will never be used for that post. 


= How do I create a custom message only specific post? =

To create a custom message related to a specific post go to that posts edit page.  On the right side bar you will see a box that is Titled "WPSite Rehsare YourAccount”.  In this box you can create custom messages only relating to this post.


= How is the reshare content created? =

The reshare content is created by using the settings in the “Rehare Content" section of your account to determine what the content will consist of.  Posts are first filtered using the settings in the “Post Filter” section in your account.  Then a random post is chosen from these qualified posts.  After that, a random message is chosen by first looking to see if there any custom messages relating to hat post.  If so then randomly choose from those custom messages, if not then get all checked messages relating to this post and randomly chose one.  If there are no checked messages then there will be no message in this reshare content.  After the post and message are chosen, the content is created. 

== Trouble Shooting Twitter Account ==

My Twitter account has not been tweeting at its intervals or at all.

First check to see if the account is set to active, and all your post filters are valid.  This is a very common problem so go through these steps to make sure your post filter settings are allowing for at least a couple posts to be selected.  


   * Make sure your minimum and maximum age are valid and will return a list of posts.  For example if you put your minimum age as 1 day and maximum age as 2 days, and you have no posts that were published in the last two days, then no posts can be selected and nothing will be reshared.
   * Make sure you have selected post types to include.  This is found in the Accounts “Post Filter” section.
   * Make sure to check to see if you have at least one box unchecked in the exclude posts in this category setting.
   * Go to the Exclude Posts page and make sure that all, if not most posts are included.  All checked posts will be excluded when selecting a post to reshare.


If you have done the steps above and there are valid posts WPSite Reshare can chosen from then go to the Accounts page and make sure the "reshare now" works for the account.  Hovering over the account under the “ Minimum Interval” column there is a "reshare now" link.  More on the “reshare now” go to the Help page in the plugin. Click this link and look on your twitter account to see if anything was tweeted.  

If the "reshare now" worked and something was tweeted then the error is most likely a "duplicate status error" from twitter or a problem with the wordpress CRON job.  The most common issue is that twitter won’t allow duplicate tweets in a set interval of time.  If your blog only has a few of posts and you have only created a few or no messages, then WPSite Reshare could be trying to reshare the same content.  A quick fix could be adding more messages to give your content more variety.  If this doesn’t fix it then try downloading the WP Control plugin http://wordpress.org/plugins/wp-crontrol/.  This shows you all wordpress cron jobs.  Under the “Tools” menu page in your blog admin panel, click on the submenu “Control”.  This page will show all your CRON jobs.  Here there should be CRON jobs with hooks called wpsite_reshare_*, which are all WPSite Reshare CRON jobs.  If there are none, and the wpsite reshare account is set to active, then the CRON jobs are not scheduling.  If this is so please contact kjbenk@gmail.com for further information.

If the "reshare now" didn’t work then there is something wrong with your connection to your twitter account.  First check to see if your Access Level Capabilities are set to "Read and Write” (read more about that in the FAQ).  If these the Access Level Capabilities are set to “Read and Write”, then maybe is has something to do with your Callback URL.  Twitter will complain sometimes if a Callback URL is not set.  This is only a twitter developer application bug and it will not affect your site at all.  You can put a dummy Callback URL in this field which we recommend to be your main url.  To set your Callback URL, go to your twitter application using this link https://dev.twitter.com/apps and go to the “Settings” tab.  Under the “Application Type” section you will see the Callback URL field.  Put your url into this field e.g. http://example.com, and hit “Update this twitter application’s settings”.

All errors should be found in the debug log if you want more information. 

== Screenshots ==



== Changelog ==

= 1.0 =
Initail release (twitter only)
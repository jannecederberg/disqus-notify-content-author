=== Disqus Notify Post/Page Author ===
Contributors: jcederberg
Donate link: not-implemented-yet
Tags: disqus, comment, comments, notify, notification, email, post, page, author
Requires at least: 2.8
Tested up to: 3.9.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

If using Disqus, the authors of posts/pages do not get notified of comments if they're not Disqus moderators. This plugin fixes that.

== Description == 

= Purpose =
This plugin notifies post/page author by email of comments posted through the
[Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin even if the author is not an admin of the Disqus account used for the site.

In other words, this plugin implements the same notification functionality that WP ships with out of the box but which is circumvented by using the Disqus Comment System.

*[I want to install it!](http://wordpress.org/plugins/disqus-notify-content-author/installation/)*

= Works with =
Confirmed to work with at least with Disqus Comment System versions 2.74-2.77.

== Installation ==

**Before installing, make sure you have the Disqus Comment System plugin installed AND that you have not disabled automatic comment syncing in the Disqus WP plugin's settings**

= Installation through WordPress user interface =

1. (Log in to your WordPress site)
2. In WP admin interface choose *Plugins* > *Add New* OR Navigate to *http://YOURSITE.com/wp-admin/plugin-install.php*
3. In *Add New Plugin* interface search for: *[Disqus Notify Post Author](http://YOURSITE.com/wp-admin/plugin-install.php?tab=search&s=disqus+notify+post+author)*
4. Install the plugin

= Installation using a zip file =

1. [Download the zip package](https://github.com/jannecederberg/disqus-notify-content-author/archive/master.zip) of this plugin from its GitHub repo
2. Go to the *Plugins - Add New* page in WP
3. Click *Upload* and select the downloaded ZIP file

= Installation using Git =
As a final option, especially if you maintain multiple sites, you may wish to use Git to clone the plugin:

1. Open an SSH connection to your WordPress server
2. Navigate to the plugins directory: *[wproot]/wp-content/plugins*
3. Run the following command: *git clone https://github.com/jannecederberg/disqus-notify-content-author.git*
4. Log into your WordPress using your browser and go to the Plugins listing
5. Enable the plugin

== Frequently Asked Questions ==

= I receive two notification emails for each comment =

If you're admin on the Disqus account used for the site then yes you will, one from Disqus and another from WordPress. However, users who have authored content on your site but are not admins in the Disqus account will only receive one notification email (coming from WordPress).

= Why won't the notifications arrive immediately? =

There is a delay of a few minutes in notification delivery as notifications to post/page authors are emailed only after the Disqus system submits them back to your WP instance.

= There's a repo/plugin on GitHub with the same name =

Yes, that's a duplicate of the codebase of this plugin. This plugin was originally released on GitHub in March 2014. In August 2014 I applied and got the plugin promoted to WordPress.org. The GitHub repo still remains active and all changes to the plugin are actually first pushed to GitHub and only after that are they pushed to the SVN repo at wordpress.org.

If you'd rather use this plugin by doing a *git clone*, feel free to do so :)

= What's the background of the plugin? =

In standard WordPress settings you can define for WP to email the post/page author whenever a comment is posted on their content; this setting is on by default. However, if you're using the [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin (at least up to version 2.74), then post/page authors won't receive comment notifications. Instead, only comment moderators (defined in [Disqus admin panel](https://disqus.com/admin/settings/moderation/)) will be notified.

= Why not simply modify Disqus plugin code? =

You *should not* modify the Disqus Comment System plugin code to accomplish author notification. Why? Because it'll break your plugin updates. In other words, any time you update your Disqus plugin, you'll have to remember to re-apply your modification...

And what if you manage multiple WP sites? There's a 95.37% chance you'll forget to re-apply
the change on at least one of those WP instances at least sometime...plus it's pretty annoying re-applying the change over and over again.

Instead, this plugin utilizes WP's <kbd>wp_insert_comment</kbd> hook/action and the <kbd>wp_notify_postauthor</kbd> function as done in this plugin.

= Does the plugin work with WP versions prior to 3.9? =

I assume it will work with the same Wordpress versions as the Disqus Comment System, which is WP 2.8 and higher. Nevertheless, I have not tested support on all versions. If you come across a combo of WP+Disqus versions with which this plugin doesn't work, could you please report it, thank you :)

= Does the plugin work with Disqus versions prior to 2.74? =

I haven't tested. Please report in case you try it :)

== Screenshots ==

This plugin does not add anything to the user interface and hence contains no screenshots.

== Changelog ==

= 1.0.1 (2014-08-20) =
* Renamed the plugin from *Disqus Notify Content Author* to *Disqus Notify Post/Page Author*

= 1.0 (2014-08-14) =
* First public release on Wordpress.org

== Upgrade Notice ==

= 1.0.1 =
This is simply a change in the name of the plugin; if you already installed this plugin, there's no need to upgrade.

= 1.0 =
Initial public release. Nothing to upgrade.

== Related articles ==
These sites/blogs describe the same issue that this plugin solves. Using this plugin is simpler though and prevents you from shooting your own leg (by not doing custom hacks)

* [WP Daily Bits](http://wpdailybits.com/blog/notify-post-author-for-new-comment-disqus/45)
* [Cornflower Design](http://www.cornflowerdesign.co.uk/2011/11/disqus-notify-post-author/)

== Contributers ==
Contributers to the initial version of this plugin that was released in March 2014 on GitHub

- [hmemcpy](https://github.com/hmemcpy) @ GitHub: Instructions for using .zip for installing into WP
=== Disqus Notify Post/Page Author ===
Contributors: jcederberg
Donate link: not-implemented-yet
Tags: disqus, comment, comments, notify, notification, email, post, page, author
Requires at least: 2.8
Tested up to: 3.9.2
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

If using Disqus Comment System, the authors of posts/pages do not get notified of comments. This plugin fixes that.

== Description ==

= Purpose =

This WordPress plugin notifies post/page author by email of comments posted through the
[Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin. In other words the plugin implements the same notification functionality WP ships with out of the box but which is circumvented by using the Disqus Comment System without this plugin.

Please notice that there is a delay of a few minutes in notification delivery as notifications to post/page authors are emailed only after the Disqus system submits them back to your WP instance.

Confirmed to work with WordPress 3.9.x and [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) versions 2.74-2.77.

= Background / Problem =

In WordPress settings you can define for WP to email the post/page author whenever a comment is posted on their content. However, if you're using the [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin (at least up to version 2.74), then post/page authors won't receive comment notifications. Instead, only comment moderators (defined in [Disqus admin panel](https://disqus.com/admin/settings/moderation/)) will be notified.

= Why not simply modify Disqus plugin code? =

On wpdailybits.com in a post dated Nov. 2010 you'll find a solution, but unfortunately a sub-optimal one:
[How to Make Disqus Notify the Post Author When a New Comment Is Posted?](http://wpdailybits.com/blog/notify-post-author-for-new-comment-disqus/45).

Sure, the above approach works, thank you Damian for presenting it...BUT...

You *should not* modify the Disqus Comment System plugin code to accomplish author notification. Why? Because it'll break your plugin updates. In other words, any time you update your Disqus plugin, you'll have to remember to re-apply your modification...

And what if you manage multiple WP sites? There's a 95.37% chance you'll forget to re-apply
the change on at least one of those WP instances at least sometime...plus it's pretty annoying re-applying the change over and over again.

= A more elegant solution =

Utilize WP's <kbd>wp_insert_comment</kbd> hook/action and the <kbd>wp_notify_postauthor</kbd> function as done in this plugin. See below for instructions.

== Installation ==

Install by searching for the plugin in WP's plugin interface and then install from there.

Alternatively you may [download the zip](https://github.com/jannecederberg/disqus-notify-content-author/archive/master.zip) archive of this repository, then go to the **Plugins - Add New** page in WP, click **Upload** and select the downloaded ZIP file.

As a final option, you may use Git to clone the plugin files into <kbd>wproot/wp-content/plugins/disqus-author-notify</kbd> and then go to the Plugins page in WP and enable it.

== Frequently Asked Questions ==

= Does the plugin work with WP versions prior to 3.9? =

I assume it will work with the same Wordpress versions as the Disqus Comment System, which is WP 2.8 and higher. Nevertheless, I have not tested support on all versions.

If you come across a combo of WP+Disqus versions with which this plugin doesn't work, could you please report it, thank you :)

= Does the plugin work with Disqus versions prior to 2.74? =

I haven't tested. Please report in case you try it :)

== Screenshots ==

This plugin does not add anything to the user interface and hence contains no screenshots.

== Changelog ==

= 1.0.1 =
* Rename plugin name from "Disqus Notify Content Author" to "Disqus Notify Post/Page Author"

= 1.0 =
* First public release on Wordpress.org

== Upgrade Notice ==

= 1.0.1 =
This is simply a change in the name of the plugin; if you already installed this plugin, there's no need to upgrade.

= 1.0 =
Initial public release. Nothing to upgrade.

== Contributers ==

- [hmemcpy](https://github.com/hmemcpy) @ GitHub: Instructions for using .zip for installing into WP
# Disqus Author Notify for WordPress 

## Purpose

This WordPress plugin notifies post/page author of comments posted through the
[Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin just like the regular WordPress
comment notification functionality.

Confirmed to work with WordPress 3.9 and [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) versions 2.74 and 2.75.

## Background / Problem

In WordPress settings you can define for WP to email the post/page author whenever a comment is posted on their content. However, if you're using the [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin (at least up to version 2.74), then post/page authors won't receive comment notifications. Instead, only comment moderators (defined in [Disqus admin panel](https://disqus.com/admin/settings/moderation/)) will be notified.

## Solution

### Why not simply modify Disqus plugin code?

On wpdailybits.com in a post dated Nov. 2010 you'll find a solution, but unfortunately a sub-optimal one:
[How to Make Disqus Notify the Post Author When a New Comment Is Posted?](http://wpdailybits.com/blog/notify-post-author-for-new-comment-disqus/45)

Sure, the above approach works, thank you Damian for presenting it...BUT...

You *should not* modify the Disqus Comment System plugin code to accomplish author notification. Why? Because it'll break your plugin updates. In other words, any time you update your Disqus plugin, you'll have to remember to re-apply your modification...

And what if you manage multiple WP sites? There's a 95.37% chance you'll forget to re-apply
the change on at least one of those WP instances at least sometime...plus it's pretty annoying re-applying the change over and over again.

### A more elegant solution

Utilize WP's <kbd>wp_insert_comment</kbd> hook/action and the <kbd>wp_notify_postauthor</kbd> function as done in this plugin. See below for instructions.

## Plugin installation

[Download the zip](https://github.com/jannecederberg/wp-disqus-author-notify/archive/master.zip) archive of this repository, then go to the
**Plugins - Add New** page in WP, click **Upload** and select the downloaded ZIP file.

Alternatively, Git clone or simply copy the files into <kbd>wproot/wp-content/plugins/disqus-author-notify</kbd> and then go to the
Plugins page in WP and enable it.

## Credits

I'd like to thank Damien of [wpdailybits.com](http://wpdailybits.com) for giving me an idea of how to refine my approach to solving the problem and how to cut 10+ lines of code out of my original plugin by leveraging <kbd>wp_notify_postauthor</kbd> instead of re-creating the same functionality myself :)

### Contributers

- [hmemcpy](https://github.com/hmemcpy): Instructions for using .zip for installing into WP

## Disclaimer

This plugin is provided as-is without any warranty. In case you choose to use this plugin, you'll be doing so at your own risk. The plugin works flawlessly for me, but I won't guarantee that it'll work for you.

## License

This plugin is released under GPLv2 license just like [WordPress](http://wordpress.org/about/license).

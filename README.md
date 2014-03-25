# Disqus Author Notify for WordPress 

## In a nutshell

This [WordPress](http://wordpress.org/) plugin notifies post/page author of comments posted through the
[Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin just like the regular WordPress
comment notification functionality.

Tested in March 2014 on WP 3.8.1 and WP's [Disqus plugin](http://wordpress.org/plugins/disqus-comment-system/) version 2.74.

## Background

In WordPress settings you can define for WP to email the post/page author whenever a comment is posted on their content.
However, if you're using the [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/) plugin (at
least up to version 2.74), then you won't get these notifications. Instead, only comment moderators will be notified.

## Why not simply modify Disqus plugin code?

On [wpdailybits.com](http://wpdailybits.com) in a post dated Nov. 2010 [Damien](http://wpdailybits.com/blog/author/Damienoh)
writes on [How to Make Disqus Notify the Post Author When a New Comment Is Posted?](http://wpdailybits.com/blog/notify-post-author-for-new-comment-disqus/45)
Sure, this approach works BUT...

You SHOULD NOT modify the Disqus Comment System plugin code to accomplish author notification. Why? Because it'll break your
upgrade path! In other words, any time you update your Disqus plugin, you'll have to remember to re-apply your modification...

And what if you manage multiple WP sites. There's a pretty much a 95.37% chance you'll forget to re-apply
the change on at least one of those instances at least sometime...plus it's pretty annoying re-applying the change over and over again.

## A more elegant solution

Utilize WP's <kbd>wp_insert_comment</kbd> hook/action and the <kbd>wp_notify_postauthor</kbd> function as done in this plugin.
See below for instructions.

## Usage

Git clone or simply copy the files into <kbd>wproot/wp-content/plugins/disqus-author-notify</kbd> and then go to the
Plugins page in WP and enable it.

## Disclaimer

This plugin is provided as-is without any warranty. You will be using the plugin at your own responsibility/risk.

## License

This plugin is released under GPLv2 license just like [WordPress](http://wordpress.org/about/license).

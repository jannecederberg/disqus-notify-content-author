<?php
/**
 * Plugin Name: Disqus Notify Post/Page Author
 * Plugin URI: http://wordpress.org/plugins/disqus-notify-content-author/
 * Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
 * Version: 1.1.RC1
 * Author: Janne Cederberg
 * Author URI: http://opetus.tv
 * License: GPLv2
 */

defined('ABSPATH') or die("See no evil, hear no evil, speak no evil");

/**
 * Action for notifying author of comments/pingbacks
 *
 * The main action hook for notifying authors when new comments
 * or pingbacks are added to posts and pages.
 *
 * @author jcederberg
 */
function disqus_notify_content_author($comment_id, $comment_obj = null) {
	if ( _disqus_notify_content_author__is_not_spam($comment_obj) ) {
		wp_notify_postauthor($comment_id);
	}
}

/**
 * Check if a pingback is marked as spam (by for example Akismet)
 *
 * With pingbacks being sent to the site while also using Disqus,
 * the plugin is seemingly causing spam pingbacks caught by Akismet
 * to be sent out to the post author.
 *
 * @author jcederberg, kraftbj
 * @see https://wordpress.org/support/topic/check-spam-status
 */
function _disqus_notify_content_author__is_not_spam($comment_obj) {
	$comment_status = $comment_obj->comment_approved;
	return ( $comment_status != 'spam' );
}

add_action('wp_insert_comment', 'disqus_notify_content_author', 99, 2);

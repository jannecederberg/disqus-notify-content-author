<?php
/**
 * Plugin Name: Disqus Notify Post/Page Author
 * Plugin URI: http://wordpress.org/plugins/disqus-notify-content-author/
 * Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
 * Version: 1.0.1
 * Author: Janne Cederberg
 * Author URI: http://opetus.tv
 * License: GPLv2
 */

defined('ABSPATH') or die("See no evil, hear no evil, speak no evil");

function disqus_notify_content_author($comment_id, $comment = null) {
    wp_notify_postauthor($comment_id);
}

add_action('wp_insert_comment', 'disqus_notify_content_author');

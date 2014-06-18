<?php
/*
Plugin Name: Disqus Author Notify
Plugin URI: http://opetus.tv
Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
Version: 1.0
Author: Janne Cederberg
Author URI: http://opetus.tv

Copyright: Janne Cederberg
License: GPLv2
*/

function disqus_author_notify_by_email($comment_id, $comment = null) {
    wp_notify_postauthor($comment_id);
}

add_action('wp_insert_comment', 'disqus_author_notify_by_email');


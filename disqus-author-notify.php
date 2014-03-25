<?php
/*
Plugin Name: Disqus Author Notify
Plugin URI: http://opetus.tv
Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
Version: 1.0
Author: Janne Cederberg
Author URI: http://opetus.tv

Copyright: Janne Cederberg
License: GPLv2+
*/

add_action('wp_insert_comment', 'disqus_author_notify_by_email');

function disqus_author_notify_by_email($comment_id, $comment) {
    wp_notify_postauthor($comment_id);
/*    $oComment = get_comment($comment_id);
    $oPost = get_post($oComment->comment_post_ID);
    $postAuthorID = (int) $oPost->post_author;
    $oPostAuthor = get_user_by('id', $postAuthorID);
    wp_mail(
        // email to
        $oPostAuthor->user_email,
        // email title
        sprintf('Uusi kommentti sivulla "%s"', $oPost->post_title),
        // email content
        sprintf(
            "Moro!\nNimimerkki %s kirjoitti kommentin sivulle %s :\n\n%s",
            //$oPostAuthor->display_name,
            $oComment->comment_author,
            get_permalink($oPost->ID),
            $oComment->comment_content
        ),
        // headers
        sprintf('From: %s', get_bloginfo('admin_email'))
    );
 */
}

<?php
/*
Plugin Name: Comment Notify
Plugin URI: http://opetus.tv
Description: Notify post/page author of posted comments by emailing to WP profile email address.
Version: 1.0
Author: Janne Cederberg
Author URI: http://opetus.tv

Copyright: Janne Cederberg
License: GPLv2+
*/

add_action('wp_insert_comment', 'notify_author_by_email');

function notify_author_by_email($comment_id, $comment) {
    $oComment = get_comment($comment_id);
    $oPost = get_post($oComment->comment_post_ID);
    $postAuthorID = $oPost->post_author;
    $oPostAuthor = get_user_by('id', $postAuthorID);
    wp_mail(
        // email to
        $oPostAuthor->user_email,
        // email title
        'Uusi kommentti sivulla "' . $oPost->post_title . '"',
        // email content
        sprintf(
            "Moro!\nNimimerkki %s kirjoitti kommentin sivulle %s :\n\n%s",
            //$oPostAuthor->display_name,
            $oComment->comment_author,
            get_permalink($oPost->ID),
            $oComment->comment_content
        ),
        // headers
        'From: ' . get_bloginfo('admin_email')
    );
}

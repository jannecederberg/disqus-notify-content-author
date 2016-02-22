<?php
/**
 * Plugin Name: Disqus Notify Post/Page Author
 * Plugin URI: http://wordpress.org/plugins/disqus-notify-content-author/
 * Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
 * Version: 1.2.1
 * Author: Janne Cederberg
 * Author URI: http://jannecederberg.fi
 * License: GPLv2
 */

defined('ABSPATH') or die("See no evil, hear no evil, speak no evil");

/**
 * WordPress post types that comment notifications will trigger on
 *
 * @see https://codex.wordpress.org/Post_Types
 * @todo Make admin-configurable in WordPress UI
 */
$DISQUS_NOTIFY_ON_POST_TYPES = array('post', 'page');

/**
 * WordPress user meta key name to be used when storing notification opt-out info to DB
 */
define('USER_META_KEY_NAME', 'dnca_dont_notify');
define('DISQUS_MODERATE_URL', 'https://disqus.com/admin/moderate/#/approved/search/id:');


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
function _dnca__is_not_spam($comment_obj) {
	$comment_status = $comment_obj->comment_approved;
	return ( $comment_status != 'spam' );
}


/**
 * Write comment data dump to WordPress root for debugging
 */
function _dnca__comment_dump($id, $comment_obj) {
	ob_start();
	var_dump($comment_obj);
	$out = ob_get_flush();
	file_put_contents('comment_dump' .$id. '.txt', $out);
}

/**
 * Notify on comments only for selected post types
 *
 * @todo Make admin-configurable in WordPress UI
 */
function _dnca__notify_on_post_type($type) {
	global $DISQUS_NOTIFY_ON_POST_TYPES;
	return in_array($type, $DISQUS_NOTIFY_ON_POST_TYPES);
}


/**
 * Determine wheter or not the author wants to opt out of notifications
 */
function _dnca__author_opts_out($userID) {
	$value = get_the_author_meta(USER_META_KEY_NAME, $userID);
	return ($value === 'y');
}


/**
 *
 */
function _dnca__author_commented_on_own_post($post_author_id, $comment_obj) {
	$post_author_obj = get_userdata($post_author_id);
	if ( $post_author_obj === false ) {
		return false;
	}
	// Matches if author of the post comments on their own post AND
	// has the same email address defined in their WP profile settings
	// as they provided (via social login or otherwise) when commenting via Disqus.
	return ( $post_author_obj->user_email == $comment_obj->comment_author_email );
}


/**
 * Prints out the checked string needed for a checked HTML checkbox
 */
function _dnca__get_optout_checkbox_checked($userID) {
	$value = esc_attr( get_the_author_meta( USER_META_KEY_NAME, $userID ) );
	echo ($value == 'y') ? 'checked="checked"' : '';
}


/**
 *
 */
function dnca__filter_notification_text($notify_msg, $comment_id) {
	$comment_obj = get_comment($comment_id);
	$type = $comment_obj->comment_type;
	if ( $type == 'pingback' || $type == 'trackback' ) {
		// Don't alter pingback and trackback notifications
		return $notify_msg;
	}
	// $comment_obj->comment_agent is of the following format: Disqus/1.1(2.84):<disqus-comment-id>
	$disqus_details = explode(':', $comment_obj->comment_agent);
	if ( substr($disqus_details[0], 0, 6) != 'Disqus' ) {
		// If comment was not via Disqus, don't modify it
		return $notify_msg;
	}
	$disqus_id = $disqus_details[1];
	// Alter aspects of the core WordPress comment notification email text
	// defined in: https://core.trac.wordpress.org/browser/tags/4.3.1/src/wp-includes/pluggable.php#L1462
	$notify_msg = str_replace('#comments', '#disqus_thread', $notify_msg);
	$notify_msg = preg_replace('/#comment-[\d]+/', "#comment-$disqus_id", $notify_msg);
	$notify_lines = explode("\r\n", $notify_msg);
	foreach ($notify_lines as $key => $line) {
		if ( strpos($line, 'comment.php?action=') > -1 ) {
			unset($notify_lines[$key]);
		}
	}
	$notify_lines[] = 'Administer this comment: ' . DISQUS_MODERATE_URL . $disqus_id;
	$notify_msg = implode("\r\n", $notify_lines);
	return $notify_msg;
}


/**
 * Used as a hook to add notification opt-out field into user profile editing
 *
 * @todo Add textdomain for i18n
 */
function dnca__add_optout_field( $user ) {
?>
	<h3><?php _e('Disqus Notify Post/Page Author', 'dnca__main'); ?></h3>
	<table class="form-table">
	<tr>
		<th><?php _e('Don\'t notify me on comments', 'dnca__main'); ?></th>
		<td>
			<label for="<?php echo USER_META_KEY_NAME; ?>">
				<input type="checkbox" name="<?php echo USER_META_KEY_NAME; ?>" id="<?php echo USER_META_KEY_NAME; ?>" value="y" <?php _dnca__get_optout_checkbox_checked($user->ID); ?> />
				<?php _e('Do not notify me of comments to my posts/pages', 'dnca__main'); ?>
			</label>
			<p class="description"><?php _e('This is useful for example if you are a Disqus moderator relating to the same comments. Even without selecting this, you will not be notified of your own comments to your own posts, assuming you defined the same email address here and when commenting.', 'dnca__main'); ?></p>
		</td>
	</tr>
	</table>
<?php }


/**
 * @todo Finish creating an UI for admin to define which post types comment notifications are sent on
 */
function dnca__add_post_type_field() {
	/*
	<tr>
		<tr>
		<th>Post types on which comment notifications are sent</th>
		<td>
			<?php
				// Get non-core post types
				$types = get_post_types(array('public' => true), 'names');
				// Prepend core post types (excluding attachment, revision)
				foreach ($types as $value):
			?>
			<label for="dnca-post-type-<?php echo $value; ?>">
				<input type="checkbox" name="dnca-post-type-<?php echo $value; ?>" id="dnca-post-type-<?php echo $value; ?>" value="<?php echo $value; ?>" />
				<?php echo $value; ?>
			</label>
			<?php endforeach; ?>
		</td>
	</tr>
	*/
}


/**
 * Used to save notification opt-out field value on user details save
 */
function dnca__save_optout_field( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	// @todo: input validation for security!
	// WordPress will delete meta value if it's set to zero.
	// To avoid deleting and creating DB records, we'll use "y" (yes) and "n" (no)
	$value = (isset($_POST[USER_META_KEY_NAME]) && $_POST[USER_META_KEY_NAME] === 'y') ? 'y' : 'n';
	update_user_meta( $user_id, USER_META_KEY_NAME, $value);
}


/**
 * Action for notifying author of comments/pingbacks
 *
 * The main action hook for notifying authors when new comments
 * or pingbacks are added to posts and pages.
 *
 * @author jcederberg
 */
function dnca__main($comment_id, $comment_obj = null) {
	$post_id        = $comment_obj->comment_post_ID;
	$post_obj       = get_post($post_id);
	$post_author_id = $post_obj->post_author;

	// Following is only for debugging:
	//_dnca__comment_dump($comment_id, $comment_obj);

	$not_spam = _dnca__is_not_spam($comment_obj);
	$notify_on_type = _dnca__notify_on_post_type($post_obj->post_type);
	$opt_in = !_dnca__author_opts_out($post_author_id);
	$not_own_post = !_dnca__author_commented_on_own_post($post_author_id, $comment_obj);

	if ( $not_spam && $notify_on_type && $opt_in && $not_own_post ) {
		wp_notify_postauthor($comment_id);
	}
}

/**
 * Define hook functions
 */

// Comment insertion hook (main kickoff point of this plugin)
add_action( 'wp_insert_comment', 'dnca__main', 99, 2 );

// User profile UI and save hooks
add_action( 'show_user_profile', 'dnca__add_optout_field' );
add_action( 'edit_user_profile', 'dnca__add_optout_field' );
add_action( 'personal_options_update', 'dnca__save_optout_field' );
add_action( 'edit_user_profile_update', 'dnca__save_optout_field' );

// Alter comment notification email text
add_filter( 'comment_notification_text', 'dnca__filter_notification_text', 99, 2 );
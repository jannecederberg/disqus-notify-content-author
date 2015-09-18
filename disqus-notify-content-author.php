<?php
/**
 * Plugin Name: Disqus Notify Post/Page Author
 * Plugin URI: http://wordpress.org/plugins/disqus-notify-content-author/
 * Description: When using Disqus Comment System, notify post/page author of comments by email without hacking the Disqus plugin.
 * Version: 1.1
 * Author: Janne Cederberg
 * Author URI: http://opetus.tv
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
 * Prints out the checked string needed for a checked HTML checkbox
 */
function _dnca__get_optout_checkbox_checked($userID) {
	$value = esc_attr( get_the_author_meta( USER_META_KEY_NAME, $userID ) );
	echo ($value == 'y') ? 'checked="checked"' : '';
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
		<th><?php _e('Don\'t notify of comments', 'dnca__main'); ?></th>
		<td>
			<label for="<?php echo USER_META_KEY_NAME; ?>">
				<input type="checkbox" name="<?php echo USER_META_KEY_NAME; ?>" id="<?php echo USER_META_KEY_NAME; ?>" value="y" <?php _dnca__get_optout_checkbox_checked($user->ID); ?> />
				<?php _e('Do not notify me of comments to my posts/pages', 'dnca__main'); ?>
			</label>
		</td>
	</tr>
	</table>
<?php }


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
	update_usermeta( $user_id, USER_META_KEY_NAME, $value);
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

	if ( _dnca__is_not_spam($comment_obj) ) {
		if ( _dnca__notify_on_post_type($post_obj->post_type) && !_dnca__author_opts_out($post_author_id) ) {
			wp_notify_postauthor($comment_id);
		}
	}
}

/**
 * Define hook functions
 */
add_action('wp_insert_comment', 'dnca__main', 99, 2);
add_action( 'show_user_profile', 'dnca__add_optout_field' );
add_action( 'edit_user_profile', 'dnca__add_optout_field' );
add_action( 'personal_options_update', 'dnca__save_optout_field' );
add_action( 'edit_user_profile_update', 'dnca__save_optout_field' );

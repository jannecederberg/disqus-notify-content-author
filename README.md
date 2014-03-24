# WordPress Comment Notify

Notifies WordPress post/page author of comments posted. Works with standard WordPress comments as well as
when using [Disqus Comment System](http://wordpress.org/plugins/disqus-comment-system/).

Operation is based on registering a function for the action/hook <kbd>wp_insert_comment</kbd>. In the hook
function the <kbd>wp_mail</kbd> function is called.

Tested with WP 3.8.1 and WP's Disqus plugin version 2.7.4.

## Usage

Clone into <kbd>wproot/wp-content/plugins</kbd> and then go to the Plugins page in WP and enable it.

## Disclaimer

This plugin was written strictly to scratch my own itch at [Opetus.tv](http://opetus.tv) and hence currently has all strings as hard-coded strings and in Finnish. Maybe I'll develop the plugin further to include a translation file (.po).

Feel free to use/modify the plugin if you find it useful. You will use the plugin entirely at your own risk.

## License

This plugin is released under GPLv2 license just like [WordPress](http://wordpress.org/about/license).

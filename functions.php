<?php
/**
 * Starkers functions and definitions
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
	 * @package 	WordPress
	 * @subpackage 	Starkers
	 * @since 		Starkers 4.0
 */

/* ========================================================================================================================

Required external files

======================================================================================================================== */

require_once( 'external/starkers-utilities.php' );


/* ========================================================================================================================

Theme specific settings

Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme

======================================================================================================================== */

add_theme_support('post-thumbnails');

// register_nav_menus(array('primary' => 'Primary Navigation'));

/* ========================================================================================================================

Actions and Filters

======================================================================================================================== */

add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

/* ========================================================================================================================

Custom Post Types - include custom post types and taxonimies here
======================================================================================================================== */
require_once( 'custom-post-types/custom-post-types.php' );

require_once( 'external/clean-admin-ui.php' );

/* ========================================================================================================================

Scripts

======================================================================================================================== */






// Drop Function
function drop($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}


/**
 * Add scripts via wp_head()
 *
 * @return void
 * @author Keir Whitaker
 */

function starkers_script_enqueuer() {
	// wp_register_script('site', get_template_directory_uri().'/main.min.js', '', '', true);
	// wp_enqueue_script('site');

	// wp_register_style('screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen');
 //      wp_enqueue_style('screen');
}
function get_version() {
	include "version.php";
	return $version;
}
/* ========================================================================================================================

Comments

======================================================================================================================== */

/**
 * Custom callback for outputting comments
 *
 * @return void
 * @author Keir Whitaker
 */
function starkers_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<?php if ( $comment->comment_approved == '1' ): ?>
	<li>
		<article id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment ); ?>
			<h4><?php comment_author_link() ?></h4>
			<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
			<?php comment_text() ?>
		</article>
	<?php endif;
}


/* ========================================================================================================================

Email / Mandrill

======================================================================================================================== */

// add_filter('mandrill_payload', 'handle_mandrill_payload');

// function handle_mandrill_payload($message) {
// 	echo $message;
// }
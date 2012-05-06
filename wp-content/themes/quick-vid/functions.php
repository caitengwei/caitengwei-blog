<?php
//Define the wp_content DIR for backward compatibility
if (!defined('WP_CONTENT_URL'))
	define('WP_CONTENT_URL', get_option('site_url').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
	define('WP_CONTENT_DIR', ABSPATH.'/wp-content');

function quick_embed_defaults($embed_size){
	$embed_size['width'] = 528;

	return $embed_size;
}
add_filter('embed_defaults', 'quick_embed_defaults');

$max_width = 400;
$GLOBALS['content_width'] = 400;

register_sidebar( array( 'name' => 'Sidebar', 'before_widget' => '<div class="widget %2$s" id="%1$s">','after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>' ) );

function get_template_file($filename) {
	if (file_exists(TEMPLATEPATH."/$filename"))
		include(TEMPLATEPATH."/$filename");
}

function get_custom_field($field) {
	global $post;
	$custom_field = get_post_meta($post->ID, $field, true);
	echo $custom_field;
}

function image_attachment($field) {
	global $post;
	$custom_field = get_post_meta($post->ID, $field, true);
	
	if($custom_field)
		echo '<img src="'.$custom_field.'" alt="'.get_the_title().'"/>';
}

add_filter('wp_page_menu_args','it_page_menu_args');
function it_page_menu_args($args) {
	global $wp_theme_options;
	$include = $wp_theme_options['include_pages'];
	$show_home = (in_array('home',(array)$include)) ? 1 : 0;
	$include_pages = implode(',',(array)$include);
	$new_args = array(
		'show_home'		=> $show_home,
		'title_li'		=> '',
		'sort_column'	=> 'menu_order, post_title',
		'menu_class'	=> 'menu',
		'echo'			=> true,
		'include'		=> $include_pages
	);
	return array_merge( $args, $new_args );
}

add_filter('wp_page_menu','it_page_menu');
function it_page_menu($menu) {
	$menu = str_replace('<div class','<div id',$menu);
	return $menu;
}

include(TEMPLATEPATH."/lib/custom-header.php");

add_action( 'admin_menu', 'it_custom_header_add_menu', 20 );
function it_custom_header_add_menu() {
    add_submenu_page( $GLOBALS['wp_theme_page_name'], __('Custom Header'), __('Custom Header'), 'edit_themes', 'custom-header', array( &$GLOBALS['custom_image_header'], 'admin_page' ) );
}

//Add support for Automatic Feed Links
add_theme_support('automatic-feed-links');

//Theme Options code
include(TEMPLATEPATH."/lib/theme-options/theme-options.php");
$wp_theme_options = get_option('it-options');

add_action( 'ithemes_load_plugins', 'ithemes_functions_after_init' );
function ithemes_functions_after_init() {
	//Include Tutorials Page
	include(TEMPLATEPATH."/lib/tutorials/tutorials.php");
	//Contact Page Template code
	include(TEMPLATEPATH."/lib/contact-page-plugin/contact-page-plugin.php");
}

add_filter( 'it_featured_images_options', 'it_filter_featured_images_options' );
function it_filter_featured_images_options( $options ) {
	$options['width'] = 360;
	$options['height'] = 240;
	$options['variable_height'] = false;
	$options['force_disable_overlay'] = true;
	
	return $options;
}

//Tracking/Analytics Code
function it_print_tracking() {
	global $wp_theme_options;
	if (isset($wp_theme_options['tracking']))
		echo stripslashes($wp_theme_options['tracking']);
}
if ($wp_theme_options['tracking_pos'] == "header")
	add_action('wp_head', 'it_print_tracking');
else
	add_action('it_footer', 'it_print_tracking');

// register navigation menus if WordPress version supports it
add_action( 'init', 'ithemes_register_menu' );
function ithemes_register_menu() {
	if ( function_exists( 'register_nav_menu' ) ) {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Primary Menu' ) );
	}
}

if ( ! function_exists( 'wp_nav_menu' ) ) {
	function wp_nav_menu( $args ) {
		call_user_func( $args['fallback_cb'] );
	}
}

function ithemes_navigation() {
	wp_nav_menu( array('theme_location' => 'primary', 'container' => 'div', 'container_id' => 'menu', 'fallback_cb' => 'ithemes_render_menu'));
 }
function ithemes_render_menu() { 
	wp_page_menu();
}

if ( ! function_exists( 'quickvid_comment' ) ) :
	function quickvid_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'quickvid' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'quickvid' ); ?></em>
				<br />
			<?php endif; ?>
	
			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'quickvid' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'quickvid' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->
	
			<div class="comment-body"><?php comment_text(); ?></div>
	
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->
	
		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'quickvid' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'quickvid'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

?>

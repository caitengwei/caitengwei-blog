<?php
/**
 * Defines a list of filter hooks and the functions tied to those hooks
 *
 * @package Suffusion
 * @subpackage Functions
 */

/**
 * The alternative title of a page is used for display in the navigation bar, or for listing purposes in calls to wp_list_pages().
 *
 * @param $pages
 * @param array $args
 * @return array
 */
function suffusion_replace_page_with_alt_title($pages, $args = array()) {
	global $suffusion_meta_fields_by_id;

	foreach ($pages as $key => $page) {
		if (isset($suffusion_meta_fields_by_id[$page->ID]) && isset($suffusion_meta_fields_by_id[$page->ID]['suf_alt_page_title'])) {
			$alt_title = $suffusion_meta_fields_by_id[$page->ID]['suf_alt_page_title'];
			if (trim($alt_title) != '') {
				$page->post_title = $alt_title;
				$pages[$key] = $page;
			}
		}
	}
	return $pages;
}

function suffusion_set_more_link($more_link_text) {
	return "<span class='more-link fix'>".$more_link_text."</span>";
}

function suffusion_pages_link($content) {
	$args = array(
		'before' => '<div class="page-links"><strong>'.__('Pages:', 'suffusion').'</strong>',
		'after' => '</div>',
		'link_before' => '<span class="page-num">',
		'link_after' => '</span>',
		'next_or_number' => 'number',
		'echo' => 0
	);
	$content .= wp_link_pages($args);
	return $content;
}

function suffusion_hide_reply_link_for_pings($link, $custom_options = array(), $current_comment, $current_post) {
	global $suf_show_hide_reply_link_for_pings;
	if ($suf_show_hide_reply_link_for_pings != "allow") {
		if (($current_comment->comment_type != "") && ($current_comment->comment_type != "comment")) {
			$link = "";
		}
	}
	return $link;
}

function suffusion_filter_trk_ping_from_count($output) {
	global $post, $suf_show_track_ping;

	if (!is_admin()) {
		if ($suf_show_track_ping == "show" || $suf_show_track_ping == "separate") {
			return $output;
		}
		else {
			$all_comments = get_comments('status=approve&post_id=' . $post->ID);
			$comments_by_type = separate_comments($all_comments);
			$comments_number = count($comments_by_type['comment']);
			return $comments_number;
		}
	}
	else {
		return $output;
	}
}

function suffusion_get_comment_type_from_request() {
	global $post, $suffusion_comment_types;
	$comment_type = isset($_REQUEST['comment_type']) ? $_REQUEST['comment_type'] : 'comment';

	if ($comment_type == null || $comment_type == "" || !isset($suffusion_comment_types[$comment_type]) || $suffusion_comment_types[$comment_type] == null) {
		$all_comments = get_comments('status=approve&post_id=' . $post->ID);
		$comments_by_type = separate_comments($all_comments);

		if (count($comments_by_type['comment']) > 0) {
			$comment_type = 'comment';
		}
		else if (count($comments_by_type['trackback']) > 0){
			$comment_type = 'trackback';
		}
		else if (count($comments_by_type['pingback']) > 0){
			$comment_type = 'pingback';
		}
	}
	return $comment_type;
}

function suffusion_list_comments() {
	global $suf_show_track_ping;
	if ($suf_show_track_ping == "show") {
		$commentargs = array(
			"avatar_size" => 48,
			"callback" => "suffusion_comments_callback"
		);
	}
	else if ($suf_show_track_ping == "separate") {
		$comment_type = suffusion_get_comment_type_from_request();
		$commentargs = array(
			"avatar_size" => 48,
			"type" => "$comment_type",
			"callback" => "suffusion_comments_callback"
		);
	}
	else if ($suf_show_track_ping == "hide") {
		$commentargs = array(
			"avatar_size" => 48,
			"type" => "comment",
			"callback" => "suffusion_comments_callback"
		);
	}

	echo "<ol class=\"commentlist\">\n";
	wp_list_comments($commentargs);
	echo "</ol>\n";
}

function suffusion_split_comments() {
	global $post, $suf_show_track_ping, $suffusion_comment_types;

	if ($suf_show_track_ping != "separate") {
		return;
	}

	$all_comments = get_comments('status=approve&post_id=' . $post->ID);
	$comments_by_type = separate_comments($all_comments);

	echo "<div class=\"comment-response-types fix\">\n";
	foreach ($comments_by_type as $comment_type => $comment_type_list) {
		if ($comment_type == 'pings') {
			continue;
		}
		$type_number = count($comment_type_list);
		if ($type_number > 0) {
			$page_link = get_page_link($post->ID);
			$pretty_comment_type = (!isset($suffusion_comment_types[$comment_type]) || $suffusion_comment_types[$comment_type] == null) ? $suffusion_comment_types['comment'] : $suffusion_comment_types[$comment_type];
			$request_comment_type = suffusion_get_comment_type_from_request();
			if ($request_comment_type != $comment_type) {
				$page_link = add_query_arg("comment_type", $comment_type, $page_link);
				echo "<a href=\"$page_link#comments\" class=\"comment-response-types\">".$pretty_comment_type." ($type_number)</a> ";
			}
			else {
				echo "<span class=\"comment-response-types\">".$pretty_comment_type." ($type_number)</span> ";
			}
		}
	}
	echo "</div>\n";
}

function suffusion_append_comment_type($link) {
	global $suf_show_track_ping;

	if ($suf_show_track_ping != "separate") {
		return $link;
	}

	$comment_type = suffusion_get_comment_type_from_request();
	$link = add_query_arg("comment_type", $comment_type, $link);
	return $link;
}

function suffusion_comment_navigation() {
	get_template_part('custom/pagination', 'comments');
}

/**
 * Controls the default length of excerpts across the site.
 *
 * @param $length
 * @return int
 */
function suffusion_excerpt_length($length) {
	global $suf_excerpt_custom_length;
	if (suffusion_admin_check_integer($suf_excerpt_custom_length)) {
		return $suf_excerpt_custom_length;
	}
	else {
		return $length;
	}
}

/**
 * Function used to control the number of words to be returned in a category block excerpt
 * @param  $length
 * @return int
 */
function suffusion_excerpt_length_cat_block($length) {
	global $suf_mag_catblocks_excerpt_length, $suf_excerpt_custom_length;
	if (suffusion_admin_check_integer($suf_mag_catblocks_excerpt_length)) {
		return $suf_mag_catblocks_excerpt_length;
	}
	else if (suffusion_admin_check_integer($suf_excerpt_custom_length)) {
		return $suf_excerpt_custom_length;
	}
	else {
		return $length;
	}
}

function suffusion_excerpt_more_replace($more) {
	global $post, $suf_excerpt_read_more_style, $suf_excerpt_custom_more_text;
	if ($suf_excerpt_read_more_style == 'append') {
		return '';
	}

	$stripped = stripslashes($suf_excerpt_custom_more_text);
	$stripped = wp_specialchars_decode($stripped, ENT_QUOTES);
	return " <a href='".get_permalink($post->ID)."' class='excerpt-more'>".$stripped."</a>";
}

function suffusion_excerpt_more_append($output) {
	global $post, $suf_excerpt_read_more_style, $suf_excerpt_custom_more_text;
	if ($suf_excerpt_read_more_style == 'replace') {
		return $output;
	}
	$stripped = stripslashes($suf_excerpt_custom_more_text);
	$stripped = wp_specialchars_decode($stripped, ENT_QUOTES);
	return $output." <a href='".get_permalink($post->ID)."' class='excerpt-more-append'>".$stripped."</a>";
}

/**
 * Adds a few more classes to the post_class response:
 * 	- category id
 * 	- post sequence #
 * 	- post parity
 * 	- excerpt / full-content
 * 	- no-title if title is not shown
 *
 * @param $classes
 * @return array
 */
function suffusion_extra_post_classes($classes) {
	static $suffusion_post_sequence;

	$categories = get_the_category();
	if (is_array($categories)) {
		foreach ($categories as $category) {
			$classes[] = 'category-'.$category->cat_ID.'-id';
		}
	}

	if (!is_single()) {
		$suffusion_post_sequence++;
		$classes[] = 'post-seq-'.$suffusion_post_sequence;
		if ($suffusion_post_sequence%2 == 1) {
			$classes[] = 'post-parity-odd';
		}
		else {
			$classes[] = 'post-parity-even';
		}
	}
	else {
		$classes[] = 'full-content';
	}

	if ((is_single() && !is_page()) || !is_single()) {
		$title = get_the_title();
		$format = suffusion_get_post_format();
		$format = $format == 'standard' ? '' : $format.'_';
		$show_title = 'suf_post_'.$format.'show_title';
		global $$show_title;
		if (isset($$show_title)) {
			$show_title = $$show_title;
		}

		if ($title == '' || (isset($show_title) && $show_title == 'hide')) {
			$classes[] = 'no-title';
		}
	}
	return $classes;
}

function suffusion_get_post_title_and_link($text = '') {
	global $post;
	$title = get_the_title();
	$title = ($title == null || !$title) ? $text : $title;
	$ret = "<a href='".get_permalink($post->ID)."' class='entry-title' rel='bookmark' title='".esc_attr($title)."' >".$title."</a>";
	return apply_filters('suffusion_get_post_title_and_link', $ret);
}

function suffusion_unlink_page($link, $id) {
	global $suffusion_meta_fields_by_id;
	if (isset($suffusion_meta_fields_by_id[$id]) && isset($suffusion_meta_fields_by_id[$id]['suf_nav_unlinked'])) {
		$link_disabled = $suffusion_meta_fields_by_id[$id]['suf_nav_unlinked'];
		if ($link_disabled) {
			return "#";
		}
	}
	return $link;
}

function suffusion_js_for_unlinked_pages($listing) {
	if (trim($listing) != '') {
		$listing = str_replace(array("href='#'", 'href="#"'), "href='#' onclick='return false;'", $listing);
	}
	return $listing;
}

/**
 * Removes the "title" attribute from "a" tags. This is applied for the navigation bars only, so that the title doesn't show up when you hover over the elements.
 *
 * @param  $listing
 * @return mixed
 */
function suffusion_remove_a_title_attribute($listing) {
	global $suf_nav_strip_a_title;
	if (isset($suf_nav_strip_a_title) && $suf_nav_strip_a_title == 'hide') {
		if (trim($listing) != '') {
			$listing = preg_replace('/title=\"(.*?)\"/','',$listing);
		}
	}
	return $listing;
}

function suffusion_comments_callback($comment, $args, $depth) {
	global $suf_comment_display_type;
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;

	$comment_type = get_comment_type($comment->comment_ID);

	$cache = wp_cache_get('comment_template');

	if (!is_array($cache)) $cache = array();

	if ( !isset( $cache[$comment_type] ) ) {
		$template = locate_template(array("comment-{$suf_comment_display_type}-{$comment_type}.php", "comment-{$comment_type}.php", "comment-{$suf_comment_display_type}.php", 'comment.php'));

		$cache[$comment_type] = $template;
		wp_cache_set('comment_template', $cache);
	}

	require($cache[$comment_type]);
}

/**
 * Determines how an attachment is to be displayed in an attachment page - as a link or as an icon.
 *
 * @param  $type
 * @param  $mime
 * @return string
 */
function suffusion_filter_attachment_display($type, $mime) {
	$option_name = "suf_{$mime}_att_type";
	global $$option_name;
	if (isset($$option_name)) {
		return $$option_name;
	}
	return $type;
}

/**
 * Adds conditional comments around the rounded corners CSS inclusion. This is because conditional comments cannot be generated by wp_enqueue_style at present.
 * See http://core.trac.wordpress.org/ticket/16118
 *
 * @param  $css_html_tag
 * @param  $handle
 * @return string
 */
function suffusion_filter_rounded_corners_css($css_html_tag, $handle) {
	if ($handle == 'suffusion-rounded') {
		return "<!--[if !IE]>-->".$css_html_tag."<!--<![endif]-->\n<!--[if gt IE 8]>".$css_html_tag."<![endif]-->\n";
	}
	return $css_html_tag;
}

/**
 * Adds conditional comments around IE CSS inclusion. This is because conditional tags cannot be generated by wp_enqueue_style at present.
 * See http://core.trac.wordpress.org/ticket/16118
 *
 * @param  $css_html_tag
 * @param  $handle
 * @return string
 */
function suffusion_filter_ie_css($css_html_tag, $handle){
	if ($handle == 'suffusion-ie') {
		return "<!--[if lt IE 8]>".$css_html_tag."<![endif]-->\n";
	}
	return $css_html_tag;
}

/**
 * Returns the allowed HTML tags in a comment form. The tags can be printed below the comment form.
 *
 * @param $tags
 * @return string
 */
function suffusion_allowed_html_tags($tags) {
	global $suf_comment_show_html_tags;
	if ($suf_comment_show_html_tags == 'show') {
		return $tags;
	}
	else {
		return '';
	}
}

/**
 * Creates a chat format from content for a post with post format "chat". It assumes that each message in the chat is of the structure
 * "Author: Message". It then emphasizes the author and indents the message.
 *
 * @param $content
 * @return string
 */
function suffusion_chat_format($content) {
	$chatoutput = "<dl class=\"chat-transcript\">\n";
	$split = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $content);
	foreach($split as $haystack) {
		if (strpos($haystack, ":")) {
			$string = explode(":", trim($haystack), 2);
			$who = strip_tags(trim($string[0]));
			$what = strip_tags(trim($string[1]));
			$row_class = empty($row_class)? " class=\"chat-highlight\"" : "";
			$chatoutput = $chatoutput . "<dt$row_class><strong>$who:</strong></dt> <dd>$what</dd>\n";
		}
		else {
			// the string didn't contain a needle. Displaying anyway in case theres anything additional you want to add within the transcript
			$chatoutput = $chatoutput . $haystack . "\n";
		}
	}
	// print our new formated chat post
	$content = $chatoutput . "</dl>\n";
	return $content;
}

/**
 * Adds classes mm-tab to a tab that has a mega-menu beneath it, and dd-tab to one that has a drop-down.
 *
 * @param $classes
 * @param $item
 * @param $args
 * @return array
 * @since 4.0.0
 */
function suffusion_mm_nav_css($classes, $item, $args = array()) {
	$mega = suffusion_get_post_meta($item->ID, 'suf_mm_warea', true);
	if ($mega && $mega != '') {
		$classes[] = 'mm-tab';
	}
	else if (isset($item->menu_item_parent) && $item->menu_item_parent == 0) {
		$classes[] = 'dd-tab';
	}

	return $classes;
}

/**
 * Adds the appropriate post types to a taxonomy page. If the right post types are not added, WP considers the post type to be "post"
 * and returns no matches.
 *
 * @since 4.0.0
 */
function suffusion_custom_taxonomy_contents() {
	if (is_tax()) {
		$tax = get_queried_object();
		$taxonomy = get_taxonomy($tax->taxonomy);

		global $wp_query;
		$args = array_merge($wp_query->query, array('post_type' => $taxonomy->object_type));
		query_posts($args);
	}
}

/**
 * This function can be used to disable a component for any view by adding it to the "display" hook for that page. E.g. For a page if you
 * don't want the top navigation bar, you have to do this:
 *  <code>add_filter('suffusion_can_display_top_navigation', 'suffusion_disable_component_for_view');</code>
 * The above code can be added to the template for the page, before the get_header() call.
 *
 * @param $original
 * @return bool
 * @since 4.0.2
 */
function suffusion_disable_component_for_view($original) {
	return false;
}

/**
 * @param array $classes
 * @param $class
 * @return mixed
 */
function suffusion_get_width_classes($classes = array(), $class = '') {
	if (!is_array($classes)) {
		$classes = explode(' ', $classes);
	}

	if (in_array('page-template-1l-sidebar-php', $classes) || is_page_template('1l-sidebar.php')) {
		$var = '1l_';
	}
	else if (in_array('page-template-1r-sidebar-php', $classes) || is_page_template('1r-sidebar.php')) {
		$var = '1r_';
	}
	else if (in_array('page-template-1l1r-sidebar-php', $classes) || is_page_template('1l1r-sidebar.php')) {
		$var = '1l1r_';
	}
	else if (in_array('page-template-2l-sidebars-php', $classes) || is_page_template('2l-sidebars.php')) {
		$var = '2l_';
	}
	else if (in_array('page-template-2r-sidebars-php', $classes) || is_page_template('2r-sidebars.php')) {
		$var = '2r_';
	}
	else {
		$var = '';
	}
	$width_type = "suf_{$var}wrapper_width_type";
	$width_preset = "suf_{$var}wrapper_width_preset";
	global $$width_type, $$width_preset;

	if ($$width_type == 'fixed' && ($$width_preset != 'custom-components' || $$width_preset != 'custom')) {
		$classes[] = 'preset-'.$$width_preset.'px';
	}
	return $classes;
}
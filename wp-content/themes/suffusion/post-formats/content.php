<?php
/**
 * Default post format applied to all types of posts.
 *
 * @since 3.8.4
 * @package Suffusion
 * @subpackage Formats
 */
global $post, $suf_show_content_thumbnail;
if (has_post_thumbnail($post->ID) && $suf_show_content_thumbnail == 'show') {
	global $suf_excerpt_thumbnail_alignment, $suf_excerpt_thumbnail_size;
	//Could use suffusion_get_image(), but the theme uploader recommends use of the_post_thumbnail at least once in the theme...
	//echo suffusion_get_image(array('no-link' => true));
	if ($suf_excerpt_thumbnail_size == 'custom') {
		$thumbnail = get_the_post_thumbnail(null, 'excerpt-thumbnail');
	}
	else {
		$thumbnail = get_the_post_thumbnail(null, $suf_excerpt_thumbnail_size);
	}
	echo "<div class='$suf_excerpt_thumbnail_alignment-thumbnail'>" . $thumbnail . "</div>";
}
$continue = __('Continue reading &raquo;', 'suffusion');
the_content($continue);

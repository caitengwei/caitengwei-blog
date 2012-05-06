<?php ?>

<div id="head" class="article">
	<p><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>

<p class="screenreader"><a href="#inhalt">Jump to content</a></p>

<div id="navi-main">
	<h1 class="screenreader">Main navigation</h1>
	<ul>
		<?php wp_list_pages('depth=1&title_li='); ?>
	</ul>
</div>



<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<?php if (have_posts()) : ?>
	<h1 id="content" class="screenreader">Posts</h1>

	<?php while (have_posts()) : the_post(); ?>
	<?php include(TEMPLATEPATH."/custom_post.php"); ?>
	<?php endwhile; ?>
	<h1 class="screenreader">Paging</h1>
	<ul id="paging" style="margin: 0 auto;">
		<li id="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></li>
		<li id="older"><?php next_posts_link('&laquo; Older Entries') ?></li>
	</ul>

</div>

<?php else : ?>

	<h1>Not Found</h1>
	<div class="article">
		<p>Sorry, but you are looking for something that isn't here.</p>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
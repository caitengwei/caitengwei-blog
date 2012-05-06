<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="article">
		<h1><?php the_title() ?></h1>

		<?php the_content('Read the rest of this entry &raquo;'); ?>

		<p class="articlefooter">
			<?php if (comments_open()) : ?>
			<span class="kommentarfeed"><?php comments_rss_link('Comment feed'); ?></span>
			<?php endif; ?>
		</p>
	</div>

	<hr />
	
	<?php comments_template(); ?>
	
	<?php endwhile; ?>

</div>

<?php else : ?>

	<h1>Not Found</h1>
	<div class="article">
		<p>Sorry, but you are looking for something that isn't here.</p>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<?php if (have_posts()) : ?>
	<div class="article">
		<h1 id="content">Search results</h1>
	</div>
	<hr />

	<?php while (have_posts()) : the_post(); ?>

	<div class="article">
		<h2 class="searchhl">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php the_excerpt(); ?>
		<p class="articlefooter">
			<span class="posted"><?php the_time('M d, Y') ?> by <?php the_author_posts_link(); ?></span>
		</p>

	</div>
	
	<hr />

<?php endwhile; ?>

	<h1 class="screenreader">Paging</h1>
	<ul id="paging" style="margin: 0 auto;">
		<li id="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></li>
		<li id="older"><?php next_posts_link('&laquo; Older Entries') ?></li>
	</ul>

</div>

<?php else : ?>

	<div class="article">
		<h1 id="content">No results!</h1>
		<p>Sorry, but you are looking for something that isn't here.</p>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
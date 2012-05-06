<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="article">
		<h1><?php the_title() ?></h1>

		<div class="date">
			<div class="date_month"><?php the_time('M Y') ?></div>
			<div class="date_day"><?php the_time('d') ?></div>
			<?php edit_post_link(__('Edit This'),'<small>','</small>'); ?>
		</div>

		<?php the_content('Read the rest of this entry &raquo;'); ?>

		<p class="articlefooter">
			<span class="posted"><?php the_time('M d, Y') ?> by <?php the_author_posts_link(); ?></span>
		
			<span class="trackback">
				<a href="<?php trackback_url() ?>" rel="nofollow trackback"><?php _e('Trackback'); ?></a>
			</span>
		
			<?php the_tags('<br /><span class="tags">Tags: ', ', ', '</span>'); ?>
			<br />
			<span class="cats">Filed in: <?php the_category(', '); ?></span>
			<br />
			<span class="kommentarfeed"><?php comments_rss_link('Comment feed'); ?></span>
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
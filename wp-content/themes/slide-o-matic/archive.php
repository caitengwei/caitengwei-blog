<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<?php if (have_posts()) : ?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
	  <div class="article">
	
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 id="content">Posts filed in &#8216;<?php single_cat_title(); ?>&#8217;</h1>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 id="content">Posts tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 id="content">Archive for <?php the_time('F jS, Y'); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 id="content">Archive for <?php the_time('F, Y'); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 id="content">Archive for <?php the_time('Y'); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 id="content">Author Archive</h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 id="content">Blog Archives</h1>
 	  <?php } ?>
 	  
 	  </div><hr />

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
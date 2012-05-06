<?php get_header(); global $wp_theme_options; ?>
<!--archive.php-->

	<div id="container" class="clearfix">
		<div id="content">
<?php if (have_posts()) : // the loop ?>

			<h1 class="pagetitle"><?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
					<?php _e("Archive for"); ?> <?php echo single_cat_title(); ?>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
					<?php _e("Archive for"); ?> <?php the_time('F jS, Y'); ?>
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
					<?php _e("Archive for"); ?> <?php the_time('F, Y'); ?>
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
					<?php _e("Archive for"); ?> <?php the_time('Y'); ?>
				<?php /* If this is a search */ } elseif (is_search()) { ?>
					<?php _e("Search Results"); ?>
				<?php /* If this is an author archive */ } elseif (is_author()) { ?>
					<?php _e("Author Archive"); ?>
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
					<?php _e("Blog Archives"); ?>
				<?php } //do not delete ?>
			</h1>

<?php while (have_posts()) : the_post(); ?>

			<!--Post Wrapper Class-->
			<div <?php if (function_exists('post_class')) post_class(); ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<div class="meta-page">
					<span class="month"><?php the_time( 'M' ); ?></span>
					<span class="day"><?php the_time( 'j' ); ?></span>
				</div>
				<div class="entry">
					<?php the_content(); ?>
					<div class="meta-bottom clearfix clear-float">
						Filed Under: <?php the_category(', ') ?><?php edit_post_link('Edit This Post', ' ( ', ' )'); ?>
					</div>
				</div>
			</div>

<?php endwhile; ?>

			<!-- Previous/Next page navigation -->
			<div class="page-nav">
				<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Page')) ?></div>
				<div class="alignright"><?php next_posts_link(__('Next Page &raquo;')); ?></div>
			</div>

<?php else : ?>

			<h3><?php _e("Page Not Found"); ?></h3>
			<p><?php _e("We're sorry, but the page you are looking for isn't here."); ?></p>
			<p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>

<?php endif; ?>

		</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

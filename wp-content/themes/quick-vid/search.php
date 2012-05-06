<?php get_header(); global $wp_theme_options; ?>
<!--search.php-->

	<div id="container" class="clearfix">

		<div id="content">
    
<?php if (have_posts()) : // the loop ?>

			<h1 class="pagetitle"><?php if (is_search()) { _e('Search Results for "'); echo the_search_query().'"'; } ?></h1>

<?php while (have_posts()) : the_post(); // the loop ?>
    
			<!--Post Wrapper Class-->
			<div <?php if (function_exists('post_class')) post_class(); ?>>
	
				<!--post title as a link-->
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

				<!--post meta info-->
				<div class="meta">
					<?php the_author_posts_link(); ?> | <?php the_time(get_option('date_format')); ?> | <a href="<?php comments_link(); ?>"> <?php comments_number('0','1','%'); ?> <?php _e('Comments'); ?></a>
				</div>

				<div class="entry">
					<!--optional excerpt or automatic excerpt of the post-->
					<?php the_excerpt(); ?>
					<div class="meta-bottom clearfix">
						Filed Under: <?php the_category(', ') ?><?php edit_post_link('Edit This Post', ' ( ', ' )'); ?>
					</div>
				</div>
   
			</div><!--end .post div-->

<?php endwhile; //end one post ?>
    
			<!-- Previous/Next page navigation -->
			<div class="page-nav">
				<div class="alignleft"><?php previous_posts_link(__('&laquo; Previous Page')) ?></div>
				<div class="alignright"><?php next_posts_link(__('Next Page &raquo;')); ?></div>
			</div>

<?php else : //do not delete ?>

			<h3><?php _e("Page Not Found"); ?></h3>
			<p><?php _e("We're sorry, but the page you are looking for isn't here."); ?></p>
			<p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>

<?php endif; //do not delete ?>

		</div><!--end content div-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

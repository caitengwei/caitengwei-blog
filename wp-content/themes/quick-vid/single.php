<?php get_header(); global $wp_theme_options; ?>
<!--single.php-->

	<div id="container" class="clearfix">
		<div id="content">
		
			<?php if (have_posts()) : // the loop ?>
				<?php while (have_posts()) : the_post(); // the loop ?>
				
					<!--Post Wrapper Class-->
					<div style="margin-bottom:0;" <?php if (function_exists('post_class')) post_class(); ?>>
						<!--post title as a link-->
						<h1 class="single-pagetitle" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
						<div class="meta-page">
							<span class="month"><?php the_time( 'M' ); ?></span>
							<span class="day"><?php the_time( 'j' ); ?></span>
						</div>
						<div class="author-meta">
							<span class="author">Posted by <?php echo the_author_posts_link(); ?></span>
						</div>
						<div class="entry">
							<!--post text-->
							<?php the_content(); ?>
							<div class="clear-float"></div>
							<!--for paginate posts-->
							<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
							<div class="meta-bottom clearfix clear-float">
								Filed Under: <?php the_category(', ') ?><?php edit_post_link('Edit This Post', ' ( ', ' )'); ?><br />
								<?php the_tags('Tagged With: ',' , ',''); ?>
							</div>
						</div>
					</div><!--end .post div-->
					
					<?php comments_template(); // include comments template ?>
					
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

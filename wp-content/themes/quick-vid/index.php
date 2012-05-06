<?php
get_header();

global $wp_theme_options; ?>

	<div id="container" class="clearfix">
		<div id="content">
			<?php
				$numposts = get_option('posts_per_page');
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts('showposts='.$numposts.'&paged=' . $paged);
			?>
			<?php while (have_posts()) : the_post(); ?>
				<!--Post Wrapper Class-->
				<div <?php if (function_exists('post_class')) post_class(); ?>>
					<div class="meta">
						<span class="month"><?php the_time( 'M' ); ?></span>
						<span class="day"><?php the_time( 'j' ); ?></span>
					</div>
					<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry">
						<!--post excerpt-->
						<?php the_content(); ?>
						<div class="meta-bottom clearfix clear-float">
							<a href="<?php comments_link(); ?>"> <?php comments_number('0','1','%')    ; ?> <?php _e('Comments'); ?></a>
							<?php edit_post_link('Edit This Post', ' ( ', ' )'); ?>
						</div>
					</div>
					<!--for paginate posts-->
					<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				</div><!--end .post div-->
			<?php endwhile; //end one post ?>
			<!-- Previous/Next page navigation -->
			<div class="page-nav">
				<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer Posts')) ?></div>
				<div class="alignright"><?php next_posts_link(__('Older Posts &raquo;')); ?></div>
			</div>
		</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

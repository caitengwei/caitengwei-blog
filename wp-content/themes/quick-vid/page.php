<?php get_header();

global $wp_theme_options; ?>

<!--page.php-->

	<div id="container" class="clearfix">
		<div id="content">
		
			<?php if (have_posts()) : while (have_posts()) : the_post(); // the loop ?>
			
				<h1 class="pagetitle" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
				<div class="entry">
					<!--post text with the read more link-->
					<?php the_content(); ?>
					<div class="clear-float"></div>
					<?php edit_post_link('(Edit this page)', '<br />', ''); ?>
					<!--for paginate posts-->
					<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				</div>
				<?php if ($post->comment_status == 'open') { ?>
					<?php comments_template( '', true ); ?>
				<?php } ?>
				
			<?php endwhile; ?>
			<?php else : ?>
			
				<h3><?php _e("Page not Found"); ?></h3>
				<p><?php _e("We're sorry, but the page you're looking for isn't here."); ?></p>
				<p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>
				
			<?php endif; // do not delete ?>
			
		</div><!--end content div-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
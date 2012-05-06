<?php get_header(); ?>

<?php get_sidebar(); ?>
    
    <div id="content" class="two-column float-left">
    
		<?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
        
        <div class="post">
        
        <h1><?php the_title(); ?></h1>
        <?php edit_post_link('Edit', '<p>', '</p>'); ?>        
        
        <?php the_content(); ?>
        
        </div><!--/.post-->
        
        <?php endwhile; ?>
        <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        
    </div><!--/content -->

<?php get_footer(); ?>
<?php get_header(); ?>

<?php get_sidebar(); ?>
    
    <div id="content float-right two-column">
    
		<?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
        
        <div class="post">
        
        <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Read more...</a>
        
        <?php endwhile; ?>
        <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        
        <div class="content-bot">

        <?php next_posts_link('&laquo; previous') ?>
        <a href="<?php bloginfo('url'); ?>">home</a> 
        <a href="#">top</a>
        <?php previous_posts_link('next &raquo;') ?></p>
        
        </div>
    
    </div><!--/content -->

<?php get_footer(); ?>
<?php
/*
	Template Name: Full Width
*/
?>

<?php get_header(); ?>
  
    <div id="content" class="float-left three-column">
    
		<?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
        
        <div class="post">
        
        <h1><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
        <p class="premeta">Posted by <?php the_author(); ?> on <?php the_date(); ?> under <?php the_category(', '); ?> | <img src="<?php bloginfo('template_directory'); ?>/images/icon-comment.gif" alt="" /><?php comments_popup_link('Be the First to Comment', 'Read the First Comment', '% Comments to Read', 'comments-link', 'Comments are off for this article'); ?> <?php edit_post_link('Edit', ' | ', ''); ?></p>        
        
        <?php the_content('<strong>Read more of this article &raquo;</strong>'); ?>
        
        
        <?php if ( function_exists('the_tags')) the_tags('<div class="postmeta"><p>Tags: <span>', ', ', ' </span></p></div>'); ?>
        
        
        </div><!--/.post-->
        
        <?php endwhile; ?>
        <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
        
        <div class="content-bot">

        <?php next_posts_link('&laquo; previous') ?>
        <a href="<?php bloginfo('url'); ?>">home</a> 
        <a href="#">top</a>
        <?php previous_posts_link('next &raquo;') ?></p>
        
        </div><!--/.contet-bot-->
    
    </div><!--/content -->

<?php get_footer(); ?>
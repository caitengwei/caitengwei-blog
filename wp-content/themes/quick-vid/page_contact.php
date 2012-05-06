<?php
/*
Template Name: Contact Page
*/
?>
<?php get_header(); global $wp_theme_options; ?>
<!--page_contact.php-->

	<div id="container" class="clearfix">
		<div id="content">
		
			<?php if (have_posts()) : // the loop ?>
				<?php while (have_posts()) : the_post(); // the loop ?>
				
					<h1 class="pagetitle" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
					<div class="entry">
						<!--post text with the read more link-->
						<?php the_content(); ?>
						<div class="clear-float"></div>
						<!--the contact form code-->
						<?php if ( ! empty( $GLOBALS['ithemes_contact_page'] ) ) : ?>
							<?php $GLOBALS['ithemes_contact_page']->render(); ?>
						<?php endif; ?>
					</div>
					
				<?php endwhile; //end post ?>
			<?php else : //do not delete ?>
			
				<h3><?php _e("Page Not Found"); ?></h3>
				<p><?php _e("We're sorry, but the page you are looking for isn't here."); ?></p>
				<p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>
			
			<?php endif; //do not delete ?>
			
		</div><!--end content div-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

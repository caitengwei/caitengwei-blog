<?php get_header(); global $wp_theme_options; ?>
<!--404.php-->

	<div id="container" class="clearfix">

		<div id="content">
			<div class="entry">
				<h1 class="pagetitle"><?php _e("Page Not Found"); ?></h1>
				<p><?php _e("We're sorry, but the page you are looking for isn't here."); ?></p>
				<p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar") ?></p>
			</div>
		</div><!--end content div-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
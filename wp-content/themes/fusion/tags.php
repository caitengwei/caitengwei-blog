<?php /*
Template Name: Tag Cloud
*/ ?>

<?php get_header(); ?>

  <!-- mid content -->
<div id="mid-content">
	<?php if ( function_exists('wp_tag_cloud') ) : ?>
	<div style="margin:5em auto auto auto;border:1px solid #111;padding:15px;">
		<ul  style="margin:0 0 0 1em;padding:0;line-height:250%;">
			<?php wp_tag_cloud('smallest=11&largest=30&number=0'); ?>
		</ul>
	</div>
	<?php endif; ?>
	</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

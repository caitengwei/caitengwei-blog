<?php ?>

<div class="article">
	<h2>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to 
		<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h2>

	<div class="date">
		<div class="date_month"><?php the_time('M Y') ?></div>
		<div class="date_day"><?php the_time('d') ?></div>
		<?php edit_post_link(__('Edit This'),'<small>','</small>'); ?>
	</div>

	<?php the_content('Read the rest of this entry &raquo;'); ?>
	
	<p class="articlefooter">
		<span class="posted"><?php the_time('M d, Y') ?> by <?php the_author_posts_link(); ?></span>
		
		<?php if (comments_open() || $comments ) { ?>
		<span class="kommentar"><?php comments_popup_link('No Comments', '1 Comment', 'Comments (%)'); ?></span>
		<?php } ?>
		
		<?php if (is_single()) { ?>
			<?php the_tags('<br /><span class="tags">Tags: ', ', ', '</span>'); ?>
			<br /><span class="cats">Filed in: <?php the_category(', '); ?></span>
		<?php } ?>
		
	</p>
</div>

<hr />
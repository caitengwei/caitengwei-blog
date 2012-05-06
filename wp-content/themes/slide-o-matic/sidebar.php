<h1 class="screenreader">Additional information</h1>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<div class="blogtoy">
	<h2 class="widgetheader">About <?php bloginfo('name'); ?></h2>
	<div class="innerwidget">
		<p><?php bloginfo('description'); ?></p>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<div class="blogtoy">
	<h2 class="widgetheader">Subscribe to this</h2>
	<div class="innerwidget">
		<ul class="feeds">
			<li class="rss">
				<a href="feed:<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
			</li>
			<li class="rss">
				<a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
			</li>	
		</ul>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<div class="blogtoy">
	<h2 class="widgetheader"><?php _e('Categories'); ?></h2>
	<div class="innerwidget">
		<ul>
			<?php wp_list_cats(); ?>
		</ul>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<div class="blogtoy">
	<h2 class="widgetheader"><?php _e('Archives'); ?></h2>
	<div class="innerwidget">
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<?php if (function_exists('wp_tag_cloud')) { ?>
<div class="blogtoy">
	<h2 class="widgetheader">Tags</h2>
	<div class="innerwidget">
		<?php wp_tag_cloud('smallest=0.8&largest=2.5&unit=em'); ?>
	</div>
</div>
<?php } ?>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<div class="blogtoy">
	<?php wp_list_bookmarks('title_before=<h2 class="widgetheader">&title_after=</h2><div class="innerwidget">&between=: &show_description=1&category_before=&category_after=&category_name=&categorize=0'); ?>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<?php if ( is_home()) { ?>
<div class="blogtoy">
	<h2 class="widgetheader">Log</h2>
	<div class="innerwidget">
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>
</div>
<?php } ?>

<!-- ++++++++++++++++++++++++++++++++++++++ -->

<?php endif; ?>
<hr id="endfirst" class="bottomspace" />
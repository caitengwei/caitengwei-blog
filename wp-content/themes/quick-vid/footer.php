<?php global $wp_theme_options; ?>

		</div><!--end container div-->

	</div><!--end wrap div-->

	<div id="footer" class="clearfix">
		<p>&copy; <?php _e("Copyright"); ?> <?php bloginfo('name'); ?> <?php print date('Y'); ?>. <?php _e("All Rights Reserved"); ?><br />
		<a href="http://ithemes.com/quick-vid" title="<?php _e("Quick-Vid"); ?>"><?php _e("Quick-Vid"); ?></a> <?php _e("by"); ?> <a href="http://ithemes.com" title="<?php _e("Premium WordPress Themes"); ?>">iThemes</a></p>

	</div><!--end footer div-->

</div><!--end outer-wrap div-->

<?php wp_footer(); ?>

<?php do_action('it_footer'); ?>

</body>

</html>
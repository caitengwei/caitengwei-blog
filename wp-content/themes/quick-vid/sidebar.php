<?php global $wp_theme_options; ?>
<!--sidebar.php-->

	<div class="sidebar">
		<div class="widget-wrap">
			<?php if ( !dynamic_sidebar('Sidebar')) : ?>
				<div class="widget">
					<h4><?php _e("Widget Section"); ?></h4>
					<p>This area is a featured section where you can write about your website. Here you can highlight what's new or other things which are important to your site visitors. <a href="#">Continued &raquo;</a></p>
				</div>
			<?php endif; ?>
		</div>
	</div><!--end .sidebar div-->

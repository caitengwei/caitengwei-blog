</div><!--/wrapper-->

</div><!--/container-->

<div id="footer-wrapper">

<div id="footer">

	<div class="one-column float-left">
    
    	<?php if ( !function_exists('dynamic_sidebar')
       	 || !dynamic_sidebar(4) ) : ?>
		
		<?php endif; ?>
        
        <h2>Site Information</h2>
        
        <p>&copy; <?php echo (date('Y')); ?> <?php bloginfo('name'); ?><br />
        <a href="http://www.egracecreative.com/2008/09/26/ministry-free-wordpress-theme/">Ministry Free Theme</a><br />
        by <a href="http://www.egracecreative.com">eGrace Creative</a>.</p>
        
    </div>

	<div class="one-column float-left">
    
    	<?php if ( !function_exists('dynamic_sidebar')
       	 || !dynamic_sidebar(2) ) : ?>
    
    	<h2>Pages</h2>
        <ul>
        	<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
            <?php wp_list_pages('title_li=0&depth=1'); ?>
        </ul>
        
        <?php endif; ?>
        
    </div>
    
    <div class="one-column float-left">
    
    	<?php if ( !function_exists('dynamic_sidebar')
       	 || !dynamic_sidebar(3) ) : ?>
        
    	<h2>Blogroll</h2>
        <ul>
        	<?php wp_list_bookmarks('title_li=&category_before=&category_after='); ?>
        </ul>
		
		<?php endif; ?>
    </div>    	

</div><!--/footer-->

</div><!--/footer-wrapper-->

<?php wp_footer(); ?>
</body>
</html>

<?php



function widget_slide_search() {
?>
<div class="blogtoy %2$s">
  <h2 class="widgetheader"><?php echo __('Search'); ?></h2>
  <div class="innerwidget">
    <form method="get" action="<?php bloginfo('url'); ?>/">
    	<fieldset>
    		<label for="widgetsearch" class="screenreader">Search: </label>
    		<input id="widgetsearch" name="s" value="<?php the_search_query(); ?>" onblur="if (this.value == '') {this.value = '<?php the_search_query(); ?>';}" onfocus="if (this.value == '<?php the_search_query(); ?>') {this.value = '';}"  />
    		<input type="submit" id="widgetsearchsubmit" value=">" />
    	</fieldset>
    </form>
  </div>
</div>
    
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_slide_search');


  if (function_exists('register_sidebars')) {
  	register_sidebars(2, array(
  		'before_widget' => '<div class="blogtoy %2$s">',
  		'after_widget' => '</div></div>',
  		'before_title' => '<h2 class="widgetheader">',
  		'after_title' => '</h2><div class="innerwidget">'
  	));
  }

?>
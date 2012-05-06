<?php
/*
	Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content float-right two-column">
    
    <div class="post">
    	
        <h1>Browse the Archives</h1>
        
        <p>By Category:</p>
    	<ul>
    		<?php wp_list_categories('title_li='); ?>
    	</ul>
        
        <p>By Date:</p>
    	<ul>
    		<?php wp_get_archives('type=monthly'); ?>
    	</ul>
    	
    </div>
    
</div><!--/content-->
	
<?php get_footer(); ?>
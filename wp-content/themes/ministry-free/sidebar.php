    <div id="sidebar" class="float-left one-column">
    
    	<?php if ( !function_exists('dynamic_sidebar')
       	 || !dynamic_sidebar(1) ) : ?>
         
        <div class="widget">
            <h2>Articles by Category</h2>
            <ul class="highlight">
            	<?php wp_list_categories('title_li=&hierarchical=false'); ?>
            </ul>
        </div>
        
        <div class="widget">
            <h2>Recent Posts</h2>
            <ul>
            	<?php
 					$postslist = get_posts('numberposts=10');
 					foreach ($postslist as $post) : 
    				setup_postdata($post);
 				?> 
 				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endforeach; ?>
           	</ul>
        </div>
         
        <?php endif; ?>
    
    </div><!--/sidebar-->
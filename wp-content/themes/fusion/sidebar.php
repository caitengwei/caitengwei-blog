<!-- Function get_recent_comments() -->
<?php
function get_recent_comments($no_comments = 10, $before = '<li> ', $after = '</li>') {

	global $wpdb, $tablecomments, $tableposts;
	$request = "SELECT ID, post_title, comment_ID, comment_content, comment_author, comment_author_url FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND (post_status = 'publish' OR post_status = 'static')";
	
	$request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
	$comments = $wpdb->get_results($request);
	$output = '';
	foreach ($comments as $comment) {
		$post_title = stripslashes($comment->post_title);
		$comment_author = stripslashes($comment->comment_author);
		$comment_content = strip_tags($comment->comment_content);
		$comment_author_url = $comment->comment_author_url;
		$comment_content = stripslashes($comment_content);
		$comment_excerpt =cutstr($comment_content,20);
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$output .= $before . '<a href="' . $permalink . '" title="[' . $comment_author . '] - ' . $post_title . '">' . $comment_excerpt . '</a>' . $after;
	}
	echo $output;
}

function cutstr($string, $length) {
	
	if(strlen($string) <= $length) {
		return $string;
	}
	
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	
	$n = $tn = $noc = 0;
	while($n < strlen($string)) {
	
		$t = ord($string[$n]);
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1; $n++; $noc++;
		} elseif(194 <= $t && $t <= 223) {
			$tn = 2; $n += 2; $noc += 2;
		} elseif(224 <= $t && $t < 239) {
			$tn = 3; $n += 3; $noc += 2;
		} elseif(240 <= $t && $t <= 247) {
			$tn = 4; $n += 4; $noc += 2;
		} elseif(248 <= $t && $t <= 251) {
			$tn = 5; $n += 5; $noc += 2;
		} elseif($t == 252 || $t == 253) {
			$tn = 6; $n += 6; $noc += 2;
		} else {
			$n++;
		}
	
		if($noc >= $length) {
			break;
		}
	}
	if($noc > $length) {
		$n -= $tn;
	}
	$strcut = substr($string, 0, $n);
	$strcut = str_replace(array('&', '"', '< ', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	$strcut .= '...';
	
	return $strcut;
}
?>
<!-- Function get_recent_comments() End -->

<?php /* Fusion/digitalnature */

if(!is_page_template('page-nosidebar.php')):
 if((is_page_template('page-3col.php') || (get_option('fusion_3col')=='yes')) && (!is_page_template('page-2col.php'))): include(TEMPLATEPATH . '/sidebar2.php'); endif; ?>

<!-- sidebar -->
<div id="sidebar">
 <!-- sidebar 1st container -->
 <div id="sidebar-wrap1">
  <!-- sidebar 2nd container -->
  <div id="sidebar-wrap2">
     <ul id="sidelist">
     	<?php if ( is_404() || is_category() || is_day() || is_month() || is_year() || is_search() || is_paged() ) { ?>
        <li class="infotext">
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
            <p><?php printf(__('You are currently browsing the archives for the %s category.', 'fusion'), single_cat_title('',false)); ?></p>

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
            <p><?php printf(__('You are currently browsing the archives for %s','fusion'), get_the_time(__('l, F jS, Y','fusion'))); ?></p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
            <p><?php printf(__('You are currently browsing the archives for %s','fusion'), get_the_time(__('F, Y','fusion'))); ?></p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
            <p><?php printf(__('You are currently browsing the archives for the year %s','fusion'), get_the_time(__('Y','fusion'))); ?></p>

			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
            <p class="error"><?php printf(__('You have searched the archives for %s.','fusion'), '<strong>'.get_search_query().'</strong>'); ?></p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			  <p><?php _e('You are currently browsing the archives.','fusion'); ?></p>
			<?php } ?>
	 	</li>
        <?php }?>

        <?php 	/* Widgetized sidebar, if you have the plugin installed. */
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

        <!-- wp search form -->
        <li>
         <div class="widget">
          <div id="searchtab">
            <div class="inside">
              <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                <fieldset>
                <input type="text" name="s" id="searchbox" class="searchfield" value="<?php _e("Search","fusion"); ?>" onfocus="if(this.value == '<?php _e("Search","fusion"); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e("Search","fusion"); ?>';}" />
                 <input type="submit" value="Go" class="searchbutton" />
                </fieldset>
              </form>
            </div>
          </div>
         </div>
        </li>
        <!-- /wp search form -->

        <li>
         <div class="widget">
          <!-- sidebar menu (categories) -->
          <ul class="nav">
            <?php if(get_option('fusion_jquery')=='no')
              echo preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a>@i', '<li$1><a$2><span>$3</span></a>', wp_list_categories('show_count=0&echo=0&title_li='));
             else
              echo preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a> \(\<a ([^>]*)([^>]*)>XML\<\/a>\) \((.*?)\)@i', '<li $1><a$2><span>$3 <em>($6)</em></span></a><a class="rss tip" $4></a>', wp_list_categories('show_count=1&echo=0&title_li=&feed=XML'));  ?>

            <?php if (function_exists('xili_language_list')) { xili_language_list(); } ?>

          </ul>
          <!-- /sidebar menu -->
          </div>
        </li>

			<li class="box-wrap" id="box-subscribe">
				<div class="box">
					<h2 class="title"><?php _e('SUBSCRIBE','fusion'); ?></h2>
					<div class="inside">
						<ul>
							<? if (function_exists('chicklet_creator')) { chicklet_creator(); } ?> 
						</ul>
					</div>
				</div>
			</li>

			<li class="box-wrap" id="box-subscribe">
				<div class="box">
					<h2 class="title"><?php _e('Weibo','fusion'); ?></h2>
					<div class="inside">
                        <ul class="weibo">
                            <iframe width="95%" height="550" class="share_self" frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=1&ptype=1&speed=0&skin=5&isTitle=0&noborder=0&isWeibo=1&isFans=1&uid=1865850807&verifier=6d797160&dpc=1"></iframe>
                        </ul>
                        <!--
                         <ul class="weibo">
						 <? if (function_exists('wm_tweet')) { wm_tweet(); } ?> </ul>
                        <div class="mwrapper" id="mwrapper-wm_show-2">
                            <a class="scroll up" href="javascript:;"><img src="http://caitengwei.com/blog/wp-content/plugins/wp-microblogs/images/transparent.gif" /></a>
                            <div class="mcontainer">
                                <ul class="microblogs">
                                    <?php $args = array( 'count' => 2, 'list_wrapper' => '<li class="tweet">%s</li>',); ?>
                                    <?php if (function_exists('wm_tweets')) { wm_tweets($args); } ?>
                                </ul>
                            </div>
                        </div>
                        -->
					</div>
				</div>
			</li>

			<li class="box-wrap" id="box-recent_posts">
				<div class="box">
					<h2 class="title"><?php _e('Recent Posts','fusion'); ?></h2>
					<div class="inside">
                        <ul>
                            <?php wp_get_archives('title_li=&type=postbypost&limit=10'); ?>
                        </ul>
					</div>
				</div>
			</li>

        <?php /*
			<li class="box-wrap" id="box-recent_comments">
				<div class="box">
					<h2 class="title"><?php _e('Recent Comments','fusion'); ?></h2>
					<div class="inside">
						<ul>
        		<?php get_recent_comments(); ?>
						</ul>
					</div>
				</div>
			</li>
         */ ?>

        <li>
         <div class="widget">
          <ul>
           <?php wp_list_bookmarks('title_before=<h2 class="title">&title_after=</h2>'); ?>
          </ul>
         </div>
        </li>

        <li class="box-wrap" id="box-archives">
          <div class="box">
           <h2 class="title"><?php _e('Archives','fusion'); ?></h2>
           <div class="inside">
            <ul>
             <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
            </ul>
           </div>
          </div>
        </li>
        
        <li class="box-wrap" id="box-meta">
          <div class="box">
           <h2 class="title"><?php _e('Meta','fusion'); ?></h2>
           <div class="inside">
            <ul>
             <?php wp_register(); ?>
             <li><?php wp_loginout(); ?></li>
             <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
             <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
             <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
             <?php wp_meta(); ?>
            </ul>
           </div>
          </div>
        </li>
        <?php endif; ?>
     </ul>
  </div>
  <!-- /sidebar 2nd container -->
 </div>
 <!-- /sidebar 1st container -->
</div>
<!-- /sidebar -->

<?php endif;  ?>

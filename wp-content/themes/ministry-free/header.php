<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title>
		<?php if ( is_home() ) { ?><?php bloginfo('name'); ?> &raquo; <?php bloginfo('description'); ?><?php } ?>
		<?php if ( is_search() ) { ?>Search Results &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_author() ) { global $wp_query; $curauth = $wp_query->get_queried_object(); ?>Author Archives &raquo; <?php echo $curauth->nickname; ?> &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_single() ) { ?><?php wp_title(''); ?> &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_page() ) { ?><?php wp_title(''); ?> &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_category() ) { ?><?php single_cat_title(); ?> &raquo; Archive &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_year() ) { ?><?php the_time('Y'); ?> &raquo; Archive &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_month() ) { ?><?php the_time('F Y'); ?> &raquo; Archive &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if ( is_day() ) { ?><?php the_time('d F Y'); ?> &raquo; Archive &raquo; <?php bloginfo('name'); ?><?php } ?>
		<?php if (function_exists('is_tag')) { if (is_tag()) { ?><?php single_tag_title("", true); ?> &raquo; Tag Archive &raquo; <?php bloginfo('name'); ?><?php } } ?>
	</title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description') ?>" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1); ?> Comments RSS feed" />
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>
	
</head>

<body>
<div id="container">

<div id="search-subscribe">
	
    <div class="subscribe">    
    <a href="<?php bloginfo('rss2_url'); ?>">SUBSCRIBE <img src="<?php bloginfo('template_directory'); ?>/images/rss.gif" alt="Subscribe to our RSS Feed" /></a>
    </div>
	
    <div class="search">
	<?php $search_text = "search our site"; ?>
    <form method="get" id="searchform" action="<?php bloginfo('home'); ?>/" style="float: left; display: inline; margin: 0px; padding: 0px;">
    <input type="text" style="width: 220px; color: #222; border: 1px #aaa solid; background: #fff; margin: 0px 15px 0px 0px; padding: 2px;" value="search our site" name="s" id="s" class="searchbox" onblur="if (this.value == '') {this.value = 'search our site';}" onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" /> 
    <input type="hidden" id="searchsubmit" /> 
    </form>
    </div> 
    
</div>

<div id="header">

	<div id="logo">
    
    	<p class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></p>
        <p class="description"><?php bloginfo('description'); ?></p>
    
    </div>
    
    <div id="nav">
    
    	<ul>
        	<li><a href="<?php bloginfo('url'); ?>">home</a></li>
        	<?php wp_list_pages('depth=1&title_li='); ?>
        </ul>
    
    </div>

</div><!--/header-->

<div id="wrapper">
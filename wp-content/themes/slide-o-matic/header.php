<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
	<script type="text/javascript">
	<!--
	document.write('<style type="text/css">.innerwidget{display:none;}</style>');
	-->
	</script>

    <link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
    <link rel="stylesheet" media="print" href="<?php bloginfo('template_directory'); ?>/css/style_print.css" type="text/css" />
	<!--[if lte IE 7]>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/css/style_ie7.css" type="text/css" />
	<![endif]-->
	<!--[if lte IE 6]>
		<link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/css/style_ie.css" type="text/css" />
	<![endif]-->

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
    
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="description" content="<?php if ( is_single() ) { wp_title(''); echo ' - '; } elseif ( is_page() ) { wp_title(''); echo ' - '; } bloginfo('description'); ?>" />
	<?php if((!is_paged() ) && ( is_single() || is_page() || is_home() || is_category())){ echo '<meta name="robots" content="index, follow" />' . "\n"; } else { echo '<meta name="robots" content="noindex, follow, noodp, noydir" />' . "\n";} ?>

	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/domscripts.js"></script>

	<?php wp_head(); ?>
</head>

<body>
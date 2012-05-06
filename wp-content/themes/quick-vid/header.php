<?php global $wp_theme_options; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php wp_meta(); ?>

<!--The Title-->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :: '; } ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>

<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.gif" />

<!--The Stylesheets-->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if ( file_exists( dirname( __FILE__ ) . '/custom-style.css' ) ) : ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/custom-style.css" type="text/css" media="screen" />
<?php endif; ?>

<!--[if lt IE 7]>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/lt-ie7.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/dropdown.js"></script>
<![endif]-->
<!--[if lte IE 7]>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/lte-ie7.css" type="text/css" media="screen" />
<![endif]-->

<script type="text/javascript"><!--//--><![CDATA[//><!--
sfHover = function() {
	var sfEls = document.getElementById("menu").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
//--><!]]></script>

<!-- custom style-sheet -->
<?php if ( file_exists( dirname( __FILE__ ) . '/custom-style.css' ) ) : ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/custom-style.css" type="text/css" media="screen" />
<?php endif; ?>

<!--The RSS and Pingback-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
//A function that adds the necessary javascript for comment replying.
if (is_singular()) wp_enqueue_script( 'comment-reply' );
?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="outer-wrap">
	<div id="header-wrap">
		<div id="header" class="clearfix">
			<div id="title">
				<a href="<?php bloginfo('url'); ?>" title="Return to Home"><h1><?php bloginfo('name'); ?></h1></a>
			</div>
		</div>
	</div>
	<div id="wrap" class="clearfix">
		<div id="menu-wrap" class="clearfix">
			<div class="limit">
				<?php ithemes_navigation(); ?>
			</div>
		</div>

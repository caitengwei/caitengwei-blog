<?php
//Custom Header Image Code -- from the WordPress.com API
define('HEADER_TEXTCOLOR', 'FFFFFF');
define('HEADER_IMAGE', '%s/images/header.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 790);
define('HEADER_IMAGE_HEIGHT', 170);
define('HEADER_LINK_WIDTH', 790);
define('HEADER_LINK_HEIGHT', 170);


function header_style() { ?>
<style type="text/css">
#header {
	background: url(<?php header_image(); ?>) top left no-repeat;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
}
<?php if ( 'blank' != get_theme_mod('header_textcolor', HEADER_TEXTCOLOR) ) { ?>
#header #title a {
	text-indent: 0px;
	font-size: 28px;
	color: #<?php header_textcolor() ?>;
	line-height: <?php echo HEADER_LINK_HEIGHT; ?>px;
	width: <?php echo HEADER_LINK_WIDTH; ?>px;
	height: <?php echo HEADER_LINK_HEIGHT; ?>px;
}
<?php } ?>
</style>
<?php }
function admin_header_style() { ?>
<style type="text/css">
#headimg {
  width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
  height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
  background: url(<?php header_image(); ?>) top left no-repeat;
}
#headimg h1 {
	font-size: 24px
	color: #<?php header_textcolor() ?>;
	line-height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
}
#headimg h1 a {
	text-decoration: none;
}
#headimg #desc {
	display: none;
}
</style>
<?php }
add_custom_image_header('header_style', 'admin_header_style');  //Add the custom header
?>
<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php include(TEMPLATEPATH."/custom_navigation.php"); ?>
<?php get_sidebar(); ?>

<div id="inhalt">

	<h1 id="content" class="screenreader">Archives</h1>
	<div class="article">
		<h2>Archives by Month</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
	
	<hr />

	<div class="article">
		<h2>Archives by Subject</h2>
		<ul>
			 <?php wp_list_categories(); ?>
		</ul>
	</div>

<?php get_footer(); ?>
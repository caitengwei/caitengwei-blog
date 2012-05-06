<?php
	// Do not delete these lines

	if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && ( basename( __FILE__ ) === basename( $_SERVER['SCRIPT_FILENAME'] ) ) ) 
		die ( 'Please do not load this page directly. Thanks!' );

	if ( post_password_required() ) { 

?>
	<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php

		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="comments">
		<h3><?php comments_number( 'No Comments', 'One Comment', '% Comments' );?></h3>
		<ul class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'quickvid_comment' ) ); ?>
		</ul>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
	</div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		
	<?php else : // comments are closed ?>
		
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
	<div id="respond">
		<div class="cancel-comment-reply">
			<small><?php cancel_comment_reply_link(); ?></small>
		</div>
		<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
			<?php comment_form(array('comment_notes_after' => '')); ?>
		<?php endif; // If registration required and not logged in ?>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>

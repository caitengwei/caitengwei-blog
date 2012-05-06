<?php // Do not delete these lines

if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) 
	die ('Please do not load this page directly. Thanks!');

if (!empty($post->post_password)) { // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
		?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
		<?php
		return;
	}
}

?>


<?php if ($comments) : ?>
<div id="Kommentar">
	<h2 id="comments"><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h2>
	
	<ol class="comments">
		<?php foreach ($comments as $comment) : ?>
		<li id="comment-<?php comment_ID() ?>">
		  <a href="#comment-<?php comment_ID() ?>"><?php echo get_avatar( $comment, 40 ); ?></a>

			<h3><a href="#comment-<?php comment_ID() ?>" title="">#</a> <?php comment_author_link() ?> on <?php comment_date('F jS, Y') ?> <?php edit_comment_link('edit','[',']'); ?></h3>

			<?php if ($comment->comment_approved == '0') : ?>
			<p><em>Your comment is awaiting moderation.</em></p>
			<?php endif; ?>

			<?php comment_text() ?>
		</li>
		<?php endforeach; /* end for each comment */ ?>
	</ol>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<?php if (!is_page()) : ?>
		<p class="nocomments">Comments are closed.</p>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

</div>

<div style="margin-bottom: 2em;"></div>

<?php if ($comments) : ?>
<hr />
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="cpreview">
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="txpCommentInputForm">
		<h2 id="respond">Your Comment</h2>
		<div class="comments-wrapper">
			<fieldset id="yourcomment">
				<textarea id="message" name="comment" cols="25" rows="5" class="txpCommentInputMessage"></textarea>
				<p>You can use these tags: <br />
					<code><?php echo allowed_tags(); ?></code>
				</p>
				
				<?php if ( $user_ID ) : ?>
				<p>Logged in as 
					<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
					<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
				</p>

				<?php else : ?>

				<input type="text" name="author" id="comment_name_input" 
						class="text comment_name_input" value="<?php echo $comment_author; ?>" 
						tabindex="1" />
				<label for="comment_name_input">Name <?php if ($req) echo "(required)"; ?></label>
				
				<br />

				<input type="text" name="email" id="comment_email_input" 
						class="text comment_email_input" value="<?php echo $comment_author_email; ?>" 
						tabindex="2" />
				<label for="comment_email_input">Mail <?php if ($req) echo "(required)"; ?></label>
				
				<br />

				<input type="text" name="url" id="comment_web_input" 
						class="text comment_web_input" value="<?php echo $comment_author_url; ?>" 
						tabindex="3" />
				<label for="comment_web_input">Website</label>
				
				<br />

				<?php 
				/****** Math Comment Spam Protection Plugin ******/
				if ( function_exists('math_comment_spam_protection') ) { 
					$mcsp_info = math_comment_spam_protection();
				?> 	
				<input type="text" name="mcspvalue" id="mcspvalue" class="text" value="" tabindex="4" />
				<label for="mcspvalue">Sum of <?php echo $mcsp_info['operand1'] . ' + ' . $mcsp_info['operand2'] . ' ?' ?></label>
				<input type="hidden" name="mcspinfo" value="<?php echo $mcsp_info['result']; ?>" />
				
				<br />
				<?php } // if function_exists... ?>

				<?php endif; ?>

				<div>
					<input name="submit" class="button" type="submit" id="submitcomment" 
							tabindex="5" value="Submit Comment" />
					<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				</div>
			</fieldset>
		</div>
	<?php do_action('comment_form', $post->ID); ?>
	</form>
</div>

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
<?php
/**
 * @brief Comments theme include.
 * 
 * Used by comments_template().
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @package		WordPress
 * @subpackage	Boo_Theme
 */

global $booPage;

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load comments page directly!');
}

if (post_password_required()) {
	$booPage->msgError->addMessage('This post is password protected!');
	$booPage->msgError->saveSession();
	$booPage->redirect();
}
?>
<?php if (have_comments()): ?>
	<div class="box-wp-comments box-wp box clearfix">
		<div class="head clearfix">
			<h2><?php comments_number('No Responses', 'One Response', '% Responses' );?> to <?php the_title(); ?></h2>
		</div>
		<div class="body clearfix">
			<ol class="wp-comment-list">
				<?php wp_list_comments(); ?>
			</ol>
		</div>
	</div>
	<?php if (next_comments_link() || previous_comments_link()): ?>
		<div class="box-wp-nav box-wp box clearfix">
			<div class="body clearfix">
				<div class="align-left"><?php previous_comments_link('Older Comments'); ?></div>
				<div class="align-right"><?php next_comments_link('Newer Comments'); ?></div>
			</div>
		</div>
	<?php endif; ?>

<?php else: // no comments ?>

	<?php if ('open' == $post->comment_status): ?>
		<div class="box-wp-comments box-wp box clearfix">
			<div class="head clearfix">
				<h2>No Comments</h2>
			</div>
			<div class="body clearfix">
				<p>Be the first to comment.</p>
			</div>
		</div>
	<?php else : // comments are closed ?>
		<div class="box-wp-comments box-wp box clearfix">
			<div class="head clearfix">
				<h2>No Comments</h2>
			</div>
			<div class="body clearfix">
				<p class="wp-no-comments">Comments are closed.</p>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status): ?>
	<div class="box-wp-respond box-wp box clearfix">
		<div class="head clearfix">
			<h1><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h1>
		</div>
		<div class="body clearfix">
			<div class="wp-cancel-comment-reply">
				<small><?php cancel_comment_reply_link(); ?></small>
			</div>
			<?php if (get_option('comment_registration') && !$user_ID): ?>
				<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
			<?php else: ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="wp-comment-form">
				<?php if ($user_ID): ?>
					<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
				<?php else: ?>
					<p>
						<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
						<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label>
					</p>
					<p>
						<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
						<label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label>
					</p>
					<p>
						<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
						<label for="url"><small>Website</small></label>
					</p>
				<?php endif; ?>
				<p>
					<textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
				</p>
				<p>
					<input name="submit" class="button-submit button" type="submit" id="submit" tabindex="5" value="Submit" />
				</p>
				<fieldset>
					<?php comment_id_fields(); ?>
					<?php do_action('comment_form', $post->ID); ?>
				</fieldset>
			</form>
		</div>
	</div>
<?php endif; ?>
<?php endif; // if you delete this the sky will fall on your head ?>

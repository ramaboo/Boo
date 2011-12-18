<?php
/**
 * @brief Single theme page.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @package		WordPress
 * @subpackage	Boo_Theme
 */

include '../includes/common.php';
global $booPage; // keep global or WordPress get_header() will fail
$booPage = new Boo_Page;
$booPage->setTemplate('wordpress');
$booPage->setTitle(wp_title('-', false, 'right') . get_bloginfo('name'));

get_header();
?>
<div id="main" class="clearfix">
	<div class="col-left col clearfix">
	
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
				
				<div class="box-wp-post box-wp box clearfix <?php get_post_class(); ?>" id="post-<?php the_ID(); ?>">
					<div class="head clearfix">
						<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
						<small><?php the_time('F jS, Y'); ?> <!-- by <?php the_author() ?> --></small>
					</div>
					<div class="body clearfix">
						<div class="wp-entry">
							<?php the_content('Read more...'); ?>
						</div>
					</div>
					<div class="foot clearfix">
						<p class="wp-post-metadata">
							<?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', '); ?> | <?php edit_post_link('Edit', '', ' | '); ?> 
							<?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
						</p>
					</div>
				</div>
			<?php endwhile; ?>
			<div class="box-wp box clearfix">
				<div class="body clearfix">
					<p>
						This entry was posted
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
						on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry','','.'); ?>
					</p>
				</div>
			</div>
			<?php comments_template(); ?>
		<?php else: ?>
			<div class="box-wp box clearfix">
				<div class="head clearfix">
					<h1>Not Found</h1>
				</div>
				<div class="body clearfix">
					<p>Sorry, but you are looking for something that isn't here.</p>
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="col-right col clearfix">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>

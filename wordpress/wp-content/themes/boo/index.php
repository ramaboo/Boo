<?php
/**
 * @brief Index theme page.
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
			
			<div class="box-wp-nav box-wp box clearfix">
				<div class="body clearfix">
					<div class="align-left"><?php next_posts_link('Older Entries'); ?></div>
					<div class="align-right"><?php previous_posts_link('Newer Entries'); ?></div>
				</div>
			</div>
			
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

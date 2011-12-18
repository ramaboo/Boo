<?php
/**
 * @brief Sidebar theme include.
 * 
 * Used by get_sidebar().
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
?>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar()): // widgetized sidebar ?>
	<div class="box-wp-sidebar box-wp box clearfix">
		<div class="head clearfix">
			<h1>Search</h1>
		</div>
		<div class="body clearfix">
			<?php get_search_form(); ?>
		</div>
	</div>
	<div class="box-wp-sidebar box-wp box clearfix">
		<div class="head clearfix">
			<h1>Archives</h1>
		</div>
		<div class="body clearfix">
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</div>
	</div>
	<div class="box-wp-sidebar box-wp box clearfix">
		<div class="head clearfix">
			<h1>Categories</h1>
		</div>
		<div class="body clearfix">
			<ul>
				<?php wp_list_categories('show_count=1&title_li='); ?>
			</ul>
		</div>
	</div>
	<div class="box-wp-sidebar box-wp box clearfix">
		<div class="head clearfix">
			<h1>Meta</h1>
		</div>
		<div class="body clearfix">
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://wordpress.org/" title="Powered by WordPress">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
		</div>
	</div>
<?php else: ?>
	<div class="box-wp-sidebar box-wp box clearfix">
		<div class="head clearfix">
			<h1>Sidebar</h1>
		</div>
		<div class="body clearfix">
			<p>No sidebar found!</p>
		</div>
	</div>
<?php endif; ?>

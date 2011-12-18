<?php
/**
 * @brief Search form theme include.
 * 
 * Used by get_search_form().
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
<form method="get" id="wp-search-form" action="<?php echo get_option('home'); ?>/">
	<fieldset>
		<ol>
			<li>
				<input type="text" value="<?php echo attribute_escape(apply_filters('the_search_query', get_search_query())) ?>" name="s" id="s"/>
			</li>
			<li>
				<input type="submit" name="wp-search-button" id="wp-search-button" class="button-search button" value="Search" />
			</li>
		</ol>
	</fieldset>
</form>
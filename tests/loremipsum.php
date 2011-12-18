<?php
/* SVN FILE: $Id: timer.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_LoremIpsum object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_LoremIpsum
 */

require_once 'config/default.php';

safe_scripts();

include 'includes/header-simple.php';

?>
<div id="main" class="clearfix">
	<h1>Paragraphs</h1>
	<?php echo Boo_LoremIpsum::htmlPs(5); ?>
	
	<h1>Unorderd Lists</h1>
	<?php echo Boo_LoremIpsum::htmlUl(5); ?>
	
	<h1>Words</h1>
	<p>
		<?php echo Boo_LoremIpsum::getWords(50); ?>
	</p>
</div>
<?php include 'includes/footer-simple.php'; ?>
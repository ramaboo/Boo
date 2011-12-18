<?php
/* SVN FILE: $Id: html-all.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Validator object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Validator
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php
	echo bool_word(Boo_Validator::isEmail('david%kddd@moo.com'));
	
	
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
<?php
/* SVN FILE: $Id: error-trigger.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Error object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Error
 */

define('BOO_DEBUG', true);

require_once 'config/default.php';

safe_tests();

// start error handling
Boo_Error::start();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php trigger_error("Sample error", E_USER_ERROR); ?>
</div>
<?php include 'includes/footer-simple.php'; ?>
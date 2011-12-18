<?php
/* SVN FILE: $Id: error-trigger.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing error methods.
 * 
 * Tests Boo_Error::dbError(), Boo_Error::logError(), Boo_Error::smsError(), and Boo_Error::emailError().
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

// fill session object
session_start();

// start error handling
Boo_Error::start();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php
		$symbols = Boo_Test::getFruits();
		$e = new Boo_Error;
		$e->setError(E_USER_ERROR, 'Just testing', __FILE__, 42, $symbols);
		$e->dbError();
		$e->logError();
		$e->emailError();
		$e->smsError();
		echo $e->htmlError();
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
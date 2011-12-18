<?php
/* SVN FILE: $Id: qrbg-cache.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief QRBG cache test file.
 * 
 * This script is used to test the Boo_Qrbg object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Qrbg
 */

require_once '../config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	$q = new Boo_Qrbg;
	$q->clearCache();
	
	echo $q->getLongInt();
?>
</div>
<?php include 'includes/footer-simple.php'; ?>

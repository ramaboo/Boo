<?php
/* SVN FILE: $Id: html-all.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Db object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Db
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php
	
		//$db = new Boo_Db('boo', 'foo');
	
		$user = new Boo_User;
		
		echo $user->getTableName();
		br();
		$io = new Boo_Io;
		
		$io->setTableName('moo');
		echo $io->getTableName();
		br();
		echo $user->getTableName();
		
		br();
	//	echo $db->getTableName();
		
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
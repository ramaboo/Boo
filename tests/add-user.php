<?php
/* SVN FILE: $Id: add-user.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Add user test.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_User
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	$user = new Boo_User;
	
	$user->setUsername('frank' . uniqid());
	$user->setPassword('open1234');
	$user->setEmail('someone@yourcompany.com');
	
	//$user->addGroup('user');
	
	$user->setField('moo', 'testing123');
	
	$user->save();
	
	$userId = $user->getUserId();
	echo "User $userId added!<br/>";
	
	$user->open(62);
	
	var_dump($user);
	$user->close();
?>
</div>
<?php include 'includes/footer-simple.php'; ?>
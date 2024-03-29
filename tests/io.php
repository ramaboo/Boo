<?php
/* SVN FILE: $Id: io.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_IO object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Io
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	$io = new Boo_Io('boo_tests', 'test_id');
	
	$io->setEncryptedFields(array('card_number'));
	
	$io->setIgnoredField('password');
	
	$io->setMagicFields(array('created', 'modified'));
	$io->removeMagicField('created');
	$io->addMagicFields(array('uuid', 'ip'));
	$io->addMagicField('created');
	
	$io->setSerializedField('settings');
	
	$io->set('password', 'open1234');
	
	$io->set('first_name', 'john');
	$io->set('website', 'http://test.com/');
	
	$io->set('card_number', '1234123412341234');
	
	$io->set('settings', Boo_Test::getFruits());
	
	$io->save();
	
	echo $io->htmlDebugDiv();
?>
</div>
<?php include 'includes/footer-simple.php'; ?>
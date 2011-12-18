<?php
/* SVN FILE: $Id: select.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief HTML select test file.
 * 
 * This script is used to test the Boo_Html_Select object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * @see			Boo_Html_Select
 */

require_once '../config/default.php';

safe_tests();

include '../includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	$ul = new Boo_Html_Ul;
	
	$tmpLis[0] = new Boo_Html_Li;
	$tmpLis[0]->setContent('First item');
	
	$tmpLis[1] = new Boo_Html_Li;
	$tmpLis[1]->setAttr('id', 'moo');
	$tmpLis[1]->setContent('Second item');
	
	$tmpLis[2] = new Boo_Html_Li;
	$tmpLis[2]->setContent('Third item');
	
	$ul->addLi($tmpLis[0]);

	
	$ul->getLi(0)->appendContent(' - by reference');
	
	echo "moo";
	echo $ul;
	echo "end moo";
	echo br(2);
	$ul->addLi($tmpLis[1]);
	$ul->getLiById('moo');
	echo br(2);
	//$ul->removeLiById('moo');
	
//	$ul->addLi($tmpLis[2]);
	
	echo "UL";
	echo $ul;
	//pre_r($ul);
	echo "end ul";
	
	
	echo "UL3";
	echo $ul;
	//pre_r($ul);
	echo "end ul3";
	
	
	$ol = new Boo_Html_Ol;
	
	echo br(2);

	$ol->merge($ul);
	$ol->addLi($tmpLis[2]);
	echo $ol
	
?>
</div>
<?php include('../includes/footer.php'); ?>
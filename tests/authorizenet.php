<?php
/* SVN FILE: $Id: authorizenet.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Authorize.Net test file.
 * 
 * This script is used to test the Boo_AuthorizeNet object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * @see			Boo_AuthorizeNet
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	$an = new Boo_AuthorizeNet;
	$an->setField('x_amount', '1.00');
	$an->setField('x_type', 'AUTH_ONLY');
	$an->setField('x_card_num', MY_CARD_NUMBER);
	$an->setField('x_exp_date', MY_EXP_DATE);
	$an->testRequest();
	$an->setMode('live');
	$an->send();
	
	echo $an->htmlResultsUl(array(), true)->html();
	
	echo br(2);
	
	echo $an->htmlTestForm();
?>
</div>
<?php include 'includes/footer-simple.php'; ?>
<?php
/* SVN FILE: $Id: sms.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief SMS test file.
 * 
 * This script is used to test the Boo_Sms object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * @see			Boo_Sms
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';

$sms = new Boo_Sms;

$sms->setSubject('moo');
$sms->setBody('boo');
//$sms->setPhoneNumber('5179805017');
$sms->setCarrierId(80);


//$sms->send();

?>
<div id="main" class="clearfix">
	<h1>Sample Form</h1>
	<form action="sms.php" method="post">
		<?php echo $sms->htmlCarrierSelect2(true); ?>
		<input type="text" name="phone_number" value="<?php echo (isset($_POST['phone_number'])) ? $_POST['phone_number'] : ''; ?>" />
		<input type="submit" />
	</form>
<?php
	
	var_dump($sms->getCarriers());
	echo br(2);
	
	var_dump($sms->getCarrierDomains());
	echo br(2);
	
	var_dump($sms->getCarrierNames());
	echo br(2);
	
	echo $sms->getCarrierNameById(45);
	echo br(2);
	
	$sms->setPhoneNumber('1#555-980-5017&*');
	echo $sms->getPhoneNumber();
?>
</div>
<?php include 'includes/footer-simple.php'; ?>

<?php
/* SVN FILE: $Id: form-xml.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Html_Form_Xml object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Html_Form_Xml
 */

require_once 'config/defult.php';

safe_tests();

$booPage = new Boo_Page;
$booPage->setTitle('Form Test');

$form = new Boo_Html_Form_Xml;
$form->loadXMLForm('../xml/forms.xml', true); // load test form
$form->open('test');
	
if ($booPage->isPostBack()) {
	$result = $form->validate();
	if ($result) {
		
	} else {
		// form is not valid
		$booPage->msgError->addOl($form->getErrors());
		
	}
}

include 'includes/header.php';
?>
<div id="main" class="clearfix">
	<?php echo $form->html(); ?>
</div>
<?php include 'includes/footer.php'; ?>

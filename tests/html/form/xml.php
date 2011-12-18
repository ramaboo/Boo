<?php
/* SVN FILE: $Id: select.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief HTML XML form test file.
 * 
 * This script is used to test the Boo_Html_Form_Xml object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * @see			Boo_Html_Form_Xml
 */

require_once '../../config/default.php';

safe_tests();

$formTest = new Boo_Html_Form_Xml;
$formTest->setFilename(BOO_BASE_DIR . '/xml/test.xml');
$formTest->open('test');

include '../../includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php
		echo $formTest->html();
	?>
</div>
<?php include '../../includes/footer-simple.php'; ?>
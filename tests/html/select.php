<?php
/* SVN FILE: $Id: select.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
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

$booPage = new Boo_Page;
$booPage->setTitle('HTML - Select');

$select = new Boo_Html_Select;
$select->setAttr('name', 'test');
$select->setAttr('id', 'test');

$select->setData(Boo_Validator::getStates());
$select->setDefaultIndex(5);

if ($booPage->isPostBack()) {
	$booPage->msgSuccess->addMessage('Postback!');
}

include '../includes/header.php';
?>
<div id="main" class="clearfix">
	<form method="post" action="select.php">
		<?php echo $select->html(); ?>
		<input class="button button-submit" type="submit" value="Submit" />
	</form>
</div>
<?php include '../includes/footer.php'; ?>
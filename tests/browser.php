<?php
/* SVN FILE: $Id: browser.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Browser object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Browser
 */

require_once 'config/default.php';

safe_tests();

if (!BOO_BROWSER) {
	die('BOO_BROWSER is false, exiting');
}

if (!class_exists('Boo_Browser')) {
	die('Class Boo_Browser does not exist, exiting');
}

//unset($_SERVER['HTTP_USER_AGENT']);

Boo_Browser::start();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<table>
		<thead>
			<tr>
				<th>Function</th>
				<th>Result</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Boo_Browser::isIe();</td>
				<td><?php echo bool_word(Boo_Browser::isIe()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isIe6();</td>
				<td><?php echo bool_word(Boo_Browser::isIe6()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isIe7();</td>
				<td><?php echo bool_word(Boo_Browser::isIe7()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isIe8();</td>
				<td><?php echo bool_word(Boo_Browser::isIe8()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isFirefox();</td>
				<td><?php echo bool_word(Boo_Browser::isFirefox()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isFirefox2();</td>
				<td><?php echo bool_word(Boo_Browser::isFirefox2()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isFirefox3();</td>
				<td><?php echo bool_word(Boo_Browser::isFirefox3()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isSafari();</td>
				<td><?php echo bool_word(Boo_Browser::isSafari()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isSafari2();</td>
				<td><?php echo bool_word(Boo_Browser::isSafari2()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isSafari3();</td>
				<td><?php echo bool_word(Boo_Browser::isSafari3()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isOpera();</td>
				<td><?php echo bool_word(Boo_Browser::isOpera()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isOpera9();</td>
				<td><?php echo bool_word(Boo_Browser::isOpera9()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::isChrome();</td>
				<td><?php echo bool_word(Boo_Browser::isChrome()); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::getVersion();</td>
				<td><?php echo Boo_Browser::getVersion(); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::getMajorVersion();</td>
				<td><?php echo Boo_Browser::getMajorVersion(); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::getMinorVersion();</td>
				<td><?php echo Boo_Browser::getMinorVersion(); ?></td>
			</tr>
			<tr>
				<td>Boo_Browser::getBrowserName();</td>
				<td><?php echo Boo_Browser::getBrowserName(); ?></td>
			</tr>
		</tbody>
	</table>
	<h1>Browser Dump</h1>
	<?php
		pre_r(Boo_Browser::getBrowser());
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
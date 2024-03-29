<?php
/* SVN FILE: $Id: qrbg.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief QRBG test file.
 * 
 * This script is used to test the Boo_Qrbg object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Qrbg
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';

$q = new Boo_Qrbg;

//$q->testCmd();

?>
<div id="main" class="clearfix">
	<ul>
		<li>
			Int8: <?php echo $q->getInt8(); ?>
		</li>
		<li>
			Int16: <?php echo $q->getInt16(); ?>
		</li>
		<li>
			Int32: <?php echo $q->getInt32(); ?>
		</li>
		<li>
			Int64: <?php echo $q->getInt64(); ?>
		</li>
		<li>
			Byte: <?php echo $q->getByte(); ?>
		</li>
		<li>
			Int: <?php echo $q->getInt(); ?>
		</li>
		<li>
			LongInt: <?php echo $q->getLongInt(); ?>
		</li>
		<li>
			Float: <?php echo $q->getFloat(); ?>
		</li>
		<li>
			Double: <?php echo $q->getDouble(); ?>
		</li>
		<li>
			Bytes[10]: <?php var_export($q->getBytes(10)); ?>
		</li>
		<li>
			Ints[5]: <?php var_export($q->getInts(5)); ?>
		</li>
		<li>
			LongInts[1]: <?php var_export($q->getLongInts(1)); ?>
		</li>
		<li>
			Floats[5]: <?php var_export($q->getFloats(5)); ?>
		</li>
		<li>
			Doubles[2]: <?php var_export($q->getDoubles(2)); ?>
		</li>
	</ul>
</div>
<?php include 'includes/footer-simple.php'; ?>
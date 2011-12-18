<?php
/* SVN FILE: $Id: remember.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Remember test script.
 * 
 * This script displays the results of common comparison operations.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class EmptyObj {}

class NonEmptyObj {
	public $boo = 5;
	public function moo() { echo 'A cow says moo!'; }
}

$emptyObj = new EmptyObj;

$nonEmptyObj = new NonEmptyObj;

$emptyArray = array();

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<h1>List of Common PHP Results</h1>
	<ul>
		<li>
			<span>is_null(null);</span>
			<?php echo '// ' . strtoupper(bool_word(is_null(null))); ?>
		</li>
		<li>
			<span>is_null('');</span>
			<?php echo '// ' . strtoupper(bool_word(is_null(''))); ?>
		</li>
		<li>
			<span>is_null(0);</span>
			<?php echo '// ' . strtoupper(bool_word(is_null(0))); ?>
		</li>
		<li>
			<span>is_null(false);</span>
			<?php echo '// ' . strtoupper(bool_word(is_null(false))); ?>
		</li>
		<li>
			<span>is_null($emptyObj);</span>
			<?php echo '// ' . strtoupper(bool_word(is_null($emptyObj))); ?>
		</li>
		<li>
			<span>is_null($emptyArray);</span>
			<?php echo '// ' . strtoupper(bool_word(is_null($emptyArray))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull(true);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull(true))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull(null);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull(null))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull('');</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull(''))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull(0);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull(0))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull(false);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull(false))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull($emptyObj);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull($emptyObj))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull($nonEmptyObj);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull($nonEmptyObj))); ?>
		</li>
		<li>
			<span>Boo_Validator::isNull($emptyArray);</span>
			<?php echo '// ' . strtoupper(bool_word(Boo_Validator::isNull($emptyArray))); ?>
		</li>
		<li>
			<span>null == null;</span>
			<?php echo '// ' . strtoupper(bool_word(null == null)); ?>
		</li>
		<li>
			<span>null == '';</span>
			<?php echo '// ' . strtoupper(bool_word(null == '')); ?>
		</li>
		<li>
			<span>null == 0;</span>
			<?php echo '// ' . strtoupper(bool_word(null == 0)); ?>
		</li>
		<li>
			<span>null == false;</span>
			<?php echo '// ' . strtoupper(bool_word(null == false)); ?>
		</li>
		<li>
			<span>null == $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word(null == $emptyObj)); ?>
		</li>
			<li>
			<span>null == $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(null == $emptyArray)); ?>
		</li>
		<li>
			<span>'' == null;</span>
			<?php echo '// ' . strtoupper(bool_word('' == null)); ?>
		</li>
		<li>
			<span>'' == '';</span>
			<?php echo '// ' . strtoupper(bool_word('' == '')); ?>
		</li>
		<li>
			<span>'' == 0;</span>
			<?php echo '// ' . strtoupper(bool_word('' == 0)); ?>
		</li>
		<li>
			<span>'' == false;</span>
			<?php echo '// ' . strtoupper(bool_word('' == false)); ?>
		</li>
		<li>
			<span>'' == $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word('' == $emptyObj)); ?>
		</li>
		<li>
			<span>'' == $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word('' == $emptyArray)); ?>
		</li>
		<li>
			<span>0 == null;</span>
			<?php echo '// ' . strtoupper(bool_word(0 == null)); ?>
		</li>
		<li>
			<span>0 == '';</span>
			<?php echo '// ' . strtoupper(bool_word(0 == '')); ?>
		</li>
		<li>
			<span>0 == 0;</span>
			<?php echo '// ' . strtoupper(bool_word(0 == 0)); ?>
		</li>
		<li>
			<span>0 == false;</span>
			<?php echo '// ' . strtoupper(bool_word(0 == false)); ?>
		</li>
		<li>
			<span>0 == $emptyObj;</span>
			<?php echo '// ' . strtoupper(@bool_word(0 == $emptyObj)); ?>
		</li>
		<li>
			<span>0 == $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(0 == $emptyArray)); ?>
		</li>
		<li>
			<span>false == null;</span>
			<?php echo '// ' . strtoupper(bool_word(false == null)); ?>
		</li>
		<li>
			<span>false == '';</span>
			<?php echo '// ' . strtoupper(bool_word(false == '')); ?>
		</li>
		<li>
			<span>false == 0;</span>
			<?php echo '// ' . strtoupper(bool_word(false == 0)); ?>
		</li>
		<li>
			<span>false == false;</span>
			<?php echo '// ' . strtoupper(bool_word(false == false)); ?>
		</li>
		<li>
			<span>false == $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word(false == $emptyObj)); ?>
		</li>
		<li>
			<span>false == $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(false == $emptyArray)); ?>
		</li>
		<li>
			<span>null === null;</span>
			<?php echo '// ' . strtoupper(bool_word(null === null)); ?>
		</li>
		<li>
			<span>null === '';</span>
			<?php echo '// ' . strtoupper(bool_word(null === '')); ?>
		</li>
		<li>
			<span>null === 0;</span>
			<?php echo '// ' . strtoupper(bool_word(null === 0)); ?>
		</li>
		<li>
			<span>null === false;</span>
			<?php echo '// ' . strtoupper(bool_word(null === false)); ?>
		</li>
		<li>
			<span>null === $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word(null === $emptyObj)); ?>
		</li>
		<li>
			<span>null === $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(null === $emptyArray)); ?>
		</li>
		<li>
			<span>'' === null;</span>
			<?php echo '// ' . strtoupper(bool_word('' === null)); ?>
		</li>
		<li>
			<span>'' === '';</span>
			<?php echo '// ' . strtoupper(bool_word('' === '')); ?>
		</li>
		<li>
			<span>'' === 0;</span>
			<?php echo '// ' . strtoupper(bool_word('' === 0)); ?>
		</li>
		<li>
			<span>'' === false;</span>
			<?php echo '// ' . strtoupper(bool_word('' === false)); ?>
		</li>
		<li>
			<span>'' === $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word('' === $emptyObj)); ?>
		</li>
		<li>
			<span>'' === $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word('' === $emptyArray)); ?>
		</li>
		<li>
			<span>0 === null;</span>
			<?php echo '// ' . strtoupper(bool_word(0 === null)); ?>
		</li>
		<li>
			<span>0 === '';</span>
			<?php echo '// ' . strtoupper(bool_word(0 === '')); ?>
		</li>
		<li>
			<span>0 === 0;</span>
			<?php echo '// ' . strtoupper(bool_word(0 === 0)); ?>
		</li>
		<li>
			<span>0 === false;</span>
			<?php echo '// ' . strtoupper(bool_word(0 === false)); ?>
		</li>
		<li>
			<span>0 === $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word(0 === $emptyObj)); ?>
		</li>
		<li>
			<span>0 === $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(0 === $emptyArray)); ?>
		</li>
		<li>
			<span>false === null;</span>
			<?php echo '// ' . strtoupper(bool_word(false === null)); ?>
		</li>
		<li>
			<span>false === '';</span>
			<?php echo '// ' . strtoupper(bool_word(false === '')); ?>
		</li>
		<li>
			<span>false === 0;</span>
			<?php echo '// ' . strtoupper(bool_word(false === 0)); ?>
		</li>
		<li>
			<span>false === false;</span>
			<?php echo '// ' . strtoupper(bool_word(false === false)); ?>
		</li>
		<li>
			<span>false === $emptyObj;</span>
			<?php echo '// ' . strtoupper(bool_word(false === $emptyObj)); ?>
		</li>
		<li>
			<span>false === $emptyArray;</span>
			<?php echo '// ' . strtoupper(bool_word(false === $emptyArray)); ?>
		</li>
	</ul>
	<h2>Function <tt>empty()</tt></h2>
	<ul>
		<li><i>&quot;&quot; (an empty string)</i></li>
		<li><i>0 (0 as an integer)</i></li>
		<li><i>&quot;0&quot; (0 as a string)</i></li>
		<li><b><tt class="constant">NULL</tt></b></li>
		<li><b><tt class="constant">FALSE</tt></b></li>
		<li><i>array() (an empty array)</i></li>
		<li><i>var $var; (a variable declared, but without a value in a class)</i></li>
	</ul>
</div>
<?php include 'includes/footer-simple.php'; ?>
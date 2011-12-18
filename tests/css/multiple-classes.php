<?php
/* SVN FILE: $Id: select.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Multiple classes test file.
 * 
 * This script is used to test fixes for the multiple classes css bug in IE 6
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * @see			http://www.quirksmode.org/css/multipleclasses.html
 */

require_once '../config/default.php';

safe_tests();

include '../includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<style type="text/css">
		p.italic { font-style: italic; }
		p.underline { text-decoration: underline; }
		p.green { background-color: green }
		p.red { background-color: red }
		p.underline.red { font-variant: small-caps; }
	</style>
	
	<p class="italic green">
		This paragraph has <code>class="italic green"</code> It should be italic and green.
	</p>
	<p class="underline green">
		This paragraph has <code>class="underline green"</code> It should be underlined and green.
	</p>
	<p class="italic red">
		This paragraph has <code>class="italic red"</code> It should be italic and red.
	</p>
	<p class="underline red">
		This paragraph has <code>class="underline red"</code> It should be underlined, red, 
		and it should use small-caps.
	</p>
</div>
<?php include '../includes/footer.php'; ?>
<?php
/* SVN FILE: $Id: timer.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Timer object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Timer
 */

require_once 'config/default.php';

safe_scripts();

include 'includes/header-simple.php';

$timer = new Boo_Timer;
$start = $timer->start();

?>
<div id="main" class="clearfix">
	<h1>Now</h1>
	<p>
		<?php var_dump(time()); ?>
	</p>
	<h1>Start Time</h1>
	<p>
		<?php var_dump($start); ?>
	</p>
	<h1>Current Time</h1>
	<p>
		<?php var_dump($timer->getTime()); ?>
	</p>
	<?php
		for($i = 0; $i < 10000; $i++) {
			// waste time
			$tmp = ($i/42) + ($i * 42) + ($i - 42) + ($i + 42);
		}
	
	?>
	<h2>After Wasting Time</h2>
	<p>
		<?php var_dump($timer->getTime()); ?>
	</p>
	<h1>Stop</h1>
	<p>
		<?php var_dump($timer->stop()); ?>
	</p>
	<h2>Current Time</h2>
	<p>
		<?php var_dump($timer->getTime()); ?>
	</p>
	
	<h1>Reset</h1>
	<?php
		$timer->reset();
		echo $timer->getTime();
	?>
	<h1>Boo_Timer::getMicroTime()</h1>
	<p>
		<?php var_dump(Boo_Timer::getMicroTime()); ?>
	</p>
</div>
<?php include 'includes/footer-simple.php'; ?>
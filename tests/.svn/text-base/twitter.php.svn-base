<?php
/* SVN FILE: $Id: timer.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Twitter object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Twitter
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<?php
		$twitter = new Boo_Twitter(BOO_TWITTER_USERNAME, BOO_TWITTER_PASSWORD);
		
		// fetch your profile in xml format
$xml = $twitter->updateStatus('testing status');

var_dump($twitter);

// display the raw xml
echo "<pre>";
echo htmlentities($xml);
echo "</pre>";

	
	
	
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
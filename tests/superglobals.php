<?php
/* SVN FILE: $Id: superglobals.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Displays super globals.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */
require_once 'config/default.php';

safe_tests();

session_start();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
<?php
	echo '<div id="superglobals">';
	
	echo '<h1>$_SERVER</h1>';
	foreach ($_SERVER as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_GET</h1>';
	foreach ($_GET as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_POST</h1>';
	foreach ($_POST as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_FILES</h1>';
	foreach ($_FILES as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_COOKIE</h1>';
	foreach ($_COOKIE as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_SESSION</h1>';
	foreach ($_SESSION as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_REQUEST</h1>';
	foreach ($_REQUEST as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	
	echo '<h1>$_ENV</h1>';
	foreach ($_ENV as $key => $value) {
		echo "<b>{$key}</b>: {$value}<br/>";
		
	}
	echo '</div>';
?>
</div>
<?php include 'includes/footer-simple.php'; ?>

<?php
/* SVN FILE: $Id: camel_case.php 200 2009-02-22 19:10:02Z david@ramaboo.com $ */
/**
 * @brief Converts variables in files from underscored case to lower camel case.
 * 
 * call cDir() with the directory of the files you wish to change.
 * 
 * Will only effect \c $undersored_words and \c $this->undersocred_words.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */
// !!! CHANGE THIS TO MATCH YOUR SERVER !!!
define('BASE_DIR', '/var/www/ramaboo/');
require_once '/var/www/ramaboo/config/dev.ramaboo.com.php';
require_once '/var/www/Boo-2.0.0/Boo.php';

function c($word) {
	return Boo_Helper::toCamelCase($word);
}

function cFile($filename) {
	
	$ext = Boo_Helper::getFileExtension($filename);
	
	if ($ext != 'php') {
		return true; // not PHP file
	}
	
	// do not fix this file - BAD THINGS WILL HAPPEN!!!
	if (basename($filename) == 'camel_case.php') {
		echo "Skip: {$filename}<br />";
		return true;
	}
	
	// do not fix
	if (basename($filename) == 'Smarty.php') {
		echo "Skip: {$filename}<br />";
		return true;
	}
	
	$convert = file_get_contents($filename);
	
	$reg = '/(\$this->\w*|\$\w*)/e';
	$rep = 'c(\'$1\')';
	$done = preg_replace($reg, $rep, $convert);
	
	// fix PHP superglobals - this is ugly but it works
	$done = preg_replace('/\$SERVER/', '$_SERVER', $done);
	$done = preg_replace('/\$GET/', '$_GET', $done);
	$done = preg_replace('/\$POST/', '$_POST', $done);
	$done = preg_replace('/\$FILES/', '$_FILES', $done);
	$done = preg_replace('/\$COOKIE/', '$_COOKIE', $done);
	$done = preg_replace('/\$SESSION/', '$_SESSION', $done);
	$done = preg_replace('/\$REQUEST/', '$_REQUEST', $done);
	$done = preg_replace('/\$ENV/', '$_ENV', $done);
	
	$fp = fopen($filename, 'w');
	fwrite($fp, $done);
	fclose($fp);
	echo "Done: {$filename}<br/>";
}

function cDir($path) {
	$dir = opendir($path);
		
	if (!$dir) {
		trigger_error("Path {$path} is not valid", E_USER_ERROR);
		return false;
	}
	
	while (($file = readdir($dir)) !== false) {
		
		if ($file != '.' && $file != '..' && substr($file, -1) != '~' && substr($file, 0, 4) != '.svn') {
			if (is_dir($path . '/' . $file)){
				// recursive
				if ($file == 'lib') {
					echo 'Entering lib directory (skipping)<br />';
				} else {
					echo "Recursive: {$file}<br/>";
					cDir($path . '/' . $file);
				}
			}
			else {
				
				cFile($path . '/' . $file);
			}
		}
	}
	
	// close dir
	closedir($dir);
}

cFile('/usr/local/apache2/htdocs/Boo-2.0.0/classes/Twitter.php');
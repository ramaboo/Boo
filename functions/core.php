<?php
/* SVN FILE: $Id: core.php 254 2009-12-10 01:53:44Z david@ramaboo.com $ */
/**
 * @brief Core functions file.
 * 
 * This file provides core functions used by Boo.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Checks if a number is odd.
 * @param int $number The number.
 * @return bool TRUE if number is odd, FALSE otherwise.
 */
function is_odd($number) { return $number & 1; }

/**
 * @brief Checks if a number is even.
 * @param int $number The number.
 * @return bool TRUE if number is even, FALSE otherwise.
 */
function is_even($number) { return !($number & 1); }

/**
 * @brief Returns word associated with boolean value.
 * @param bool $opt The value to test.
 * @return string Returns "true" if TRUE, "false" if FALSE.
 */
function bool_word($opt) {
	return ($opt) ? 'true' : 'false';
}

/**
 * @brief Returns the answer word.
 * @param bool $opt The value to test.
 * @return string Returns "yes" if TRUE, "no" if FALSE.
 */
function answer_word($opt) {
	return ($opt) ? 'yes' : 'no';
}

/**
 * @brief Returns TRUE if the word equals "true".
 * @param string $word The word to test.
 * @return bool TRUE if string equals "true", FALSE otherwise.
 */
function word_bool($word) {
	$word = strtolower(trim($word));
	return ($word == 'true');
}

/**
 * @brief Delete a file, or a folder and its contents.
 * 
 * @author Aidan Lister <aidan@php.net>
 * @version 1.0.3
 * @link http://aidanlister.com/repos/v/function.rmdirr.php
 * @param string $dirname Directory to delete.
 * @return bool Returns TRUE on success, FALSE on failure.
 * @licence Public Domain
 */
function rmdirr($dirname) {
	// sanity check
	if (!file_exists($dirname)) {
		return false;
	}
	
	// simple delete for a file
	if (is_file($dirname) || is_link($dirname)) {
		return unlink($dirname);
	}
	
	// loop through the folder
	$dir = dir($dirname);
	while (false !== ($entry = $dir->read())) {
		// skip pointers
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		
		// recursive
		rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
	}
	
	// clean up
	$dir->close();
	return rmdir($dirname);
}

/**
 * @brief Returns contents of css file.
 * 
 * This function will remove the @charset line if it exists.
 * 
 * @param string $filename Filename to the css file.
 * @return string The contents of the file.
 */
function file_get_contents_css($filename) {
	$file = file_get_contents($filename);
	
	// get first line of file
	$firstline = substr($file, 0, stripos($file, ';') + 1);
	
	// if its @charset then remove it
	if (strtolower(substr($firstline, 0 ,8)) == '@charset') {
		return substr($file, strlen($firstline));
	} else {
		// user forgot the @charset so return the file as it is
		return $file;
	}
}

/**
 * @brief Sets the headers correctly for PHP to output CSS.
 * @return void.
 */
function header_css() {
	header('Content-type: text/css; charset=utf-8');
	header('Cache-Control: must-revalidate');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 360) . ' GMT');
}

/**
 * @brief Sets headers correctly for downloading a file.
 * @param string $filename The filename as displayed to the user.
 * @param int $contentLength[optional] The length of the content.
 * @param string $contentType[optional] The content type.
 * @return void.
 */
function header_download($filename, $contentLength = -1, $contentType = 'application/force-download') {
	$filename = basename($filename);
	$contentLength = (int) $contentLength;
	$contentType = trim($contentType);
	
	// check if content length is a positive integer or 0
	if (ctype_digit((string) $contentLength)) {
		header('Content-Length: ' . $contentLength);
	}
	
	header('Pragma: public'); // required
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false); // required for certain browsers 
	if ($contentType) {
		header("Content-Type: {$contentType}");
	}
	header('Content-Transfer-Encoding: binary');
	header("Content-Disposition: attachment; filename={$filename}");
}

/**
 * @brief Sets the headers correctly for no cache pages.
 * @return void.
 * @param int $contentLength[optional] The content length.
 * @param string $contentType[optional] The content type.
 * @param string $charset[optional] The character set.
 * @since 2.0.0
 */
function header_no_cache($contentLength = -1, $contentType = 'text/html', $charset = 'utf-8') {
	$contentLength = (int) $contentLength;
	$contentType = trim($contentType);
	$charset = trim($charset);
	
	// check if content length is a positive integer or 0
	if (ctype_digit((string) $contentLength)) {
		header('Content-Length: ' . $contentLength);
	}
	
	if ($contentType) {
		header("Content-Type: {$contentType}; charset={$charset}");
	}
	
	header('Expires: Mon, 26 Jul 1997 05:00:00');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
	header('Pragma: no-cache'); // HTTP/1.0
}

/**
 * @brief Sets the headers correctly for JSON responses.
 * @return void.
 * @param int $contentLength[optional] The content length.
 * @since 2.0.0
 */
function header_json($contentLength = -1) {
	header_no_cache($contentLength, 'application/json', 'utf-8');
}

/**
 * @brief Moves an element within an array.
 * @param array $array The array.
 * @param int $index The item to move.
 * @param mixed $direction The direction to move the item as a positive or negative integer. The words "up" or "down" may also be used.
 * @return mixed The array on success, or FALSE on failure.
 * @warning Only works on numerically indexed arrays.
 */
function move_element(array $array, $index, $direction) {
	switch (strtolower(trim($direction))) {
		case 'up':
			$direction = 1;
			break;
		case 'down':
			$direction = -1;
			break;
		default:
			$direction = (int) $direction;
			break;
	}
	
	// make sure the index is within the array bounds
	if ($index < 0 || $index >= count($array)) {
		return false;
	}
	
	// make sure the target index is within the array bounds
	$index2 = $index + $direction;
	if ($index2 < 0 || $index2 >= count($array) || $index2 == $index) {
		return false;
	}
	
	// move the elements in the array
	$tmpItem = $array[$index2];
	$array[$index2] = $array[$index];
	$array[$index] = $tmpItem;
	
	return $array;
}

/**
 * @brief Returns uptime on a unix system.
 * 
 * The output format is D HH:MM:SS or HH:MM:SS if day is 0.
 * 
 * @return string The uptime.
 */
function get_uptime() {
	// set handle
	$handle = fopen('/proc/uptime', 'r');
	
	if(!$handle) {
		trigger_error("Function get_uptime() failed, cannot open /proc/uptime", E_USER_ERROR);
		return false;
	} else {
		// open handle
		$proc = fgets($handle);
		// close handle
		fclose($handle);
		
		// remove idle time and fractions of a second
		$result = round(substr($proc,0,strpos($proc,' ')));
		
		// divide up result
		$parts['day'] = floor($result / 86400);
		$parts['hour'] = floor(($result - ($parts['day'] * 86400)) / 3600);
		$parts['minute'] = floor(($result - ($parts['day'] * 86400) - ($parts['hour'] * 3600)) / 60);
		$parts['second'] = floor($result - ($parts['minute'] * 60) - ($parts['day'] * 86400) - ($parts['hour'] * 3600));
		
		// format uptime for output in format D HH:MM:SS or HH:MM:SS if day is 0
		$uptime = '';
		if ($parts['day']) {
			$uptime .=  $parts['day'] . ' ';
		}
		$uptime .= sprintf('%02d', $parts['hour']) . ':' . sprintf('%02d', $parts['minute']) . ':' . sprintf('%02d', $parts['second']);
	}
	
	return $uptime;
}

/**
 * @brief Makes sure running scripts is allowed.
 * 
 * Set \c BOO_ALLOW_SCRIPTS to TRUE in your config file to allow scripts.
 * 
 * @return mixed Returns TRUE if allowed, exits otherwise.
 */
function safe_scripts() {
	if (BOO_ALLOW_SCRIPTS) {
		return true;
	} else {
		exit('Scripts are not allowed, set BOO_ALLOW_SCRIPTS to TRUE if you wish to use scripts');
	}
}

/**
 * @brief Makes sure running tests is allowed.
 * 
 * Set \c BOO_ALLOW_TESTS to TRUE in your config file to allow tests.
 * 
 * @return mixed Returns TRUE if allowed, exits otherwise.
 */
function safe_tests() {
	if (BOO_ALLOW_TESTS) {
		return true;
	} else {
		exit('Tests are not allowed, set BOO_ALLOW_TESTS to TRUE if you wish to use tests');
	}
}

/**
 * @brief Returns the string surrounded by double quotes.
 * @return string The quoted string.
 */
function quote($string) {
	return "\"{$string}\"";
}

/**
 * @brief Formats string for insertion into database.
 * 
 * This function does not check for SQL injections.
 * By default this function is identical to strtolower().
 * 
 * If you wish to preserve capitalization in your database or use
 * another capitalization schema then edit this function.
 * 
 * Only some strings are passed though this function. For example
 * a users first name would be however the state code would not (its always uppercase).
 * 
 * @param string $string The string to format
 * @return string Returns the string in database format (default is lowercase).
 */
function strtodb($string) {
	return strtolower(trim($string));
}
/**
 * @brief Cleans file name of dangerous characters.
 * 
 * @param string The file name (not including directory).
 * @return string The safe file name.
 */
function clean_filename($filename) {
	$filename = trim($filename);
	$safe = '[^\x20\.0-9a-zA-z_-]'; // allow only letters, numbers, underscore, hyphen, period, and space
	$filename = preg_replace('/^[.]*/', '', $filename); // remove any leading dots
	$filename = preg_replace("/{$safe}/", '_', $filename); // replace unsafe characters
	
	return $filename;
}

/**
 * @brief Truncates a string to a given length.
 * 
 * If the string ends in a punctuation mark then it is removed before applying \c $etc.
 * 
 * Punctuation marks include [.!?:;,-] and the space character.
 * 
 * @param string $text The text to truncate.
 * @param int $length The length to truncate to.
 * @param string $etc[optional] Addition to the string after truncating. Defaults to ellipsis.
 * @return string Returns truncated string plus addition if supplied.
 */
function truncate($text, $length, $etc = '...') {
	$text = html_entity_decode($text, ENT_QUOTES);
	if (strlen($text) > $length) {
		$text = substr($text, 0, $length);
		
		$punctuation = ' .!?:;,-'; //punctuation you want removed
		$text = (strspn(strrev($text), $punctuation) != 0) ? substr($text, 0, -strspn(strrev($text), $punctuation)) : $text;
		
		$text = $text . $etc;
	}
	
	$text = htmlentities($text, ENT_QUOTES);
	return $text;
}

/**
 * @brief Returns a HTML break.
 * 
 * This function is usefull for quickly outputing breaks for testing.
 * 
 * @param int $count[optional] The number of breaks to return.
 * @param bool $return[optional] Set to TRUE to return output, FALSE to print.
 * @return string HTML breaks. Will echo if $return is set to FALSE.
 */
function br($count = 2, $return = false) {
	$count = (int) $count;
	if ($return) {
		return str_repeat('<br />', $count);
	} else {
		echo str_repeat('<br />', $count);
	}
}

/**
 * @brief Determins if a flag is present.
 * @return bool Returns TRUE if flag is present, FALSE otherwise.
 * @param int $flags The flags to be tested.
 * @param int $flagCheck The flag to check for.
 */
function has_flag($flags, $flagCheck) {
	return ($flags & $flagCheck) == $flagCheck;
}

/**
 * @brief Adds a set of flags to eachother.
 * @return int Returns result of the flag addition.
 * @param int $flags The original flag set.
 * @param int $flagAdd The flag set to add.
 */
function add_flag($flags, $flagAdd) {
	return $flags | $flagAdd;
}

/**
 * @brief Removes a flag from a set of flags.
 * @return int Returns the result after the flag removal.
 * @param int $flags The original flag set.
 * @param int $flagRemove The flag to remove.
 */
function remove_flag($flags, $flagRemove) {
	return $flags & ~$flagRemove;
}

/**
 * @brief Returns output of print_r enclosed in \c <pre> tags.
 * @return string The output of print_r enclosed in \c <pre> tags.
 * @param mixed $expression The expression to be printed.
 * @param bool $return[optional] Set to TRUE to return output, FALSE to print.
 */
function pre_r($expression, $return = false) {
	if ($return) {
		return '<pre>' . print_r($expression, true) . '</pre>';
	} else {
		echo '<pre>';
		print_r($expression, false);
		echo '</pre>';
	}
}

/**
 * @brief Trims whitespace from each value in an array
 * @return void.
 * @param array $array A reference to the input array.
 * @param string $charlist List of all characters that you want to be stripped.
 */
function array_trim(&$array, $charlist = false) { array_walk($array, 'array_trim_callback', $charlist); }

/**
 * @brief Callback function used with \c array_trim().
 * @return void.
 * @param string $value A reference to the value to trim.
 * @param mixed $key The array key.
 * @param string $charlist List of all characters that you want to be stripped.
 */
function array_trim_callback(&$value, $key, $charlist) {
	if ($charlist === false) {
		$value = trim($value);
	} else {
		$value = trim($value, $charlist);
	}
}

/**
 * @brief Returns an array with all values lowercased or uppercased.
 * 
 * @since 2.0.0
 * @return array Returns an array with all values lowercased or uppercased.
 * @param object $input The array to work on 
 * @param int $case[optional] Either \c CASE_UPPER or \c CASE_LOWER (default).
 */
function array_change_value_case(array $input, $case = CASE_LOWER) {
	switch ($case) {
		case CASE_LOWER:
			return array_map('strtolower', $input);
			break;
		case CASE_UPPER:
			return array_map('strtoupper', $input);
			break;
		default:
			trigger_error("Case {$case} is not valid, CASE_LOWER or CASE_UPPER only", E_USER_ERROR);
			return false;
	}
}

/**
 * @brief Counts files recursively.
 * 
 * @see Boo_Helper::getFileExtension()
 * @param string $path The path.
 * @param mixed[optional] $fileList The file list.
 * @return array Returns an array of files where the key is the file extension and the value is the count, or FALSE on error.
 */
function count_files($path, &$fileList = false) {
	$files = array();
	// open dir
	$dir = opendir($path);
	
	if (!$dir) {
		trigger_error("Path {$path} is not valid", E_USER_ERROR);
		return false;
	}
	
	while (($file = readdir($dir)) !== false) {
		
		if ($file != '.' && $file != '..') {
			if (is_dir($path . DIRECTORY_SEPARATOR . $file)){
				// recursive
				$files = array_add($files, count_files($path . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR, $fileList));
			}
			else {
				
				if (is_array($fileList)) {
					$fileList[] = "{$path}{$file}";
				}
				
				// get file extension
				$ext = Boo_Helper::getFileExtension($file);
				
				// increase file count
				(isset($files[$ext])) ? $files[$ext]++ : $files[$ext] = 1;
			}
		}
	}
	// close dir
	closedir($dir);
	return $files;
}

/**
 * @brief Adds the values of one array to the values of another array with the same key.
 * 
 * @param array $a1 The first array.
 * @param array $a2 The second array.
 * @return array Returns the combined array.
 */
function array_add(array $a1, array $a2) {
	// add items in a1 that are also in a2
	foreach ($a1 as $key => $value) {
		if (array_key_exists($key, $a2)) {
			$a1[$key] = $a1[$key] + $a2[$key];
		}
	}
	
	// add items in a2 that are not in a1
	foreach ($a2 as $key=>$value) {
		if (!array_key_exists($key, $a1)) {
			$a1[$key] = $a2[$key];
		}
	}
	
	return $a1;
}

/**
 * @brief Un-quotes a quoted string recursivly.
 * @return mixed Returns Un-quoted string or array.
 * @param mixed $value The input string or array.
 */
if (!function_exists('stripslashes_deep')) { // keeps WordPress happy since it uses the same function
	function stripslashes_deep($value) {
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
		return $value;
	}
}

/**
 * @brief Returns a string with words removed from the end.
 * 
 * Removes all trailing whitespace as well.
 * 
 * @return string Returns string without word if found, original string otherwise.
 * @param string $str The string to manipulate.
 * @param string $word The word to remove.
 * @param bool $caseSensitive[optional] Use case sensitive searching.
 */
function rtrim_word($str, $word, $caseSensitive = true) {
	$str = rtrim($str);
	$word = rtrim($word);
	$strLen = strlen($str);
	$wordLen = strlen($word);
	
	if ($caseSensitive) {
		if (substr($str, $wordLen * -1) == $word) {
			return rtrim(substr($str, 0, $strLen - $wordLen));
		}
	} else {
		if (strtolower(substr($str, $wordLen * -1)) == strtolower($word)) {
			return rtrim(substr($str, 0, $strLen - $wordLen));
		}
	}
	
	return $str;
}

/**
 * @brief Returns a string with words removed from the begining.
 * 
 * Removes all proceding whitespace as well.
 * 
 * @return string Returns string without word if found, original string otherwise.
 * @param string $str The string to manipulate.
 * @param string $word The word to remove.
 * @param bool $caseSensitive[optional] Use case sensitive searching.
 */
function ltrim_word($str, $word, $caseSensitive = true) {
	$str = ltrim($str);
	$word = ltrim($word);
	$wordLen = strlen($word);
	
	if ($caseSensitive) {
		if (substr($str, 0, $wordLen) == $word) {
			return ltrim(substr($str, $wordLen));
		}
	} else {
		if (strtolower(substr($str, 0, $wordLen)) == strtolower($word)) {
			return ltrim(substr($str, $wordLen));
		}
	}
	
	return $str;
}

/**
 * @brief Fixes magic quotes if you them on (which you shouldn't).
 * @return void.
 */
function fix_magic_quotes() {
	if (get_magic_quotes_gpc()) {
		$_POST = array_map('stripslashes_deep', $_POST);
		$_GET = array_map('stripslashes_deep', $_GET);
		$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
		$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	}
}

/**
 * @brief Gets the include contents of a file.
 * @return string The contents.
 * @param string $filename The filename.
 */function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}

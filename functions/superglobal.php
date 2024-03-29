<?php
/* SVN FILE: $Id: superglobal.php 238 2009-06-19 19:57:50Z david@ramaboo.com $ */
/**
 * @brief Superglobal functions file.
 * 
 * This file provides superglobal functions used by Boo.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Returns a value from \c $GLOBALS.
 * @param string $key The key for array \c $GLOBALS.
 * @return mixed The value from \c $GLOBALS or FALSE if not found.
 */
function globals($key) {
	$key = (string) $key;
	if (isset($GLOBALS) && array_key_exists($key, $GLOBALS)) {
		return $GLOBALS[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_SERVER.
 * @param string $key The key for array \c $_SERVER.
 * @return mixed The value from \c $_SERVER or FALSE if not found.
 */
function _server($key) {
	$key = (string) $key;
	if (isset($_SERVER) && array_key_exists($key, $_SERVER)) {
		return $_SERVER[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_GET.
 * @param string $key The key for array \c $_GET.
 * @return mixed The value from \c $_GET or FALSE if not found.
 */
function _get($key) {
	$key = (string) $key;
	if (isset($_GET) && array_key_exists($key, $_GET)) {
		return $_GET[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_POST.
 * @param string $key The key for array \c $_POST.
 * @return mixed The value from \c $_POST or FALSE if not found.
 */
function _post($key) {
	$key = (string) $key;
	
	// remove [] from key
	if (substr($key, -2) == '[]') {
		$key = substr($key, 0, strlen($key) - 2);
	}
	
	$depth = explode('[', $key);
	// remove trailing bracket
	array_trim($depth, ']');
	
	// handle arrays
	if (isset($_POST)) {
		$postVar = $_POST;
		foreach ($depth as $key => $value) {
			if (array_key_exists($value, $postVar)) {
				$postVar = $postVar[$value];
			} else {
				return false;
			}
		}
		return $postVar;
	} else {
		return false;
	}
}


/**
 * @brief Returns a value from \c $_FILES.
 * @param string $key The key for array \c $_FILES.
 * @return mixed The value from \c $_FILES or FALSE if not found.
 */
function _files($key) {
	$key = (string) $key;
	if (isset($_FILES) && array_key_exists($key, $_FILES)) {
		return $_FILES[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_COOKIE.
 * @param string $key The key for array \c $_COOKIE.
 * @return mixed The value from \c $_COOKIE or FALSE if not found.
 */
function _cookie($key) {
	$key = (string) $key;
	if (isset($_COOKIE) && array_key_exists($key, $_COOKIE)) {
		return $_COOKIE[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_SESSION.
 * @param string $key The key for array \c $_SESSION.
 * @return mixed The value from \c $_SESSION or FALSE if not found.
 */
function _session($key) {
	$key = (string) $key;
	if (isset($_SESSION) && array_key_exists($key, $_SESSION)) {
		return $_SESSION[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_REQUEST.
 * @param string $key The key for array \c $_REQUEST.
 * @return mixed The value from \c $_REQUEST or FALSE if not found.
 */
function _request($key) {
	$key = (string) $key;
	if (isset($_REQUEST) && array_key_exists($key, $_REQUEST)) {
		return $_REQUEST[$key];
	} else {
		return false;
	}
}

/**
 * @brief Returns a value from \c $_ENV.
 * @param string $key The key for array \c $_ENV.
 * @return mixed The value from \c $_ENV or FALSE if not found.
 */
function _env($key) {
	$key = (string) $key;
	if (isset($_ENV) && array_key_exists($key, $_ENV)) {
		return $_ENV[$key];
	} else {
		return false;
	}
}

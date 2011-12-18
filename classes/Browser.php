<?php
/* SVN FILE: $Id: Browser.php 220 2009-03-30 14:59:19Z david@ramaboo.com $ */
/**
 * @brief Browser class.
 * 
 * Used for basic browser detection.
 * 
 * @class		Boo_Browser
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * 
 * @required Function <a href="http://us3.php.net/function.get-browser">get_browser</a>. \b Read the notes.
 * @see http://us3.php.net/function.get-browser
 * @see http://browsers.garykeith.com/downloads.asp
 * @see http://us3.php.net/manual/en/misc.configuration.php#ini.browscap
 */

class Boo_Browser {
	/**
	 * @brief Browser object.
	 * 
	 * This object is loaded by the cunstructor.
	 */
	protected static $browser;
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		self::start();
	}
	
	/**
	 * @breif Starts the Boo_Browser object.
	 * 
	 * Loads \c self::$browser. Called from \c Boo_Browser::__construct().
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function start() {
		
		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			trigger_error('No user agent, can not continue', E_USER_NOTICE);
			self::$browser = new Boo_Null;
			return false;
		}
		
		self::$browser = get_browser();
		
		if (!self::$browser) {
			trigger_error('Function get_browser() failed', E_USER_WARNING);
			self::$browser = new Boo_Null;
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * @brief Determins if the browser is in the IE family.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isIe() { return self::$browser->browser == 'IE'; }
	
	/**
	 * @brief Determins if the browser is IE 6.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isIe6() { return self::$browser->browser == 'IE' && self::$browser->majorver == 6; }
	
	/**
	 * @brief Determins if the browser is IE 7.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isIe7() { return self::$browser->browser == 'IE' && self::$browser->majorver == 7; }
	
	/**
	 * @brief Determins if the browser is IE 8.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isIe8() { return self::$browser->browser == 'IE' && self::$browser->majorver == 8; }
	
	/**
	 * @brief Determins if the browser is in the Firefox family.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isFirefox() { return self::$browser->browser == 'Firefox'; }
	
	/**
	 * @brief Determins if the browser is Firefox 2.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isFirefox2() { return self::$browser->browser == 'Firefox' && self::$browser->majorver == 2; }
	
	/**
	 * @brief Determins if the browser is Firefox 3.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isFirefox3() { return self::$browser->browser == 'Firefox' && self::$browser->majorver == 3; }
	
	/**
	 * @brief Determins if the browser is in the Opera family.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isOpera() { return self::$browser->browser == 'Opera'; }
	
	/**
	 * @brief Determins if the browser is Opera 9.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isOpera9() { return self::$browser->browser == 'Opera' && self::$browser->majorver == 9; }
	
	/**
	 * @brief Determins if the browser is in the Safari family.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isSafari() { return self::$browser->browser == 'Safari'; }
	
	/**
	 * @brief Determins if the browser is Safari 2.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isSafari2() { return self::$browser->browser == 'Safari' && self::$browser->majorver == 2; }
	
	/**
	 * @brief Determins if the browser is Safari 3.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isSafari3() { return self::$browser->browser == 'Safari' && self::$browser->majorver == 3; }
	
	/**
	 * @brief Determins if the browser is Chrome.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isChrome() { return self::$browser->browser == 'Chrome'; }
	
	/**
	 * @brief Returns a string representing the browser name.
	 * @return string The browser name.
	 */
	public static function getBrowserName() { return self::$browser->browser; }
	
	/**
	 * @brief Returns the browser object.
	 * @return object The browser object.
	 */
	public static function getBrowser() { return self::$browser; }
	
	/**
	 * @brief Returns the version number of the browser.
	 * @return string The version number.
	 */
	public static function getVersion() { return self::$browser->version; }
	
	/**
	 * @brief Returns the major version number of the browser.
	 * @return string The major version number.
	 */
	public static function getMajorVersion() { return self::$browser->majorver; }
	
	/**
	 * @brief Returns the minor version number of the browser.
	 * @return string The minor version number.
	 */
	public static function getMinorVersion() { return self::$browser->minorver; }
}

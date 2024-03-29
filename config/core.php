<?php
/* SVN FILE: $Id: core.php 221 2009-03-30 15:05:17Z david@ramaboo.com $ */
/**
 * @brief Core config file.
 * 
 * Contains default values for common Boo constants. You should override \c BOO_DEBUG and \c BOO_PRODUCTION.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Debug mode.
 * 
 * Set to FALSE in production environment.
 * 
 * @warning Enabling debug mode can cause sensitive information to be displayed. It should only be used in a private environment.
 */
if (!defined('BOO_DEBUG')) { define('BOO_DEBUG', true); }

/**
 * @brief Production mode.
 * 
 * Set to TRUE in production enviroment.
 * This will enable optimizing and other features that are not normaly done.
 */
if (!defined('BOO_PRODUCTION')) { define('BOO_PRODUCTION', false); }

/**
 * @brief The Boo version number.
 * 
 * You will probably not need to change this. Setting the wrong
 * version can cause weird things to happen.
 */
if (!defined('BOO_VERSION')) { define('BOO_VERSION', '2.0.0'); }

/**
 * @brief Your domain name.
 */
if (!defined('BOO_DOMAIN')) { define('BOO_DOMAIN', $_SERVER['HTTP_HOST']); }

/**
 * @brief Current scheme used.
 * 
 * You should not need to change this.
 */
if (!defined('BOO_SCHEME')) { define('BOO_SCHEME', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http')); }

/**
 * @brief Enable SSL support.
 */
if (!defined('BOO_SSL')) { define('BOO_SSL', BOO_PRODUCTION); }

/**
 * @brief Secret only known to a single installation.
 * This value is used as a salt for several hashing functions.
 */
if (!defined('BOO_SECRET')) { define('BOO_SECRET', 'LOTS_OF_RANDOM_CHARACTERS_HERE'); }

/**
 * @brief Allow classes to be overridden.
 * 
 * For example if TRUE and the class User exists then Boo_User would be replaced with
 * type User the Boo_Page object.
 * 
 * @attention Will not work with all classes. Boo_Dd can not be overriden.
 */
if (!defined('BOO_CLASS')) { define('BOO_CLASS', true); }

/**
 * @brief Use browser object.
 * 
 * Boo contains a usefully browser object which uses the function get_browser().
 * Because of the parsing time required this object can slow down an application so it is disabled by default.
 * To use it you must have browscap defined in your php.ini file.
 * 
 * @see http://php.net/manual/en/function.get-browser.php
 * @see http://www.php.net/manual/en/misc.configuration.php#ini.browscap
 * @see http://browsers.garykeith.com/downloads.asp
 */
if (!defined('BOO_BROWSER')) { define('BOO_BROWSER', false && ini_get('browscap')); } // makes sure that \c BOO_BROWSER will only be TRUE if browscap is defined in php.ini

/**
 * @brief Enable WordPress support.
 */
if (!defined('BOO_WORDPRESS')) { define('BOO_WORDPRESS', false); }

/**
 * @brief Allows anyone to access scripts located in the scripts folder.
 * 
 * @warning Setting this to TRUE is a huge security risk and should only
 * be done on test machines with limited access.
 * 
 * Used by the safe_scripts() function.
 */
if (!defined('BOO_ALLOW_SCRIPTS')) { define('BOO_ALLOW_SCRIPTS', false); }

/**
 * @brief Allows anyone to access tests located in the tests folder.
 * 
 * @warning Setting this to TRUE is a huge security risk and should only
 * be done on test machines with limited access.
 * 
 * Used by the safe_tests() function.
 */
if (!defined('BOO_ALLOW_TESTS')) { define('BOO_ALLOW_TESTS', false); }

/**
 * @brief Shows the pi.debugger on each page.
 * 
 * This is useful for testing on Internet Explore or other browsers when Firebug is not available.
 * 
 * @see http://code.google.com/p/pi-js/
 */
if (!defined('BOO_PI_DEBUGGER')) { define('BOO_PI_DEBUGGER', false); }

/**
 * @brief Show Firebug Lite on each page.
 * 
 * @see http://getfirebug.com/lite.html
 */
if (!defined('BOO_FIREBUG_LITE')) { define('BOO_FIREBUG_LITE', false); }

/**
 * @brief Automatically add clearfix class to html elements.
 */
if (!defined('BOO_CLEARFIX')) { define('BOO_CLEARFIX', true); }

/**
 * @brief Automatically fix magic quotes.
 */
if (!defined('BOO_FIX_MAGIC_QUOTES')) { define('BOO_FIX_MAGIC_QUOTES', true); }

/**
 * @brief Boo log file.
 */
if (!defined('BOO_LOG_FILE')) { define('BOO_LOG_FILE', BOO_BASE_DIR . '/log/boo.log'); } // needs write access

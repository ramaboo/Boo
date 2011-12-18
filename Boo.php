<?php
/* SVN FILE: $Id: Browser.php 180 2009-02-08 14:53:40Z david@ramaboo.com $ */
/**
 * @brief Boo core component.
 * 
 * Include this file with every page using Boo. This provides the nessesary bootstrapping to get Boo up and running.
 * 
 * You should define any configuration values you wish to override before including this file.
 * 
 * @code
 * require_once 'PATH_TO/Boo.php';
 * @endcode
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 * 
 * @todo		Cleanup file.
 */

/**
 * @brief Absolute path to base directory for Boo.
 */
if (!defined('BOO_BASE_DIR')) { define('BOO_BASE_DIR', dirname(__FILE__)); }

/**
 * @brief Autoload default configuration files.
 */
if (!defined('BOO_AUTOLOAD_CONFIG')) { define('BOO_AUTOLOAD_CONFIG', true); }

if (BOO_AUTOLOAD_CONFIG) {
	// load default configuration files
	require_once BOO_BASE_DIR . '/config/core.php'; // must go first (constants used in other files)
	require_once BOO_BASE_DIR . '/config/authorizenet.php';
	require_once BOO_BASE_DIR . '/config/db.php';
	require_once BOO_BASE_DIR . '/config/directories.php';
	require_once BOO_BASE_DIR . '/config/email.php';
	require_once BOO_BASE_DIR . '/config/error.php';
	require_once BOO_BASE_DIR . '/config/google.php';
	require_once BOO_BASE_DIR . '/config/html.php';
	require_once BOO_BASE_DIR . '/config/local.php';
	require_once BOO_BASE_DIR . '/config/qrbg.php';
	require_once BOO_BASE_DIR . '/config/regex.php';
	require_once BOO_BASE_DIR . '/config/sms.php';
	require_once BOO_BASE_DIR . '/config/twitter.php';

	if (BOO_WORDPRESS) {
		require_once BOO_BASE_DIR . '/config/wordpress.php';
	}
}

/**
 * @brief Autoload Swift Mailer files.
 */
if (!defined('BOO_AUTOLOAD_SWIFT')) { define('BOO_AUTOLOAD_SWIFT', true); }

if (BOO_AUTOLOAD_SWIFT) {
	// include required files for Swift Mailer
	require_once BOO_LIB_DIR . '/Swift.php';
	require_once BOO_LIB_DIR . '/Swift/Connection/SMTP.php';
	require_once BOO_LIB_DIR . '/Swift/Authenticator/LOGIN.php';
}

/**
 * @brief Autoload Smarty files.
 */
if (!defined('BOO_AUTOLOAD_SMARTY')) { define('BOO_AUTOLOAD_SMARTY', true); }

if (BOO_AUTOLOAD_SMARTY) {
	// include required files for Smarty
	require_once BOO_LIB_DIR . '/Smarty/Smarty.class.php';
}

/**
 * @brief Autoload Boo functions.
 */
if (!defined('BOO_AUTOLOAD_FUNCTIONS')) { define('BOO_AUTOLOAD_FUNCTIONS', true); }

if (BOO_AUTOLOAD_FUNCTIONS) {
	// include functions
	require_once BOO_BASE_DIR . '/functions/core.php';
	require_once BOO_BASE_DIR . '/functions/superglobal.php';
}

/**
 * @brief Autoload Boo classes.
 */
if (!defined('BOO_AUTOLOAD_CLASSES')) { define('BOO_AUTOLOAD_CLASSES', true); }

if (BOO_AUTOLOAD_CLASSES) {
	// include class loader
	require_once BOO_BASE_DIR . '/classes/ClassLoader.php';
	
	// load all classes
	Boo_ClassLoader::load('Boo_Html'); // must go first (base class)
	Boo_ClassLoader::load('Boo_Db'); // must go first (common class)
	Boo_ClassLoader::load('Boo_Io'); // must go first (common class)
	
	Boo_ClassLoader::load('Admin');
	Boo_ClassLoader::load('Boo_AuthorizeNet');
	
	if (BOO_BROWSER) {
		Boo_ClassLoader::load('Boo_Browser');
	} 
	
	//Boo_ClassLoader::load('Account');
	Boo_ClassLoader::load('Boo_Charset');
	Boo_ClassLoader::load('Boo_Csv');
	Boo_ClassLoader::load('Boo_Dialog');
	
	Boo_ClassLoader::load('Error');
	
	//Boo_ClassLoader::load('Feedback');
	Boo_ClassLoader::load('Boo_Format');
	//Boo_ClassLoader::load('Gallery');
	Boo_ClassLoader::load('Boo_Group');
	Boo_ClassLoader::load('Boo_Helper');
	Boo_ClassLoader::load('Boo_Log');
	Boo_ClassLoader::load('Boo_Lookup');
	Boo_ClassLoader::load('Boo_LoremIpsum');
	Boo_ClassLoader::load('Boo_Null');
	//Boo_ClassLoader::load('Image');
	//Boo_ClassLoader::load('ImageCollection');
	Boo_ClassLoader::load('Boo_Page');
	Boo_ClassLoader::load('Boo_Test');
	Boo_ClassLoader::load('Boo_Sms');
	Boo_ClassLoader::load('Boo_Qrbg');
	Boo_ClassLoader::load('Boo_Smarty');
	Boo_ClassLoader::load('Boo_Timer');
	Boo_ClassLoader::load('Boo_Twitter');
	Boo_ClassLoader::load('Boo_User');
	
	//Boo_ClassLoader::load('Sorter');
	//Boo_ClassLoader::load('Pager');
	//Boo_ClassLoader::load('Newsletter');
	
	Boo_ClassLoader::load('Validator');
}

if (BOO_FIX_MAGIC_QUOTES) {
	fix_magic_quotes();
}

<?php
/* SVN FILE: $Id: directories.php 251 2009-11-28 01:48:34Z david@ramaboo.com $ */
/**
 * @brief Directories config file.
 * 
 * Contains default values for direcotry related constants.
 * All directories should include a trailing slash.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Application directory.
 */
if (!defined('BOO_APP_DIR')) { define('BOO_APP_DIR', dirname(BOO_BASE_DIR)); }

/**
 * @brief Location of your XML files.
 */
if (!defined('BOO_XML_DIR')) { define('BOO_XML_DIR', BOO_BASE_DIR . '/xml'); }

/**
 * @brief Application webroot directory.
 */
if (!defined('BOO_WEBROOT_DIR')) { define('BOO_WEBROOT_DIR', BOO_APP_DIR . '/www'); }

/**
 * @brief Web accessible path to your Boo folder.
 */
if (!defined('BOO_BASE_DIR_HTML')) { define('BOO_BASE_DIR_HTML', BOO_SCHEME . '://' . BOO_DOMAIN . '/Boo-' . BOO_VERSION); }

/**
 * @brief Absolute path to lib directory.
 */
if (!defined('BOO_LIB_DIR')) { define('BOO_LIB_DIR', BOO_BASE_DIR . '/lib'); }

/**
 * @brief Path to your Boo CSS folder.
 */
if (!defined('BOO_CSS_DIR')) { define('BOO_CSS_DIR', BOO_BASE_DIR . '/css'); }

/**
 * @brief Web accessible path to your Boo CSS folder.
 */
if (!defined('BOO_CSS_DIR_HTML')) { define('BOO_CSS_DIR_HTML', BOO_BASE_DIR_HTML . '/css'); }

/**
 * @brief Path to your Boo JavaScript folder.
 */
if (!defined('BOO_JS_DIR')) { define('BOO_JS_DIR', BOO_BASE_DIR . '/js'); }

/**
 * @brief Web accessible path to your Boo JavaScript folder.
 */
if (!defined('BOO_JS_DIR_HTML')) { define('BOO_JS_DIR_HTML', BOO_BASE_DIR_HTML . '/js'); }

/**
 * @brief Absolute path to images folder.
 */
if (!defined('BOO_IMAGE_DIR')) { define('BOO_IMAGE_DIR', BOO_BASE_DIR . '/images'); }

/**
 * @brief  Web accessible path to your Boo images folder.
 */
if (!defined('BOO_IMAGE_DIR_HTML')) { define('BOO_IMAGE_DIR_HTML', BOO_BASE_DIR_HTML . '/images'); }

/**
 * @brief Smarty directory.
 * @see http://www.smarty.net/manual/en/installing.smarty.basic.php
 */
if (!defined('BOO_SMARTY_DIR')) { define('BOO_SMARTY_DIR', BOO_BASE_DIR . '/smarty'); }

<?php
/* SVN FILE: $Id: error.php 221 2009-03-30 15:05:17Z david@ramaboo.com $ */
/**
 * @brief Error config file.
 * 
 * Contains default values for error constants.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Location of your log file.
 */
if (!defined('BOO_ERROR_LOG_FILE')) { define('BOO_ERROR_LOG_FILE', BOO_BASE_DIR . '/log/error.log'); } // needs write access

/**
 * @brief PHP 5.3.x variable.
 */
if (!defined('E_DEPRECATED')) { define('E_DEPRECATED', 8192); }

/**
 * @brief PHP 5.3.x variable.
 */
if (!defined('E_USER_DEPRECATED')) { define('E_USER_DEPRECATED', 16384); }

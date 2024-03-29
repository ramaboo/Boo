<?php
/* SVN FILE: $Id: qrbg.php 196 2009-02-19 14:59:47Z david@ramaboo.com $ */
/**
 * @brief QRBG config file.
 * 
 * Contains default values for the Quantum Random Bit Generator Service constants.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Qrbg
 * @see			http://random.irb.hr/
 */

/**
 * @brief Your QRBG Service username.
 * @see http://random.irb.hr/signup.php
 * @since 2.0.0
 */
if (!defined('BOO_QRBG_USERNAME')) { define('BOO_QRBG_USERNAME', 'YOUR_USERNAME'); }

/**
 * @brief Your QRBG Service password.
 * @since 2.0.0
 */
if (!defined('BOO_QRBG_PASSWORD')) { define('BOO_QRBG_PASSWORD', 'YOUR_PASSWORD'); }

/**
 * @brief Path to qrand executable.
 * 
 * @see http://random.irb.hr/
 */
if (!defined('BOO_QRBG_CMD')) { define('BOO_QRBG_CMD', BOO_LIB_DIR . '/QRand/bin/./qrand'); } // include ./qrand

/**
 * @brief QRBG cache.
 * 
 * Using cache improves response time but requires MySQL and some additional setup.
 */
if (!defined('BOO_QRBG_CACHE')) { define('BOO_QRBG_CACHE', true); }

/**
 * @brief QRBG cache size.
 */
if (!defined('BOO_QRBG_CACHE_SIZE')) { define('BOO_QRBG_CACHE_SIZE', 100); }

<?php
/* SVN FILE: $Id: db.php 222 2009-04-02 09:33:06Z david@ramaboo.com $ */
/**
 * @brief Database config file.
 * 
 * Contains default values for database constants. You will need to override all of these.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Db
 */

/**
 * @brief Database connection string.
 * 
 * Use a PDO compatible connection string.
 */
if (!defined('BOO_DB_CONNECTION_STRING')) { define('BOO_DB_CONNECTION_STRING', 'mysql:host=localhost;dbname=YOUR_DB_NAME'); }

/**
 * @brief Database username.
 */
if (!defined('BOO_DB_USERNAME')) { define('BOO_DB_USERNAME', 'YOUR_USERNAME'); }

/**
 * @brief Database password.
 */
if (!defined('BOO_DB_PASSWORD')) { define('BOO_DB_PASSWORD', 'YOUR_PASSWORD'); }

/**
 * @brief The key used for \c MySQL AES_ENCRYPT and \c AES_DECRYPT.
 * 
 * @warning Be sure to change the default key.
 */
if (!defined('BOO_AES_KEY')) { define('BOO_AES_KEY', 'LOTS_OF_RANDOM_CHARACTERS_HERE'); }

/* You should not change anything below this line unless you are sure you know what your doing. */
/* If you do you will need to change your database setup. */

/**
 * @brief Empty group id.
 */
if (!defined('BOO_GROUP_EMPTY')) { define('BOO_GROUP_EMPTY', 0); }

/**
 * @brief Root group id.
 */
if (!defined('BOO_GROUP_ROOT')) { define('BOO_GROUP_ROOT', 1); }

/**
 * @brief Administrators group id.
 */
if (!defined('BOO_GROUP_ADMIN')) { define('BOO_GROUP_ADMIN', 2); }

/**
 * @brief User group id.
 */
if (!defined('BOO_GROUP_USER')) { define('BOO_GROUP_USER', 3); }

/**
 * @brief Anonymous group id.
 */
if (!defined('BOO_GROUP_ANONYMOUS')) { define('BOO_GROUP_ANONYMOUS', 4); }

/**
 * @brief Status is OK.
 */
if (!defined('BOO_STATUS_OK')) { define('BOO_STATUS_OK', 1); }

/**
 * @brief Status is closed.
 */
if (!defined('BOO_STATUS_CLOSED')) { define('BOO_STATUS_CLOSED', 0); }

/**
 * @brief Status is suspended.
 */
if (!defined('BOO_STATUS_SUSPENDED')) { define('BOO_STATUS_SUSPENDED', -1); }

/**
 * @brief Status is disabled.
 */
if (!defined('BOO_STATUS_DISABLED')) { define('BOO_STATUS_DISABLED', -2); }

/**
 * @brief Status is pending.
 */
if (!defined('BOO_STATUS_PENDING')) { define('BOO_STATUS_PENDING', -4); }

/**
 * @brief Status is unknown.
 */
if (!defined('BOO_STATUS_UNKNOWN')) { define('BOO_STATUS_UNKNOWN', -2147483648); }

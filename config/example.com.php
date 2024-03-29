<?php
/* SVN FILE: $Id: example.com.php 196 2009-02-19 14:59:47Z david@ramaboo.com $ */
/**
 * @brief Sample config file.
 * 
 * This is a sample configuration file for a typical setup (in this case for example.com).
 * There are many more possible configuration values. This file just covers the most common ones.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Your domain name.
 */
define('BOO_DOMAIN', 'YOUR_DOMAIN'); // example.com

/**
 * @brief Debug mode.
 * 
 * Set to FALSE in production environment.
 * 
 * @warning Enabling debug mode can cause sensitive information to be displayed. It should only be used in a private environment.
 */
define('BOO_DEBUG', true);

/**
 * @brief Production mode.
 * 
 * Set to TRUE in production enviroment.
 * This will enable optimizing and other features that are not normaly done.
 */
define('BOO_PRODUCTION', false);

/**
 * @brief Database connection string.
 * 
 * Use a PDO compatible connection string.
 */
define('BOO_DB_CONNECTION_STRING', 'mysql:host=localhost;dbname=YOUR_DB_NAME');

/**
 * @brief Database username.
 */
define('BOO_DB_USERNAME', 'YOUR_USERNAME');

/**
 * @brief Database password.
 */
define('BOO_DB_PASSWORD', 'YOUR_PASSWORD');

/**
 * @brief The key used for \c MySQL AES_ENCRYPT and \c AES_DECRYPT.
 * 
 * @warning Be sure to change the default key.
 */
define('BOO_AES_KEY', 'LOTS_OF_RANDOM_CHARACTERS_HERE');

/**
 * @brief SMTP server address.
 */
define('BOO_SMTP_SERVER', 'YOUR_SMTP_SERVER'); // Gmail uses smtp.gmail.com

/**
 * @brief SMTP server port.
 */
define('BOO_SMTP_PORT', 25); // Gmail uses 465

/**
 * @brief SMTP server username.
 */
define('BOO_SMTP_USERNAME', 'YOUR_USERNAME');

/**
 * @brief SMTP server password.
 */
define('BOO_SMTP_PASSWORD', 'YOUR_PASSWORD');

/**
 * @brief SMTP server encryption.
 * 
 * \li 2 = TLS
 * \li 4 = SSL
 * \li 8 = Unencrypted
 */
define('BOO_SMTP_ENC', 8); // Gmail uses 4

<?php
/* SVN FILE: $Id: db.php 196 2009-02-19 14:59:47Z david@ramaboo.com $ */
/**
 * @brief WordPress config file.
 * 
 * Contains default values for WordPress.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			http://wordpress.org/
 */

/**
 * @brief The name of the database for WordPress.
 */
if (!defined('DB_NAME')) { define('DB_NAME', 'YOUR_DB_NAME'); }

/**
 * @brief MySQL database username.
 */
if (!defined('DB_USER')) { define('DB_USER', BOO_DB_USERNAME); }

/**
 * @brief MySQL database password.
 */
if (!defined('DB_PASSWORD')) { define('DB_PASSWORD', BOO_DB_PASSWORD); }

/**
 * @brief MySQL hostname.
 */
if (!defined('DB_HOST')) { define('DB_HOST', 'localhost'); }

/**
 * @brief Database charset.
 */
if (!defined('DB_CHARSET')) { define('DB_CHARSET', 'utf8'); }

/**
 * @brief Database collate type.
 * 
 * Leave blank.
 */
if (!defined('DB_COLLATE')) { define('DB_COLLATE', ''); }

/**
 * @brief Authentication unique keys.
 * 
 * Automatically generated. You can change them if you want.
 * 
 * @link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service
 * @since WordPress 2.6.0
 */
if (!defined('AUTH_KEY')) { define('AUTH_KEY', hash('sha256', 'AUTH_KEY' . BOO_SECRET)); }
if (!defined('SECURE_AUTH_KEY')) { define('SECURE_AUTH_KEY', hash('sha256', 'SECURE_AUTH_KEY' . BOO_SECRET)); }
if (!defined('LOGGED_IN_KEY')) { define('LOGGED_IN_KEY', hash('sha256', 'LOGGED_IN_KEY' . BOO_SECRET)); }
if (!defined('NONCE_KEY')) { define('NONCE_KEY', hash('sha256', 'NONCE_KEY' . BOO_SECRET)); }

// WordPress database table prefix
if (!isset($table_prefix)) { $table_prefix = 'wp_'; }

/**
 * @brief WordPress localized language, defaults to English.
 */
if (!defined('WPLANG')) { define ('WPLANG', ''); }

/**
 * @biref WordPress absolute path to the Wordpress directory.
 */
if (!defined('ABSPATH')) { define('ABSPATH', BOO_APP_DIR . '/www/wordpress/'); }

/**
 * @brief Wordpress debug mode.
 */
if (!defined('WP_DEBUG')) { define('WP_DEBUG', BOO_DEBUG); }


// sets up WordPress vars and included files
require_once(ABSPATH . 'wp-settings.php');

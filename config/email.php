<?php
/* SVN FILE: $Id: email.php 181 2009-02-08 15:23:14Z david@ramaboo.com $ */
/**
 * @brief Email config file.
 * 
 * Contains default values for email constants.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief SMTP server address.
 */
if (!defined('BOO_SMTP_SERVER')) { define('BOO_SMTP_SERVER', 'smtp.' . BOO_DOMAIN); } // Gmail uses smtp.gmail.com

/**
 * @brief SMTP server port.
 */
if (!defined('BOO_SMTP_PORT')) { define('BOO_SMTP_PORT', 25); } // Gmail uses 465

/**
 * @brief SMTP server username.
 */
if (!defined('BOO_SMTP_USERNAME')) { define('BOO_SMTP_USERNAME', 'YOUR_USERNAME'); }

/**
 * @brief SMTP server password.
 */
if (!defined('BOO_SMTP_PASSWORD')) { define('BOO_SMTP_PASSWORD', 'YOUR_PASSWORD'); }

/**
 * @brief SMTP server encryption.
 * 
 * \li 2 = TLS
 * \li 4 = SSL
 * \li 8 = Unencrypted
 */
if (!defined('BOO_SMTP_ENC')) { define('BOO_SMTP_ENC', 8); } // Gmail uses 4

/**
 * @brief SMS email address.
 * @see sms.php
 */

/**
 * @brief Error email address.
 */
if (!defined('BOO_ERROR_EMAIL')) { define('BOO_ERROR_EMAIL', 'error@' . BOO_DOMAIN); }

/**
 * @brief Bug report email address.
 */
if (!defined('BOO_BUGREPORT_EMAIL')) { define('BOO_BUGREPORT_EMAIL', 'bugs@' . BOO_DOMAIN); }

/**
 * @brief To email address.
 */
if (!defined('BOO_TO_EMAIL')) { define('BOO_TO_EMAIL', 'support@' . BOO_DOMAIN); }

/**
 * @brief From email address.
 */
if (!defined('BOO_FROM_EMAIL')) { define('BOO_FROM_EMAIL', 'support@' . BOO_DOMAIN); }

/**
 * @brief BCC email address.
 */
if (!defined('BOO_BCC_EMAIL')) { define('BOO_BCC_EMAIL', 'bcc@' . BOO_DOMAIN); }

/**
 * @brief No reply email address.
 */
if (!defined('BOO_NOREPLY_EMAIL')) { define('BOO_NOREPLY_EMAIL', 'noreply@' . BOO_DOMAIN); }

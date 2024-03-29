<?php
/* SVN FILE: $Id: sms.php 196 2009-02-19 14:59:47Z david@ramaboo.com $ */
/**
 * @brief SMS config file.
 * 
 * Contains default values for SMS constants.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief SMS email address.
 */
if (!defined('BOO_SMS_EMAIL')) { define('BOO_SMS_EMAIL', 'sms@' . BOO_DOMAIN); }

/**
 * @brief SMS phone number.
 */
if (!defined('BOO_SMS_PHONE_NUMBER')) { define('BOO_SMS_PHONE_NUMBER', 0); }

/**
 * @brief SMS carrier id.
 * @see Boo_Sms
 */
if (!defined('BOO_SMS_CARRIER_ID')) { define('BOO_SMS_CARRIER_ID', 0); }

/**
 * @brief Send error messages via SMS.
 * @see Boo_Error
 */
if (!defined('BOO_SMS_ERROR')) { define('BOO_SMS_ERROR', BOO_SMS_CARRIER_ID && BOO_SMS_PHONE_NUMBER); }

/**
 * @brief Maximum lenght of SMS subject.
 * 
 * Some carriers limit the subject to 20 characters. This limit is not enforced its only used to generate warnings.
 */
if (!defined('BOO_SMS_MAX_SUBJECT_LENGTH')) { define('BOO_SMS_MAX_SUBJECT_LENGTH', 20); }

/**
 * @brief Maximum length of SMS body.
 * 
 * Some carriers limit the body to 140 characters. This limit is not enforced its only used to generate warnings.
 */
if (!defined('BOO_SMS_MAX_BODY_LENGTH')) { define('BOO_SMS_MAX_BODY_LENGTH', 140); }
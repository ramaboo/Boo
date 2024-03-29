<?php
/* SVN FILE: $Id: regex.php 214 2009-03-02 07:44:12Z david@ramaboo.com $ */
/**
 * @brief Regular expression config file.
 * 
 * Contains default values for regular expression constants.
 * You probably wont have to override any of these.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

/**
 * @brief Regular expression for email validation.
 * 
 * This regular expression is farily good and will catch most real world emails.
 * It is not 100% compatible with RFC 2822.
 * 
 * @see http://www.faqs.org/rfcs/rfc2822.html
 */
if (!defined('BOO_REGEX_EMAIL')) { define('BOO_REGEX_EMAIL', '/^[a-zA-Z0-9\._%\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,6}$/'); }

/**
 * @brief Regular expression for URL validation.
 * 
 * @todo Provide support for additional protocols.
 */
if (!defined('BOO_REGEX_URL')) { define('BOO_REGEX_URL', '/^((http(s?):\/\/)?)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/.*)?$/ix'); }

/**
 * @brief Regular expression for URI validation.
 * 
 * @todo Provide support for additional protocols.
 */
if (!defined('BOO_REGEX_URI')) { define('BOO_REGEX_URI', '/^((http(s?):\/\/)?)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/\.*)?$/ix'); }

/**
 * @brief Regular expression for ZIP code validation.
 * 
 * @todo Support non US formats.
 */
if (!defined('BOO_REGEX_ZIP')) { define('BOO_REGEX_ZIP', '/(^[0-9]{5}$)|(^[0-9]{9}$)|(^[0-9]{5}\-[0-9]{4}$)/'); }

/**
 * @brief Regular expression for dates.
 * 
 * Possible formats:
 * \li MM/DD/YYYY
 * \li MM-DD-YYYY
 * 
 * Leading zero is optional on month and day.
 * Minimum date is 1900. Maximum date is 2099
 */
if (!defined('BOO_REGEX_DATE')) { define('BOO_REGEX_DATE', '/^([1-9]|0[1-9]|1[012])[\-\/]([1-9]|0[1-9]|[12][0-9]|3[01])[\-\/](19|20)\d\d$/'); }

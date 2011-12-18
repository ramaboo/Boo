<?php
/* SVN FILE: $Id: authorizenet.php 181 2009-02-08 15:23:14Z david@ramaboo.com $ */
/**
 * @brief Authorize.Net config file.
 * 
 * Contains default values for Authorize.Net constants. You will need to override all of these if you use Authorize.Net.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_AuthorizeNet
 */

/**
 * @brief Authorize.Net API Login ID.
 * 
 * \b Important the API Login ID is a sensitive piece of account information and should only be shared on a need-to-know basis.
 * 
 * @see http://www.authorize.net/support/Merchant/Integration_Settings/Access_Settings.htm
 */
if (!defined('BOO_AUTHORIZE_NET_LOGIN_ID')) { define('BOO_AUTHORIZE_NET_LOGIN_ID', 'YOUR_LOGIN_ID'); }

/**
 * @brief Authorize.Net Transaction Key.
 * 
 * \b Important the Transaction Key is a sensitive piece of account information that should only be shared on a need-to-know basis.
 * 
 * @see http://www.authorize.net/support/Merchant/Integration_Settings/Access_Settings.htm
 */
if (!defined('BOO_AUTHORIZE_NET_TRAN_KEY')) { define('BOO_AUTHORIZE_NET_TRAN_KEY', 'YOUR_TRAN_KEY'); }

/**
 * @brief Defines the default mode for Authorize.Net.
 * 
 * Set to 'live' to proccess transactions.
 * Using 'certification' will often yeild better results than 'test'.
 * 
 * @warning If you recieve error 13 try Boo_AuthorizeNet::testRequest() in live mode.
 * 
 * @see Boo_AuthorizeNet::setMode();
 */
if (!defined('BOO_AUTHORIZE_NET_DEFAULT_MODE')) { define('BOO_AUTHORIZE_NET_DEFAULT_MODE', 'certification'); }

/**
 * @brief Authorize.Net MD5 hash.
 * Set in your merchant interface (Account -> Settings -> MD5-Hash).
 * Unless you using Boo_AuthorizeNet::checkMd5() then you can safely leave this blank.
 */
if (!defined('BOO_AUTHORIZE_NET_MD5')) { define('BOO_AUTHORIZE_NET_MD5', ''); }

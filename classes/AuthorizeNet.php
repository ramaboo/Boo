<?php
/* SVN FILE: $Id: AuthorizeNet.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Authorize.Net class.
 * 
 * Implements the Authorize.Net AIM connection method.
 * 
 * Test credit card numbers.
 * \li 370000000000002		= American Express.
 * \li 6011000000000012		= Discover.
 * \li 5424000000000015		= MasterCard.
 * \li 4007000000027		= Visa.
 * \li 4222222222222		= Test account, set amount to desired response reason code.
 * 
 * The following constants must be defined:
 * \li \c BOO_AUTHORIZE_NET_LOGIN_ID = Your Authorize.Net API Login ID.
 * \li \c BOO_AUTHORIZE_NET_TRAN_KEY = Your Authorize.Net Transaction Key.
 * \li \c BOO_AUTHORIZE_NET_DEFAULT_MODE = The Authorize.Net default mode (set to 'live', 'test', or 'certification').
 * \li \c BOO_AUTHORIZE_NET_MD5 = Your Authorize.Net MD5 hash, leave blank if your not sure.
 * 
 * @class		Boo_AuthorizeNet
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @required	http://curl.haxx.se/ cURL version 7.15.0 or greater. SSL support must be \b enabled.
 * @see			http://ramaboo.com/code/authorizenet/ Advanced Integration Method (AIM) Developer Guide
 * @see			http://www.authorize.net/support/aim_guide.pdf
 * @see			http://curl.haxx.se/docs/install.html
 */

class Boo_AuthorizeNet {
	
	/**
	 * @brief Fields array.
	 */
	protected $fields = array();
	
	/**
	 * @brief Response.
	 * See AIM guide.
	 */
	protected $response = '';
	
	/**
	 * @brief Response code.
	 * @see Boo_AuthorizeNet::getResponseCode()
	 */
	protected $responseCode = 0;
	
	/**
	 * @breif Response subcode.
	 * See AIM guide.
	 */
	protected $responseSubcode = 0;
	
	/**
	 * @brief Response resone code.
	 * See AIM guide.
	 */
	protected $responseReasonCode = 0;
	
	/**
	 * @brief Response resone text.
	 * See AIM guide.
	 */
	protected $responseReasonText = '';
	
	/**
	 * @brief Approval code.
	 * See AIM guide.
	 */
	protected $approvalCode = '';
	
	/**
	 * @brief AVS result code.
	 * @see Boo_AuthorizeNet::getAvsResultCode()
	 */
	protected $avsResultCode = '';
	
	/**
	 * @brief Transaction identifier.
	 * 
	 * 10 digit string.
	 * @warning Do not store as INT. Value can be greater than 2147483647 or 4294967295. BIGINT or CHAR(10) are safe.
	 */
	protected $transactionId = '';
	
	/**
	 * @brief MD5 hash of transaction.
	 */
	protected $md5Hash = '';
	
	/**
	 * @brief Card code response code.
	 * @see Boo_AuthorizeNet::getCardCodeResponseCode()
	 */
	protected $cardCodeResponseCode = '';
	
	/**
	 * @brief CAVV response code.
	 * @see Boo_AuthorizeNet::getCavvResponseCode()
	 */
	protected $cavvResponseCode = '';
	
	/**
	 * @brief Transaction mode.
	 * @see Boo_AuthorizeNet::setMode();
	 */
	protected $mode = 'live';
	
	/**
	 * @brief Transaction URL.
	 * Must be secure!
	 */
	protected $url = 'https://secure.authorize.net/gateway/transact.dll';
	
	/**
	 * @brief Array of expiration date months.
	 */
	protected static $expDateMonths = array(
		'01' => '01', '02' => '02', '03' => '03', '04' => '04',
		'05' => '05', '06' => '06', '07' => '07', '08' => '08',
		'09' => '09', '10' => '10', '11' => '11', '12' => '12');
	
	/**
	 * @brief Array of expiration date years.
	 */
	protected static $expDateYears = array(
		'09' => '2009', '10' => '2010', '11' => '2011', '12' => '2012',
		'13' => '2013', '14' => '2014', '15' => '2015', '16' => '2016',
		'17' => '2017', '18' => '2018', '19' => '2019', '20' => '2020',
		'21' => '2021', '22' => '2022', '23' => '2023', '24' => '2024',
		'25' => '2025', '26' => '2026', '27' => '2027', '28' => '2028');
	
	/**
	 * @brief Array of card types.
	 */
	protected static $cardTypes = array(
		'v' => 'Visa',
		'm' => 'MasterCard',
		'a' => 'American Express',
		'd' => 'Discover');
	
	/**
	 * @brief Loads default values.
	 * @return void.
	 */
	public function __construct() {
		// defaults
		$this->fields = array(
			'x_login' => BOO_AUTHORIZE_NET_LOGIN_ID,
			'x_version' => '3.1',
			'x_delim_char' => '|',
			'x_encap_char' => '"',
			'x_delim_data' => 'TRUE',
			'x_type' => 'AUTH_CAPTURE', // AUTH_CAPTURE, AUTH_ONLY, CAPTURE_ONLY, CREDIT, VOID, PRIOR_AUTH_CAPTURE
			'x_method' => 'CC',
			'x_tran_key' => BOO_AUTHORIZE_NET_TRAN_KEY,
			'x_relay_response' => 'FALSE');
		
		$this->setMode(BOO_AUTHORIZE_NET_DEFAULT_MODE);
	}
	
	/**
	 * @brief Get expiration date months.
	 * 
	 * @return array Returns expiration date months, key is 2 digit month, value is 2 digit month.
	 */
	public static function getExpDateMonths() { return self::$expDateMonths; }
	
	/**
	 * @brief Get the expiration date years.
	 * 
	 * @return array Returns expiration date years, key is 2 digit year, value is 4 digit year.
	 */
	public static function getExpDateYears() { return self::$expDateYears; }
	
	/**
	 * @brief Gets the card types.
	 * 
	 * @return array Returns card types, key is a single letter, value is common name.
	 */
	public static function getCardTypes() { return self::$cardTypes; }
	
	/**
	 * @breif Sets the mode.
	 * 
	 * Posible values are:
	 * \li live = For production use.
	 * \li test = Test mode.
	 * \li certification = Certification mode.
	 * 
	 * @param string $mode The mode. 
	 * @return bool Returns TURE if mode was set, FALSE otherwise.
	 * @warning Test mode and certification mode can cause problems try Boo_AuthorizeNet::testRequest()
	 * if you recieve error 13.
	 * 
	 */
	public function setMode($mode) {
		$mode = trim(strtolower($mode));
		switch ($mode) {
			case 'test':
				$this->url = 'https://test.authorize.net/gateway/transact.dll';
				break;
			case 'live':
				$this->url = 'https://secure.authorize.net/gateway/transact.dll';
				break;
			case 'certification':
				$this->url = 'https://certification.authorize.net/gateway/transact.dll';
				break;
			default:
				trigger_error("Mode {$mode} is not valid", E_USER_ERROR);
				return false;
		}
		$this->mode = $mode;
		return true;
	}
	
	/**
	 * @brief Gets the current mode.
	 * @return string The mode.
	 */
	public function getMode() { return $this->mode; }
	
	/**
	 * @brief Gets the current URL.
	 * @return string The URL.
	 */
	public function getUrl() { return $this->url; }
	
	/**
	 * @brief Gets the MD5 hash.
	 * @return string The MD5 hash.
	 */
	public function getMd5Hash() { return $this->md5Hash; }
	
	/**
	 * Checks the gateway MD5 response to make sure that it is correct.
	 * 
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function checkMd5 () {
		if (!$this->md5Hash) {
			trigger_error('MD5 hash can not be false', E_USER_WARNING);
			return false;
		}
		
		if (!BOO_AUTHORIZE_NET_MD5) {
			trigger_error('BOO_AUTHORIZE_NET_MD5 can not be false', E_USER_ERROR);
			return false;
		}
		
		if (!$this->transactionId) {
			trigger_error('Transaction ID can not be false', E_USER_WARNING);
			return false;
		}
		
		$amount = $this->getField('x_amount');
		if (!$amount) {
			trigger_error('Amount can not be false', E_USER_WARNING);
			return false;
		}
		
		$result = strtoupper(md5(BOO_AUTHORIZE_NET_MD5 . BOO_AUTHORIZE_NET_LOGIN_ID . $this->transactionId . $amount));
		return $result == $this->md5Hash;
	}
	
	
	/**
	 * @brief The gateway response.
	 * @return string The gateway response.
	 */
	public function getResponse() { return $this->response; }
	
	/**
	 * @brief Indicates the result of the transaction.
	 * 
	 * Posible values are:
	 * \li 0 = Response code is not yet set.
	 * \li 1 = This transaction has been approved.
	 * \li 2 = This transaction has been declined.
	 * \li 3 = There has been an error processing this transaction.
	 * \li 4 = This transaction is being held for review.
	 * 
	 * @return int The response code.
	 */
	public function getResponseCode() { return (int) $this->responseCode; }
	
	/**
	 * @brief Returns the word associated with the response code.
	 * 
	 * Possible return values are:
	 * \li unset
	 * \li approved
	 * \li declined
	 * \li error
	 * \li held
	 * 
	 * @return string The word associated with the response code (lowercase), FALSE on failure.
	 */
	public function getResponseCodeWord() {
		$code = $this->getResponseCode();
		switch ($code) {
			case 0:
				$word = 'unset';
				break;
			case 1:
				$word = 'approved';
				break;
			case 2:
				$word = 'declined';
				break;
			case 3:
				$word = 'error';
				break;
			case 4:
				$word = 'held';
				break;
			default:
				trigger_error("Response code {$code} is not valid", E_USER_ERROR);
				return false;
		}
		
		return $word;
	}
	
	/**
	 * @brief Determins if transaction is approved.
	 * @return bool Returns TRUE if approved, FALSE otherwise.
	 */
	public function isApproved() { return $this->responseCode == 1; }
	
	/**
	 * @brief Determins if transaction is declined.
	 * @return bool Returns TURE if declined, FALSE otherwise.
	 */
	public function isDeclined() { return $this->responseCode == 2; }
	
	/**
	 * @brief Determins if transaction caused an error.
	 * @return bool Returns TRUE if error, FALSE otherwise.
	 */
	public function isError() { return $this->responseCode == 3; }
	
	/**
	 * @brief Determins if transaction is being held for review.
	 * @return bool Returns TRUE if transaction is on hold, FALSE otherwise.
	 */
	public function isHold() { return $this->responseCode == 4; }
	
	/**
	 * @brief A code used by the system for internal transaction tracking.
	 * @return int The response subcode.
	 */
	public function getResponseSubcode() { return (int) $this->responseSubcode; }
	
	/**
	 * @brief A code representing details about the transaction.
	 * @return int The response reason code.
	 */
	public function getResponseReasonCode() { return (int) $this->responseReasonCode; }
	
	/**
	 * @brief Brief description of the result.
	 * @return int The response reason text.
	 */
	public function getResponseReasonText() { return $this->responseReasonText; }
	
	/**
	 * @brief The six-digit alphanumeric approval code.
	 * @return string The approval code.
	 */
	public function getApprovalCode() { return $this->approvalCode; }
	
	/**
	 * @brief Indicates the result of AVS.
	 * 
	 * Posible values are:
	 * \li A = Address (Street) matches, ZIP does not.
	 * \li B = Address information not provided for AVS check.
	 * \li E = AVS error.
	 * \li G = Non-U.S. Card Issuing Bank.
	 * \li N = No Match on Address (Street) or ZIP.
	 * \li P = AVS not applicable for this transaction.
	 * \li R = Retry - System unavailable or timed out.
	 * \li S = Service not supported by issuer.
	 * \li U = Address information is unavailable.
	 * \li W = 9 digit ZIP matches, Address (Street) does not.
	 * \li X = Address (Street) and 9 digit ZIP match.
	 * \li Y = Address (Street) and 5 digit ZIP match.
	 * \li Z = 5 digit ZIP matches, Address (Street) does not.
	 * 
	 * @return string AVS result code.
	 */
	public function getAvsResultCode() { return $this->avsResultCode; }
	
	/**
	 * @brief The transaction identification number.
	 * 
	 * 10 digit number.
	 * @return string The transaction id.
	 */
	public function getTransactionId() { return $this->transactionId; }
	
	/**
	 * @brief Indicates results of card code verification
	 * 
	 * Posible values are:
	 * \li M = Match.
	 * \li N = No match.
	 * \li P = Not processed.
	 * \li S = Should have been present.
	 * \li U = Issuer unable to process request.
	 * 
	 * @return string The card code response code.
	 */
	public function getCardCodeResponseCode() { return $this->cardCodeResponseCode; }
	
	/**
	 * @brief Indicates the results of cardholder authentication verification.
	 *
	 * Posible values are:
	 * \li null (or empty string) = CAVV not validated.
	 * \li 0 = CAVV not validated because erroneous data was submitted.
	 * \li 1 = CAVV failed validation.
	 * \li 2 = CAVV passed validation.
	 * \li 3 = CAVV validation could not be performed; issuer attempt incomplete.
	 * \li 4 = CAVV validation could not be performed; issuer system error.
	 * \li 5 = Reserved for future use.
	 * \li 6 = Reserved for future use.
	 * \li 7 = CAVV attempt - failed validation - issuer available (U.S.-issued card/non-U.S acquirer).
	 * \li 8 = CAVV attempt - passed validation - issuer available (U.S.-issued card/non-U.S. acquirer).
	 * \li 9 = CAVV attempt - failed validation - issuer unavailable (U.S.-issued card/non-U.S. acquirer).
	 * \li A = CAVV attempt - passed validation - issuer unavailable (U.S.-issued card/non-U.S. acquirer).
	 * \li B = CAVV passed validation, information only, no liability shift.
	 * 
	 * @return string The cardholder authentication verification value response code.
	 */
	public function getCavvResponseCode() { return $this->cavvResponseCode; }
	
	/**
	 * @brief Sets field value.
	 * 
	 * @param string $name The field name.
	 * @param string $value The field value.
	 * @return bool Returns TRUE if successful, FALSE otherwise. 
	 */
	public function setField($name, $value) {
		if (strstr($name, '|')) {
			trigger_error('Name can not contain the pipe character', E_USER_WARNING);
			return false;
		}
		
		if (is_array($value)) {
			// $value is array convert to string
			$value = serialize($value);
		}
		
		if (strstr($value, '|')) {
			trigger_error('Value can not contain the pipe character', E_USER_WARNING);
			return false;
		}
		
		$this->fields[$name] = $value;
		return true;
	}
	
	/**
	 * @brief Returns the field value.
	 * 
	 * @param string $name The field name.
	 * @return bool The field value if successful, FALSE otherwise.
	 */
	public function getField($name) {
		if (array_key_exists($name, $this->fields)) {
			return $this->fields[$name];
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Returns fields in field-value pairs.
	 * @returns string The fields in field-value pairs. 
	 */
	public function getFieldsEncoded() {
		$tmp = '';
		foreach($this->fields as $key => $value) {
			$tmp .= "{$key}=" . urlencode($value) . '&';
		}
		$tmp = rtrim($tmp, '&');
		return $tmp;
	}
	
	/**
	 * @brief Sends the request to Authorize.Net.
	 * 
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 */
	public function send() {
		$ch = curl_init(); 
		
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // returns response data instead of TRUE
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getFieldsEncoded());
		
		// uncomment the following line if you get no gateway response
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		$this->response = curl_exec($ch); //execute post and get results
		
		$error = curl_error($ch);
		if ($error) {
			trigger_error($error, E_USER_ERROR);
			return false;
		}
		
		curl_close ($ch);
		
		// parse response
		$responseFields = explode('|', $this->response);
		
		// strip quotes
		foreach ($responseFields as $key => $value) {
			$responseFields[$key] = substr($value, 1, strlen($value) - 2);
		}
		
		// set variables
		$this->responseCode = $responseFields[0];
		$this->responseSubcode = $responseFields[1];
		$this->responseReasonCode = $responseFields[2];
		$this->responseReasonText = $responseFields[3];
		$this->approvalCode = ($responseFields[4] == '000000') ? '' : $responseFields[4]; // replace 000000 with empty string
		$this->avsResultCode = $responseFields[5];
		$this->transactionId = $responseFields[6];
		$this->md5Hash = $responseFields[37];
		$this->cardCodeResponseCode = $responseFields[38];
		$this->cavvResponseCode = $responseFields[39];
		
		return true;
	}
	
	/**
	 * @brief Loads values from \c $_POST.
	 * 
	 * @return int Returns number of values loaded, 0 if nothing was loaded.
	 */
	public function loadPost() {
		$count = 0;
		if (!isset($_POST)) {
			trigger_error('Superglobal $_POST is not set', E_USER_WARNING);
		}
		
		foreach ($_POST as $key => $value) {
			$this->setField($key, $value);
			$count++;
		}
		return $count;
	}
	
	/**
	 * @brief Sets the request to test mode.
	 * @return bool Function always returns TRUE.
	 * @param bool $value[optional] Set to TRUE for test mode, FALSE for normal mode.
	 */
	public function testRequest($value = true) {
		if ($value) {
			$this->setField('x_test_request', 'TRUE');
		} else {
			$this->setField('x_test_request', 'FALSE');
		}
		return true;
	}
	
	/**
	 * @brief Returns HTML test form.
	 * 
	 * This function is usefully for generating a simple HTML form for testing 
	 * Authorize.Net transactions. This form should only be used for testing purposes and is not secure.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @return Boo_Html_Form  The HTML form on success, FALSE otherwise.
	 */
	public function htmlTestForm(array $attrs = array()) {
		$form = new Boo_Html_Form;
		$form->applyAttrs($attrs);
		
		$ol = new Boo_Html_Ul;
		
		foreach ($this->fields as $key => $value) {
			$tmpLi = new Boo_Html_Li;
			$tmpLi->setContent("<label for\"{$key}\">{$key}</label><input type=\"text\" name=\"{$key}\" value=\"{$value}\"/>");
			$ol->addLi($tmpLi);
		}
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<input class="button button-submit" type="submit" value="Submit" /></li>');
		$ol->addLi($tmpLi);
		
		$form->setAttr('action', $this->url);
		$form->setContent($ol->html());
		return $form;
	}
	
	/**
	 * @brief Gets the results as a HTML unordred list.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @param bool $debug[optional] Debug mode.
	 * @return Boo_Html_Ul The results link as a HTML unordred list, FALSE on failure.
	 * @warning This method will display sensitive information including everything sent to Authorize.Net. Be careful how you use it!
	 */
	public function htmlResultsUl(array $attrs = array(), $debug = BOO_DEBUG) {
		if (BOO_PRODUCTION) {
			trigger_error('Function is not available in production mode, set BOO_PRODUCTION to false', E_USER_ERROR);
			return false;
		}
		
		$ul = new Boo_Html_Ul;
		$ul->applyAttrs($attrs);
		
		if ($this->getResponseCode() == 3 && $this->getResponseReasonCode() == 13) {
			trigger_error('Try Boo_AuthorizeNet::testRequest() in live mode', E_USER_WARNING);
			// do not return false
		}
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Transaction ID</b>: ' . $this->getTransactionId());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Response Code</b>: ' . $this->getResponseCode() . " " . strtoupper($this->getResponseCodeWord()));
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Response Subcode</b>: ' . $this->getResponseSubcode());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Response Reason Code</b>: ' . $this->getResponseReasonCode() . ' ' . $this->getResponseReasonText());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Approval Code</b>: ' . $this->getApprovalCode());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>AVS Result Code</b>: ' . $this->getAvsResultCode());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>MD5 Hash</b>: ' . $this->getMd5Hash());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Card Code Response Code</b>: ' . $this->getCardCodeResponseCode());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>CAVV Response Code</b>: ' . $this->getCavvResponseCode());
		$ul->addLi($tmpLi);
		
		$tmpLi = new Boo_Html_Li;
		$tmpLi->setContent('<b>Mode</b>: ' . strtoupper($this->getMode()) . ' ' . $this->getUrl());
		$ul->addLi($tmpLi);
		
		if ($debug) {
			foreach ($this->fields as $key => $value) {
				$tmpLi = new Boo_Html_Li;
				$tmpLi->setContent("<b>Field [{$key}]</b>: {$value}");
				$ul->addLi($tmpLi);
			}
		}
		return $ul;
	}
}
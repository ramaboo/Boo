<?php
/* SVN FILE: $Id: Sms.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief SMS class.
 * 
 * This class is used to send a <a href="http://en.wikipedia.org/wiki/Short_message_service">SMS</a> (Short Message Service).
 * 
 * @class		Boo_Sms
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @required	http://www.swiftmailer.org/ Swift Mailer (included in \c BOO_LIB_DIR)
 * @see			http://www.swiftmailer.org/wikidocs/
 */

class Boo_Sms {
	
	/**
	 * @brief The phone number.
	 */
	protected $phoneNumber = 0;
	
	/**
	 * @brief The carrier ID.
	 */
	protected $carrierId = 0;
	
	/**
	 * @brief The message subject.
	 */
	protected $subject = null;
	
	/**
	 * @brief The message body.
	 */
	protected $body = null;
	
	/**
	 * @brief Array of carriers.
	 * 
	 * Contains a multidimensional array of carrier information.
	 * 
	 * @since 2.0.0 Carrier IDs were renumbered.
	 */
	protected static $carriers = array(
		5 => array('name' => 'Alaska Communications', 'domain' => 'msg.acsalaska.com'),
		10 => array('name' => 'Alltel', 'domain' => 'message.alltel.com'),
		15 => array('name' => 'AT&amp;T Wireless', 'domain' => 'txt.att.net'),
		20 => array('name' => 'Boost', 'domain' => 'myboostmobile.com'),
		25 => array('name' => 'Cellular South', 'domain' => 'csouth1.com'),
		30 => array('name' => 'Centennial Wireless', 'domain' => 'cwemail.com'),
		35 => array('name' => 'Cincinnati Bell', 'domain' => 'gocbw.com'),
		40 => array('name' => 'Cricket', 'domain' => 'sms.mycricket.com'),
		45 => array('name' => 'Helio', 'domain' => 'myhelio.com'),
		50 => array('name' => 'MetroPCS', 'domain' => 'mymetropcs.com'),
		55 => array('name' => 'Midwest Wireless', 'domain' => 'clearlydigital.com'),
		60 => array('name' => 'Nextel', 'domain' => 'messaging.nextel.com'),
		65 => array('name' => 'Qwest', 'domain' => 'qwestmp.com'),
		70 => array('name' => 'Sprint', 'domain' => 'messaging.sprintpcs.com'),
		75 => array('name' => 'SunCom Wireless', 'domain' => 'tms.suncom.com'),
		80 => array('name' => 'T-Mobile', 'domain' => 'tmomail.net'),
		85 => array('name' => 'Unicel', 'domain' => 'utext.com'),
		90 => array('name' => 'US Cellular', 'domain' => 'email.uscc.net'),
		95 => array('name' => 'Verizon Wireless', 'domain' => 'vtext.com'),
		100 => array('name' => 'Virgin Mobile', 'domain' => 'vmobl.com'));
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {}
	
	/**
	 * @brief Returns array of carrier names.
	 * @return array Carrier names. The index is the carrier ID. The value is the carrier name.
	 */
	public static function getCarrierNames() {
		$carrierNames = array();
		
		foreach (self::$carriers as $key => $value) {
			$carrierNames[$key] = $value['name'];
		}
		
		return $carrierNames;
	}
	
	/**
	 * @brief Returns carrier name for a given carrier ID.
	 * @param int $carrierId The carrier ID.
	 * @return string The carrier name on success, FALSE otherwise.
	 */
	public static function getCarrierNameById($carrierId) {
		if (!self::isCarrierId($carrierId)) {
			trigger_error("Carrier ID {$carrierId} is not valid", E_USER_WARNING);
			return false;
		}
		
		return self::$carriers[$carrierId]['name'];
	}
	
	/**
	 * @brief Returns array of carrier domains.
	 * @return array Carrier domains. The index is the carrier ID. The value is the carier domain.
	 */
	public static function getCarrierDomains() {
		$carrierDomains = array();
		
		foreach (self::$carriers as $key => $value) {
			$carrierDomains[$key] = $value['domain'];
		}
		
		return $carrierDomains;
	}
	
	/**
	 * @brief Returns carrier domain for a given carrier ID.
	 * @param int $carrierId The carrier ID.
	 * @return string The carrier daomin on success, FALSE otherwise.
	 */
	public static function getCarrierDomainById($carrierId) {
		if (!self::isCarrierId($carrierId)) {
			trigger_error("Carrier ID {$carrierId} is not valid", E_USER_WARNING);
			return false;
		}
		
		return self::$carriers[$carrierId]['domain'];
	}
	
	/**
	 * @brief Returns array of carriers.
	 * @return array Multidimensional array of carriers.
	 */
	public static function getCarriers() { return self::$carriers; }
	
	/**
	 * @brief Determins if carrier ID is valid.
	 * @param int $carrierId The carrier ID to test.
	 * @return bool Returns TRUE if carrier ID is valid, FALSE otherwise.
	 */
	public static function isCarrierId($carrierId) { return isset(self::$carriers[$carrierId]); }
	
	/**
	 * @brief Sets the phone number.
	 * 
	 * @param string $phoneNumber The phone number.
	 * @return bool Returns TRUE if phone number is valid, FALSE otherwise.
	 * 
	 * @code
	 * $sms->setPhoneNumber('8003682669');
	 * @endcode
	 * 
	 * @todo Add support for non US phone numbers.
	 */
	public function setPhoneNumber($phoneNumber) {
		
		if (self::isPhoneNumber($phoneNumber)) {
			$this->phoneNumber = self::formatPhoneNumber($phoneNumber);
			return true;
		} else {
			// number is not valid
			trigger_error("Phone number {$phoneNumber} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Returns phone number.
	 * @return string Phone number, NULL is returned if phone number is not set.
	 */
	public function getPhoneNumber() { return $this->phoneNumber;}
	
	/**
	 * @brief Determins if a phone number is valid.
	 * @return bool Returns TRUE if phone number is valid, FALSE otherwise.
	 * @param string $phoneNumber The phone number to test.
	 */
	public static function isPhoneNumber($phoneNumber) {
		return (bool) self::formatPhoneNumber($phoneNumber);
	}
	
	/**
	 * @brief Formats a phone number.
	 * @return mixed On success returns formated phone number, FALSE otherwise.
	 * @param string $phoneNumber The phone number to format.
	 */
	public static function formatPhoneNumber($phoneNumber) {
		// remove non numeric characters
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
		
		if (strlen($phoneNumber) == 11 && substr($phoneNumber, 0, 1) == 1) {
			// remove leading 1 on 11 digit numbers
			$phoneNumber = substr($phoneNumber, 1);
		}
		
		if (strlen($phoneNumber) == 10) {
			// 10 digit number
			return $phoneNumber;
		} else {
			// not valid
			return false;
		}
	}
	
	/**
	 * @brief Sets the carrier ID.
	 * 
	 * @param int $carrierId The carrier ID.
	 * @return bool Returns TRUE if carrier ID is valid, FALSE otherwise.
	 */
	public function setCarrierId($carrierId) {
		$carrierId = (int) $carrierId;
		if (self::isCarrierId($carrierId)) {
			$this->carrierId = $carrierId;
			return true;
		} else {
			trigger_error("Carrier ID {$carrierId} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Returns carrier ID.
	 * @return int Carrier ID, NULL is returned if carrier ID is not set.
	 */	
	public function getCarrierId() { return $this->carrierId; }
	
	/**
	 * @brief Returns carrier name.
	 * @return string Carrier name, FALSE is returned if carrier ID is not set.
	 */
	public function getCarrierName() {
		return self::getCarrierNameById($this->carrierId);
	}
	
	/**
	 * @brief Returns carrier domain.
	 * @return string Carrier domain, FALSE is returned if carrier ID is not set.
	 */
	public function getCarrierDomain() {
		return self::getCarrierDomainById($this->carrierId);
	}
	
	/**
	 * @brief Returns email.
	 * @return string Email used to send SMS.
	 * 
	 * @ex 8003682669@tmomail.net
	 */
	public function getEmail() {
		// check if phone number is set
		if (!$this->phoneNumber) {
			trigger_error("Phone number {$this->phoneNumber} cannot be null", E_USER_NOTICE);
			return false;
		}
		// check if carrier ID is set
		if (!$this->carrierId) {
			trigger_error("Carrier ID {$this->carrierId} cannot be null", E_USER_NOTICE);
			return false;
		}
		
		return $this->phoneNumber . '@' . self::getCarrierDomainById($this->carrierId);
	}
	
	/**
	 * @brief Sets the subject.
	 * 
	 * @param string $subject The subject.
	 * @return bool Function always returns TRUE.
	 */
	public function setSubject($subject) {
		$subject = trim($subject);
		$length = strlen($subject);
		if ($length > BOO_SMS_MAX_SUBJECT_LENGTH) {
			trigger_error("Subject length {$length} is greater than " . BOO_SMS_MAX_SUBJECT_LENGTH . ' characters, subject may be truncated', E_USER_NOTICE);
		}
		$this->subject = $subject;
		return true;
	}
	
	/**
	 * @brief Returns subject.
	 * @return string Returns the subject of the message.
	 */
	public function getSubject() { return $this->subject; }
	
	/**
	 * @brief Sets the body.
	 *
	 * @param string $body The body.
	 * @return bool Function always returns TRUE.
	 */
	public function setBody($body) {
		$body = trim($body);
		$length = strlen($body);
		if ($length > BOO_SMS_MAX_BODY_LENGTH) {
			trigger_error("Body length {$length} is greater than " . BOO_SMS_MAX_BODY_LENGHT . ' characters, body may be truncated', E_USER_NOTICE);
		}
		$this->body = $body;
		return true;
	}
	
	/**
	 * @brief Returns body.
	 * @return string Returns the body of the message.
	 */
	public function getBody() { return $this->body; }
	
	/**
	 * @brief Sends the message.
	 * Sends the message. Phone number and carrier ID must be set priory to calling the send method. This function requires <a href="http://www.swiftmailer.org/">Swift</a>.
	 * 
	 * @return bool Returns TRUE if send was successful, FALSE otherwise.
	 * 
	 * @code
	 * $sms->send();
	 * @endcode
	 * 
	 * @todo Add support for mail() function.
	 */
	public function send() {
		if (!$this->isValid()) {
			trigger_error('Message is not valid', E_USER_WARNING);
			return false;
		}
		
		$smtp = new Swift_Connection_SMTP(BOO_SMTP_SERVER, BOO_SMTP_PORT, BOO_SMTP_ENC);
		$smtp->setUsername(BOO_SMTP_USERNAME);
		$smtp->setPassword(BOO_SMTP_PASSWORD);
		
		// start swift 
		$swift = new Swift($smtp);
		
		// create the message
		$message = new Swift_Message($this->subject, $this->body);
		
		// send
		$send = $swift->send($message, $this->getEmail(), BOO_SMS_EMAIL);
		$swift->disconnect();
		
		// check if it was sent successfully
		if ($send) {
			return true;
		} else {
			trigger_error('Send failed', E_USER_NOTICE);
			return false;
		}
	}
	
	/**
	 * @breif Determins if the message is valid.
	 * @return bool Returns TRUE if valid, FALSE otherwise.
	 */
	public function isValid() {
		$result = true;
		// check if phone number is set
		if (!$this->phoneNumber) {
			trigger_error('Phone number cannot be null', E_USER_NOTICE);
			$result = $result && false;
		}
		// check if carrier ID is set
		if (!$this->carrierId) {
			trigger_error('Carrier ID cannot be null', E_USER_NOTICE);
			$result = $result && false;
		}
		
		// check if either subject, body, or both are set
		if(!$this->subject && !$this->body) {
			trigger_error('Either a subject or body is required', E_USER_NOTICE);
			$result = $result && false;
		}
		
		return $result;
	}
	
	/**
	 * @brief Returns a HTML drop-down list of carriers.
	 * 
	 * @param bool $sticky[optional] If set to TRUE the drop down list will be sticky.
	 * @param array $attrs[optional] Array of attributes to add to the HTML select.
	 * @return string HTML drop-down list of all avalible carriers.
	 * @since 2.0.0 Carrier IDs were renumbered.
	 */
	public static function htmlCarrierSelect($sticky = true, array $attrs = array()) {
		$carrierNames = $this->getCarrierNames();
		$select = new Boo_Html_Select;
		$select->setSticky($sticky);
		$select->setData($carrierNames);
		$select->setTitle('Select Carrier');
		$select->applyAttrs($attrs);
		
		return $select;
	}
	
	
	/**
	 * @brief Returns a HTML drop-down list of carriers.
	 * 
	 * This function is usefull for creating an HTML select of the avalible carriers. The value for each option will be set to the carrier ID.
	 * If the selected value is 0 no carrier was chosen from the drop-down list.
	 * 
	 * This function is not dependent on Boo_Html_Select. If you have the entire Boo Framework installed 
	 * you should use Boo_Sms::htmlCarrierSelect() instead.
	 * 
	 * @param bool $sticky[optional] If set to TRUE the drop down list will be sticky.
	 * @return string HTML drop-down list of all avalible carriers.
	 * @since 2.0.0 Carrier IDs were renumbered.
	 * 
	 * @code
	 * <select name="carrier" id="carrier">
	 * <option value="0">Select Carrier</option>
	 * <option value="5">Alaska Communications</option>
	 * <option value="10">Alltel</option>
	 * ...
	 * <option value="100">Virgin Mobile</option>
	 * </select>
	 * @endcode
	 */
	public static function htmlCarrierSelect2($sticky = true) {
		$carrierNames = self::getCarrierNames();
		$tmp = "<select name=\"carrier\" id=\"carrier\">\n"
			. "<option value=\"0\">Select Carrier</option>\n";
		
		if (!empty($_POST) && isset($_POST['carrier']) && $sticky) {
			// postback and sticky
			foreach ($carrierNames as $key => $value) {
				if ($key == $_POST['carrier']) {
					// selected
					$tmp .= "<option selected=\"selected\" value=\"{$key}\">" . $carrierNames[$key] . "</option>\n";
				} else {
					$tmp .= "<option value=\"{$key}\">" . $carrierNames[$key] . "</option>\n";
				}
			}
		} else {
			// regular
			foreach ($carrierNames as $key => $value) {
				$tmp .= "<option value=\"{$key}\">" . $carrierNames[$key] . "</option>\n";
			}
		}
		
		$tmp .= "</select>\n";
		return $tmp;
	}
}
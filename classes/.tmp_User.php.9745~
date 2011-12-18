<?php
/* SVN FILE: $Id: User.php 232 2009-05-04 03:09:46Z david@ramaboo.com $ */
/**
 * @brief User class.
 * 
 * This class is used to create and manipulate users.
 * 
 * @class		Boo_User
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.9.5
 */

class Boo_User extends Boo_Io {
	
	/**
	 * @brief Table name.
	 * 
	 * Used for static functions.
	 * For non static functions see Boo_Db::setTableName().
	 */
	const TABLE_NAME = 'boo_users';
	
	/**
	 * @brief Primary key.
	 * 
	 * Used for static functions.
	 * For non static functions see Boo_Db::setPrimaryKey().
	 */
	const PRIMARY_KEY = 'user_id';
	
	/**
	 * @brief Maximum length of username.
	 */
	const MAX_USERNAME_LENGTH = 32;
	
	/**
	 * @brief Minimum length of username.
	 */
	const MIN_USERNAME_LENGTH = 4;
	
	
	/**
	 * @brief Default constructor.
	 * 
	 * @param int $user[optional] User to open.
	 * @return void.
	 */
	public function __construct($user = false) {
		parent::__construct(self::TABLE_NAME, self::PRIMARY_KEY);
		
		// defaults
		$this->setIgnoredField('password');
		$this->setMagicFields(array('created', 'modified', 'ip'));
		$this->setSerializedField('settings');
		$this->setStatus(BOO_STATUS_OK);
		$this->setGroupId(BOO_GROUP_USER);
		$this->setCountryCode('US');
		
		if ($user !== false) {
			$this->open($user);
		}
	}
	
	
	public function hasAccount() {
		return (bool) $this->getAccountId();
	}
	
	public function openAccount($accountId = false) {
		
		
		if ($accountId === false) {
			$accountId = $this->getAccountId();
		}
		
		if ($accountId === false) {
			trigger_error('Account ID is false, user does not have an account', E_USER_NOTICE);
			return false;
		}
		if (class_exists('Account', false) && BOO_CLASS) {
			$this->account = new Account;
		} else {
			$this->account = new Boo_Account;
		}
		$result = $this->account->open($accountId);
		
		return $result;
	}
	
	/**
	 * @brief Sets the users group ID.
	 * 
	 * @param int $groupId The group ID.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setGroupId($groupId) {
		$groupId = (int) $groupId;
		
		if (Boo_Group::isGroupId($groupId)) {
			return $this->set('group_id', $groupId);
		} else {
			trigger_error("Group ID {$groupId} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users group ID.
	 * 
	 * @return int Returns the users group ID if set, FALSE otherwise.
	 */
	public function getGroupId() { return $this->get('group_id'); }
	
	/**
	 * @brief Sets the users account ID.
	 * 
	 * @param int $accountId The account id.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setAccountId($accountId) {
		$accountId = (int) $accountId;
		
		if (Boo_Account::isAccountId($accountId)) {
			return $this->set('account_id', $accountId);
		} else {
			trigger_error("Account ID {$accountId} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users account ID.
	 * 
	 * @return int Returns the users account ID if set, FALSE otherwise.
	 */
	public function getAccountId() { return $this->get('account_id'); }
	
	/**
	 * @brief Set users status.
	 * 
	 * Possible values are:
	 * \li \c BOO_STATUS_OK
	 * \li \c BOO_STATUS_CLOSED
	 * \li \c BOO_STATUS_SUSPENDED
	 * \li \c BOO_STATUS_DISABLED
	 * \li \c BOO_STATUS_PENDING
	 * \li \c BOO_STATUS_UNKNOWN
	 * 
	 * You may use other integer values of your own. Statuses that indicate
	 * a user is in good standing (and allowed to login) should be greater than or equal to 1. Statuses 
	 * that indicate a users account is closed, suspended, or otherwise inaccesable (and not allowed to login) be less
	 * than or equal to 0.
	 * 
	 * @param int $status User status.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setStatus($status) {
		$status = (int) $status;
		return $this->set('status', $status);
	}
	
	/**
	 * @brief Gets the users status.
	 * @return int The users status, FALSE on failure.
	 */
	public function getStatus() { return $this->get('status'); }
	
	/**
	 * @breif Determins if a users status is OK.
	 * @return bool Returns TRUE if user is OK, FALSE otherwise.
	 * @warning This function will return TRUE for any positive status not just \c BOO_STATUS_OK.
	 */
	public function isStatusOK() { return ($this->get('status') >= 1); }
	
	/**
	 * @brief Sets users private status.
	 * 
	 * @param bool $opt Private status.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setPrivate($opt) {
		$private = (bool) $private;
		return $this->set('private', $opt);
	}
	
	/**
	 * @brief Determins if a users profile is private.
	 * 
	 * @return bool Returns TRUE if private, FALSE otherwise.
	 */
	public function isPrivate() { return (bool) $this->get('private'); }
	
	/**
	 * @brief Sets the users website.
	 * 
	 * @param string $website The website.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setWebsite($website) {
		$website = Boo_Format::formatURL($website);
		
		if (Boo_Validator::isUrl($website)) {
			return $this->set('website', $website);
		} else {
			trigger_error("Website {$website} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users website.
	 * 
	 * @return string Returns the users website if set, FALSE otherwise.
	 */
	public function getWebsite() { return $this->get('website'); }
	
	/**
	 * @brief Gets the users website as a HTML anchor.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @return Boo_Html The users link as a HTML anchor, FALSE on failure.
	 */
	public function htmlWebsiteA(array $attrs = array()) {
		$website = $this->get('website');

		if ($website) {
			$a = new Boo_Html_A;
			$a->applyAttrs($attrs);
			
			$a->setAttr('href', Boo_Format::formatURL($website));
			$a->setContent($website);
			
			return $a;
			
		} else {
			return false;
		}
	}
	
	
	/**
	 * @brief Sets the users first name.
	 * 
	 * @param string $name The first name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setFirstName($name) {
		$name = strtodb($name);
		
		if (Boo_Validator::isName($name)) {
			return $this->set('first_name', $name);
		} else {
			trigger_error("First name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users first name.
	 * 
	 * @return string Returns the users first name if set, FALSE otherwise.
	 */
	public function getFirstName() { return $this->get('first_name'); }
	
	/**
	 * @brief Sets the users last name.
	 * 
	 * @param string $name The last name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setLastName($name) {
		$name = strtodb($name);
		
		if (Boo_Validator::isName($name)) {
			return $this->set('last_name', $name);
		} else {
			trigger_error("Last name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users last name.
	 * 
	 * @return string Returns the users last name if set, FALSE otherwise.
	 */
	public function getLastName() { return $this->get('last_name'); }
	
	/**
	 * @brief Gets the users name.
	 * 
	 * Formated as first name space last name if both are present, otherwise just the
	 * name that is set.
	 * 
	 * @return string Returns the users name if set, FALSE otherwise.
	 */
	public function getName() {
		$name = trim($this->get('first_name') . ' ' . $this->get('last_name')); // removes extra spaces
		if ($name) {
			return $name;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Sets the users company.
	 * 
	 * @param string $company The company.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCompany($company) {
		$company = strtodb($company);
		
		if (Boo_Validator::isString($company, 2, 32)) {
			return $this->set('company', $company);
		} else {
			trigger_error("Company {$company} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users company.
	 * 
	 * @return string Returns the users company if set, FALSE otherwise.
	 */
	public function getCompany() { return $this->get('company'); }
	
	/**
	 * @brief Sets the users street.
	 * 
	 * @param string $street The street.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setStreet($street) {
		$street = strtodb($street);
		
		if (Boo_Validator::isStreet($street)) {
			return $this->set('street', $street);
		} else {
			trigger_error("Street {$street} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users street.
	 * 
	 * @return string Returns the users street if set, FALSE otherwise.
	 */
	public function getStreet() { return $this->get('street'); }
	
	/**
	 * @brief Sets the users apartment number.
	 * 
	 * @param string $apt The apartment number.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setApartmentNumber($apt) {
		$apt = strtodb($apt);
		if (Boo_Validator::isApartmentNumber($apt)) {
			return $this->set('apartment_number', $apt);
		} else {
			trigger_error("Apartment number {$apt} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users apartment number.
	 * 
	 * @return string Returns the users apartment number if set, FALSE otherwise.
	 */
	public function getApartmentNumber() { return $this->get('apartment_number'); }
	
	/**
	 * @brief Determins if user has an apartment number.
	 * 
	 * @attention Zero is a valid apartment number.
	 * @return bool Returns TRUE if apartment number is present, FALSE otherwise.
	 */
	public function hasApartmentNumber() { return !Boo_Validator::isNull($this->getApartmentNumber()); }
	
	/**
	 * @brief Sets the users city.
	 * 
	 * @param string $city The city.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCity($city) { 
		$city = strtodb($city);
		
		if (Boo_Validator::isCity($city)) {
			return $this->set('city', $street);
		} else {
			trigger_error("City {$city} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users city.
	 * 
	 * @return string Returns the users city if set, FALSE otherwise.
	 */
	public function getCity() { return $this->get('city'); }
	
	/**
	 * @brief Sets the users state.
	 * 
	 * @param string $state The state as a state code or state name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setState($state) {
		$state = trim($state);
		
		if (!$state) {
			trigger_error('State can not be false', E_USER_WARNING);
			return false;
		}
		
		if (Boo_Validator::isStateCode($state)) {
			// $state is a state code
			return $this->setStateCode($state);
		} elseif (Boo_Validator::isStateName($state)) {
			// $state is a state name
			return $this->setStateName($state);
		} else {
			// neither code or name
			trigger_error("State {$state} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Sets the users state.
	 * 
	 * @param string $state The state as a state name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setStateName($name) {
		$name = trim($name);
		
		if (Boo_Validator::isStateName($name)) {
			// $state is a state name
			return $this->set('state_code', Boo_Helper::getStateCodeByName($state));
		} else {
			// neither a code or name
			trigger_error("State name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Sets the users state code.
	 * 
	 * State code is the two letter abbreviation.
	 * 
	 * @see Boo_Validator::$states.
	 * @param string $code The state code.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setStateCode($code) {
		$code = strtoupper(trim($code));
		
		if (Boo_Validator::isStateCode($code)) {
			return $this->set('state_code', $code);
		} else {
			// not a valid code
			trigger_error("State code {$code} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users state code.
	 * 
	 * Provides API compatibility.
	 * 
	 * @see Boo_Validator::$states.
	 * @return string State code in strtoupper.
	 */
	public function getState() { return $this->get('state_code'); }
	
	/**
	 * @brief Gets the users state code.
	 * 
	 * @see Boo_Validator::$states.
	 * @return string State code in strtoupper.
	 */
	public function getStateCode() { return $this->get('state_code'); }
	
	/**
	 * @brief Gets the users state name.
	 * 
	 * @see Boo_Validator::$states.
	 * @return string State name.
	 */
	public function getStateName() { return Boo_Helper::getStateNameByCode($this->get('state_code')); }
	
	/**
	 * @brief Sets the users country.
	 * 
	 * @param string $country The country as a country code or country name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCountry($country) {
		$country = trim($country);
		
		if (!$country) {
			if (BOO_WARNING) { trigger_error('Country can not be false', E_USER_WARNING); }
			return false;
		}
		
		if (Boo_Validator::isCountryCode($country)) {
			// $country is a country code
			return $this->setCountryCode($country);
		} elseif (Boo_Validator::isCountryName($country)) {
			// $country is a country name
			return $this->setCountryName($country);
		} else {
			// neither code or name
			trigger_error("Country {$country} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Sets the users country.
	 * 
	 * @param string $country The country as a country name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCountryName($name) {
		$name = trim($name);
		
		if (Boo_Validator::isCountryName($name)) {
			// $country is a country name
			return $this->set('country_code', Boo_Helper::getCountryCodeByName($country));
		} else {
			// neither a code or name
			trigger_error("Country name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Sets the users country code.
	 * 
	 * Country code is the two letter abbreviation.
	 * 
	 * @see Boo_Validator::$countries.
	 * @param string $code The country code.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCountryCode($code) {
		$code = strtoupper(trim($code));
		
		if (Boo_Validator::isCountryCode($code)) {
			return $this->set('country_code', $code);
		} else {
			// not a valid code
			trigger_error("Country code {$code} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users country code.
	 * 
	 * Provides API compatibility.
	 * 
	 * @see Boo_Validator::$countries.
	 * @return string Country code in strtoupper.
	 */
	public function getCountry() { return $this->get('country_code'); }
	
	/**
	 * @brief Gets the users country code.
	 * 
	 * @see Boo_Validator::$countries.
	 * @return string Country code in strtoupper.
	 */
	public function getCountryCode() { return $this->get('country_code'); }
	
	/**
	 * @brief Gets the users country name.
	 * 
	 * @see Boo_Validator::$countries.
	 * @return string Country name.
	 */
	public function getCountryName() { return Boo_Helper::getCountryNameByCode($this->get('country_code')); }
	
	/**
	 * @brief Sets the users ZIP code.
	 *
	 * @param string $zip The ZIP code.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setZip($zip) {
		$zip = Boo_Format::formatZip($zip);
		
		if (Boo_Validator::isZip($zip)) {
			return $this->set('zip', $zip);
		} else {
			trigger_error("ZIP {$zip} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users ZIP code.
	 * 
	 * @return string ZIP code.
	 */
	public function getZip() { return $this->get('zip'); }
	
	/**
	 * @brief Sets the users carrier ID.
	 * 
	 * @see Boo_SMS
	 * @param int $carrierId The carrier ID.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setCarrierId($carrierId) {
		$carrierId = (int) $carrierId;
		
		if (Boo_SMS::isCarrierId($carrierId)) {
			return $this->set('carrier_id', $carrierId);
		} else {
			trigger_error("Carrier ID {$carrierId} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users carrier ID.
	 * 
	 * @return int The carrier ID.
	 */
	public function getCarrierId() { return $this->carrierId; }
	
	/** 
	 * @brief Sets the users SMS number.
	 * 
	 * @param string $smsNumber The SMS number
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setSmsNumber($smsNumber) {
		$smsNumber = Boo_Format::formatPhoneNumber($smsNumber);
		
		if (Boo_Validator::isPhoneNumber($smsNumber)) {
			return $this->set('sms_number', $smsNumber);
		} else {
			trigger_error("SMS number {$smsNumber} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users SMS number.
	 * 
	 * @return string The SMS number if available, empty string otherwise.
	 */
	public function getSmsNumber() { return ($this->get('sms_number')) ? $this->get('sms_number') : ''; }
	
	/**
	 * @brief Sets the users fax number.
	 * 
	 * @param string $faxNumber The fax number
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setFaxNumber($faxNumber) {
		$faxNumber = Boo_Fromat::formatPhoneNumber($faxNumber);
		
		if (Boo_Validator::isPhoneNumber($faxNumber)) {
			return $this->set('fax_number', $faxNumber);
		} else {
			trigger_error("Fax number {$faxNumber} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users fax number.
	 * 
	 * @return string The fax number if available, empty string otherwise.
	 */
	public function getFaxNumber() { return ($this->get('fax_number')) ? $this->get('fax_number') : ''; }
	
	/**
	 * @brief Sets the users phone number.
	 * 
	 * @param string $phoneNumber The phone number
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setPhoneNumber($phoneNumber) {
		
		$phoneNumber = Boo_Format::formatPhoneNumber($phoneNumber);
		
		if (Boo_Validator::isPhoneNumber($phoneNumber)) {
			return $this->set('phone_number', $phoneNumber);
		} else {
			trigger_error("Phone number {$phoneNumber} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users phone number.
	 * 
	 * @return string The phone number if available, empty string otherwise.
	 */
	public function getPhoneNumber() { return ($this->get('phone_number')) ? $this->get('phone_number') : ''; }
	
	/**
	 * @brief Gets the users ID.
	 * 
	 * @return int The users ID.
	 */
	public function getUserId() { return (int) $this->get('user_id'); }
	
	/**
	 * @brief Gets the users link as a HTML anchor.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @return Boo_Html The users link as a HTML anchor, FALSE on failure.
	 */
	public function htmlUserA(array $attrs = array()) {
		$username = $this->get('username');
		if ($username) {
			
			$a = new Boo_Html_A;
			$a->applyAttrs($attrs);
			
			$a->setAttr('href', "/user/{$username}/");
			$a->setContent($username);
			
			return $a;
		} else {
			trigger_error('Username can not be false', E_USER_NOTICE);
			return false;
		}
	}
	
	
	
	/**
	 * @brief Sets the users username.
	 * 
	 * Setting the username to an already existing username will generate an \c E_USER_WARNING
	 * and return FALSE.
	 * 
	 * @param string $username The username.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setUsername($username) {
		$username = strtolower(trim($username));
		
		if (self::isUsername($username)) {
			trigger_error("Username {$username} already exists", E_USER_WARNING);
			return false;
		} else {
			if (Boo_Validator::isUsername($username)) {
				return $this->set('username', $username);
			} else {
				trigger_error("Username {$username} is not valid", E_USER_WARNING);
				return false;
			}
		}
	}
	
	/**
	 * @breif Gets the users username.
	 * 
	 * @return string The users usersname.
	 */
	public function getUsername() { return $this->get('username'); }

	/**
	 * @brief Sets the users password.
	 * 
	 * @param string $password The password.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	public function setPassword($password) {
		$password = trim($password);
		
		if (!Boo_Validator::isPassword($password)) {
			if (BOO_WARNING) { trigger_error("Password (hidden) is not valid", E_USER_WARNING); }
			return false;
		}
		if ($password == '********' && $this->get('password_hash')) {
			// password is already set
			// ignore this request
			return true;
		}
		$result = true;
		$result = $result && $this->set('password', $password);
		// generate password hash
		$salt = hash('md5', uniqid(rand(), true)); // 32 character salt
		$result = $result && $this->set('password_hash', hash('sha256', $password . BOO_SECRET . $salt)); // 64 character password hash
		$result = $result && $this->set('salt', $salt); // save salt
		return $result;
	}
	
	/**
	 * @brief Gets the users password hash.
	 * @return string The password hash.
	 */
	public function getPasswordHash() { return $this->get('password_hash'); }
	
	/**
	 * @brief Gets the users password salt.
	 * @return string The password salt.
	 */
	public function getSalt() { return $this->get('salt'); }
	
	public function isAuthTokenValid($authToken) {
		$authToken = strtolower(trim($authToken));
		return $this->getAuthToken() == $authToken;
	}
	
	public function getAuthToken() {
		return hash('sha256', $this->getUserId() .  $this->getPasswordHash() . $this->getSalt() . BOO_SECRET);
	}
	
	
	public function htmlAuthA(array $attrs = array()) {
		$a = new Boo_Html_A;
		$a->applyAttrs($attrs);
		
		if (BOO_SSL) {
			$url = 'https://';
		} else {
			$url = 'http://';
		}
		
		
		$url .= BOO_DOMAIN . '/password/reset/' . $this->getUserId() . '/' . $this->getAuthToken() . '/';
		$a->setAttr('src', $url);
		
		return $a;
	}
	
	/**
	 * @brief Sets the users email address.
	 * 
	 * @param string $email The email address.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setEmail($email) {
		$email = Boo_Format::formatEmail($email);
		
		if (Boo_Validator::isEmail($email)) {
			return $this->set('email', $email);
		} else {
			trigger_error("Email address {$email} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the users email address.
	 * 
	 * @return string The users email address.
	 */
	public function getEmail() { return $this->get('email'); }
	
	/**
	 * @brief Gets the users email address link.
	 * 
	 * @param string $subject[optional] The subject.
	 * @return string The users email address link as a URL, FALSE on failure.
	 */
	public function getEmailLink($subject = false) {
		$email = $this->get('email');
		if ($email) {
			$result = "mailto:{$email}";
			if ($subject) {
				$result .= "?subject={$subject}";
			}
			return $result;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Gets the users email address as a HTML anchor.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @param string $subject[optional] The subject.
	 * @return Boo_Html The users link as a HTML anchor, FALSE on failure.
	 */
	public function htmlEmailA(array $attrs = array(), $subject = false) {
		$email = $this->get('email');
		if ($email) {
			$a = new Boo_Html_A;
			$a->applyAttrs($attrs);
			
			$a->setAttr('href', $this->getEmailLink($subject));
			$a->addClass('email');
			$a->setContent($email);
			
			return $a;
			
			
		} else {
			return false;
		}
	}
	
	
	/**
	 * @brief Gets the time of the users last login.
	 * 
	 * @return int Unix timestamp of the last login.
	 */
	public function getLastLogin() { return $this->get('last_login'); }
	
	/**
	 * @brief Gets the time of the users last IP.
	 * 
	 * @return int Unix timestamp of the last IP used by the user.
	 */
	public function getLastIp() { return $this->get('last_ip'); }
	
	/**
	 * @brief Authorize user.
	 * 
	 * @return Returns TRUE on success, FALSE otherwise.
	 */
	public function auth() {
		$userId = $this->getUserId();
		if (!$userId) {
			trigger_error('User ID cannot be zero', E_USER_NOTICE);
			return false;
		}
		
		$_SESSION['boo_auth'] = true;
		$_SESSION['boo_user_id'] = $userId;
		$_SESSION['boo_user_id_hash'] = hash('sha256', $userId . _server('HTTP_USER_AGENT') . BOO_SECRET);
	
		return true;
	}
	
	/**
	 * @brief Verifys a session hash to be sure the user ID was not changed without our knowning.
	 * @return bool Returns TRUE if verified, FALSE otherwise.
	 */
	public function verifyUserIdHash() {
		if (isset($_SESSION['boo_user_id_hash']) && isset($_SESSION['boo_user_id'])) {
			return $_SESSION['boo_user_id_hash'] == hash('sha256', $_SESSION['boo_user_id']
				. _server('HTTP_USER_AGENT') . BOO_SECRET);
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determins if a session is authorized.
	 * 
	 * @return bool Returns TRUE if authorized, FALSE otherwise.
	 */
	public function isAuth() {
		if (isset($_SESSION['boo_auth'])) {
			session_regenerate_id(true);
			return $this->verifyUserIdHash();
		}
		return false;
	}
	
	/**
	 * @brief Login the user.
	 * 
	 * @param string $username[optional] The username. If it is not set then Boo_User::getUsername() will be used.
	 * @param string $password[optional] The password. If it is not set then Boo_User::getPassword() will be used.
	 * 
	 * @return Returns TRUE if login was successful, FALSE otherwise.
	 */
	public function login($username = false, $password = false) {
		$passwordHash = ''; $salt = ''; $userId = 0;
		
		if ($username === false) {
			$username = $this->getUsername();
		} else {
			$username = strtolower(trim($username));
		}
		
		if ($password === false) {
			$password = $this->getPassword();
		} else {
			$password = trim($password);
		}
		
		$dbh = Boo_DB::connect();
		$stmt = $dbh->prepare("SELECT {$this->primaryKey}, username, password_hash, salt FROM {$this->tableName} WHERE username = :username LIMIT 1");
		
		$stmt->bindParam(':username', $username);
		// set user id
		$stmt->bindColumn($this->primaryKey, $userId);
		// grab password_hash and salt
		$stmt->bindColumn('password_hash', $passwordHash);
		$stmt->bindColumn('salt', $salt);
		try {
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOUND);
			if ($result) {
				// user found check password 
				if (hash('sha256', $password . BOO_SECRET . $salt) == $passwordHash) {
					if($this->isStatusOK()) {
						session_regenerate_id(true);
						// load user info
						$this->open($userId);
						$this->auth();
						$this->set('last_login', time());
						$this->set('last_ip', Boo_Page::getIp());
						// save last login and IP to database
						$this->save();
						return true;
					} else {
						// account status is not valid
						trigger_error("User {$userId} status is not OK, maybe your account is suspended", E_USER_NOTICE);
						return false;
					}
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	
	/**
	 * @brief Logout user.
	 * 
	 * @return bool Always returns TRUE.
	 */
	public function logout() {
		$_SESSION['boo_auth'] = false;
		$_SESSION['boo_user_id'] = 0;
		return true;
	}
	
	/**
	 * @breif Preform checks befor saving the user object.
	 * 
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	public function beforeSave() {
		
		if (!$this->get('username')) {
			trigger_error('Username can not be null', E_USER_WARNING);
			return false;
		}
		
		if (!$this->get('password_hash')) {
			trigger_error('Password hash can not be null', E_USER_WARNING);
			return false;
		}
		
		if (!$this->get('salt')) {
			trigger_error('Salt can not be null', E_USER_WARNING);
			return false;
		}
		
		if (!$this->getBooId()) {
			// add new user
			$username = $this->get('username');
			if (self::isUsername($username)) {
				trigger_error("Username {$username} is not unique", E_USER_WARNING);
				return false;
			}
		} else {
			// save existing user
		}
		
		return true;
	}
	
	/**
	 * @brief Opens the user object.
	 * 
	 * @param mixed $user The user to open. Accepts a user ID, email address, or username.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	public function open($user) {
		$user = trim($user);
		
		if (ctype_digit($user)) {
			// user ID
			$userId = $user;
		} elseif (Boo_Validator::isEmail($user)) {
			// email address
			$userId = self::getUserIdByEmail($user);
		} else {
			// username
			$userId = self::getUserIdByUsername($user);
		}
		
		if ($userId === false) {
			trigger_error("User {$user} not found", E_USER_WARNING);
			return false;
		}
		
		return parent::open($userId);
	}
	
	public function openImages($userId = false) {
		$userId = (int) $userId;
		
		if (!$userId) {
			$userId = $this->getUserId();
		}
		
		if (!$userId) {
			trigger_error('User ID can not be zero, try Boo_User::open() first', E_USER_WARNING);
			return false;
		}
		
		return $this->images->open($userId);
		
	}
	// ##################################################################
	// FIX SETINGS
	
	/**
	 * @brief Sets a user setting.
	 * 
	 * @param string $name The setting name.
	 * @param mixed $value The setting value.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @todo Add support for more complex settings.
	 */
	public function setSetting($name, $value) {
		$name = trim($name);
		if (!preg_match('/(^[0-9A-Za-z]{1,16}$)/', $name)) {
			trigger_error("Name {$name} is not valid", E_USER_WARNING);
			return false;
		}
		// allows false to work as a $value
		if ($value && !preg_match('/(^[0-9A-Za-z]{1,16}$)/', $value)) {
			trigger_error("Value {$value} is not valid", E_USER_WARNING);
			return false;
		}
		
		$tmpSettings = $this->get('settings');
		$tmpSettings[$name] = $value;
		
		return $this->set('settings', $tmpSettings);
	}
	
	/**
	 * @brief Sets the users settings.
	 * 
	 * @param array $settings The array of settings.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setSettings(array $settings) {
		if (empty($settings)) {
			if (BOO_DEBUG) { trigger_error('Settings array is empty, using Boo_User::clearSettings() instead', E_USER_NOTICE); }
			return $this->clearSettings();
		}
		
		return $this->set('settings', $settings);
	}
	
	/**
	 * @brief Adds a user setting
	 * 
	 * Provides API compatibility.
	 * 
	 * @param string $name The setting name.
	 * @param mixed $value The setting value.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addSetting($name, $value) {
		$name = trim($name);
		
		$tmpSettings = $this->get('settings');
		$tmpSettings[$name] = $value;
		
		if (array_key_exists($name, $tmpSettings)) {
			rigger_error("Setting {$name} already exists, use Boo_User::setSetting() instead", E_USER_WARNING);
			return false;
		} else {
			return $this->setSetting($name, $value);
		}
		
	}
	
	/**
	 * @brief Adds settings to the users settings.
	 * 
	 * @param array $settings The array of settings.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addSettings(array $settings) {
		if (empty($settings)) {
			trigger_error('Settings array is empty', E_USER_NOTICE);
			return false;
		}
		
		$tmpSettings = $this->get('settings');
		
		$tmpSettings = array_merge($tmpSettings, $settings);
		return $this->set('settings', $settings);
	}
	
	/**
	 * @brief Determins if a user has a setting.
	 * 
	 * @param string $key The setting key.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function hasSetting($key) {
		$key = trim($key);
		$tmpSettings = $this->get('settings');
		
		return array_key_exists($key, $tmpSettings);
	}
	
	/**
	 * @brief Clears users settings.
	 * 
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	public function clearSettings() {
		return $this->set('settings', array());
	}
	
	/**
	 * @brief Removes a users settings.
	 * 
	 * @param string $name The name of the setting.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeSetting($name) {
		$name = trim($name);
		$tmpSettings = $this->get('settings');
		
		if (array_key_exists($name, $tmpSettings)) {
			unset($tmpSettings[$name]);
			return $this->set('settings', $tmpSettings);
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Gets a user setting.
	 * 
	 * @param string $name The name of the setting.
	 * @return mixed Returns setting on success, FALSE on failure.
	 */
	public function getSetting($name) {
		$name = trim($name);
		$tmpSettings = $this->get('settings');
		
		if (array_key_exists($name, $tmpSettings)) {
			return $tmpSettings[$name];
		} else {
			trigger_error("Setting {$name} was not found", E_USER_NOTICE);
			return false;
		}
	}
		
	/**
	 * @brief Gets array of users settings.
	 * @return array Returns array of users settings, FALSE on failure.
	 */
	public function getSettings() { return $this->get('settings'); }
	
	
	/**
	 * @brief Determines if a username already exists.
	 * 
	 * @param string $username The username.
	 * @return bool Returns TRUE if username is already in the database, FALSE otherwise.
	 */
	public static function isUsername($username) {
		$username = strtolower(trim($username));
		return (bool) self::exists($username, 'username');
	}
	
	/**
	 * @brief Determines if an email address already exists.
	 * 
	 * @param string $email The email address.
	 * @return bool Returns TRUE if email address is already in the database, FALSE otherwise.
	 */
	public static function isEmail($email) {
		$email = trim($email);
		return (bool) self::exists($email, 'email');
	}
	
	/**
	 * @brief Determins if a user already exists.
	 * @param mixed $user The user to open. Accepts a user ID, email address, or username.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
		
	public static function isUser($user) {
		$user = trim($user);
		
		if (ctype_digit($user)) {
			// user ID
			$userId = $user;
		} elseif (Boo_Validator::isEmail($user)) {
			// email address
			$userId = self::getUserIdByEmail($user);
		} else {
			// username
			$userId = self::getUserIdByUsername($user);
		}
		
		return !$userId === false;
	}
	/**
	 * @brief Determines if a user ID already exists.
	 * 
	 * @param int $userId The user ID.
	 * @return bool Returns TRUE if user ID is already in the database, FALSE otherwise.
	 */
	public static function isUserId($userId) {
		$userId = (int) $userId;
		// allows for a user ID of 0
		return !(self::exists($name, 'name', self::TABLE_NAME, self::PRIMARY_KEY) === false);
	}
	
	/**
	 * @brief Gets a field given an ID.
	 * 
	 * @param string $field The field
	 * @param int $userId The user ID.
	 * @return mixed Returns the value of the field if successful, FALSE otherwise.
	 */
	public static function getFieldByUserId($field, $userId) {
		$field = trim($field);
		$userId = (int) $userId;
		
		
		if (class_exists('User', false) && BOO_CLASS) {
			$user = new User;
		} else {
			$user = new Boo_User;
		}
		
		if ($user->open($userId)) {
			return $user->get($field);
		} else {
			trigger_error("Opening user {$userId} failed, can not continue", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Determins if an item exists in a given column.
	 * 
	 * Shortcut function for Boo_User.
	 * 
	 * @param string $search The search string.
	 * @param string $column The column name.
	 * @param string $tableName[optional] The table name.
	 * @param mixed $primaryKey[optional] The primary key for the table, should be a Boo ID.
	 * @return mixed Returns Boo ID on success, FALSE on failure.
	 */
	public static function exists($search, $column, $tableName = self::TABLE_NAME, $primaryKey = self::PRIMARY_KEY) {
		return parent::exists($search, $column, $tableName, $primaryKey);
	}
	
	/**
	 * @brief Gets a user ID given a username.
	 * 
	 * @param string $username The username.
	 * @return int Returns the user ID if successful, FALSE otherwise.
	 */
	public static function getUserIdByUsername($username) {
		$username = strtolower(trim($username));
		return self::exists($username, 'username');
	}
	
	/**
	 * @brief Gets a user ID given an email address.
	 * 
	 * @param string $email The email address.
	 * @return int Returns the user ID if successful, FALSE otherwise.
	 */
	public static function getUserIdByEmail($email) {
		$email = strtolower(trim($email));
		return self::exists($email, 'email');
	}
	
	/**
	 * @brief Gets the current user ID from the session.
	 * 
	 * @return int Returns user ID on success, FALSE otherwise.
	 */
	public static function getSessionUserId() {
		$userId = ((isset($_SESSION['boo_user_id'])) ? $_SESSION['boo_user_id'] : false);
		return $userId;
	}
	
	
	/**
	 * @brief Determins if a user has a full address.
	 * 
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function hasAddress() {
		$result = $this->getStreet() && $this->getCity() && $this->getStateCode() && $this->getZip() && $this->getCountryName();
		return $result;
	}
	
	/**
	 * @brief Returns address as html.
	 * 
	 * Uses <span class="address"> tags.
	 * @param array $attrs[optional] Array of attributes.
	 * @return string Address as html.
	 */
	public function htmlAddressSpan(array $attrs = array()) {
		$tmp = '';
		if ($this->getName()) {
			$tmp .= ucwords($this->getName()) . '<br />';
		}
		
		if ($this->getStreet()) {
			if ($this->hasApartmentNumber()) { // zero is a valid apartment number
				$tmp .= ucwords($this->getStreet()) . ' #' . $this->getApartmentNumber() .'<br />';
			} else {
				$tmp .= ucwords($this->getStreet()) . '<br />';
			}
		}
		
		$tmp .= ucwords($this->getCity()) . ', ' . $this->getStateCode() . ' ' . $this->getZip(). '<br />';
		$tmp .= $this->getCountryName();
		
		$span = new Boo_Html_Span;
		$span->applyAttrs($attrs);
		$span->addClass('address');
		$span->setContent($tmp);
		return $span;
	}
	
	/**
	 * @brief Determins if user is a member of the root group.
	 * 
	 * @return bool Returns TRUE if user is a member of the root group, FALSE otherwise.
	 */
	public function isRoot() {
		if ($this->getGroupId() == BOO_GROUP_ROOT) {
			return true;
		} else {
			return false;
		}
	}
	
}
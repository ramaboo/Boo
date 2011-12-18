<?php
/* SVN FILE: $Id: Twitter.php 215 2009-03-17 01:15:42Z david@ramaboo.com $ */
/**
 * @brief Twitter class.
 * 
 * This class is used to interact with the Twitter API.
 * 
 * Based on twitterlibphp by Justin Poliey.
 * 
 * @class		Boo_Twitter
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://github.com/jdp/twitterlibphp/ twitterlibphp
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 Justin Poliey
 * @copyright	2009 David Singer
 * @author		Justin Poliey <jdp34@njit.edu>
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			http://apiwiki.twitter.com/
 */

class Boo_Twitter extends Boo_Db {
	/**
	 * @brief Twitter username.
	 */
	protected $username = false;
	
	/**
	 * @brief Twitter password.
	 */
	protected $password = false;
	
	/**
	 * @brief Contains the last HTTP status code returned.
	 */
	protected $httpStatus = false;
	
	/**
	 * @brief Contains the last API call.
	 */
	protected $lastApiCall = false;
	
	/**
	 * @brief Contains the application calling the API.
	 * 
	 * @attention Must be registered first.
	 * @see http://twitter.com/help/request_source
	 */
	protected $applicationSource = 'boo';
	
	/**
	 * @brief Return format.
	 * @see Boo_Twitter::getSupportedFormat();
	 */
	protected $format = 'xml';
	
	/**
	 * @brief Array of supported formats.
	 */
	protected static $supportedFormats = array('xml', 'json', 'rss', 'atom');
	
	
	protected static $supportedDevices = array('sms', 'im', 'none');
	
	
	/**
	 * @brief Maximum length of username.
	 */
	const MAX_USERNAME_LENGTH = 15;
	
	/**
	 * @brief Minimum length of username.
	 */
	const MIN_USERNAME_LENGTH = 1;
	
	/**
	 * @brief Maximum length of password.
	 */
	const MAX_PASSWORD_LENGTH = 30;
	
	/**
	 * @brief Minimum length of password.
	 */
	const MIN_PASSWORD_LENGTH = 6;

	/**
	 * @brief Default constructor.
	 * @return void.
	 * @param string $username[optional] Twitter username.
	 * @param string $password[optional] Twitter password.
	 */
	public function __construct($username = false, $password = false) {
		if ($username !== false) {
			$this->setUsername($username);
		}
		
		if ($password !== false) {
			$this->setPassword($password);
		}
	}
	
	public function saveSession() {
		$_SESSION['booTwitter'] = serialize($this);
		return true;
	}
	
	public function openSession() {
		
		if ($this->hasSession()) {
			$session = unserialize($_SESSION['booTwitter']);
			foreach (get_object_vars($session) as $key => $value) {
				$this->$key = $value;
			}
			return true;
		} else {
			trigger_error('No Twitter session found', E_USER_WARNING);
			return false;
		}
	}
	
	public function hasSession() {
		return isset($_SESSION['booTwitter']);
	}
	
	public function getSession() {
		if ($this->hasSession()) {
			return unserialize($_SESSION['booTwitter']);
		} else {
			trigger_error('No Twitter session found', E_USER_NOTICE);
			return false;
		}
	}
	
	public static function getSupportedFormats() { return self::$supportedFormats; }
	
	public static function isSupportedFormat($format) {
		$format = strtolower(trim($format));
		return in_array($format, $this->supportedFormats);
	}
	
	public static function getSupportedDevices() { return self::$supportedDevices; }
	
	public static function isSupportedDevice($device) {
		$device = strtolower(trim($device));
		return in_array($device, $this->supportedDevices);
	}
	
	
	public function getCredentials() { return sprintf('%s:%s', $this->username, $this->password); }
	
	public function setApplicationSource($source) {
		$source = trim($source);
		if (Boo_Validator::isString($source)) {
			$this->applicationSource = $source;
			return true;
		} else {
			trigger_error("Source {$source} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	public function setFormat($format) {
		$this->format = strtolower(trim($format));
		
		if (self::isSupportedFormat($format)) {
			$this->format = $format;
			return true;
		} else {
			trigger_error("Format {$format} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	public function setUsername($username) {
		$username = trim($username);
		if (Boo_Validator::isAlphaNumPlus($username, Boo_Twitter::MIN_USERNAME_LENGTH, Boo_Twitter::MAX_USERNAME_LENGTH)) {
			$this->username = $username;
			return true;
		} else {
			trigger_error("Username {$username} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	public function getUsername() { return $this->username; }
	
	public function setPassword($password) {
		$password = trim($password);
		if (Boo_Validator::isString($password, Boo_Twitter::MIN_PASSWORD_LENGTH, Boo_Twitter::MAX_PASSWORD_LENGTH)) {
			$this->password = $password;
			return true;
		} else {
			trigger_error("Password {$password} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	public function getPublicTimeline($sinceId = 0) {
		$apiCall = sprintf('http://twitter.com/statuses/public_timeline.%s', $this->format);
		if ($sinceId > 0) {
			$apiCall .= sprintf('?since_id=%d', $sinceId);
		}
		return $this->apiCall($apiCall);
	}
	
	public function getFriendsTimeline($id = null, $since = null) {
		$id = trim($id);
		$since = trim($since);
		if ($id != null) {
			$apiCall = sprintf('http://twitter.com/statuses/friends_timeline/%s.%s', $id, $this->format);
		}
		else {
			$apiCall = sprintf('http://twitter.com/statuses/friends_timeline.%s', $this->format);
		}
		if ($since != null) {
			$apiCall .= sprintf('?since=%s', urlencode($since));
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function getUserTimeline($id = null, $count = 20, $since = null) {
		$id = trim($id);
		$since = trim($since);
		if ($id != null) {
			$apiCall = sprintf('http://twitter.com/statuses/user_timeline/%s.%s', $id, $this->format);
		}
		else {
			$apiCall = sprintf('http://twitter.com/statuses/user_timeline.%s', $this->format);
		}
		if ($count != 20) {
			$apiCall .= sprintf('?count=%d', $count);
		}
		if ($since != null) {
			$apiCall .= sprintf('%ssince=%s', (strpos($apiCall, '?count=') === false) ? '?' : '&', urlencode($since));
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function showStatus($id) {
		$apiCall = sprintf('http://twitter.com/statuses/show/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall);
	}
	
	public function updateStatus($status) {
		$status = urlencode(stripslashes(urldecode($status)));
		$apiCall = sprintf('http://twitter.com/statuses/update.xml?status=%s', $status);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function getReplies($page = 0) {
		$apiCall = sprintf('http://twitter.com/statuses/replies.%s', $this->format);
		if ($page) {
			$apiCall .= sprintf('?page=%d', $page);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function destroyStatus($id) {
		$apiCall = sprintf('http://twitter.com/statuses/destroy/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function getFriends($id = null) {
		$id = trim($id);
		// take care of the id parameter
		if ($id != null) {
			$apiCall = sprintf('http://twitter.com/statuses/friends/%s.%s', $id, $this->format);
		}
		else {
			$apiCall = sprintf('http://twitter.com/statuses/friends.%s', $this->format);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function getFollowers($id = null, $page = 1, $lite = false) {
		$id = trim($id);
		// either get authenticated users followers, or followers of specified id
		if ($id != null) {
			$apiCall = sprintf('http://twitter.com/statuses/followers/%s.%s', $id, $this->format);
		}
		else {
			$apiCall = sprintf('http://twitter.com/statuses/followers.%s', $this->format);
		}
		// pagination
		if ($page > 1) {
			$apiCall .= sprintf('?page=%d', $page);
		}
		// this isnt in the documentation, but apparently it works
		if ($lite) {
			$apiCall .= sprintf('%slite=true', ($page > 1) ? '&' : '?');
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function getFeatured() {
		$apiCall = sprintf('http://twitter.com/statuses/featured.%s', $this->format);
		return $this->apiCall($apiCall);
	}
	
	public function showUser($id) {
		$apiCall = sprintf('http://twitter.com/users/show/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true);
	}

	public function showUserByEmail($email) {
		$email = trim($email);
		
		if (!Boo_Validator::isEmail($email)) {
			trigger_error("Email {$email} is not valid", E_USER_WARNING);
			return false;
		}
		
		$apiCall = sprintf('http://twitter.com/users/show.xml?email=%s', $email);
		return $this->apiCall($apiCall, true);
	}
	
	public function showUserByScreenName($screenName) {
		$screenName = trim($screenName);
		$apiCall = sprintf('http://twitter.com/users/show.xml?screen_name=%s', $screenName);
		return $this->apiCall($apiCall, true);
	}
	
	public function getMessages($since = null, $sinceId = 0, $page = 1) {
		$since = trim($since);
		$apiCall = sprintf('http://twitter.com/direct_messages.%s', $this->format);
		if ($since != null) {
			$apiCall .= sprintf('?since=%s', urlencode($since));
		}
		if ($sinceId > 0) {
			$apiCall .= sprintf('%ssince_id=%d', (strpos($apiCall, '?since') === false) ? '?' : '&', $sinceId);
		}
		if ($page > 1) {
			$apiCall .= sprintf('%spage=%d', (strpos($apiCall, '?since') === false) ? '?' : '&', $page);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function getSentMessages($since = null, $sinceId = 0, $page = 1) {
		$since = trim($since);
		$apiCall = sprintf('http://twitter.com/direct_messages/sent.%s', $this->format);
		if ($since != null) {
			$apiCall .= sprintf('?since=%s', urlencode($since));
		}
		if ($sinceId > 0) {
			$apiCall .= sprintf('%ssince_id=%d', (strpos($apiCall, '?since') === false) ? '?' : '&', $sinceId);
		}
		if ($page > 1) {
			$apiCall .= sprintf('%spage=%d', (strpos($apiCall, '?since') === false) ? '?' : '&', $page);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function newMessage($user, $text) {
		$text = urlencode(stripslashes(urldecode($text)));
		$user = trim($user);
		$apiCall = sprintf('http://twitter.com/direct_messages/new.%s?user=%s&text=%s', $this->format, $user, $text);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function destroyMessage($id) {
		$apiCall = sprintf('http://twitter.com/direct_messages/destroy/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function createFriendship($id) {
		$apiCall = sprintf('http://twitter.com/friendships/create/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function destroyFriendship($id) {
		$apiCall = sprintf('http://twitter.com/friendships/destroy/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function friendshipExists($userA, $userB) {
		$userA = trim($userA);
		$userB = trim($userB);
		$apiCall = sprintf('http://twitter.com/friendships/exists.%s?user_a=%s&user_b=%s', $this->format, $userA, $userB);
		return $this->apiCall($apiCall, true);
	}
	
	public function verifyCredentials() {
		$apiCall = sprintf('http://twitter.com/account/verify_credentials.%s', $this->format);
		$apiCall = $this->apiCall($apiCall, true);
		
		if ($this->httpStatus == 200) {
			return true;
		} elseif ($this->httpStatus == 401) {
			return false;
		} else {
			trigger_error('Verify credentials failed, something is wrong', E_USER_WARNING);
			return false;
		}
	}
	
	public function endSession() {
		$apiCall = 'http://twitter.com/account/end_session';
		return $this->apiCall($apiCall, true);
	}
	
	/**
	 * @brief Updates location.
	 * @depreciated
	 * @return mixed Twitter data.
	 * @param string $location Your location.
	 */
	public function updateLocation($location) {
		$location = trim($location);
		$apiCall = sprintf('http://twitter.com/account/update_location.%s?location=%s', $this->format, $location);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function updateDeliveryDevice($device) {
		$device = strtolower(trim($device));
		if (self::isSupportedDevice($device)) {
			$apiCall = sprintf('http://twitter.com/account/update_delivery_device.%s?device=%s', $this->format, $device);
			return $this->apiCall($apiCall, true, true);
		} else {
			trigger_error("Device {$device} is not supported", E_USER_WARNING);
			return false;
		}
	}
	
	public function getRateLimitStatus() {
		$apiCall = sprintf('http://twitter.com/account/rate_limit_status.%s', $this->format);
		return $this->apiCall($apiCall, true);
	}
	
	public function getArchive($page = 1) {
		$apiCall = sprintf('http://twitter.com/account/archive.%s', $this->format);
		if ($page > 1) {
			$apiCall .= sprintf('?page=%d', $page);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function getFavorites($id = null, $page = 1) {
		$id = trim($id);
		$page = (int) $page;
		if ($id == null) {
			$apiCall = sprintf('http://twitter.com/favorites.%s', $this->format);
		}
		else {
			$apiCall = sprintf('http://twitter.com/favorites/%s.%s', $id, $this->format);
		}
		if ($page > 1) {
			$apiCall .= sprintf('?page=%d', $page);
		}
		return $this->apiCall($apiCall, true);
	}
	
	public function createFavorite($id) {
		$apiCall = sprintf('http://twitter.com/favorites/create/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function destroyFavorite($id) {
		$apiCall = sprintf('http://twitter.com/favorites/destroy/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function follow($id) {
		$apiCall = sprintf('http://twitter.com/notifications/follow/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function leave($id) {
		$apiCall = sprintf('http://twitter.com/notifications/leave/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function createBlock($id) {
		$apiCall = sprintf('http://twitter.com/blocks/create/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function destroyBlock($id) {
		$apiCall = sprintf('http://twitter.com/blocks/destroy/%d.%s', $id, $this->format);
		return $this->apiCall($apiCall, true, true);
	}
	
	public function test() {
		$apiCall = sprintf('http://twitter.com/help/test.%s', $this->format);
		return $this->apiCall($apiCall, true);
	}
	
	public function getDowntimeSchedule() {
		$apiCall = sprintf('http://twitter.com/help/downtime_schedule.%s', $this->format);
		return $this->apiCall($apiCall, true);
	}
	
	protected function apiCall($apiUrl, $requireCredentials = false, $httpPost = false) {
		if (!$this->beforeApiCall($apiUrl)) {
			return false;
		}
		
		$curlHandle = curl_init();
		
		if($this->applicationSource) {
			if (strpos($apiUrl, '?') === false) {
				$apiUrl .= '?source=' . urlencode($this->applicationSource); // first
			} else {
				$apiUrl .= '&source=' . urlencode($this->applicationSource); // not first
			}
		}
		curl_setopt($curlHandle, CURLOPT_URL, $apiUrl);
		
		if ($requireCredentials) {
			curl_setopt($curlHandle, CURLOPT_USERPWD, $this->getCredentials());
		}
		
		if ($httpPost) {
			curl_setopt($curlHandle, CURLOPT_POST, true);
		}
		
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Expect:'));
		
		$twitterData = curl_exec($curlHandle);
		$this->httpStatus = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
		$this->lastApiCall = $apiUrl;
		
		curl_close($curlHandle);
		
		return $this->afterApiCall($twitterData);
	}
	
	protected function beforeApiCall($apiUrl) {
		return true;
	}
	
	protected function afterApiCall($twitterData) {
		return $twitterData;
	}
	
	public function lastStatusCode() { return $this->httpStatus; }
	
	public function lastApiCall() { return $this->lastApiCall; }
}

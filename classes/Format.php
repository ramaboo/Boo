<?php
/* SVN FILE: $Id: Format.php 237 2009-05-25 05:47:45Z david@ramaboo.com $ */
/**
 * @brief Format class.
 * 
 * This class is used for basic input formating.
 * 
 * @class		Boo_Format
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Format {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {}
	
	/**
	 * @brief Formats URL.
	 * 
	 * @param string $url The URL.
	 * @param int $format[optional] The format.
	 * @return string Returns formated URL on success, FALSE on failure.
	 * 
	 * @todo Finish function.
	 */
	public static function formatUrl($url, $format = 0) {
		if (BOO_DEBUG) { trigger_error('Warning Boo_Format::formatUrl() is not finished', E_USER_WARNING); }
		$url = trim($url);
		if (!$url) {
			return false;
		}
		return Boo_Helper::addHttp($url);
	}
	
	/**
	 * @brief Formats URI.
	 * 
	 * @param string $url The URI.
	 * @param int $format[optional] The format.
	 * @return string Returns formated URI on success, FALSE on failure.
	 * 
	 * @todo Finish function.
	 */
	public static function formatUri($uri, $format = 0) {
		if (BOO_DEBUG) { trigger_error('Warning Boo_Format::formatUri() is not finished', E_USER_WARNING); }
		$uri = trim($uri);
		if (!$uri) {
			return false;
		}
		return Boo_Helper::addHttp($url);
	}
	
	/**
	 * @brief Formats phone number.
	 * 
	 * @param string $phoneNumber The phone number.
	 * @param int $format[optional] The format.
	 * 
	 * Possible formats are:
	 * \li 0 = 8003682669
	 * \li 1 = 800-368-2669
	 * \li 2 = (800) 368-2669
	 * \li 3 = 800.368.2669
	 * 
	 * @return string Formated phone number, FALSE on failure.
	 */
	public static function formatPhoneNumber($phoneNumber, $format = 0) {
		$phoneNumber = trim($phoneNumber);
		$result = false;
		
		$phoneNumber = Boo_Helper::removeNonNumeric($phoneNumber);
		
		// test phone number
		if (!Boo_Validator::isPhoneNumber($phoneNumber)) {
			trigger_error("Phone number {$phoneNumber} is not valid", E_USER_NOTICE);
			return false;
		}
		
		// clean up phone number
		if (strlen($phoneNumber) == 11 && substr($phoneNumber, 0, 1) == 1) {
			// remove leading 1 from phone number
			$phoneNumber = substr($phoneNumber, 1);
		}
		
		switch ($format) {
			case 0: // 5555555555
				$result = $phoneNumber;
				break;
			case 1: // 555-555-5555
				$result = substr($phoneNumber, 0, 3). '-' . substr($phoneNumber, 3, 3) . '-' . substr($phoneNumber, 6, 4);
				break;
			case 2: // (555) 555-5555
				$result = '('. substr($phoneNumber, 0, 3). ') ' . substr($phoneNumber, 3, 3) . '-' . substr($phoneNumber, 6, 4);
				break;
			case 3: // 555.555.5555
				$result = substr($phoneNumber, 0, 3). '.' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 4);
				break;
			default:
				trigger_error("Format {$format} is not valid", E_USER_ERROR);
				return false;
		}
		
		return $result;
	}
	
	
	/**
	 * @brief Formats phone extension.
	 * 
	 * @param string $phoneExt The phone extension.
	 * @param int $format[optional] The format.
	 * 
	 * Possible formats are:
	 * \li 0 = 1234
	 * \li 1 = x1234
	 * 
	 * @return string Formated phone extension, FALSE on failure.
	 */
	public static function formatPhoneExtension($phoneExt, $format = 0) {
		$phoneExt = trim($phoneExt);
		$result = false;
		
		$phoneExt = Boo_Helper::removeNonNumeric($phoneExt);
		
		// test phone number
		if (!Boo_Validator::isPhoneExtenstion($phoneExt)) {
			trigger_error("Phone extension {$phoneExt} is not valid", E_USER_WARNING);
			return false;
		}
		
		switch ($format) {
			case 0: // 1234
				$result = $phoneExt;
				break;
			case 1: // x1234
				$result = 'x' . $phoneExt;
				break;
			default:
				trigger_error("Format {$format} is not valid", E_USER_ERROR);
				return false;
		}
		
		return $result;
	}
	
	/**
	 * @brief Formats ZIP code.
	 * 
	 * @param string $zip The ZIP code.
	 * @param int $format[optional] The format.
	 * 
	 * Possible formats are:
	 * \li 0 = 123451234
	 * \li 1 = 12345-1234
	 * 
	 * @return string Formated ZIP code, FALSE on failure.
	 * @todo International support.
	 */
	public static function formatZip($zip, $format = 0) {
		$zip = trim($zip);
		$result = false;
		
		if ($zip == null) {
			return false; 
		}
		
		$zip = Boo_Helper::removeNonNumeric($zip);
		
		if (!Boo_Validator::isZip($zip)) {
			trigger_error("Zip code {$zip} is not valid", E_USER_WARNING);
			return false;
		}
		
		switch ($format) {
			case 0:
				$result = $zip;
				break;
			case 1: // 12345-1234
				$length = strlen($zip);
				if ($length == 5) { // 5 digit code
					$result = $zip;
				} elseif ($length == 9) { // 9 digit code
					$result = substr($phoneNumber, 0, 5). '-' . substr($phoneNumber, 5, 4);
				} else {
					trigger_error("Zip code {$zip} with length {$length} is not valid", E_USER_WARNING);
					return false;
				}
				break;
			default:
				trigger_error("Format {$format} is not valid", E_USER_WARNING);
				return false;
		}
		
		return $result;
	}
	
	/**
	 * @brief Formats a card number.
	 * 
	 * Possible formats are:
	 * \li 0 = 5424000000000015
	 * 
	 * @param string $cardNumber The card number.
	 * @param int $format[optional] The format.
	 * 
	 * @return string Formated card number on success, FALSE on failure.
	 * 
	 * @todo Add more formats.
	 */
	public static function formatCardNumber($cardNumber, $format = 0) {
		$cardNumber = trim($cardNumber);
		
		if (Boo_Validator::isCardNumber($cardNumber)) {
			return Boo_Helper::removeNonNumeric($cardNumber);
		} else {
			trigger_error('Card number (hidden) is not valid', E_USER_WARNING);
			return false;
		}
		
	}
	
	/**
	 * @brief Formats expiration date.
	 * 
	 * Expiration date can be in the following formats:
	 * \li MMYY
	 * \li MM/YY
	 * \li MM-YY
	 * \li MMYYYY
	 * \li MM/YYYY
	 * \li MM-YYYY
	 * \li YYYY-MM-DD
	 * \li YYYY/MM/DD
	 * 
	 * Possible formats are:
	 * \li 0 = MMDD
	 * 
	 * @param string $expDate The expiration date.
	 * @param int $format[optional] The format.
	 * @todo Add support for other formats.
	 * @return string Formated expiration date on success, FALSE on failure.
	 */
	public static function formatExpDate($expDate, $format = 0) {
		$expDate = trim($expDate);
		if (Boo_Validator::isNull($expDate)) {
			return false;
		}
		
		
		$expDate = Boo_Helper::removeNonNumeric($expDate);
		$length = strlen($expDate);
		
		$year = ''; $month = '';
		// parse out year, month, and day
		switch ($length) {
			
			case 4: // MMYY
				$month = substr($expDate, 0, 2);
				$year = substr($expDate, 2, 2);
				break;
				
			case 6: // MMYYYY
				$month = substr($expDate, 0, 2);
				$year = substr($expDate, 4, 2);
				break;
				
			case 8: // YYYYMMDD
				$month = substr($expDate, 4, 2);
				$year = substr($expDate, 2, 2);
				break;
				
			default:
				trigger_error("Expiration date {$expDate} is not valid.", E_USER_WARNING);
				return false;
		}
		
		return $month . $year;
		
	}
	
	/**
	 * @brief Formats email address.
	 * 
	 * @param string $email The email address.
	 * @param int $format[optional] The format.
	 * @return bool Returns formated email address on success, FALSE on failure.
	 * @todo Add additional formats.
	 */
	public static function formatEmail($email, $format = 0) {
		$email = strtolower(trim($email));
		
		if (Boo_Validator::isEmail($email)) {
			return $email;
		} else {
			trigger_error("Email address {$email} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Formats a Socical Security number.
	 * 
	 * @param string $ssNumber The Social Security number.
	 * @param int $format[optional] The format.
	 * @return bool Returns formated Social Security number on success, FALSE on failure.
	 * @todo Add additional formats.
	 */
	public static function formatSocialSecurityNumber($ssNumber, $format = 0) {
		$ssNumber = trim($ssNumber);
		$ssNumber = ereg_replace('[^0-9]+', '', $ssNumber);
		
		if (Boo_Validator::isSocialSecurityNumber($ssNumber)) {
			return substr($ssNumber, 0, 3) . '-' . substr($ssNumber, 3, 2) . '-' . substr($ssNumber, 5, 4);
			
		} else {
			trigger_error("Social Security number {$ssNumber} is not valid", E_USER_WARNING);
			return false;
		}
		
	}
	
	/**
	 * @brief Formats prices.
	 * 
	 * @param string $price The price.
	 * @param string $format[optional] The format.
	 * @return bool Returns formated price on success, FALSE on failure.
	 * @todo Add additional formats.
	 */
	public static function formatPrice($price, $format = 0) {
		$price = Boo_Helper::removeCurrencySymbol($price);
		$format = strtolower(trim($format));
		
		if (Boo_Validator::isNull($price)) {
			return '0.00';
		}
		
		if (Boo_Validator::isPrice($price)) {
			
			switch ($format) {
				case '0':
					return number_format($price, 2);
					break;
				case '1': case 'db':
					return number_format($price, 2, '.', '');
					break;
					
				default:
					trigger_error("Fromat {$format} is not valid", E_USER_ERROR);
					return false;
				}
		} else {
			trigger_error("Price {$price} is not valid", E_USER_WARNING);
			return false;
		}
		
	}
	
	/**
	 * @brief Formats a value.
	 * 
	 * Use # in the format rule to represent the value.
	 * 
	 * @param string $value The value to format.
	 * @param string $formatRule The format rule.
	 * @return mixed The value if format was successful, FALSE otherwise.
	 */
	public static function format($value, $formatRule) {
		$value = trim($value);
		$value = quote($value);
		
		// make dollar sign safe
		$value = str_replace('$', '\$', $value);
		
		$formatRule = trim($formatRule);
		// add ending semicolon if needed
		if (substr($formatRule, -1) != ';') {
			$formatRule .= ';';
		}
		$formatRule = str_replace('#', $value, $formatRule);
		
		$result = eval("return {$formatRule}");
		return $result;
	}
}
<?php
/* SVN FILE: $Id: Helper.php 215 2009-03-17 01:15:42Z david@ramaboo.com $ */
/**
 * @brief Helper class.
 * 
 * The helper class is used to preform many common functions that
 * do not necessarily belong in other classes.
 * 
 * @class		Boo_Helper
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Helper {

	/**
	 * @brief Returns the given lower case and underscored word as a Pascal case word.
	 * 
	 * @param string $underscoredWord Word to convert.
	 * @return string Pascal case word. LikeThis.
	 * @copyright Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 2.0.0
	 */
	public static function toPascalCase($underscoredWord) {
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $underscoredWord)));
	}
	
	/**
	 * @brief Returns the given lower case and underscored word as a lower camel caseed word.
	 * 
	 * @param string $underscoredWord Word to convert.
	 * @return string Lower camel case word. likeThis.
	 * @since 2.0.0
	 */
	public static function toCamelCase($underscoredWord) {
		$tmp = self::toPascalCase($underscoredWord);
		
		if (strlen($tmp) > 0) {
			$tmp[0] = strtolower($tmp[0]);
			
		}
		return $tmp;
	}
	
	/**
	 * @brief Returns the given word as an underscored word.
	 * 
	 * @param string $camelCase Camel cased word to be underscorized.
	 * @return string Underscored version of the camel case word. like_this.
	 * @copyright Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 2.0.0
	*/
	public static function toUnderscoreCase($camelCase) {
		return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCase));
	}
	
	/**
	 * @brief Returns given string in filename case.
	 * 
	 * @return The string in filename case. like_this or like-this.
	 * @param string $mixedCase The string to convert.
	 * @since 2.0.5
	 */
	public static function toFilenameCase($mixedCase) {
		$string = self::toUnderscoreCase($mixedCase);
		return $string;
	}
	
	/**
	 * @brief Adds http://.
	 * 
	 * Adds http:// to the \c $url. If https:// or http:// is present then the original \c $url is returned.
	 * 
	 * @param string $url The url. 
	 * @return string The formatted url.
	 */
	public static function addHttp($url) {
		// adds http:// if absent
		// if the url starts with https:// nothing is done
		if ((strtolower(substr($url, 0, 7)) != 'http://') && (strtolower(substr($url, 0, 8)) != 'https://')) {
			return 'http://' . $url;
		} else {
			return $url;
		}
	}
	
	/**
	 * @brief Adds https://.
	 * 
	 * Adds https:// to the \c $url. If http:// is present, it is replaced with https://.
	 * 
	 * @param string $url The url. 
	 * @return string The formatted url.
	 */
	public static function addHttps($url) {
		// add https:// if absent
		if (strtolower(substr($url, 0, 8)) != 'https://') {
			if ((strtolower(substr($url, 0, 7)) == 'http://')) {
				$url = substr($url, 7); // remove http://
			}
			
			return 'https://' . $url;
		} else {
			return $url;
		}
	}
	
	/**
	 * @brief Returns state name.
	 * 
	 * @param string $code The state code. 
	 * @return string The state name.
	 */
	public static function getStateNameByCode($code) {
		$code = strtoupper($code);
		if (isset(Boo_Validator::$states[$code])) {
			return Boo_Validator::$states[$code];
		} else { 
			trigger_error("State code {$code} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Returns state code.
	 * 
 	 * @param string $name The state name.
	 * @return string The state code.
	 */
	public static function getStateCodeByName($name) {
		$name = strtolower(trim($name));
		
		$states = array_map('strtolower', Boo_Validator::$states);
		
		$key = $arraySearch($states, $name);
		if ($key) {
			return $key;
		} else { 
			trigger_error("State name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Returns country name.
	 * 
 	 * @param string $code The country code. 
	 * @return string The country name.
	 */
	public static function getCountryNameByCode($code) {
		$code = strtoupper($code);
		if (isset(Boo_Validator::$countries[$code])) {
			return Boo_Validator::$countries[$code];
		} else { 
			trigger_error("Country code {$code} is not valid", E_USER_WARNING);
			return false;
		}	
	}
	
	/**
	 * @brief Removes non numeric characters.
	 * 
	 * Removes all characters except [0123456789] from a string.
	 * 
 	 * @param string $string The string.
	 * @return string The formated string.
	 */
	public static function removeNonNumeric($string) {
		$string = preg_replace('%[^0-9]%', '', $string);
		return $string;
	}
	
	/**
	 * @brief Removes non decimal characters.
	 * 
	 * Removes all characters except [0123456789.] from a string.
	 * 
 	 * @param string $string The string. 
	 * @return string The formated string.
	 */
	public static function removeNonDecimal($string) {
		$string = preg_replace('%[^0-9\.]%', '', $string);
		return $string;
	}
	
	/**
	 * @brief Removes the currency symbol.
	 * 
	 * You must correctly set \c BOO_CURRENCY_SYMBOL in your config file for this function to work.
	 * 
 	 * @param string $price The price.
	 * @return string The formated price.
	 */
	public static function removeCurrencySymbol($price) {
		$price = trim($price);
		if (substr($price, 0, 1) == BOO_CURRENCY_SYMBOL) {
			$price = substr($price, 1);
		}
		return $price;
	}
	
	/**
	 * @brief Returns file extension.
	 * 
	 * Updated to use PHP function \c pathinfo() instead.
	 * If the file is a backup file (ends in a tilde) then a tilde
	 * is returned regardles of extension.
	 * 
	 * @param string $filename The filename.
	 * @return string The file extension. If no file extension is included NULL returned, FALSE on error.
	 */
	public static function getFileExtension($filename) {
			if ($filename == null) {
				trigger_error('Filename can not be null', E_USER_NOTICE);
				return false;
			}
			
			$pathParts = pathinfo($filename);
			$ext = isset($pathParts['extension']) ? $pathParts['extension'] : null;
			
			if (substr($filename, -1) == '~') {
				// backup file
				$ext = '~';
			}
			
			return $ext;
	}
	
	/**
	 * @brief Returns a unique MD5 string.
	 * 
	 * @return string Unique MD5 string.
	 */
	public static function getUniqueMd5() {
		return hash('md5', uniqid(mt_rand(), true));
	}
	
	/**
	 * @brief Generates a Universally Unique IDentifier, version 4.
	 * 
	 * @see http://www.ietf.org/rfc/rfc4122.txt
	 * @see http://en.wikipedia.org/wiki/UUID
	 * @return string A UUID, made up of 32 hex digits and 4 hyphens.
	 */
	public static function getUuid() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
	}
}
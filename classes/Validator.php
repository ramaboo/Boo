<?php
/* SVN FILE: $Id: Validator.php 240 2009-10-19 07:39:14Z david@ramaboo.com $ */
/**
 * @brief Validator class.
 * 
 * This class is used to validate data.
 * 
 * Boo validation functions ignore leading and trailing whitespace.
 * For example Boo_Validator::isInt("   16   ") will return TRUE.
 * 
 * @class		Boo_Validator
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.0
 */

class Boo_Validator {
	
	/**
	 * @brief Array of countries.
	 * 
	 * The array contains the country names (official short names in English) in alphabetical order as given in ISO 3166-1 and the corresponding ISO 3166-1-alpha-2 code.
	 * The array index is the ISO 3166-1-alpha-2 code in strtoupper format. 
	 * The array value is the short country name in ucword format (with the exception of the words "of, "and", "the").
	 * There are currently 246 countries in the array.
	 * 
	 * Updated 2008-08-08.
	 * 
	 * @see http://www.iso.org/iso/country_codes/iso_3166_code_lists/
	 * 
	 */
	protected static $countries = array(
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua and Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia and Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, The Democratic Republic of the',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island and Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KP' => 'Korea, Democratic People\'s Republic of',
		'KR' => 'Korea, Republic of',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia, The Former Yugoslav Republic of',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States of',
		'MD' => 'Moldova, Republic of',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre and Miquelon',
		'VC' => 'Saint Vincent and the Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome and Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia and the South Sandwich Islands',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard and Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan, Province of China',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania, United Republic of',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks and Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Minor Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis and Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe');
	
	/**
	 * @brief Array of states.
	 * 
	 * The array contains all 50 state names plus the District of Columbia in alphabetical order and the corisponding abbreviations.
	 * The array index is the state abbreviation in strtoupper format.
	 * The array value is the state name in ucword format (with the exception of the word "of").
	 * There are currently 51 states in the array.
	 */
	protected static $states = array(
		'AL' => 'Alabama', 
		'AK' => 'Alaska', 
		'AZ' => 'Arizona', 
		'AR' => 'Arkansas', 
		'CA' => 'California', 
		'CO' => 'Colorado', 
		'CT' => 'Connecticut', 
		'DE' => 'Delaware', 
		'DC' => 'District of Columbia', 
		'FL' => 'Florida', 
		'GA' => 'Georgia', 
		'HI' => 'Hawaii', 
		'ID' => 'Idaho', 
		'IN' => 'Illinois', 
		'IL' => 'Indiana', 
		'IA' => 'Iowa', 
		'KS' => 'Kansas', 
		'KY' => 'Kentucky', 
		'LA' => 'Louisiana', 
		'ME' => 'Maine', 
		'MD' => 'Maryland', 
		'MA' => 'Massachusetts', 
		'MI' => 'Michigan', 
		'MN' => 'Minnesota', 
		'MS' => 'Mississippi', 
		'MO' => 'Missouri', 
		'MT' => 'Montana', 
		'NE' => 'Nebraska', 
		'NV' => 'Nevada', 
		'NH' => 'New Hampshire', 
		'NJ' => 'New Jersey', 
		'NM' => 'New Mexico', 
		'NY' => 'New York', 
		'NC' => 'North Carolina', 
		'ND' => 'North Dakota', 
		'OH' => 'Ohio', 
		'OK' => 'Oklahoma', 
		'OR' => 'Oregon', 
		'PA' => 'Pennsylvania', 
		'RI' => 'Rhode Island', 
		'SC' => 'South Carolina', 
		'SD' => 'South Dakota', 
		'TN' => 'Tennessee', 
		'TX' => 'Texas', 
		'UT' => 'Utah', 
		'VT' => 'Vermont', 
		'VA' => 'Virginia', 
		'WA' => 'Washington', 
		'WV' => 'West Virginia', 
		'WI' => 'Wisconsin', 
		'WY' => 'Wyoming');
	
	/**
	 * @brief Array of Greek letters.
	 * 
	 * @see http://en.wikipedia.org/wiki/Greek_alphabet
	 * Key is numeric value, value is the English word.
	 */
	protected static $greekLetters = array(
		1 => 'Alpha',
		2 => 'Beta',
		3 => 'Gamma',
		4 => 'Delta',
		5 => 'Epsilon',
		7 => 'Zeta',
		8 => 'Eta',
		9 => 'Theta',
		10 => 'Iota',
		20 => 'Kappa',
		30 => 'Lambda',
		40 => 'Mu',
		50 => 'Nu',
		60 => 'Xi',
		70 => 'Omicron',
		80 => 'Pi',
		100 => 'Rho',
		200 => 'Sigma',
		300 => 'Tau',
		400 => 'Upsilon',
		500 => 'Phi',
		600 => 'Chi',
		700 => 'Psi',
		800 => 'Omega');
	
	
	/**
	 * @brief Quick array for doing yes and no.
	 */
	protected static $yesNo = array(
		1 => 'Yes',
		0 => 'No');
	
	/**
	 * @brief Quick array for doing true and false.
	 */
	protected static $trueFalse = array(
		1 => 'True',
		0 => 'False');
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {}
	
	/**
	 * @brief Returns an array of states.
	 * @return array Array of states. Key is the state code, value is state name with the first letter capitalized.
	 */
	public static function getStates() { return self::$states; }
	
	/**
	 * @brief Returns an array of countries.
	 * @return array Array of states. Key is the country code, value is country name with the first letter capitalized.
	 */
	public static function getCountries() { return self::$countries; }
	
	/**
	 * @brief Validates a value.
	 * 
	 * Use # (pound sign) in the validation rule to represent the value.
	 * 
	 * You should only use this function if you need to store a validation rule as a string of text 
	 * such as in an xml file for use with Boo_Form. Calling member functions directly is much more efficient.
	 * 
	 * @param string $value The value to validate.
	 * @param string $validationRule The validation code (must be valid PHP).
	 * @param bool $required[optional] Value is required (not null).
	 * @return bool Returns TRUE if validation was successful, FALSE otherwise.
	 * 
	 * @code
	 * Boo_Validator::validate(5, "Boo_Validator::isInt(#, 3, 8);", true);
	 * // returns TRUE
	 * @endcode
	 */
	
	/**
	 * @brief Gets the yes or no array.
	 * @return array Returns yes or no array. The key is the integer, value is the word.
	 */
	public static function getYesNo() {
		return self::$yesNo;
	}
	
	/**
	 * @brief Gets the greek letters array.
	 * @return array Returns greek letters array. The key is the value of the lettter, value is the English word.
	 */
	public static function getGreekLetters() {
		return self::$greekLetters;
	}
	
	/**
	 * @brief Gets the true or false array.
	 * @return array Returns true or false array. The key is the integer, value is the word.
	 */
	public static function getTrueFalse() {
		return self::$trueFalse;
	}
	
	public static function validate($value, $validationRule, $required = true) {
		$value = trim($value);
		$value = quote(addslashes($value));
		
		// make dollar sign safe
		$value = str_replace('$', '\$', $value);
		
		$validationRule = trim($validationRule);
		// add ending semicolon if needed
		if (substr($validationRule, -1) != ';') {
			$validationRule .= ';';
		}
		$validationRule = str_replace('#', $value, $validationRule);
		
		//echo "Validation Rule: {$validationRule}<br /><br />"; // useful for debugging
		
		$result = eval("return $validationRule");
		
		// special case for allowing null values
		if (!$required && $value == "\"\"") { // double quotes because of call to quote()
			$result = true;
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if a value is a string or not.
	 * 
	 * @param string $string The value to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @return bool Returns TRUE if it is a string, FALSE otherwise.
	 */
	public static function isString($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		if (strlen($string) > 0) {
			$result = true;
			if ($min !== false) {
				$result = $result && (strlen($string) >= $min);
			}
			if ($max !== false) {
				$result = $result && (strlen($string) <= $max);
			}
		}
		return $result;
	}
	
	/**
	 * @brief Determines if a value is alphabetic.
	 * 
	 * Alphabetic is defined as [A-Za-z].
	 * 
	 * @param string $string The value to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @return bool Returns TRUE if value is alphabetic, FALSE otherwise.
	 * @see http://us3.php.net/manual/en/function.ctype-alpha.php
	 */
	public static function isAlpha($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		if (ctype_alpha($string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && (strlen($string) >= $min);
			}
			if ($max !== false) {
				$result = $result && (strlen($string) <= $max);
			}
		}
		return $result;
	}
	
	/**
	 * @brief Determines if a value is alphanumeric.
	 * 
	 * Alphanumeric is defined as [A-Za-z0-9].
	 * 
	 * @param string $string The value to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @return bool Returns TRUE if value is alphanumeric, FALSE otherwise.
	 * @see http://us3.php.net/manual/en/function.ctype-alnum.php
	 */
	public static function isAlphaNum($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		if (ctype_alnum($string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && (strlen($string) >= $min);
			}
			if ($max !== false) {
				$result = $result && (strlen($string) <= $max);
			}
		}
		return $result;
	}
	
	/**
	 * @brief Determines if a value is alphanumeric plus the undersocre.
	 * 
	 * Alphanumeric is defined as [A-Za-z0-9_].
	 * 
	 * @param string $string The value to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @param bool $firstChar[optional] If TRUE the first character must be a letter.
	 * @return bool Returns TRUE if value is alphanumeric, FALSE otherwise.
	 */
	public static function isAlphaNumPlus($string, $min = false, $max = false, $firstChar = false) {
		$string = trim($string);
		$result = false;
		if (preg_match('/^[A-Za-z0-9_]*$/', $string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && (strlen($string) >= $min);
			}
			if ($max !== false) {
				$result = $result && (strlen($string) <= $max);
			}
			
			if ($firstChar) {
				// first character must be letter
				$result = $result && self::isAlpha(substr($string, 0 , 1));
			}
		}
		return $result;
	}
	
	/**
	 * @brief Determines if a value is alphanumeric plus some common characters.
	 * 
	 * Alphanumeric is defined as [A-Za-z0-9_-.()].
	 * 
	 * @param string $string The value to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @param bool $firstChar[optional] If TRUE the first character must be a letter.
	 * @return bool Returns TRUE if value is alphanumeric, FALSE otherwise.
	 * @todo Maybe add more characters.
	 */
	public static function isAlphaNumExtended($string, $min = false, $max = false, $firstChar = false) {
		$string = trim($string);
		$result = false;
		if (preg_match('/^[A-Za-z0-9_\-\.\(\)]*$/', $string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && (strlen($string) >= $min);
			}
			if ($max !== false) {
				$result = $result && (strlen($string) <= $max);
			}
			
			if ($firstChar) {
				// first character must be letter
				$result = $result && self::isAlpha(substr($string, 0 , 1));
			}
		}
		return $result;
	}
	
	/**
	 * @brief Determines if string contains only ASCII printable characters.
	 * 
	 * @see Boo_Charset::getPrintable().
	 * 
	 * @param string $string The string to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @return bool Returns TRUE if string contains only ASCII printable characters, FALSE otherwise.
	 */
	public static function isPrintable($string, $min = false, $max = false) {
		$string = trim($string);
		$result = true;
		foreach (str_split($string) as $value) {
			if (strpos(Boo_Charset::getPrintable(), $value) === false) {
				$result = false;
				break;
			}
		}
		
		if ($min !== false) {
			$result = $result && (strlen($string) >= $min);
		}
		if ($max !== false) {
			$result = $result && (strlen($string) <= $max);
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if string contains only hexadecimal characters.
	 * 
	 * @see Boo_Charset::getHex().
	 * 
	 * @param string $string The string to test.
	 * @param integer $min[optional] The minimum length of the string.
	 * @param integer $max[optional] The maximum length of the string.
	 * @return bool Returns TRUE if string contains only hexadecimal characters, FALSE otherwise.
	 */
	public static function isHex($string, $min = false, $max = false) {
		$string = strtolower(trim($string));
		$result = true;
		
		if (preg_match('/^[a-f0-9]*$/', $string)) {
			$result = true;
		} else {
			$result = false;
		}
		
		if ($min !== false) {
			$result = $result && (strlen($string) >= $min);
		}
		if ($max !== false) {
			$result = $result && (strlen($string) <= $max);
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if string is a Social Security number.
	 * 
	 * Social Security number can be in any format. Use Boo_Format::formatSocialSecurityNumber() if you 
	 * want the data properly formated.
	 * 
	 * @warning This function is only a rough validator as it does not check for reserved numbers such as 666-xx-xxxx or xxx-xx-0000, etc.
	 * 
	 * @return bool Returns TRUE if string is a Socical Security number, FALSE otherwise.
	 * @param string $ssNumber The string to test.
	 * @see http://en.wikipedia.org/wiki/Social_security_number
	 */
	public static function isSocialSecurityNumber($ssNumber) {
		$ssNumber = trim($ssNumber);
		$ssNumber = ereg_replace('[^0-9]+', '', $ssNumber);
		
		if ($ssNumber == '') {
			return false;
		}
		
		if (strlen($ssNumber) == 9) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if a string is numeric.
	 * 
	 * Preforms the same function as the built in PHP function \c is_numeric().
	 * 
	 * @param string $string The test string.
	 * @param int $min Minimum value of the number.
	 * @param int $max Maximum value of the number.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @see http://us3.php.net/manual/en/function.is-numeric.php
	 */
	public static function isNumeric($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		if (is_numeric($string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && $string >= $min;
			}
			if ($max !== false) {
				$result = $result && $string <= $max;
			}
		}
		return $result;
		
	}
	
	/**
	 * @brief Determines if a string is a float.
	 * 
	 * @param string $string The test string.
	 * @param int $min Minimum value of the number.
	 * @param int $max Maximum value of the number.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isFloat($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		if (preg_match('/^(\d?)+(\.\d*)?$/', $string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && $string >= $min;
			}
			if ($max !== false) {
				$result = $result && $string <= $max;
			}
		}
		return $result;
		
	}
	
	/**
	 * @brief Determines if a string is a price.
	 * 
	 * The maximum price is 16 characters or 14 with 2 decimal places.
	 * This is the same as MySQL 5 datatype decimal(16,2).
	 * 
	 * @param string $string The test string.
	 * @param int $min Minimum value of the number.
	 * @param int $max Maximum value of the number.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isPrice($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		
		// remove curancy symbol
		$string = Boo_Helper::removeCurrencySymbol($string);
		
		if (preg_match('/(^[0-9]{1,16}$)|(^[0-9]{1,14}[\.][0-9]{1,2}$)/', $string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && $string >= $min;
			}
			if ($max !== false) {
				$result = $result && $string <= $max;
			}
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if a string is an integer.
	 * 
	 * Preforms the same function as the built in PHP function \c ctype_digit()
	 * except this will allow negative integers and does not require a string variable.
	 * 
	 * @param string $string The test string.
	 * @param int $min Minimum value of the number.
	 * @param int $max Maximum value of the number.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @see http://us3.php.net/manual/en/function.ctype-digit.php
	 */
	public static function isInt($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;
		// is all numbers or is a negitve sign and all numbers
		if (ctype_digit($string) || (substr($string, 0, 1) == '-' && ctype_digit(substr($string, 1)))) {
			$result = true;
			if ($min !== false) {
				$result = $result && $string >= $min;
			}
			if ($max !== false) {
				$result = $result && $string <= $max;
			}
		}
		return $result;
	}
	
	public static function isBooId($id) {
		$id = trim($id);
		$result = false;
		if (ctype_digit($id) && $id <= PHP_INT_MAX) {
			$result = true;
		}
		
		return $result;
	}
	
	
	public static function isDate($date) {
		$date = trim($date);
		return preg_match(BOO_REGEX_DATE, $date);
	}
	
	/**
	 * @brief Determines if a string is a date of a given format.
	 * 
	 * This only supports time formats supported by the PHP \c date() function and \c strtotime().
	 * 
	 * @param string $date The date to test.
	 * @param mixed $format The date format. Accepts a single format as a string or an array of formats.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @todo Test function.
	 */
	public static function isDateFormat($date, $format) {
		$date = trim($date);
		$timestamp = strtotime($date);
		
		$result = false;
		$formats = array();
		if (is_string($format)) {
			$formats[] = $format;
		} // else its an array
		
		foreach ($formats as $key => $value) {
			$phpDate = date($value, $timestamp);
			if ($date == $phpDate) {
				$result = true;
				break;
			}
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if value is a state name or state code.
	 * @return bool Returns TRUE if state is a valid state name or state code.
	 * @param string $state The state name or code to test.
	 */
	public static function isState($state) {
		return self::isStateCode($state) || self::isStateName($state);
	}
	
	/**
	 * @brief Determines if a state code is valid.
	 * @return bool Returns TRUE if state code is valid, FALSE otherwise.
	 * @param string $code The state code to test.
	 */
	public static function isStateCode($code) {
		$code = strtoupper(trim($code));
		if (isset(self::$states[$code])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if a state name is valid.
	 * @return bool Returns TRUE if state name is valid, FALSE otherwise.
	 * @param string $name The state name to test.
	 */
	public static function isStateName($name) {
		$name = strtolower(trim($name));
		foreach (self::$states as $key => $value) {
			if ($name == strtolower($value)) {
				return true;
			}
			
		}
		return false;
	}
	
	/**
	 * @brief Determines if value is a country name or country code.
	 * @return bool Returns TRUE if country is a valid country name or country code.
	 * @param string $country The country name or code to test.
	 */
	public static function isCountry($country) {
		return self::isCountryCode($country) || self::isCountryName($country);
	}
	
	/**
	 * @brief Determines if a country code is valid.
	 * @return bool Returns TRUE if country code is valid, FALSE otherwise.
	 * @param string $code The country code to test.
	 */
	public static function isCountryCode($code) {
		$code = strtoupper(trim($code));
		if (isset(self::$countries[$code])) {
			return true;
		} else {
			return false;
		}	
	}
	
	/**
	 * @brief Determines if a country name is valid.
	 * @return bool Returns TRUE if country code is valid, FALSE otherwise.
	 * @param string $name The country name to test.
	 */
	public static function isCountryName($name) {
		$name = strtolower(trim($name));
		foreach (self::$countries as $key => $value) {
			if ($name == strtolower($value)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @brief Determines if a value is a name or not.
	 * 
	 * Provides API compatibility.
	 * 
	 * @param string $name The name to test.
	 * @param integer $min[optional] The minimum length of the name.
	 * @param integer $max[optional] The maximum length of the name.
	 * @todo Improve support and provide additional tests.
	 * @return bool Returns TRUE if it is a name, FALSE otherwise.
	 */
	public static function isName($name, $min = 2, $max = 32) {
		return self::isString($name, $min, $max);
	}
	
	/**
	 * @brief Determines if a value is a street or not.
	 * 
	 * Provides API compatibility.
	 * 
	 * @param string $street The street to test.
	 * @param integer $min[optional] The minimum length of the street.
	 * @param integer $max[optional] The maximum length of the street.
	 * @todo Improve support and provide additional tests.
	 * @return bool Returns TRUE if it is a street, FALSE otherwise.
	 */
	public static function isStreet($street, $min = 2, $max = 48) {
		return self::isString($street, $min, $max);
	}
	
	/**
	 * @brief Determines if a value is an apartment number or not.
	 * 
	 * Provides API compatibility.
	 * 
	 * @attention Apartment numbers do not have to be numeric.
	 * @param string $apt The apartment number to test.
	 * @param integer $min[optional] The minimum length of the apartment number.
	 * @param integer $max[optional] The maximum length of the apartment number.
	 * @todo Improve support and provide additional tests.
	 * @return bool Returns TRUE if it is a street, FALSE otherwise.
	 */
	public static function isApartmentNumber($apt, $min = 1, $max = 16) {
		return self::isAlphaNumExtended($apt, $min, $max);
	}
	
	/**
	 * @brief Determines if a value is a city or not.
	 * 
	 * Provides API compatibility.
	 * 
	 * @param string $street The city to test.
	 * @param integer $min[optional] The minimum length of the city.
	 * @param integer $max[optional] The maximum length of the city.
	 * @todo Improve support and provide additional tests.
	 * @return bool Returns TRUE if it is a city, FALSE otherwise.
	 */
	public static function isCity($city, $min = 2, $max = 32) {
		return self::isString($city, $min, $max);
	}
	
	/**
	 * @brief Determines if a ZIP code is valid.
	 * @return bool Returns TRUE if ZIP code is valid, FALSE otherwise.
	 * @param string $zip The ZIP code to test.
	 * @todo Add support for other countries.
	 */
	public static function isZip($zip) {
		$zip = trim($zip);
		return preg_match(BOO_REGEX_ZIP, $zip);
	}
	
	/**
	 * @brief Determines if a URI is valid.
	 * @return bool Returns TRUE if URI is valid, FALSE otherwise.
	 * @param string $uri The URI to test.
	 */
	public static function isUri($uri) {
		$uri = trim($url);
		return preg_match(BOO_REGEX_URI, $uri) && (strlen($uri) < 256);
	}
	
	/**
	 * @brief Determines if a URL is valid.
	 * @return bool Returns TRUE if URL is valid, FALSE otherwise.
	 * @param string $uri The URL to test.
	 */
	public static function isUrl($url) {
		$url = trim($url);
		return preg_match(BOO_REGEX_URL, $url) && (strlen($url) < 256);
	}
	
	/**
	 * @brief Determines if an email address is valid.
	 * @return bool Returns TRUE if email address is valid, FALSE otherwise.
	 * @param string $email The email address to test.
	 */
	public static function isEmail($email) {
		$email = trim($email);
		return preg_match(BOO_REGEX_EMAIL, $email);
	}
	
	/**
	 * @brief Determines if a phone number is valid.
	 * @return bool Returns TRUE if phone number is valid, FALSE otherwise.
	 * @param string $phoneNumber The phone number to test.
	 */
	public static function isPhoneNumber($phoneNumber) {
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
		
		if ($phoneNumber == null) {
			return false;
		}
		
		if (strlen($phoneNumber) == 11 && substr($phoneNumber, 0, 1) == 1) {
			// remove leading 1 from phone number
			$phoneNumber = substr($phoneNumber, 1);
		}
		
		if (strlen($phoneNumber) == 10) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if a phone extension is valid.
	 * 
	 * Valid formats are:
	 * \li x123456
	 * \li 123456
	 * 
	 * Where 123456 can be any number from 1 to 999999.
	 * 
	 * @return bool Returns TRUE if extension is valid, FALSE otherwise.
	 * @param string $phoneExt The phone extension to test.
	 */
	public static function isPhoneExtension($phoneExt) {
		$phoneExt = trim($phoneExt);
		
		if ($phoneExt == null) {
			return false;
		}
		
		if(strtolower(substr($phoneExt, 0, 1)) == 'x') {
			// remove leading x from phone extension
			$phoneExt = substr($phoneExt, 1);
		}
		
		if (self::isInt($phoneExt, 1, 999999)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * @brief Determines if a credit card number is masked.
	 * 
	 * Checks if the first 4 digits of the card number are ****. This function is used to check
	 * account information after a user has submited updates. If the card number is masked
	 * then they have likely not updated it and it can be ignored (not saved). This is just a quick check and should only
	 * be used to determin if a card number should be saved or not. It does not check against manipulation of the 
	 * card number itself.
	 * 
	 * @warning This function does not check the validity of the masked credit card number
	 * 
	 * @return bool Returns TRUE if credit card number is masked, FALSE otherwise.
	 * @param object $cardNumber
	 */
	public static function isCardNumberMasked($cardNumber) {
		$cardNumber = trim($cardNumber);
		
		if (preg_match('/^[\*]+[0-9]{4}$/', $cardNumber)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * @brief Determines if a credit card number is valid.
	 * 
	 * @warning Uses the Luhn algorithm to check for validity. This may not work correctly for more obsucre credit cards.
	 * 
	 * @see http://en.wikipedia.org/wiki/Luhn_algorithm
	 * @return bool Returns TRUE if card number is valid, FALSE otherwise.
	 * @param string $cardNumber The card number to test.
	 */
	public static function isCardNumber($cardNumber) {
		$cardNumber = ereg_replace('[^0-9]+', '', $cardNumber);
		
		if (!$cardNumber || strlen($cardNumber) < 13) {
			// card number is null or to short
			return false;
		}
		
		$numberLength = strlen($cardNumber);
		$parity = $numberLength % 2;
		
		$total = 0;
		for ($i = 0; $i < $numberLength; $i++) {
			$digit = $cardNumber[$i];
			if ($i % 2 == $parity) {
				$digit *= 2;
				if ($digit > 9) {
					$digit -= 9;
				}
			}
			$total += $digit;
		}
		
		if ($total % 10 == 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @brief Determines if an expiration date is valid.
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
	 * @see Boo_Format::formatExpDate
	 * @param string $expDate The expiration date to test.
	 * @return bool Returns TRUE if expiration date is valid, FALSE otherwise.
	 */
	public static function isExpDate($expDate) {
		// remove non numbers
		$expDate = ereg_replace('[^0-9]+', '', $expDate);
		$length = strlen($expDate);
		
		$year = ''; $month = '';
		
		switch ($length) {
			
			case 4: // mmyy
				$month = substr($expDate, 0, 2);
				$year = substr($expDate, 2, 2);
				break;
				
			case 6: // mmyyyy
				$month = substr($expDate, 0, 2);
				$year = substr($expDate, 4, 2);
				break;
				
			case 8: // yyyymmdd
				$month = substr($expDate, 4, 2);
				$year = substr($expDate, 2, 2);	
				break;
				
			default:
				return false;
		}
		
		// valid format
		// check for expiration
		// add a month to the expiration date
		$d = strtotime("$month/01/$year +1 month");
		if ($d > time()) {
			// in the future
			return true;
		} else {
			// in the past
			return false;
		}
	}
	
	/**
	 * @brief Checks if string is safe to use in an SQL statement.
	 * 
	 * Safe characters are all letters, numbers, dash, and the underscore.
	 * 
	 * @param $string The string to test.
	 * @param integer $min[optional] The minimum length of the name.
	 * @param integer $max[optional] The maximum length of the name.
	 * @return bool Returns TRUE if string is safe, FALSE otherwise.
	 */
	public static function isSqlSafe($string, $min = false, $max = false) {
		$string = trim($string);
		$result = false;

		if (preg_match('/^[A-Za-z0-9-_\.]+$/', $string)) {
			$result = true;
			if ($min !== false) {
				$result = $result && strlen($string) >= $min;
			}
			if ($max !== false) {
				$result = $result && strlen($string) <= $max;
			}
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if string is an SQL direction.
	 * 
	 * Used by the ORDER BY SQL statment.
	 * Possible directions are:
	 * \li ASC
	 * \li DESC
	 * 
	 * @return bool Returns TRUE if string is an SQL direction, FALSE otherwise.
	 * @param string $string The string to test.
	 */
	public static function isSqlDirection($string) {
		$string = strtoupper(trim($string));
		return $string == 'ASC' || $string == 'DESC';
	}
	
	/**
	 * @brief Validates a vehical identification number aginst the ISO 3779 standard.
	 * 
	 * 1M8GDM9AXKP042788 is a valid VIN (used for testing).
	 * 
	 * @see http://ramaboo.com/code/is_vin/
	 * @see http://code.google.com/p/isvin/
	 * @see http://en.wikipedia.org/wiki/Vehicle_identification_number
	 * 
	 * @param string $vin The vehical identification number.
	 * 
	 * @return bool Returns TRUE if the vehical identification number is valid, FALSE otherwise.
	 * 
	 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
	 * @copyright 2008 David Singer
	 * @author David Singer <david@ramaboo.com>
	 * @version 1.1.3
	 * 
	 * @code
	 * if (is_vin('1M8GDM9AXKP042788')) {
	 * 	echo 'valid';
	 * } else {
	 * 	echo 'not valid';
	 * }
	 * @endcode
	 * 
	 * @todo Test and support ISO 3780.
	 */
	public static function isVin($vin) {
		$vin = strtoupper(trim($vin));
		
		// check VIN length
		if (strlen($vin) != 17) {
			// error VIN is not 17 characters long
			return false;
		}
		
		// setup array of letter values
		$value['A'] = 1;
		$value['B'] = 2;
		$value['C'] = 3;
		$value['D'] = 4;
		$value['E'] = 5;
		$value['F'] = 6;
		$value['G'] = 7;
		$value['H'] = 8;
		$value['J'] = 1;
		$value['K'] = 2;
		$value['L'] = 3;
		$value['M'] = 4;
		$value['N'] = 5;
		$value['P'] = 7;
		$value['R'] = 9;
		$value['S'] = 2;
		$value['T'] = 3;
		$value['U'] = 4;
		$value['V'] = 5;
		$value['W'] = 6;
		$value['X'] = 7;
		$value['Y'] = 8;
		$value['Z'] = 9;
		
		// setup digit weights
		$weight[0] = 8; // 1st position
		$weight[1] = 7;
		$weight[2] = 6;
		$weight[3] = 5;
		$weight[4] = 4;
		$weight[5] = 3;
		$weight[6] = 2;
		$weight[7] = 10;
		$weight[8] = 0; // 9th position, this is the check digit
		$weight[9] = 9;
		$weight[10] = 8;
		$weight[11] = 7;
		$weight[12] = 6;
		$weight[13] = 5;
		$weight[14] = 4;
		$weight[15] = 3;
		$weight[16] = 2; // 17th position
		
		$char = str_split($vin); // split string into character array
		$total = 0;
		
		// loop though each character of the vin
		for ($i = 0; $i < 17; $i++) {
			if (is_numeric($char[$i])) {
				// use number
				// update total
				$total = $total + ($char[$i] * $weight[$i]);
			} elseif (array_key_exists($char[$i], $value)) {
				// use value of letter
				// update total
				$total = $total + ($value[$char[$i]] * $weight[$i]);
			} else {
				// error illegal character used
				return false;
			}
		}
		
		$mod = $total % 11; // find remainder after deviding by 11
		
		// if mod is 10 set the check_digit to X
		if ($mod == 10) {
			$checkDigit = 'X';
		} else {
			$checkDigit = $mod;
		}
		
		// check if the 9th character in the string (the check digit) equals the calculated value
		if ($char[8] == $checkDigit) { 
			// VIN is valid
			return true;
		} else {
			// VIN is not valid
			return false;
		}
	}
	
	/**
	 * @brief Determines if a username is valid.
	 * 
	 * Provides API compatibility.
	 * 
	 * @param string $username The username.
	 * @return bool Returns TRUE if username is valid, FALSE if already in use.
	 */
	public static function isUsername($username) {
		return self::isAlphaNumPlus($username, Boo_User::MIN_USERNAME_LENGTH, Boo_User::MAX_USERNAME_LENGTH, true);
	}
	
	/**
	 * @brief Determines if a username is availiable.
	 * 
	 * @param string $username The username.
	 * @return bool Returns TRUE if username is available, FALSE if already in use.
	 */
	public static function isUsernameAvailable($username) {
		return !Boo_User::isUsername($username);
	}
	
	/**
	 * @brief Determines if a email address is availiable.
	 * 
	 * @param string $email The email address.
	 * @return bool Returns TRUE if email address is available, FALSE if already in use.
	 */
	public static function isEmailAvailable($email) {
		return !Boo_User::isEmail($email);
	}
	
	/**
	 * @brief Determines if a value is odd.
	 * 
	 * @param mixed $value The value to test.
	 * @return bool Returns TRUE if value is odd, FALSE otherwise.
	 */
	public static function isOdd($value) {
		$value = (string) trim($value);
		return ctype_digit($value) & ($value & 1);
	}
	
	/**
	 * @brief Determines if a value is even.
	 * 
	 * @param mixed $value The value to test.
	 * @return bool Returns TRUE if value is even, FALSE otherwise.
	 */
	public static function isEven($value) {
		$value = (string) trim($value);
		return ctype_digit($value) & (!($value & 1));
	}
	
	/**
	 * @brief Determines if a value contains html.
	 * 
	 * @param mixed $string The string to test.
	 * @return bool Returns TRUE if tags are found, FALSE if no tags are found.
	 */
	public static function isHtml($string) {
		$string = trim($string);
		// check if value is the same after html is removed
		$result = (strlen($string) == strlen(strip_tags($string)));
		return !$result;
	}
	
	/**
	 * @brief Determines if a value is null.
	 * 
	 * \b Important! This is not the same as is_null().
	 * 
	 * The following values are considered null:
	 * \li A string with only spaces.
	 * \li An empty string.
	 * \li NULL.
	 * \li FALSE.
	 * \li An empty array.
	 * 
	 * @param mixed $string The string to test.
	 * @return bool Returns TRUE if value is null, FALSE otherwise.
	 * @todo Fix to test objects.
	 */
	public static function isNull($string) {
		
		if (is_array($string)) {
			return empty($string);
		}
		
		if (is_object($string)) {
			// this could use some work
			return false;
		}
		
		$string = trim($string);
		return ($string == '') || ($string === null);
	}
	
	/**
	 * @brief Determines if a password is valid.
	 * 
	 * @param string $password The password.
	 * @return bool Returns TRUE if password is valid, FALSE otherwise.
	 * @todo Add support for complex password testing.
	 */
	public static function isPassword($password){
		return self::isString($password, 4, 32);
	}
	
	/**
	 * @brief Determines if a required value is set.
	 * 
	 * @param mixed $value The value to test.
	 * @return bool Returns TRUE if value is set, FALSE otherwise.
	 */
	public static function isRequired($value) {
		$value = trim($value);
		return !self::isNull($value);
	}
	
	/**
	 * @brief Determines if a value matchs the posted value with a given key.
	 * 
	 * @param string $value The value to test.
	 * @param string $post The key for the \v $_POST array.
	 * @return bool Returns TRUE if they match, FALSE otherwise.
	 */
	public static function isPostMatch($value, $post) {
		$value = trim($value);
		$post = trim($post);
		
		if (!array_key_exists($post, $_POST)) {
			// not in $_POST
			return false;
		}
		
		if ($value == $_POST[$post]) {
			// values are the smae
			return true;
		} else {
			// not the same
			return false;
		}
	}
	
	/**
	 * @brief Determines if a checkbox is checked.
	 * 
	 * Because of the way PHP handles checkboxes this is the same as Boo_Validator::isRequired().
	 * Included for API compatibility.
	 * 
	 * @param string $value
	 * @return bool Returns TRUE if checkbox is checked, FALSE otherwise.
	 */
	public static function isChecked($value) {
		return self::isRequired($value);
	}
	
	/**
	 * @brief Determines if a file has been uploaded ok.
	 * 
	 * Will not cause error if nothing was uploaded.
	 * 
	 * @see Boo_Validator::isUploadRequired().
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUpload($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_OK || $_FILES[$name]['error'] == UPLOAD_ERR_NO_FILE) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if a file has been uploaded ok.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadRequired($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_OK) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if uploaded file is less than the maximum size.
	 * 
	 * @attention Wierd logic, but its tested and works.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadSize($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_INI_SIZE || $_FILES[$name]['error'] == UPLOAD_ERR_FORM_SIZE) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if an uploaded file has a blank name.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadBlank($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_NO_FILE) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if an uploaded file was only partially upaded.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadPartial($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_PARTIAL) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if file extension is allowed on an uploaded file.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @param array $extensions The array of allowed extensions.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadExtensionAllowed($name, $extensions) {
		if (isset($_FILES[$name])) {
			$filename = $_FILES[$name]['name'];
			
			if ($_FILES[$name]['error'] == UPLOAD_ERR_OK) {
				$pathParts = pathinfo($filename);
				return in_array($pathParts['extension'], $extensions);
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if an uploaded file has a valid extension.
	 * 
	 * @param string $name The name of the file as an key in the \c $_FILES array.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public static function isUploadExtension($name) {
		if (isset($_FILES[$name])) {
			if ($_FILES[$name]['error'] == UPLOAD_ERR_EXTENSION) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determines if a string is a valid filename.
	 * 
	 * @warning Function does not clean filenames of unsafe characters.
	 * 
	 * @param string $filename The filename to test
	 * @return bool Returns TRUE if filename is valid, FALSE otherwise.
	 * @todo This function could be much better.
	 */
	public static function isFilename($filename) {
		return self::isString($filename, 1, 255);
	}
	
	/**
	 * @brief Determines if a string is a valid basename.
	 * 
	 * @warning Function does not clean basenames of unsafe characters.
	 * 
	 * @param string $basename The basename to test
	 * @return bool Returns TRUE if basename is valid, FALSE otherwise.
	 * @todo This function could be much better.
	 */
	public static function isBasename($basename) {
		return self::isString($basename, 1, 64);
	}
	
	/**
	 * @brief Determines if value is a yes or no (1 or 0).
	 * @return bool Returns TRUE if yes or no, FALSE otherwise.
	 * @param string $value The value to test.
	 * @param bool $allowWord[optional] Allow words 'yes' and 'no' to be used as well.
	 */
	public static function isYesNo($value, $allowWord = false) {
		$value = strtolower(trim($value));
		
		$result = array_key_exists($value, self::$yesNo);
		
		if ($allowWord) {
			$result = $result || self::isYesNoWord($value);
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if value is a yes or no word.
	 * @return bool Returns TRUE if value is 'yes' or 'no' (case insensitive), FALSE otherwise.
	 * @param string $value The value to test.
	 */
	public static function isYesNoWord($value) {
		$value = strtolower(trim($value));
		
		$tmpYesNo = array_change_value_case(self::$yesNo, CASE_LOWER);
		
		return in_array($value, $tmpYesNo);
	}
	
	/**
	 * @brief Determines if value is true or false (1 or 0).
	 * @return bool Returns TRUE if true or false, FALSE otherwise.
	 * @param string $value The value to test.
	 * @param bool $allowWord[optional] Allow words 'true' and 'false' to be used as well.
	 */
	public static function isTrueFalse($value, $allowWord = false) {
		$value = strtolower(trim($value));
		
		$result = array_key_exists($value, self::$trueFalse);
		
		if ($allowWord) {
			$result = $result || self::isTrueFalseWord($value);
		}
		
		return $result;
	}
	
	/**
	 * @brief Determines if value is a true or false word.
	 * @return bool Returns TRUE if value is a 'true' or 'false' (case insensitive), FALSE otherwise.
	 * @param string $value The value to test.
	 */
	public static function isTrueFalseWord($value) {
		$value = strtolower(trim($value));
		
		$tmpTrueFalse = array_change_value_case(self::$trueFalse, CASE_LOWER);
		
		return in_array($value, $tmpTrueFalse);
	}
	
}
?>

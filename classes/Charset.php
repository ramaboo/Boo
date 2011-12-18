<?php
/* SVN FILE: $Id: Charset.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Charset class.
 * 
 * This class is used as a reference for common charsets, used mostly for encryption.
 * 
 * @class		Boo_Charset
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Charset {
	
	/**
	 * @brief Alphanumeric characters.
	 */
	protected static $alphaNum = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
	/**
	 * @brief ASCII printable characters.
	 * 
	 * Characters 33 - 126. Does not include space.
	 */
	protected static $printable = '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
	
	/**
	 * @brief Hexadecimal characters.
	 */
	protected static $hex = '0123456789abcdef';
	
	/**
	 * @brief Get array of alphanumeric characters.
	 * 
	 * @return string Alphanumeric characters.
	 */
	public static function getAlphaNum() { return self::$alphaNum; }
	
	/**
	 * @brief Get array of printable characters.
	 * 
	 * Characters 33 - 126. Does not include space.
	 * 
	 * @return string Printable characters.
	 */
	public static function getPrintable() { return self::$printable; }
	
	/**
	 * @brief Get array of hexadecimal characters.
	 * 
	 * @return string Hexadecimal characters.
	 */
	public static function getHex() { return self::$hex; }
}
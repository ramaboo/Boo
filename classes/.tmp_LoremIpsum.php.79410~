<?php
/* SVN FILE: $Id: LoremIpsum.php 239 2009-10-18 22:29:37Z david@ramaboo.com $ */
/**
 * @brief Lorem ipsum class.
 * 
 * This class is used to generate lorem ipsum.
 * 
 * @class		Boo_LoremIpsum
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_LoremIpsum {
	
	/**
	 * @brief Array of paragraphs.
	 */
	protected static $ps = array();
	
	/**
	 * @brief Array of list items.
	 */
	protected static $lis = array();
	
	/**
	 * @brief Array of words.
	 */
	protected static $words = array();
	
	/**
	 * @brief Default constructor.
	 * @param bool $preload Preload ipsum files.
	 * @return void.
	 */
	public function __construct($preload = false) {
		if ($preload) {
			self::loadFiles();
		}
	}
	
	/**
	 * @brief Returns a string of words.
	 * @return string The string of words. Will always end in a period.
	 * @param int $count[optional] The number of words.
	 */
	public static function getWords($count = 20) {
		$count = (int) $count;
		if (empty(self::$words)) {
			self::loadFiles();
		}
		
		$wordSize = count(self::$words);
		if (!Boo_Validator::isInt($count, 1, $wordSize)) {
			trigger_error("Count {$count} is not valid", E_USER_WARNING);
			return false;
		}
		
		$string = '';
		for ($i = 0; $i < $count; $i++) {
			$string .= self::$words[$i] . ' ';
		}
		// remove ending characters
		$string = rtrim($string, ' .,');
		$string .= '.'; // add period
		return $string;
	}
	
	/**
	 * @brief Returns an array of paragraphs of lorem ipsum.
	 * @return Boo_Html A collection of paragraphs.
	 * @param int $count[optional] The number of paragraphs.
	 * @param array $attrs[optional] The attributes to apply to each paragraph.
	 */
	public static function htmlPs($count = 5, array $attrs = array()) {
		$count = (int) $count;
		if (empty(self::$ps)) {
			self::loadFiles();
		}
		
		$pSize = count(self::$ps);
		if (!Boo_Validator::isInt($count, 1, $pSize)) {
			trigger_error("Count {$count} is not valid", E_USER_WARNING);
			return false;
		}
		
		$html = new Boo_Html(false);
		for ($i = 0; $i < $count; $i++) {
			$tmpP = new Boo_Html_P;
			$tmpP->applyAttrs($attrs);
			
			$tmpP->setContent(self::$ps[$i]);
			$html->appendContent($tmpP);
		}
		
		return $html;
	}
	
	/**
	 * @brief Gets an unorderd list of lorem ipsum.
	 * @return Boo_Html_Ul The unordered list.
	 * @param int $count[optional] The number of list items to include.
	 * @param array $attrs[optional] The attributes for the unorderd list.
	 */
	public static function htmlUl($count = 5, array $attrs = array()) {
		$count = (int) $count;
		if (empty(self::$lis)) {
			self::loadFiles();
		}
		
		$liSize = count(self::$lis);
		if (!Boo_Validator::isInt($count, 1, $liSize)) {
			trigger_error("Count {$count} is not valid", E_USER_WARNING);
			return false;
		}
		
		$ul = new Boo_Html_Ul;
		$ul->applyAttrs($attrs);
		
		for ($i = 0; $i < $count; $i++) {
			$tmpLi = new Boo_Html_Li;
			$tmpLi->setContent(self::$lis[$i]);
			$ul->addLi($tmpLi);
		}
		
		return $ul;
	}
	
	/**
	 * @brief Loads files into class.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	private static function loadFiles() {
		// load paragraphs
		$pFile = BOO_LIB_DIR . '/LoremIpsum/ps';
		if (file_exists($pFile)) {
			$tmp = file($pFile);
			// removes line breaks at the end of each line
			array_trim($tmp);
			self::$ps = $tmp;
		} else {
			trigger_error("File {$pFile} does not exist", E_USER_ERROR);
			return false;
		}
		
		// load list items
		$liFile = BOO_LIB_DIR . '/LoremIpsum/lis';
		if (file_exists($liFile)) {
			$tmp = file($liFile);
			// removes line breaks at the end of each line
			array_trim($tmp);
			self::$lis = $tmp;
		} else {
			trigger_error("File {$liFile} does not exist", E_USER_ERROR);
			return false;
		}
		
		// load words
		$wordFile = BOO_LIB_DIR . '/LoremIpsum/words';
		if (file_exists($wordFile)) {
			$tmp = file($wordFile);
			// removes line breaks at the end of each line
			array_trim($tmp);
			self::$words = $tmp;
		} else {
			trigger_error("File {$wordFile} does not exist", E_USER_ERROR);
			return false;
		}
		
		return true;
	}
}

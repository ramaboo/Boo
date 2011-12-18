<?php
/* SVN FILE: $Id: Test.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Test class.
 * 
 * This class is used to store common testing datasets and other testing functions.
 * 
 * @class		Boo_Test
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Test {
	
	/**
	 * @brief Fruits array.
	 */
	protected static $fruits = array(
		'a' => 'Apple',
		'b' => 'Banana',
		'g' => 'Grapes',
		'l' => 'Lemon',
		'o' => 'Orange',
		't' => 'Tomato',
		'w' => 'Watermelon');
	
	/**
	 * @brief Numbers array.
	 */
	protected static $numbers = array(
		0 => 'Zero',
		1 => 'One',
		2 => 'Two',
		3 => 'Three',
		4 => 'Four',
		5 => 'Five',
		6 => 'Six',
		7 => 'Seven',
		8 => 'Eight',
		9 => 'Nine',
		10 => 'Ten');
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {}
	
	/**
	 * @brief Get array of fruits.
	 * 
	 * @return array Fruits array.
	 */
	public static function getFruits() { return self::$fruits; }
	
	/**
	 * @brief Get array of numbers (0 though 10).
	 * 
	 * @return array Numbers array.
	 */
	public static function getNumbers() { return self::$numbers; }
	
	public static function htmlKitchenSinkDiv(array $attrs = array()) {
		$div = new Boo_Html_Div;
		$div->applyAttrs($attrs);
		
		$tmp = '<h1>Heading Level 1</h1><h2>Heading Level 2</h2><h3>Heading Level 3</h3>'
			. '<h4>Heading Level 4</h4><h5>Heading Level 5</h5><h6>Heading Level 6</h6>';
			
		$tmp .= Boo_LoremIpsum::htmlPs(3);
		$tmp .= Boo_LoremIpsum::htmlUl(5);
		
		$div->setContent($tmp);
		return $div;
	}
}
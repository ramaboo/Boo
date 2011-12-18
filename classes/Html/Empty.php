<?php
/* SVN FILE: $Id: Empty.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML empty class.
 * 
 * This is a special HTML object used when an empty object is required.
 * 
 * @class		Boo_Html_Empty
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Empty extends Boo_Html {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		$this->setElement(false);
		// do nothing, do not call parent::__construct()
	}
	
	/**
	 * @brief Override parent htmlOpen() method.
	 * @return string This function always returns an empty string.
	 */
	public function htmlOpen() { return ''; }
	
	/**
	 * @brief Override parent htmlClose() method.
	 * @return string This function always returns an empty string.
	 */
	public function htmlClose() { return ''; }
	
	/**
	 * @brief Override parent html() method.
	 * @return string This function always returns an empty string.
	 * @param array $attrs[optional] Attributes array. This function ignores this variable.
	 * It is provided for API compatability only.
	 */
	public function html(array $attrs = array()) { return ''; }
}
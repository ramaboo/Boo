<?php
/* SVN FILE: $Id: FormControl.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML form control class.
 * 
 * This class is used to to manipulate HTML form controls. It is extened by Boo_Html_Input, Boo_Html_Select, and Boo_Html_Textarea.
 * 
 * @class		Boo_Html_FormControl
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

abstract class Boo_Html_FormControl extends Boo_Html {
	
	/**
	 * @brief Controls stickiness.
	 */
	protected $sticky = true;
	
	/**
	 * @brief Default constructor.
	 * @param string $element The HTML element to create.
	 * @return void.
	 */
	public function __construct($element) {
		parent::__construct($element);
	}
	
	/**
	 * @brief Sets the inputs stickiness.
	 * @param bool $opt If input is sticky or not.
	 * @return bool Function always returns TRUE.
	 */
	public function setSticky($opt) {
		$opt = (bool) $opt;
		$this->sticky = $opt;
		return true;
	}
	
	/**
	 * @brief Returns inputs stickiness.
	 * 
	 * @return bool Returns TRUE if input is sticky, FALSE otherwise.
	 */
	public function isSticky() { return $this->sticky; }
	
	/**
	 * @brief Returns posted value.
	 * 
	 * @return mixed Returns the posted value if set, FALSE otherwise.
	 */
	public function getPostedValue() {
		$value = '';
		
		$name = $this->getAttr('name');
		
		// check to make sure the name attribute is set
		if (!$this->hasAttr('name')) {
			trigger_error('Attribute name is required', E_USER_WARNING);
			return false;
		}
		
		if (array_key_exists($name, $_POST)) {
			$value = $_POST[$name];
			return $value;
		} else {
			return false;
		}
	}
}
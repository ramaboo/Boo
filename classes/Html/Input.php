<?php
/* SVN FILE: $Id: Input.php 238 2009-06-19 19:57:50Z david@ramaboo.com $ */
/**
 * @brief HTML input class.
 * 
 * This class is used to generate inputs.
 * 
 * @class		Boo_Html_Input
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.6.1
 * 
 * @todo		Cleanup file to 2.0 spces.
 */

Boo_ClassLoader::load('Html_Input_Button');
Boo_ClassLoader::load('Html_Input_Checkbox');
Boo_ClassLoader::load('Html_Input_File');
Boo_ClassLoader::load('Html_Input_Hidden');
Boo_ClassLoader::load('Html_Input_Image');
Boo_ClassLoader::load('Html_Input_Password');
Boo_ClassLoader::load('Html_Input_Radio');
Boo_ClassLoader::load('Html_Input_Reset');
Boo_ClassLoader::load('Html_Input_Submit');
Boo_ClassLoader::load('Html_Input_Text');

class Boo_Html_Input extends Boo_Html_FormControl {
	/**
	 * @brief The constructor.
	 * @brief string $type (optional) Type type of input.
	 * @return void.
	 */
	public function __construct($type = 'text') {
		$this->setAttr('type', $type);
		parent::__construct('input');
	}
	
	/**
	 * @brief Sets the inputs stickiness.
	 * @param bool $opt If input is sticky or not.
	 * @return bool TRUE.
	 */
	public function setSticky($opt) {
		$this->sticky = (bool) $opt;
		return true;
	}
	
	/**
	 * @brief Returns inputs stickiness.
	 * @return bool TRUE if input is sticky, FALSE otherwise.
	 */
	public function isSticky() { return $this->sticky; }
	
	/**
	 * @brief Extends parent method.
	 * @see Boo_Html::htmlOpen().
	 * @return string Opening HTML tag for the element.
	 */
	public function htmlOpen() {
		
		if ($this->isSticky()) {
			// input is sticky
			$type = strtolower($this->getAttr('type'));
			$name = $this->getAttr('name');
			
			// remove [] from name
		//	if (substr($name, -2) == '[]') {
		//		$name = substr($name, 0, strlen($name) - 2);
		//	}
			
			
	//		echo "$name</br>";
			
	//		echo "value:" . _post($name);
			
		//	echo "</br><br>";
			
			// check to make sure the name attribute is set
			if (!$name) {
				// name is not set
				trigger_error('Attribute name is required for sticky inputs', E_USER_WARNING);
				return false;
			}
			
			// check to make sure the type attribute is set
			if (!$type) {
				// type is not set
				trigger_error('Attribute type is required for sticky inputs', E_USER_WARNING);
				return false;
			}
			$value = $this->getAttr('value');
			//$postValue = htmlentities(_post($name), ENT_NOQUOTES, 'UTF-8');
			
			$isArray = is_array(_post($name));
			$postValue = _post($name);
			
			switch ($type) {
				// buttons are not sticky since they do not appear in $_POST
				case 'button':
					if ($value) {
						// value is already set do nothing
					} else {
						// set default value
						$this->setAttr('value', 'Button');
					}
					break;
					
				case 'checkbox':
				case 'radio':
					if ($value) {
						// check if posted value equals set value
						// this will fail if arrays of checkboxes have the same value
						if ($isArray) {
							if (in_array($value, $postValue)) {
								$this->setAttr('checked', 'checked');
							}
						} else {
							// normal
							if ($postValue == $value) {
								$this->setAttr('checked', 'checked');
							}
						}
						
					} else {
						// set default value
						$this->setAttr('value', 'on');
						if ($postValue == 'on') { // default value set last time
							$this->setAttr('checked', 'checked');
						}
						
					}
					break;
					
				case 'image':
					// images are not sticky because they do not appear in $_POST
					if ($value) {
						// value is already set do nothing
					} else {
						// set default value
						$this->setAttr('value', 'Image');
					}
					break;
					
				case 'file':
					// Boo_Html_Input_File has its own htmlOpen() method
					return parent::htmlOpen();
					break;
				case 'hidden':
				case 'password':
				case 'text':
					if ($value) {
						// value is already set do nothing
					} elseif ($postValue) {
						// post is set so we will use that
						$this->setAttr('value', $postValue);
						
					} else {
						// no default value
					}
					
					break;
					
				case 'reset':
					// reset buttons are not sticky because they do not appear in $_POST
					if ($value) {
						// value is already set do nothing
					} else {
						// set default value
						$this->setAttr('value', 'Reset');
					}
					break;
				case 'submit':
					if ($value) {
						// value is already set do nothing
					} elseif ($postValue) {
						// post is set so we will use that
						$this->setAttr('value', $postValue);
					} else {
						// set default value
						$this->setAttr('value', 'Submit');
					}
					break;
				
				default: 
					trigger_error("Unsupported attribute type {$type}", E_USER_WARNING);
					return false;
				
			}
			
			
		} else {
			// not sticky
		}
		
		return parent::htmlOpen();
	}
	
	
}
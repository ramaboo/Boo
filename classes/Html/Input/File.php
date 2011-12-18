<?php
/* SVN FILE: $Id: File.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML input file class.
 * 
 * This class is used to generate file inputs.
 * 
 * @class		Boo_Html_Input_File
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.6.1
 * 
 * @todo		Fix stickyness and validation.
 */

class Boo_Html_Input_File extends Boo_Html_Input {
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('input');
		$this->setAttr('type', 'file');
	}
	
	/**
	 * @brief Extends parent method.
	 * 
	 * @attention This funciton must be overidden because files do not use the \c $_POST array.
	 * 
	 * @see Boo_Html::htmlOpen().
	 * @return string Opening HTML tag for the element.
	 * 
	 * @todo Add javaScript hack to make images sticky, or show already uploaded image.
	 */
	public function htmlOpen() {
	/*	if ($this->isSticky()) {
			// input is sticky
			$type = strtolower($this->getAttr('type'));
			$name = $this->getAttr('name');
			
			
			// check to make sure the name attribute is set
			if (!$name) {
				// name is not set
				if (BOO_WARNING) { trigger_error("Attribute name is required for sticky inputs", E_USER_WARNING); }
				return false;
			}
			
			// check to make sure the type attribute is set
			if (!$type) {
				// type is not set
				if (BOO_WARNING) { trigger_error("Attribute type is required for sticky inputs", E_USER_WARNING); }
				return false;
			}
			
			$value = $this->getAttr('value');
			
			$fileValues = _files($name);
			
	
			var_dump($fileValues);
			echo "VALUE:$value";
		
			if ($value) {
				// value is already set do nothing
			} elseif ($fileValues) {
				// post is set so we will use that
				$this->setAttr('value', $fileValues);
				
			} else {
				// no default value
			}
			
			
		} else {
			// not sticky
		}
		*/
		
		// files can not be sticky for securty reasons
		return parent::htmlOpen();
		
	}
}
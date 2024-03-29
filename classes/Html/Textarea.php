<?php
/* SVN FILE: $Id: Textarea.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML textarea class.
 * 
 * This class is used to generate teaxareas.
 * 
 * @class		Boo_Html_Textarea
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Textarea extends Boo_Html_FormControl {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('textarea');
	}
	
	/**
	 * @brief Extends parent method.
	 * @see Boo_Html::htmlOpen().
	 * @return string Opening HTML tag for the element.
	 */
	public function htmlOpen() {
		if ($this->isSticky()) {
			// input is sticky
			$name = $this->getAttr('name');
			
			// check to make sure the name attribute is set
			if (!$name) {
				// name is not set
				trigger_error('Attribute name is required for sticky inputs', E_USER_WARNING);
				return false;
			}
			$postValue = htmlentities(_post($name), ENT_NOQUOTES, 'UTF-8');
			
			if ($postValue) {
				// post is set so we will use that
				$this->setContent($postValue);
			} else {
				// no default value
			}
			
		} else {
			// not sticky
		}
		
		return parent::htmlOpen();
	}
}
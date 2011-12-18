<?php
/* SVN FILE: $Id: Script.php 220 2009-03-30 14:59:19Z david@ramaboo.com $ */
/**
 * @brief HTML script class.
 * 
 * This class is used to generate script tags.
 * 
 * @class		Boo_Html_Script
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Script extends Boo_Html {
	
	/**
	 * @brief Default constructor.
	 * @param array $defaults Default attributes for the script element.
	 * @return void.
	 */
	public function __construct(array $defaults = array(
			'type' => 'text/javascript',
			'charset' => 'utf-8')) {
		parent::__construct('script');
		
		// defaults
		$this->applyAttrs($defaults);
	}
}
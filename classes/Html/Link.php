<?php
/* SVN FILE: $Id: Link.php 220 2009-03-30 14:59:19Z david@ramaboo.com $ */
/**
 * @brief HTML link class.
 * 
 * This class is used to generate link tags.
 * 
 * @class		Boo_Html_Link
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Link extends Boo_Html {
	
	/**
	 * @brief Default constructor.
	 * @param array $defaults Default attributes for the link element.
	 * @return void.
	 */
	public function __construct(array $defaults = array(
			'rel' => 'stylesheet',
			'charset' => 'utf-8',
			'type' => 'text/css',
			'media' => 'screen')) {
				
		parent::__construct('link');
		
		// defaults
		$this->applyAttrs($defaults);
	}
}
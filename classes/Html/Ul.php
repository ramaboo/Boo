<?php
/* SVN FILE: $Id: Ul.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML unordered list class.
 * 
 * This class is used to generate unordered lists.
 * 
 * @class		Boo_Html_Ul
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Ul extends Boo_Html_List {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('ul');
	}
}
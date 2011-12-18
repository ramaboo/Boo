<?php
/* SVN FILE: $Id: Colgroup.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML column group class.
 * 
 * This class is used to generate column groups.
 * 
 * @class		Boo_Html_Colgroup
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Colgroup extends Boo_Html {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('colgroup');
	}
}
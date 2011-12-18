<?php
/* SVN FILE: $Id: Area.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML area class.
 * 
 * This class is used to generate areas.
 * 
 * @class		Boo_Html_Area
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_Area extends Boo_Html {
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('area');
	}
}
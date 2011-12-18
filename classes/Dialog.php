<?php
/* SVN FILE: $Id: Dialog.php 214 2009-03-02 07:44:12Z david@ramaboo.com $ */
/**
 * @brief Dialog class.
 * 
 * @class		Boo_Dialog
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

Boo_ClassLoader::load('Boo_Dialog_MessageBox');

class Boo_Dialog extends Boo_Html {
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('div');
	}
}
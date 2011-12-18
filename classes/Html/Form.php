<?php
/* SVN FILE: $Id: Form.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief HTML form class.
 * 
 * This class is used to generate HTML forms.
 * 
 * @class		Boo_Html_Form
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

Boo_ClassLoader::load('Boo_Html_Form_Xml');

class Boo_Html_Form extends Boo_Html {
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('form');
		
		$this->setAttr('action', $_SERVER['REQUEST_URI']); // default action
		$this->setAttr('method', 'post'); // default method is post
	}
}
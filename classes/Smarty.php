<?php
/* SVN FILE: $Id: Smarty.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Smarty class.
 * 
 * Provides a wrapper for the Smarty class.
 * 
 * @class		Boo_Smarty
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			http://www.smarty.net/
 */

class Boo_Smarty extends Smarty {
	
	/**
	 * @breif Default constructor.
	 * 
	 * Sets up config values that Smarty needs.
	 * 
	 * @return void.
	 */
	public function __construct() {
		parent::Smarty();
		$this->template_dir = BOO_SMARTY_DIR . '/templates';
		$this->compile_dir = BOO_SMARTY_DIR . '/templates_c';
		$this->config_dir = BOO_SMARTY_DIR . '/configs';
		$this->cache_dir = BOO_SMARTY_DIR . '/cache';
		$this->caching = BOO_PRODUCTION;
		$this->debugging = BOO_DEBUG;
	}
}

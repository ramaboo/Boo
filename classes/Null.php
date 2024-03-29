<?php
/* SVN FILE: $Id: Null.php 219 2009-03-20 21:26:32Z david@ramaboo.com $ */
/**
 * @brief Null class.
 * 
 * This class is will return NULL for any operation.
 * 
 * @class		Boo_Null
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.5
 */

class Boo_Null {
	
	/**
	 * @brief Returns NULL.
	 * @return null.
	 * @param string $name The name.
	 */
	public function __get($name) { return null; }
	
	/**
	 * @brief Returns NULL.
	 * @return null.
	 * @param string $name The name.
	 * @param mixed $value The value.
	 */
	public function __set($name, $value) { return null; }
	
	/**
	 * @brief Returns NULL.
	 * @return null.
	 * @param string $name The name.
	 * @param array $arguments The arguments.
	 */
	public function __call($name, array $arguments) { return null; }
	
	/**
	 * @brief Returns NULL.
	 * 
	 * No longer needed with PHP 5.3!
	 * 
	 * @return null.
	 * @param string $name The name.
	 * @param array $arguments The arguments.
	 */
	//public function __callStatic($name, array $arguments) { return null; }
}

<?php
/* SVN FILE: $Id: ClassLoader.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Class loader.
 * 
 * Loads classes into memory.
 * 
 * @class		Boo_ClassLoader
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_ClassLoader {
	/**
	 * @brief An array of files already loaded.
	 */
	protected static $loaded = array();
	
	/**
	 * @brief Returns an array of loaded classes.
	 * @return array Classes loaded.
	 */
	public static function getLoaded() { return self::$loaded; }
	
	/**
	 * @brief Determins if a class is loaded.
	 * @return bool Returns TRUE if classes is loaded, FALSE otherwise.
	 * @param string $name Name of class.
	 */
	public static function isLoaded($name) { return in_array($name, self::$loaded); }
	
	/**
	 * @brief Loads a class into memory.
	 * 
	 * @parm string $name The class name.
	 * @return bool Returns TURE if class was loaded, FALSE if class already exists.
	 */
	public static function load($name) {
		$name = trim($name);
		if (in_array($name, self::$loaded) || class_exists($name, false) || interface_exists($name, false)) {
			return false;
		} else {
			require_once(BOO_BASE_DIR . '/classes/' . str_replace('Boo/', '', str_replace('_', '/', $name)) . '.php');
			self::$loaded[] = $name;
			return true;
		}
	}
}
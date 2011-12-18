<?php
/* SVN FILE: $Id: Db.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Database class.
 * 
 * This class is used to connect to a database.
 * 
 * @class		Boo_Db
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Db {
	
	/**
	 * @brief The table name.
	 */
	protected $tableName = 'boo_default';
	
	/**
	 * @brief The name of the tables primary key.
	 */
	protected $primaryKey = 'boo_id';
	
	/**
	 * @brief Default constructor.
	 * 
	 * Handles shorthand object initialization.
	 * 
	 * @param string $tableName[optional] The table name.
	 * @param string $primaryKey[optional] The primary key.
	 * @return void.
	 */
	public function __construct($tableName = false, $primaryKey = false) {
		// set constructor values, using the shorthand form
		if ($tableName !== false) {
			$this->setTableName($tableName);
		}
		
		if ($primaryKey !== false) {
			$this->setPrimaryKey($primaryKey);
		}
	}
	
	/**
	 * @brief Connects to a database.
	 * 
	 * This function is used to connect to a database, in this case <a href="http://www.mysql.com/">MySQL 5</a>.
	 * You will need to set \c BOO_DB_CONNECTION_STRING, \c BOO_DB_USERNAME, and \c BOO_DB_PASSWORD in your config file.
	 * 
	 * @return PDO object.
	 * 
	 * @code
	 * $dbh = Boo_Db::connect();
	 * @endcode
	 */
	static function connect() {
		try {
			$dbh = new PDO(BOO_DB_CONNECTION_STRING, BOO_DB_USERNAME, BOO_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		return $dbh;
	}
	
	/**
	 * @brief Sets the table name.
	 * 
	 * @param string $tableName The table name.
	 * @return bool Returns TRUE on successs, FALSE otherwise.
	 * @todo Check if table name exists in database and cache the result.
	 */
	public function setTableName($tableName) {
		$tableName = trim($tableName);
		
		if (Boo_Validator::isSqlSafe($tableName, 1)) {
			$this->tableName = $tableName;
			return true;
		} else {
			trigger_error("The string {$tableName} contains illegal characters, SQL injection likely", E_USER_ERROR);
			return false;
		}
	}
	
	/**
	 * @brief Gets the table name.
	 * @return string The table name.
	 * @since 2.0.0
	 */
	public function getTableName() { return $this->tableName; }
	
	/**
	 * @brief Sets the primary key for the table.
	 * 
	 * @param string $key The primary key.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setPrimaryKey($key) {
		$key = trim($key);
		
		if (!Boo_Validator::isSqlSafe($key)) {
			trigger_error("The string {$key} contains illegal characters, SQL injection likely", E_USER_ERROR);
			return false;
		}
		
		if ($key) {
			$this->primaryKey = $key;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Gets the primary key.
	 * @return string The primary key.
	 */
	public function getPrimaryKey() { return $this->primaryKey; }
}
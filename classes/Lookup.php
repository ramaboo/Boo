<?php
/* SVN FILE: $Id: Db.php 208 2009-02-25 16:04:11Z david@ramaboo.com $ */
/**
 * @brief Lookup class.
 * 
 * This class is used to connect to retrieve lookup tables from a database.
 * 
 * @class		Boo_Lookup
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.5
 */

class Boo_Lookup extends Boo_Db {
	
	/**
	 * @brief Class instantance cache.
	 * Keeps DB requests to a minimum.
	 */
	protected $cache = false;
	
	protected $orderBy = array();
	
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
	
	public function getOrderBySql() {
		if (empty($this->orderBy)) {
			return false;
		}
		
		$sql = 'ORDER BY ';
		foreach ($this->orderBy as $key => $value) {
			$sql .= "{$key} {$value}, ";
		}
		
		// remove last comma and space
		$sql = rtrim($sql, ', ');
		
		
		
		return $sql;
	}
	
	public function getOrderBy() { return $this->orderBy; }
	
	public function setOrderBy($columnName, $direction = 'ASC') {
		$this->clearOrderBy();
		return $this->addOrderBy($columnName, $direction);
	}
	
	public function clearOrderBy() {
		$this->orderBy = array();
		return true;
	}
	
	public function addOrderBy($columnName, $direction = 'ASC') {
		$columnName = trim($columnName);
		$direction = strtoupper(trim($direction));
		
		if (!Boo_Validator::isSqlSafe($columnName)) {
			trigger_error("Column {$columnName} is not valid, SQL injection detected", E_USER_ERROR);
			return false;
		}
		
		if (!Boo_Validator::isSqlDirection($direction)) {
			trigger_error("Direction {$direction} is not valid", E_USER_WARNING);
			return false;
		}
		
		if (array_key_exists($columnName, $this->orderBy)) {
			trigger_error("Column {$columnName} already exists, overwriting", E_USER_NOTICE);
		}
		
		$this->orderBy[$columnName] = $direction;
		return true;
	}
	
	public function removeOrderBy($columnName) {
		$columnName = trim($columnName);
		
		if (array_key_exists($columnName, $this->orderBy)) {
			unset($this->orderBy[$columnName]);
			return true;
		} else {
			trigger_error("Column {$columnName} was not found", E_USER_NOTICE);
			return false;
		}
	}
	
	public function open($useCache = true) {
		if ($this->beforeOpen() === false) {
			return false;
		}
		
		// cache is set no need to open again
		if ($this->cache and $userCache) {
			return true;
		}
		
		$result = false;
		// open and fill cache
		$dbh = Boo_Db::connect();
		
		$columns = '*';
		$sql = trim("SELECT {$columns} FROM {$this->tableName} " . $this->getOrderBySql());
		$stmt = $dbh->prepare($sql);
		
		try {
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC); // returns array
			if (empty($results)) {
				trigger_error('No results found', E_USER_NOTICE);
				$result = false;
			} else {
				$result = true;
				$this->cache = $results;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
		if ($this->afterOpen($result) === false) {
			return false;
		}
		//echo $sql; // usefull for debugging
		return $result;
	}
	
	/**
	 * @brief Called before Boo_Lookup::open().
	 * 
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function beforeOpen() {
		return true;
	}
	
	/**
	 * @brief Called after Boo_Lookup::open().
	 * 
	 * @param bool $result The result of Boo_Lookup::open().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function afterOpen($result) {
		return true;
	}
	
	/**
	 * @brief Close the object.
	 * 
	 * Provides API function for future implementation.
	 * 
	 * @todo Implement this function and preform cleanup.
	 * @return bool Always returns TRUE.
	 */
	public function close() {
		if ($this->beforeClose() === false) {
			return false;
		}
		
		$result = true;
		// put cleanup code here
		
		if ($this->afterClose($result) === false) {
			return false;
		}
		return true;
	}
	
	/**
	 * @brief Called before Boo_Lookup::close().
	 * 
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	public function beforeClose() {
		return true;
	}
	
	/**
	 * @brief Called after Boo_Lookup::close().
	 * 
	 * @param bool $result The result of Boo_Lookup::close().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	public function afterClose($result) {
		return true;
	}
	
	public function clearCache() {
		$this->cache = false;
		return true;
	}
	
	
	public function getAssocArray($key, $value) {
		$key = trim($key);
		$value = trim($value);
		
		if (!$this->isField($key)) {
			trigger_error("Field {$key} is not valid", E_USER_WARNING);
			return false;
		}
		
		if (!$this->isField($value)) {
			trigger_error("Field {$value} is not valid", E_USER_WARNING);
			return false;
		}
		
		$data = array();
		if ($this->hasCache()) {
			foreach ($this->cache as $item) {
				$data[$item[$key]] = $item[$value];
			}
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
		return $data;
	}
	
	public function getArray($value) {
		
		if (!$this->isField($value)) {
			trigger_error("Field {$value} is not valid", E_USER_WARNING);
			return false;
		}
		
		$data = array();
		
		if ($this->hasCache()) {
			foreach ($this->cache as $item) {
				$data[] = $item[$value];
			}
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
		return $data;
		
	}
	
	
	public function htmlSelect($key, $value, $attrs = array()) {
		$data = $this->getSelectData($key, $value);
		
		$select = new Boo_Html_Select;
		$select->setAttr('name', $this->tableName); // good default value
		$select->setAttr('id', $this->tableName); // good default value
		$select->applyAttrs($attrs); // override defaults
		$select->setData($data);
		
		return $select;
	}
	
	public function getSelectData($key, $value) {
		return $this->getAssocArray($key, $value);
	}
	
	public function isField($field) {
		$field = trim($field);
		if ($this->hasCache()) {
			$firstRow = $this->cache[0];
			return array_key_exists($field, $firstRow);
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
	}
	
	public function isFieldValue($field, $value) {
		$field = trim($field);
		$value = trim($value);
		
		if (!$this->isField($field)) {
			trigger_error("Field {$field} is not valid", E_USER_WARNING);
			return false;
		}
		
		if ($this->hasCache()) {
			foreach ($this->cache as $item) {
				if ($item[$field] == $value) {
					return true;
				}
			}
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
		return false;
	}
	
	public function isPrimaryKey($value) {
		return $this->isFieldValue($this->primaryKey, $value);
	}
	
	public function getPrimaryKeyByField($field, $value) {
		$field = trim($field);
		$value = trim($value);
		
		if (!$this->isField($field)) {
			trigger_error("Field {$field} is not valid", E_USER_WARNING);
			return false;
		}
		
		if ($this->hasCache()) {
			foreach ($this->cache as $item) {
				if ($item[$field] == $value) {
					return $item[$this->primaryKey];
				}
			}
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
		
		trigger_error("Field {$field} with value {$value} was not found", E_USER_NOTICE);
		return false;
	}
	
	public function getFieldByPrimaryKey($primaryKey, $field) {
		$field = trim($field);
		$primaryKey = trim($primaryKey);
		
		
		if (!$this->isPrimaryKey($primaryKey)) {
			trigger_error("Primary key {$primaryKey} is not valid", E_USER_WARNING);
			return false;
		}
		
		if (!$this->isField($field)) {
			trigger_error("Field {$field} is not valid", E_USER_WARNING);
			return false;
		}
		
		if ($this->hasCache()) {
			foreach ($this->cache as $item) {
				if ($item[$this->primaryKey] == $primaryKey) {
					return $item[$field];
				}
			}
		} else {
			trigger_error('Cache is empty, try Boo_Lookup::open() first', E_USER_WARNING);
			return false;
		}
		
		trigger_error("Field {$field} with primary key {$primaryKey} was not found", E_USER_NOTICE);
		return false;
	}
	
	
	public function hasCache() { return !empty($this->cache); }
	
	public function getCache() { return $this->cache; }
	
	public function setCache($cache) {
		if (empty($cache)) {
			if (BOO_DEBUG) { trigger_error('Cache is empty', E_USER_NOTICE); }
		}
		
		$this->cache = $cache;
		return true;
	}
	
	public function htmlCachePre($attrs = array()) {
		$pre = new Boo_Html_Pre;
		$pre->applyAttrs($attrs);
		$pre->setContent(print_r($this->cache, true));
		
		return $pre;
	}
}
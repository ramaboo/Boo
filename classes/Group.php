<?php
/* SVN FILE: $Id: Group.php 215 2009-03-17 01:15:42Z david@ramaboo.com $ */
/**
 * @brief Group class.
 * 
 * Used to manipulate groups.
 * 
 * @class		Boo_Group
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2007 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.7.0
 */

class Boo_Group extends Boo_Io {
	
	/**
	 * @brief Table name.
	 */
	const TABLE_NAME = 'boo_groups';
	
	/**
	 * @brief Primary key.
	 */
	const PRIMARY_KEY = 'group_id';
	
	/**
	 * @brief Default constructor.
	 * @param int $groupId[optional] Group ID.
	 * @return void.
	 */
	public function __construct($groupId = false) {
		parent::__construct(self::TABLE_NAME, self::PRIMARY_KEY);
		
		// defaults
		$this->setPermisions(4); // read only
		
		if ($groupId) {
			$this->open($groupId);
		}
	}
	
	/**
	 * @brief Gets array of groups.
	 * 
	 * @return Returns array of groups, key is the group ID, value is the group name.
	 */
	public static function getGroups() {
		$dbh = Boo_DB::connect();
		$stmt = $dbh->prepare("SELECT {$this->primaryKey}, name FROM {$this->tableName}");
		
		$stmt->bindColumn('group_id', $groupId);
		$stmt->bindColumn('name', $name);
		
		try {
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if (empty($results)) {
				trigger_error('No groups were found', E_USER_NOTICE);
				return false;
			} else {
				// found groups, make array
				$tmp = array();
				foreach ($results as $row) {
					$tmp[$row['group_id']] = $row['name'];
				}
				
				return $tmp;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	
	/**
	 * @brief Group permissions.
	 * 
	 * Permissions are simmilar to GNU/Linux:
	 * \li 1 = --x
	 * \li 2 = -w-
	 * \li 3 = -wx
	 * \li 4 = r--
	 * \li 5 = r-x
	 * \li 6 = rw-
	 * \li 7 = rwx
	 * 
	 * @param int $permissions The permissions.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @todo Fix permisions.
	 */
	public function setPermissions($permissions) {
		$permissions = (int) $permissions;
		
		if ($this->isPermissions($permissions)) {
			$this->set('permissions', $permissions);
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determins if permissions are valid.
	 * 
	 * @see Boo_Group::setPermissions().
	 * @param int $permissions The permissions.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function isPermsisions($permissions) {
		$permissions = (int) $permissions;
		
		if ($permissions >= 1 && $permissions <= 7) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Sets the group name.
	 * 
	 * @param string $name The group name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setName($name) {
		$name = strtodb($name);
		
		if (Boo_Validator::isString($name, 1, 32)) { // do not use Boo_Validator::isName()
			return $this->set('name', $name);
		} else {
			trigger_error("Name {$name} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the groups name.
	 * 
	 * @return string Returns the groups name if set, FALSE otherwise.
	 */
	public function getName() { return $this->get('name'); }
	
	/**
	 * @brief Sets the groups description.
	 * 
	 * @param string $description The group description.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setDescription($description) {
		$description = strtodb($description);
		
		if (Boo_Validator::isString($description, 0, 255)) {
			return $this->set('description', $description);
		} else {
			trigger_error("Description {$description} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Gets the group description.
	 * 
	 * @return string Returns the groups description if set, FALSE otherwise.
	 */
	public function getDescription() { return $this->get('description'); }
	
	/**
	 * @brief Gets the group permissions.
	 * 
	 * @return int Returns group permissions on success, FALSE otherwise.
	 */
	public function getPermissions() { return $this->get('permissions'); }
	
	/**
	 * @brief Returns the group ID given a group name.
	 * 
	 * @param string $name The group name.
	 * @return int Group ID on success, FALSE on failure.
	 */
	public static function getGroupIdByName($name) {
		if (!$name) {
			if (BOO_WARNING) { trigger_error('Name can not be false', E_USER_WARNING); }
			return false;
		}
		
		$groupId = 0;
		$dbh = Boo_DB::connect();
		$stmt = $dbh->prepare("SELECT {$this->primaryKey} FROM {$this->tableName} WHERE name = :name LIMIT 1");
		
		$stmt->bindParam(':name', $name);
		$stmt->bindColumn('group_id', $groupId);
		
		try {
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOUND);
			
			if (!$result) {
				trigger_error("Name {$name} is not valid", E_USER_NOTICE);
				return false;
			} else {
				// found group id
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
		return $groupId;
	}

	/**
	 * @brief Determines if a group name already exists.
	 * 
	 * @param int $name The group name.
	 * @return bool Returns TRUE if group name is already in the database, FALSE otherwise.
	 */
	public static function isName($name) {
		return self::exists($name, 'name', self::TABLE_NAME, self::PRIMARY_KEY);
	}
	
	/**
	 * @brief Determines if a group ID already exists.
	 * 
	 * @param int $groupId The group ID.
	 * @return bool Returns TRUE if group ID is already in the database, FALSE otherwise.
	 */
	public static function isGroupId($groupId) {
		// allows for group ID of 0
		return !(self::exists($groupId, 'group_id', self::TABLE_NAME, self::PRIMARY_KEY) === false);
	}
}
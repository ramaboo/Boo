<?php
/* SVN FILE: $Id: Io.php 238 2009-06-19 19:57:50Z david@ramaboo.com $ */
/**
 * @brief IO class.
 * 
 * This class is used for sloppy database input and output. It is extended by other objects to provide 
 * the user with a simple way to add fields to an object. Currently it can only interact with a single table.
 * 
 * The Boo ID concept is a generic reference to the unique ID for each row of a given table. In a typical table
 * of users the Boo ID would likely be the user ID column. If no unique column exists for a given table then you
 * should create a column called boo_id and designate it an autonumber and primary key 
 * (try <a href="http://www.phpmyadmin.net/">phpMyAdmin</a> for this).
 * The Boo ID will be the value of the column designated by Boo_Io::setPrimaryKey().
 * 
 * @class		Boo_Io
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David  Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Io extends Boo_Db {
	/**
	 * @brief Fields list.
	 * 
	 * Keys are field names, values are the field values.
	 */
	protected $fields = array();
	
	/**
	 * @brief Encrypted fields list.
	 * 
	 * Boo will encrypt fields on this list with \c BOO_AES_KEY before saving into database. 
	 * Fields will be unencrypted when opened.
	 */
	protected $encryptedFields = array();
	
	/**
	 * @brief Ignored fields list.
	 * 
	 * Numerically indexed array of field names to ignore.
	 * Boo will not save fields on this list, however it will store them during the same instance.
	 */
	protected $ignoredFields = array();
	
	/**
	 * @brief Magic field list.
	 * 
	 * Boo will automaticly manipulated these fields.
	 */
	protected $magicFields = array();
	
	/**
	 * @brief List of magic fields that this class handles.
	 */
	protected $handledMagicFields = array(
		'created', 'modified', 'uuid', 'ip');
	
	/**
	 * @brief Serialized fields list.
	 * 
	 * Boo will automaticly serialize and unserialize these fileds.
	 */
	protected $serializedFields = array();
	
	/**
	 * @brief Array fields list.
	 * 
	 * Boo will automaticly store and retrieve these fileds while still allowing SQL queries in the following form:
	 * SELECT * FROM table_name WHERE value LIKE '%|search|%';
	 * 
	 * @attention This method violates table normalization rules. In most cases you should use joins instead.
	 * @warning Only stores array values, keys are permanently lost.
	 */
	protected $arrayFields = array();
	
	/**
	 * @brief Boo ID.
	 * 
	 * The Boo ID is a unique ID for each item, usualy the primary key of a table.
	 */
	protected $booId = false; // zero is a valid ID
	
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
		parent::__construct($tableName, $primaryKey);
	}
	
	/**
	 * @brief Preloads values from fields into \c $_POST.
	 * 
	 * This only works well if the \c $_POST keys are the same as Boo_Io fields. Using
	 * Boo_Html_Form_Xml::preloadPost() is safer for many uses.
	 * 
	 * @see Boo_Html_Form_Xml::preloadPost()
	 * @param bool $override[optional] Override existing values.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function preloadPost($override = true) {
		$override = (bool) $override;
		
		$fields = $this->getSafeFields();
		
		if (empty($fields)) {
			trigger_error('Fields is empty, nothing will be preloaded', E_USER_NOTICE);
			return false;
		}
		
		foreach ($fields as $key => $value) {
			if ($override) {
				$_POST[$key] = $value;
			} else {
				if (array_key_exists($key, $_POST)) {
					// value already exists, skip
				} else {
					$_POST[$key] = $value;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Sets a field.
	 * 
	 * API shorthand for Boo_Io::setField().
	 * 
	 * @param string $field The field to set.
	 * @param string $value The value of the field.
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 */
	public function set($field, $value) { return $this->setField($field, $value); }
	
	/**
	 * @brief Sets a field.
	 * 
	 * @param string $field The field to set.
	 * @param string $value The value of the field.
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 */
	public function setField($field, $value) {
		$field = trim($field);
		
		if (is_string($value)) {
			$value = trim($value);
		} // else leave alone
		
		if ($field == 'boo_id') {
			trigger_error('Field boo_id is reserved for internal use', E_USER_WARNING);
			return false;
		}
		
		$this->fields[$field] = $value;
		
		return true;
	}
	
	/**
	 * @brief Adds a field to the encrypted list.
	 * 
	 * @param string $field The field name to encrypt.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already encrypted.
	 */
	public function setEncryptedField($field) {
		$field = trim($field);
		if ($field) {
			if (in_array($field, $this->encryptedFields)) {
				// field is already in array, no need to add it again
				return true;
			} else {
				$this->encryptedFields[] = $field;
				return true;
			}
		} else {
			trigger_error('Field can not be false', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds a field to the ignored list.
	 * 
	 * @param string $field The field name to ignore.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already ignored.
	 */
	public function setIgnoredField($field) {
		$field = trim($field);
		if ($field) {
			if (in_array($field, $this->ignoredFields)) {
				// field is already in array, no need to add it again
				return true;
			} else {
				$this->ignoredFields[] = $field;
				return true;
			}
		} else {
			trigger_error('Field can not be false', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds a field to the magic list.
	 * 
	 * Provides API compatibility. Performs the same function as Boo_Io::addMagicField().
	 * 
	 * @param string $field The field name to protect.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already magic.
	 */
	public function setMagicField($field) {
		$field = trim($field);
		if ($field) {
			if (in_array($field, $this->magicFields)) {
				// field is already in array, no need to add it again
				return true;
			} else {
				if (in_array($field, $this->handledMagicFields)) {
					$this->magicFields[] = $field;
					return true;
				} else {
					trigger_error("Magic field {$field} is not handled", E_USER_WARNING);
					return false;
				}
			}
		} else {
			trigger_error('Field can not be false', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds a field to the serialized list.
	 * 
	 * Provides API compatibility. Performs the same function as Boo_Io::addSerializedField().
	 * 
	 * @param string $field The field name to protect.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already serialized.
	 */
	public function setSerializedField($field) {
		$field = trim($field);
		if ($field) {
			if (in_array($field, $this->serializedFields)) {
				// field is already in array, no need to add it again
				return true;
			} else {
				$this->serializedFields[] = $field;
				return true;
			}
		} else {
			trigger_error('Field can not be false', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds a field to the array list.
	 * 
	 * Provides API compatibility. Performs the same function as Boo_Io::addArrayField().
	 * 
	 * @param string $field The field name to protect.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already an array.
	 */
	public function setArrayField($field) {
		$field = trim($field);
		if ($field) {
			if (in_array($field, $this->arrayFields)) {
				// field is already in array, no need to add it again
				return true;
			} else {
				$this->arrayFields[] = $field;
				return true;
			}
		} else {
			trigger_error('Field can not be false', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds field.
	 * 
	 * Provides API compatibility. Functionally identical to Boo_Io::setField().
	 * 
	 * @param string $field The field to add.
	 * @param string $value The value of the field.
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 */
	public function addField($field, $value) {
		return $this->setField($field, $value);
	}
	
	/**
	 * @brief Adds a field to the encrypted list.
	 * 
	 * Provides API compatibility. Performs the same function as Boo_IO::setEncryptedField().
	 * @param string $field The field name to encrypt.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already encrypted.
	 */
	public function addEncryptedField($field) {
		return $this->setEncryptedField($field);
	}
	
	/**
	 * @brief Adds a field to the ignored list.
	 * 
	 * Provides API compatibility. Performs the same function as Boo_IO::setIgnoredField().
	 * 
	 * @param string $field The field name to ignore.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already ignored.
	 */
	public function addIgnoredField($field) {
		return $this->setIgnoredField();
	}
	
	/**
	 * @brief Adds a field to the magic list.
	 * 
	 * @param string $field The field name to make magic.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already magic.
	 */
	public function addMagicField($field) {
		return $this->setMagicField($field);
	}
	
	/**
	 * @brief Adds a field to the serialized list.
	 * 
	 * @param string $field The field name to make serialized.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already serialized.
	 */
	public function addSerializedField($field) {
		return $this->setSerializedField($field);
	}
	
	/**
	 * @brief Adds a field to the array list.
	 * 
	 * @param string $field The field name to make serialized.
	 * @return bool Returns TRUE on success, FALSE otherwise. Will return TRUE if field is already an array.
	 */
	public function addArrayField($field) {
		return $this->setArrayField($field);
	}
	
	/**
	 * @brief Removes a field
	 * 
	 * @param string $field The field name.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeField($field) {
		$field = trim($field);
		if (array_key_exists($field, $this->fields)) {
			unset($this->fields[$field]);
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * @brief Removes a field from the encrypted fields list
	 * 
	 * @param string $field The field to remove.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeEncryptedField($field) {
		$field = trim($field);
		$key = array_search($field, $this->encryptedFields);
		
		if ($key === false) {
			// field not protected
			return false;
		} else {
			// remove from list
			unset($this->encryptedFields[$key]);
			return true;
		}
	}
	
	/**
	 * @brief Removes a field from the ignored fields list
	 * 
	 * @param string $field The field to remove.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeIgnoredField($field) {
		$field = trim($field);
		$key = array_search($field, $this->ignoredFields);
		
		if ($key === false) {
			// field not protected
			return false;
		} else {
			// remove from list
			unset($this->ignoredFields[$key]);
			return true;
		}
	}
	
	/**
	 * @brief Removes a field from the magic fields list
	 * 
	 * @param string $field The field to remove.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeMagicField($field) {
		$field = trim($field);
		$key = array_search($field, $this->magicFields);
		
		if ($key === false) {
			// field not protected
			return false;
		} else {
			// remove from list
			unset($this->magicFields[$key]);
			return true;
		}
	}
	
	/**
	 * @brief Removes a field from the serialized fields list
	 * 
	 * @param string $field The field to remove.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeSerializedField($field) {
		$field = trim($field);
		$key = array_search($field, $this->serializedFields);
		
		if ($key === false) {
			// field not protected
			return false;
		} else {
			// remove from list
			unset($this->serializedFields[$key]);
			return true;
		}
	}
	
	/**
	 * @brief Removes a field from the array fields list
	 * 
	 * @param string $field The field to remove.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeArrayField($field) {
		$field = trim($field);
		$key = array_search($field, $this->arrayFields);
		
		if ($key === false) {
			// field not protected
			return false;
		} else {
			// remove from list
			unset($this->arrayFields[$key]);
			return true;
		}
	}
	
	/**
	 * @brief Gets a field value.
	 * 
	 * API shorthand for Boo_Io::getField();
	 * 
	 * @param string $field The field name.
	 * @return bool Returns the value of the field if successful, FALSE otherwise.
	 */
	public function get($field) { return $this->getField($field); }

	
	/**
	 * @brief Gets a field value.
	 * 
	 * @param string $field The field name.
	 * @return bool Returns the value of the field if successful, FALSE otherwise.
	 */
	public function getField($field) {
		if (array_key_exists($field, $this->fields)) {
			$value = $this->fields[$field];
			return $value;
			
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Sets multiple fields.
	 * 
	 * This function will clear the list of fields prior to setting them.
	 * 
	 * @param array $fields An array of fields. Key is field name, value is field value.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setFields(array $fields) {
		if (!empty($fields)) {
			$result = true;
			$this->fields = array(); // clear array
			foreach ($fields as $key => $value) {
				$result = $result && $this->setField($key, $value);
			}
			$result = $result && !empty($this->fields); // return true only if atleast one field was set
			return $result;
		} else {
			trigger_error('Fields should not be empty', E_USER_NOTICE);
			return false;
		}
	}
	
	/**
	 * @brief Sets the list of encrypted fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setEncryptedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$this->encryptedFields = array(); // clear list
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setEncryptedField($value);
			}
			return $result && !empty($this->encryptedFields); // fields added successfully and more than zero fields
		}
	}
	
	/**
	 * @brief Sets the list of ignored fields.
	 * 
	 * Boo_Io will not save fields that are ignored. This function will clear the list of 
	 * ignored fields before replacing it.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setIgnoredFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$this->ignoredFields = array(); // clear list
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setIgnoredField($value);
			}
			return $result && !empty($this->ignoredFields); // fields added successfully and more than zero fields
		}
	}
	
	/**
	 * @brief Sets the list of magic fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setMagicFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$this->magicFields = array(); // clear list
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setMagicField($value);
			}
			return $result && !empty($this->magicFields); // fields added successfully and more than zero fields
		}
	}
	
	/**
	 * @brief Sets the list of serialized fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setSerializedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$this->serializedFields = array(); // clear list
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setSerializedField($value);
			}
			return $result && !empty($this->serializedFields); // fields added successfully and more than zero fields
		}
	}
	
	/**
	 * @brief Sets the list of array fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setArrayFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$this->arrayFields = array(); // clear list
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setArrayField($value);
			}
			return $result && !empty($this->arrayFields); // fields added successfully and more than zero fields
		}
	}
	
	/**
	 * @brief Adds multiple fields.
	 * 
	 * This function will not remove existing fields.
	 * 
	 * @param array $fields An array of fields. Key is field name, value is field value.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addFields(array $fields) {
		if (!empty($fields)) {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->setField($key, $value);
			}
			$result = $result && !empty($this->fields); // return true only if atleast one field was set
			return $result;
		} else {
			trigger_error('Fields should not be empty', E_USER_NOTICE);
			return false;
		}
	}
	
	/**
	 * @brief Adds fields to the list of encrypted fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addEncryptedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->addEncryptedField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Adds fields to the list of ignored fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addIgnoredFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->addIgnoredField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Adds fields to the list of magic fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addMagicFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->addMagicField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Adds fields to the list of serialized fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addSerializedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->addSerializedField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Adds fields to the list of array fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function addArrayFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->addArrayField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes multiple fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes fields from the list of encrypted fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeEncryptedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeEncryptedField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes fields from the list of ignored fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeIgnoredFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeIgnoredField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes fields from the list of magic fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeMagicFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeMagicField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes fields from the list of serialized fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeSerializedFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeSerializedField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Removes fields from the list of array fields.
	 * 
	 * @param array $fields An array of fields. Keys are numeric, values are the field names.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeArrayFields(array $fields) {
		if (empty($fields)) {
			trigger_error('Fields can not be empty', E_USER_NOTICE);
			return false;
		} else {
			$result = true;
			foreach ($fields as $key => $value) {
				$result = $result && $this->removeArrayField($value);
			}
			return $result;
		}
	}
	
	/**
	 * @brief Clears the list of fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearFields() { 
		$this->fields = array();
		return true;
	}
	
	/**
	 * @brief Clears the list of encrypted fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearEncryptedFields() { 
		$this->encryptedFields = array();
		return true;
	}
	
	/**
	 * @brief Clears the list of ignored fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearIgnoredFields() { 
		$this->ignoredFields = array();
		return true;
	}
	
	/**
	 * @brief Clears the list of magic fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearMagicFields() { 
		$this->magicFields = array();
		return true;
	}
	
	/**
	 * @brief Clears the list of serialized fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearSerializedFields() { 
		$this->serializedFields = array();
		return true;
	}
	
	/**
	 * @brief Clears the list of array fields.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearArrayFields() { 
		$this->arrayFields = array();
		return true;
	}
	
	/**
	 * @brief Returns array of fields.
	 * 
	 * @return array The fields. Key is field name, value is field value.
	 */
	public function getFields() { return $this->fields; }
	
	/**
	 * @brief Gets the array of encrypted fields.
	 *
	 * @return array The array of encrypted fields. Key is field name, value is field value.
	 */
	public function getEncryptedFields() { return $this->encryptedFields; }
	
	/**
	 * @brief Gets the array of ignored fields.
	 *
	 * @return array The array of ignored fields. Key is field name, value is field value.
	 */
	public function getIgnoredFields() { return $this->ignoredFields; }
	
	/**
	 * @brief Gets the array of magic fields.
	 *
	 * @return array The array of magic fields. Key is field name, value is field value.
	 */
	public function getMagicFields() { return $this->magicFields; }
	
	/**
	 * @brief Gets the array of serialized fields.
	 *
	 * @return array The array of serialized fields. Key is field name, value is field value.
	 */
	public function getSerializedFields() { return $this->serializedFields; }
	
	/**
	 * @brief Gets the array of array fields.
	 *
	 * @return array The array of array fields. Key is field name, value is field value.
	 */
	public function getArrayFields() { return $this->arrayFields; }
	
	/**
	 * @brief Determins if a field exists.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if field exists, FALSE otherwise.
	 */
	public function isField($field) {
		$field = trim($field);
		return array_key_exists($field, $this->protectedFields);
	}
	
	/**
	 * @brief Determins if a field is on the encrypted list.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if it is ignored, FALSE otherwise.
	 */
	public function isEncryptedField($field) {
		$field = trim($field);
		return in_array($field, $this->encryptedFields);
	}
	
	/**
	 * @brief Determins if a field is on the ignored list.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if it is ignored, FALSE otherwise.
	 */
	public function isIgnoredField($field) {
		$field = trim($field);
		return in_array($field, $this->ignoredFields);
	}
	
	/**
	 * @brief Determins if a field is on the magic list.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if it is magic, FALSE otherwise.
	 */
	public function isMagicField($field) {
		$field = trim($field);
		return in_array($field, $this->magicFields);
	}
	
	/**
	 * @brief Determins if a field is on the serialized list.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if it is serialized, FALSE otherwise.
	 */
	public function isSerializedField($field) {
		$field = trim($field);
		return in_array($field, $this->serializedFields);
	}
	
	/**
	 * @brief Determins if a field is on the array list.
	 * 
	 * @param string $field The field.
	 * @return bool Returns TRUE if it is an array field, FALSE otherwise.
	 */
	public function isArrayField($field) {
		$field = trim($field);
		return in_array($field, $this->arrayFields);
	}
	
	/**
	 * @brief Returns an array of handled magic fields.
	 * @return array Handled magic fields.
	 */
	public function getHandledMagicFields() { return $this->handledMagicFields; }
	
	/**
	 * @brief Determins if a magic field is handled.
	 * @return bool Returns TRUE if field is handled, FALSE otherwise.
	 * @param string $field The field name.
	 */
	public function isMagicFieldHandled($field) {
		$field = trim($field);
		return in_array($field, $this->handledMagicFields);
	}
	
	/**
	 * @brief Determins if object has fields.
	 * 
	 * @return bool Returns TRUE if fields are present, FALSE otherwise.
	 */
	public function hasFields() { return !empty($this->fields); }
	
	/**
	 * @brief Determins if object has encrpyted fields.
	 * 
	 * @return bool Returns TRUE if encrypted fields are present, FALSE otherwise.
	 */
	public function hasEncryptedFields() { return !empty($this->encrpytedFields); }
	
	/**
	 * @brief Determins if object has ignored fields.
	 * 
	 * @return bool Returns TRUE if ingnored fields are present, FALSE otherwise.
	 */
	public function hasIgnoredFields() { return !empty($this->protectedFields); }
	
	/**
	 * @brief Determins if object has magic fields.
	 * 
	 * @return bool Returns TRUE if magic fields are present, FALSE otherwise.
	 */
	public function hasMagicFields() { return !empty($this->magicFields); }
	
	/**
	 * @brief Determins if object has serialized fields.
	 * 
	 * @return bool Returns TRUE if serialized fields are present, FALSE otherwise.
	 */
	public function hasSerializedFields() { return !empty($this->serializedFields); }
	
	/**
	 * @brief Determins if object has any array fields.
	 * 
	 * @return bool Returns TRUE if array fields are present, FALSE otherwise.
	 */
	public function hasArrayFields() { return !empty($this->arrayFields); }
	
	/**
	 * @brief Determins if object has safe fields.
	 * 
	 * @return bool Returns TRUE if safe fields are present, FALSE otherwise.
	 */
	public function hasSafeFields() {
		$safeFields = $this->getSafeFields();
		return !empty($safeFields);
	}
	
	/**
	 * @brief Returns an array of fields that are safe to open or save.
	 * 
	 * Will not include fields that are ignored.
	 * 
	 * @return array Returns array of safe fields on success, FALSE otherwise.
	 * */
	public function getSafeFields() {
		$safeFields = array();
		
		if (empty($this->fields)) {
			if (BOO_DEBUG) { trigger_error('Fields should not be empty', E_USER_NOTICE); }
			return false;
		}
		
		foreach ($this->fields as $key => $value) {
			if (!$this->isIgnoredField($key)) {
				$safeFields[$key] = $value;
			}
		}
		
		if (empty($safeFields)) {
			if (BOO_DEBUG) { trigger_error('Safe fields is empty', E_USER_NOTICE); }
			return false;
		}
		
		return $safeFields;
	}
	
	/**
	 * @brief Sets the Boo ID.
	 * 
	 * @param mixed $booId The Boo ID.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	private function setBooId($booId) {
		$booId = trim($booId);
		
		if ($booId === false) {
			trigger_error("Boo ID {$booId} can not equal false", E_USER_WARNING);
			return false;
		} else {
			$this->booId = $booId;
			return true;
		}
	}

	/**
	 * @brief Gets the Boo ID.
	 * 
	 * Boo ID will be unique for each item in a table.
	 * 
	 * @return int The Boo ID.
	 */
	public function getBooId() { return $this->booId; }
	
	/**
	 * @brief Merges data from a Boo_Io object.
	 * 
	 * @param Boo_Io $io The object to merge.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function merge(Boo_Io $io) {
		$beforeMerge = $this->beforeMerge($io);
		if ($beforeMerge === false) {
			return false;
		} else {
			$io = $beforeMerge;
		}
		
		
		if ($io->isEmpty()) {
			trigger_error('Object is empty, merge aborted', E_USER_WARNING);
			return false;
		}
		
		$result = true;
		$result = $result && $this->addFields($io->getFields());
		
		if ($io->hasEncryptedFields()) {
			$result = $result && $this->addEncryptedFields($io->getEncryptedFields());
		}
		
		if ($io->hasIgnoredFields()) {
			$result = $result && $this->addIgnoredFields($io->getIgnoredFields());
		}
		
		if ($io->hasMagicFields()) {
			$result = $result && $this->addMagicFields($io->getMagicFields());
		}
		
		if ($io->hasSerializedFields()) {
			$result = $result && $this->addSerializedFields($io->getSerilizedFields());
		}
		
		if ($io->hasArrayFields()) {
			$result = $result && $this->addArrayFields($io->getArrayFields());
		}
		
		if ($this->afterMerge($result) === false) {
			return false;
		}
		return $result;
	}
	
	/**
	 * @brief Called before Boo_Io::merge().
	 * 
	 * @param Boo_Io $io The object to merge.
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function beforeMerge($io) {
		return $io;
	}
	
	/**
	 * @brief Called after Boo_Io::merge().
	 * 
	 * @param bool $result The result of Boo_Io::merge().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function afterMerge($result) {
		return true;
	}
	
	/**
	 * @brief Allows you to save current instance of the object as a differnt Boo ID.
	 * @return bool Returns the result of Boo_Io::save() after Boo ID is changed.
	 * @param int $booId
	 */
	public function saveAs($booId) {
		if ($this->setBooId($booId)) {
			return $this->save();
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Saves the fields to the database.
	 * 
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function save() {
		if ($this->beforeSave() === false) {
			return false;
		}
		
		$this->handleMagicFields();
		
		$safeFields = $this->getSafeFields();
		
		if (empty($safeFields)) {
			trigger_error('Safe fields is empty, can not continue', E_USER_WARNING);
			return false;
		}
		
		$result = false;
		
		if ($this->booId === false) {
			// add new row
			$dbh = Boo_Db::connect();
			
			// build sql statment
			$sql = "INSERT INTO {$this->tableName} ( ";
			
			foreach ($safeFields as $key => $value) {
				$sql .= "{$key},";
			}
			
			$sql = Boo_Csv::fixLastComma($sql);
				
			$sql .= ') VALUES (';
			
			foreach ($safeFields as $key => $value) {
				if($this->isSerializedField($key)) {
					$safeFields[$key] = serialize($value);
				}
				
				if($this->isArrayField($key)) {
					if (is_array($value)) {
						$tmp = ''; 
						foreach ($value as $arrayKey => $arrayValue) {
							$tmp .= "\"{$arrayKey}\":\"{$arrayValue}\"|";
						}
						$tmp = rtrim($tmp, '|');
						$safeFields[$key] = $tmp;
					} elseif (Boo_Validator::isNull($value)) {
						// null is ok
						$safeFields[$key] == '';
					} else {
						trigger_error("Field {$key} can not contain the value {$value}", E_USER_WARNING);
						return false;
					}
				}
				
				if ($this->isEncryptedField($key)) {
					$sql .= "AES_ENCRYPT(:{$key}, '" . BOO_AES_KEY . "'),";
				} else {
					// regular field
					$sql .= ":{$key},";
				}
			}
			
			$sql = Boo_Csv::fixLastComma($sql);
			
			$sql .= ')';
			
			$stmt = $dbh->prepare($sql);
			
			foreach ($safeFields as $key => $value) {
				$stmt->bindValue(":{$key}", $safeFields[$key]);
			}
			
			try {
				$result = $stmt->execute();
			} catch (Exception $e) {
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			// set Boo ID and the primary key
			$this->booId = $dbh->lastInsertId();
			
		} else {
			// update existing row
			$dbh = Boo_Db::connect();
			
			$sql = "UPDATE {$this->tableName} SET {$this->primaryKey} = :boo_id, ";
			
			foreach ($safeFields as $key => $value) {
				if($this->isSerializedField($key)) {
					$safeFields[$key] = serialize($value);
				}
				
				if($this->isArrayField($key)) {
					if (is_array($value)) {
						$tmp = ''; 
						foreach ($value as $arrayKey => $arrayValue) {
							$tmp .= "\"{$arrayKey}\":\"{$arrayValue}\"|";
						}
						$tmp = rtrim($tmp, '|');
						$safeFields[$key] = $tmp;
					} elseif (Boo_Validator::isNull($value)) {
						// null is ok
						$safeFields[$key] == '';
					} else {
						trigger_error("Field {$key} can not contain the value {$value}", E_USER_WARNING);
						return false;
					}
				}
				
				if ($this->isEncryptedField($key)) {
					$sql .= "{$key} = AES_ENCRYPT(:{$key}, '" . BOO_AES_KEY . "'),";
				} else {
					// regular field
					$sql .= "{$key} = :{$key},";
				}
			}
			$sql = Boo_CSV::fixLastComma($sql);
			
			$sql .= " WHERE {$this->primaryKey} = :boo_id LIMIT 1"; // keep space before WHERE
			
			$stmt = $dbh->prepare($sql);
			
			$stmt->bindParam(':boo_id', $this->booId);
			
			foreach ($safeFields as $key => $value) {
				$stmt->bindValue(":{$key}", $safeFields[$key]);
			}
			
			try {
				$result = $stmt->execute();
			} catch (Exception $e) {
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}
		
		if ($this->afterSave($result) === false) {
			return false;
		}
		//echo $sql; // usefull for debugging
		return true;
		
	}
	
	/**
	 * @brief Called before Boo_Io::save().
	 * 
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function beforeSave() {
		return true;
	}
	
	/**
	 * @brief Called after Boo_Io::save().
	 * 
	 * @param bool $result The result of Boo_Io::save().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function afterSave($result) {
		return true;
	}
	
	/**
	 * @brief Deletes and item for the database.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function delete() {
		if ($this->beforeDelete() === false) {
			return false;
		}
		
		if ($this->booId === false) {
			trigger_error('Boo ID can not be false', E_USER_WARNING);
			return false;
		}
		
		$result = false;
		$dbh = Boo_Db::connect();
			
		$sql = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = :boo_id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':boo_id', $this->booId);
		
		try {
			$result = $stmt->execute();
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
		if ($this->afterDelete($result) === false) {
			return false;
		}
		
		return $result;
	}
	
	/**
	 * @brief Called before Boo_Io::delete().
	 * 
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function beforeDelete() {
		return true;
	}
	
	/**
	 * @brief Called after Boo_Io::delete().
	 * 
	 * @param bool $result The result of Boo_Io::delete().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function afterDelete($result) {
		return true;
	}
	
	/**
	 * @brief Counts all the rows in the table.
	 * @return int Returns the row count, FALSE on failure.
	 */
	public function count() {
		$result = false;
		$dbh = Boo_Db::connect();
		$sql = "SELECT COUNT(*) FROM {$this->tableName}";
		
		try {
			$stmt = $dbh->query($sql);
			$result = $stmt->fetchColumn();
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
		return $result;
	}
	
	/**
	 * @brief Opens the object.
	 * 
	 * Loads values from database.
	 * 
	 * @param int $booId The Boo ID.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function open($booId) {
		$beforeOpen = $this->beforeOpen($booId);
		if ($beforeOpen === false) {
			return false;
		} else {
			$booId = $beforeOpen;
		}
		
		if ($booId === false) {
			trigger_error('Boo ID can not be false', E_USER_WARNING);
			return false;
		}
		
		$booId = trim($booId);
		
		$result = false;
		$dbh = Boo_Db::connect();
		
		$columns = '*';
		
		foreach ($this->encryptedFields as $key => $value) {
			$columns .= ", AES_DECRYPT({$value}, '" . BOO_AES_KEY . "') AS {$value}";
		}
		
		$sql = "SELECT {$columns} FROM {$this->tableName} WHERE {$this->primaryKey} = :boo_id LIMIT 1";
		
		$stmt = $dbh->prepare($sql);
		
		$stmt->bindParam(':boo_id', $booId);
		
		try {
			$stmt->execute();
			$results = $stmt->fetch(PDO::FETCH_ASSOC); // returns array
			if (empty($results)) {
				trigger_error("Boo ID {$booId} is not valid", E_USER_NOTICE);
				$result = false;
			} else {
				$result = true;
				$this->addFields($results); // add results to fields
				$this->booId = $booId; // set the Boo ID to the ID that was opened
				
				// handle serialized fields
				foreach ($this->serializedFields as $key => $value) {
					if (isset($this->fields[$value])) {
						$this->fields[$value] = unserialize($this->fields[$value]);
					}
				}
				
				// handle array fields
				foreach ($this->arrayFields as $key => $value) {
					if (isset($this->fields[$value])) {
						if (Boo_Validator::isNull($this->fields[$value])) {
							// empty array
							$this->fields[$value] = array();
						} else {
							
							$tmpFields = explode('|', $this->fields[$value]);
							$tmpResults = array();
							foreach ($tmpFields as $fieldKey => $fieldValue) {
								$tmpValues = explode(':', $fieldValue);
								$tmpResults[trim($tmpValues[0], '"')] = trim($tmpValues[1], '"');
							}
														
							$this->fields[$value] = $tmpResults;
						}
					}
				}
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
	 * @brief Called before Boo_Io::open().
	 * 
	 * @param int $booId The Boo ID.
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	protected function beforeOpen($booId) {
		return $booId;
	}
	
	/**
	 * @brief Called after Boo_Io::open().
	 * 
	 * @param bool $result The result of Boo_Io::open().
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
	 * @brief Converts empty strings in fields to null.
	 * @return int Returns the number of fields changed.
	 * @param array $excludeFields[optional] Fields to exclude.
	 */
	public function fixNulls(array $excludeFields = array()) {
		$count = 0;
		foreach ($this->fields as $key => $value) {
			if (in_array($key, $excludeFields)) {
				// skip
			} else {
				if ($value === '') {
					$count++;
					$this->fields[$key] = null;
				}
			}
		}
		
		return $count;
	}
	
	/**
	 * @brief Called before Boo_Io::close().
	 * 
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	public function beforeClose() {
		return true;
	}
	
	/**
	 * @brief Called after Boo_Io::close().
	 * 
	 * @param bool $result The result of Boo_Io::close().
	 * @return bool Function always returns TRUE unless overridden by parent class.
	 */
	public function afterClose($result) {
		return true;
	}
	
	/**
	 * @beief Saves object to session.
	 * 
	 * @param string $key[optional] The session key.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function saveSession($key = 'boo_id') {
		$key = trim($key);
		
		if (!$key) {
			trigger_error('Key can not be blank', E_USER_WARNING);
			return false;
		}
		
		die("TODO FIX THIS");
		return true;
	}
	
	/**
	 * @brief Opens object in session.
	 * 
	 * @param string $key[optional] The session key.
	 * @return Returns TRUE on success, FALSE otherwise.
	 */
	public function openSession($key = 'boo_id') {
		$key = trim($key);
		
		if (!$key) {
			trigger_error('Key can not be blank', E_USER_WARNING);
			return false;
		}
		
		if (array_key_exists($key, $_SESSION)) {
			die("TODO FIX THIS");
			return true;
		} else {
			trigger_error("Key {$key} is not valid", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Clears session.
	 * 
	 * @param string $key[optional] The session key.
	 * @return bool Returns TRUE if key exists, FALSE otherwise.
	 */
	public function clearSession($key = 'boo_io') {
		$key = trim($key);
		if (array_key_exists($key, $_SESSION)) {
			unset($_SESSION[$key]);
			return true;
		} else {
			trigger_error("Key {$key} was not found, session is probably already destroyed", E_USER_NOTICE);
			return false;
		}
	}
	
	public function isEmpty() { return empty($this->fields); }
	
	/**
	 * @brief Determins if an item exists in a given column.
	 * 
	 * @param string $search The search string.
	 * @param string $column The column name.
	 * @param string $tableName The table name.
	 * @param mixed $primaryKey The primary key for the table, should be a Boo ID.
	 * @return mixed Returns Boo ID on success, FALSE on failure.
	 */
	public static function exists($search, $column, $tableName, $primaryKey) {
		$column = trim($column);
		$tableName = trim($tableName);
		$primaryKey = trim($primaryKey);
		$booId = false; // default to failure
		
		if (!Boo_Validator::isSqlSafe($column)) {
			trigger_error("The column {$column} contains illegal characters, SQL injection likely", E_USER_ERROR);
			return false;
		}
		
		if (!Boo_Validator::isSqlSafe($tableName)) {
			trigger_error("The table name {$tableName} contains illegal characters, SQL injection likely", E_USER_ERROR);
			return false;
		}
		
		if (!Boo_Validator::isSqlSafe($primaryKey)) {
			trigger_error("The primary key {$primaryKey} contains illegal characters, SQL injection likely", E_USER_ERROR);
			return false;
		}
		
		$dbh = Boo_Db::connect();
		
		$stmt = $dbh->prepare("SELECT {$primaryKey} FROM {$tableName} WHERE {$column} = :search LIMIT 1");
		$stmt->bindParam(':search', $search);
		
		$stmt->bindColumn($primaryKey, $booId);
		
		try {
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOUND);
			/*
			 * If successfull Boo ID should now be the value of the primary key,
			 * usualy a positive non zero integer.
			 * If nothing was found then an empty string is returned.
			 */
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
		// change empty string to false, ignore 0
		if ($booId === '') { $booId = false;}
		
		return $booId;
	}
	
	/**
	 * @brief Handles magic fields.
	 * 
	 * Function is called by Boo_Io::save() after Boo_Io::beforeSave().
	 * 
	 * @return bool Returns TRUE if magic fields were handled, FALSE otherwise.
	 */
	public function handleMagicFields() {
		if (!$this->hasMagicFields()) {
			return false;
		}
		
		// handle created field
		if ($this->isMagicField('created')) {
			if (!isset($this->fields['created'])) {
				$this->fields['created'] = time();
			}
		}
		
		// handle modified field
		if ($this->isMagicField('modified')) {
			// always overwrite existing value
			$this->fields['modified'] = time();
		}
		
		// handle UUID field
		if ($this->isMagicField('uuid')) {
			if (!isset($this->fields['uuid'])) {
				$this->fields['uuid'] = Boo_Helper::getUuid();
			}
		}
		
		// handle IP field
		if ($this->isMagicField('ip')) {
			if (!isset($this->fields['ip'])) {
				$this->fields['ip'] = Boo_Page::getIp();
			}
		}
		return true;
	}
	
	/**
	 * @brief Gets the time the object was created.
	 * 
	 * @return int Unix timestamp of when the object was created if present, FALSE otherwise.
	 */
	public function getCreated() { return $this->get('created'); }
	
	/**
	 * @brief Gets the time the object was modified.
	 * 
	 * @return int Unix timestamp of when the object was modified if present, FALSE otherwise.
	 */
	public function getModified() { return $this->get('modified'); }
	
	/**
	 * @brief Gets the UUID for the object.
	 * @return string The UUID for the object if present, FALSE otherwise.
	 */
	public function getUuid() { return $this->get('uuid'); }
	
	/**
	 * @brief Gets the IP for the object.
	 * @return string The IP for the object if present, FALSE otherwise.
	 */
	public function getIp() { return $this->get('ip'); }
	
	/**
	 * @brief Prints HTML for debuging.
	 * @param array $attrs[optional] Array of attributes.
	 * @return string HTML debug information.
	 */
	public function htmlDebugDiv(array $attrs = array()) {
		
		if (BOO_PRODUCTION) {
			trigger_error('Function is not available in production mode, set BOO_PRDOUCTION to FALSE', E_USER_ERROR);
			return false;
		}
		
		$tmp = '<h1>Boo_Io::htmlDebug()</h1><h2>Fields</h2><ul>';
		
		foreach ($this->fields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h2>Encrypted Fields</h2><ul>';
		
		foreach ($this->encryptedFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h2>Ignored Fields</h2><ul>';
		
		foreach ($this->ignoredFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h2>Magic Fields</h2><ul>';
		
		foreach ($this->magicFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h3>Handled Magic Fields</h3><ul>';
		
		foreach ($this->handledMagicFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h2>Serizlized Fields</h2><ul>';
		
		foreach ($this->serializedFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= '</ul><h2>Array Fields</h2><ul>';
		
		foreach ($this->arrayFields as $key => $value) {
			$tmp .= "<li><b>{$key}</b>: {$value}</li>";
		}
		
		$tmp .= "</ul><h1>Boo ID</h1><p>{$this->booId}</p>";
		
		
		$div = new Boo_Html_Div;
		$div->applyAttrs($attrs);
		$div->setContent($tmp);
		return $div;
	}
}
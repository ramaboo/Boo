<?php
/* SVN FILE: $Id: Select.php 222 2009-04-02 09:33:06Z david@ramaboo.com $ */
/**
 * @brief HTML drop-down list class.
 * 
 * This class is used to generate HTML drop-down lists.
 * 
 * @class		Boo_Html_Select
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.7.0
 * 
 * @todo Add support for selecting multiple items.
 * @todo Fix issues with htmlentities.
 */

class Boo_Html_Select extends Boo_Html_FormControl {
	/**
	 * @brief The select elements data.
	 * 
	 * Implemented as an array where the key is the option value and the value is the text displayed.
	 */
	protected $data = array();
	
	/**
	 * @brief The title of the select element.
	 * 
	 * Will be displayed as the first item in the select list if set and will contain a value of an empty string by default.
	 */
	protected $title = array('name' => '', 'value' => '');	
	
	/**
	 * @brief The default key.
	 * 
	 * Overided by posted values or selected key.
	 */
	protected $default = '';
	
	/**
	 * @brief The selected key.
	 * 
	 * Overrides posted value and default key.
	 */
	protected $selected = '';
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {
		parent::__construct('select');
	}
	
	/**
	 * @brief Sets the lists data.
	 * 
	 * @param array $data The data.
	 * @return bool Returns TRUE on sccess, FALSE otherwise.
	 */
	public function setData(array $data) {
		if (empty($data)) {
			trigger_error('Data should not be empty, try Boo_Html_Select::clearData()', E_USER_NOTICE);
			return false;
		} else {
			$this->data = $data;
			return true;
		}
	}
	
	/**
	 * @brief Clears the lists data.
	 * 
	 * @return bool Function always returns TRUE.
	 */
	public function clearData() {
		$this->data = array();
		return true;
	}
	
	/**
	 * @brief Gets the lists data.
	 * 
	 * @return array The data.
	 */
	public function getData() { return $this->data; }
	
	/**
	 * @brief Sets the title.
	 * 
	 * @param string $name The name of the title (displayed to user).
	 * @param string $value (optional) The value for the title.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setTitle($name, $value = null) {
		$name = trim($name);
		$value = trim($value);
		
		if (Boo_Validator::isNull($name)) {
			trigger_error("Name {$name} can not be null (or a null like value)", E_USER_WARNING);
			return false;
		} else {
			$this->title['name'] = $name;
			$this->title['value'] = $value;
			return true;
		}
	}
	
	/**
	 * @brief Determins if a title is set.
	 * 
	 * @return bool Returns TRUE if title is set, FALSE otherwise.
	 */
	public function hasTitle() {
		if (!Boo_Validator::isNull($this->title['name'])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Gets the title.
	 * 
	 * API compatibility.
	 * 
	 * @return string The title.
	 */
	public function getTitle() { return $this->getTitleName(); }
	
	/**
	 * @breif Gets the titles name (as seen by the user).
	 * 
	 * @return string The titles name.
	 */
	public function getTitleName() { return $this->title['name']; }
	
	/**
	 * @brief Gets the titles value.
	 * 
	 * @return string The titles value.
	 */
	public function getTitleValue() { return $this->title['value']; }
	
	/**
	 * @brief Sets the default key.
	 * 
	 * @param string $key The default key.
	 * @return bool Returns TRUE on success, FALSE on error.
	 */
	public function setDefault($key) {
		$key = trim($key);
		if (!$this->hasData()) {
			if (BOO_DEBUG) { trigger_error('Data should be set before calling this function, try Boo_Html_Select::setData(), error checking skipped', E_USER_NOTICE); }
			$this->default = $key;
			return true;
		}
		
		if (array_key_exists($key, $this->data)) {
			$this->default = $key;
			return true;
		} else {
			trigger_error("Key {$key} was not found in data", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds key to list of default items.
	 * 
	 * This feature is not yet implemented! Added for future API compatibility.
	 * 
	 * @param string $key The default key.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 * 
	 * @todo Finish this function when updating class to support multiple selects.
	 */
	public function addDefault($key) {
		return $this->setDefault($key);
	}
	
	/**
	 * @brief Gets the default key.
	 * 
	 * @return string The default key.
	 */
	public function getDefault() { return $this->default; }
	
	/**
	 * @brief Sets the selected key.
	 * 
	 * @param string $key The selected key.
	 * @return bool Returns TRUE on success, FALSE on error.
	 */
	function setSelected($key) {
		$key = trim($key);
		if (!$this->hasData()) {
			trigger_error('Data should be set before calling this function, try Boo_Html_Select::setData(), error checking skipped', E_USER_NOTICE);
			$this->selected = $key;
			return true;
		}
		
		if (array_key_exists($key, $this->data)) {
			$this->selected = $key;
			return true;
		} else {
			trigger_error("Key {$key} was not found in data", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Adds key to list of selected items.
	 * 
	 * This feature is not yet implemented! Added for future API compatibility.
	 * 
	 * @param string $key The selected key.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 * 
	 * @todo Finish this function when updating class to support multiple selects.
	 */
	public function addSelected($key) {
		return $this->setSelected($key);
	}
	
	/**
	 * @brief Gets the selected key.
	 * 
	 * @return string The selected key.
	 */
	public function getSelected() { return $this->selected; }
	
	/**
	 * @brief Sets the default index.
	 * Zero based.
	 * 
	 * @warning This function relies on the internal order of the data array. This can be dangerous.
	 * 
	 * @param int $index The default index.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setDefaultIndex($index) {
		$index = (int) $index;
		
		if ($index < 0) {
			trigger_error("Index {$index} is negative, only postive values are acceptable", E_USER_WARNING);
			return false;
		}
		
		if (!$this->hasData()) {
			trigger_error('Data should be set before calling this function, try Boo_Html_Select::setData()', E_USER_WARNING);
			return false;
		}
		
		$count = 0;
		foreach($this->data as $key=>$value) {
			if ($count == $index) {
				return $this->setDefault($key);
			}
			$count++;
		}
		
		// index is outside the bounds of the array
		return false;
	}
	
	/**
	 * @brief Gets the default index.
	 * 
	 * * Zero based.
	 * 
	 * @warning This function relies on the internal order of the data array. This can be dangerous.
	 * 
	 * @return mixed Returns default index on success, FALSE on failure.
	 */
	public function getDefaultIndex() {
		if (Boo_Validator::isNull($this->default)) {
			trigger_error('Default has not be set, try Boo_Html_Select::setDefault()', E_USER_ERROR);
			return false;
		}
		
		$count = 0;
		foreach ($this->data as $key=>$value) {
			if ($key == $this->default) {
				return $count;
			}
			$count++;
		}
		
		return false;
	}
	
	/**
	 * @brief Sets the selected index.
	 * 
	 * Zero based.
	 * 
	 * @warning This function relies on the internal order of the data array. This can be dangerous.
	 * 
	 * @param int $index The selected index.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setSelectedIndex($index) {
		$index = (int) $index;
		
		if ($index < 0) {
			trigger_error("Index {$index} is negative, only postive values are acceptable", E_USER_WARNING);
			return false;
		}
		
		if (!$this->hasData()) {
			trigger_error('Data should be set before calling this function, try Boo_Html_Select::setData()', E_USER_WARNING);
			return false;
		}
		
		$count = 0;
		foreach($this->data as $key => $value) {
			if ($count == $index) {
				return $this->setSelected($key);
			}
			$count++;
		}
		
		// index is outside the bounds of the array
		return false;
	}
	
	/**
	 * @brief Gets the selected index.
	 * 
	 * Zero based.
	 * 
	 * @warning This function relies on the internal order of the data array. This can be dangerous.
	 * 
	 * @return mixed Returns selected index on success, FALSE on failure.
	 */
	public function getSelectedIndex() {
		if (Boo_Validator::isNull($this->selected)) {
			trigger_error('Selected has not be set, try Boo_Html_Select::setSelected()', E_USER_ERROR);
			return false;
		}
		
		$count = 0;
		foreach ($this->data as $key => $value) {
			if ($key == $this->selected) {
				return $count;
			}
			$count++;
		}
		
		return false;
	}
	
	/**
	 * @brief Gets index of posted value.
	 * 
	 * @warning This function relies on the internal order of the data array. This can be dangerous.
	 * 
	 * @return mixed Returns posted index on success, FALSE otherwise.
	 */
	public function getPostedIndex() {
		$pv = $this->getPostedValue();
		
		if ($pv === false) {
			trigger_errror('Not a postback, can not continue', E_USER_ERROR);
			return false;
		}
		
		$count = 0;
		foreach ($this->data as $key => $value) {
			if ($key == $pv) {
				return $count;
			}
			$count++;
		}
		
		return false;
	}
	
	/**
	 * @brief Returns the HTML for the list.
	 * 
	 * @param array $attrs [optional] Array of attributes.
	 * @return string The HTML for list the list.
	 */
	function html(array $attrs = array()) {
		if (Boo_Validator::isNull($this->getAttr('name'))) {
			trigger_error('Attribute name cannot be null (or null like value)', E_USER_ERROR);
			return false;
		}
		
		if (Boo_Validator::isNull($this->getAttr('id'))) {
			trigger_error('Attribute id cannot be null (or null like value)', E_USER_ERROR);
			return false;
		}
		
		$this->applyAttrs($attrs);
		
		$tmp = '';
		$tmp .= $this->htmlOpen() . "\n";

		// add title if there is one
		if ($this->hasTitle()) {
			// first option
			$tmp .= '<option value="' . $this->title['value'] . '">'. $this->title['name'] . "</option>\n";
		}
		
		if ($this->isSticky()) {
			// list is sticky
			
			if (empty($this->data)) {
				trigger_error('Data is empty and the list is sticky, this will produce an empty list', E_USER_NOTICE);
				// do not return
			}
			
			$name = $this->getAttr('name');
			if (substr($name, (strlen($name) - 2), 2) == '[]') {
				// remove []
				$name = substr($name, 0, -2);
			}
			
			$selected = false;
			
			// try default, post and selected override default
			if (!Boo_Validator::isNull($this->default)) {
				$selected = $this->default;
			}
			
			// try post, use value if found
			if (array_key_exists($name, $_POST)) {
				if (is_array($_POST[$name])) {
					foreach ($_POST[$name] as $key => $value) {
						$selected[$key] = $value;
					}
				} else {
					$selected = $_POST[$name];
				}
			}
			
			// try selected, selected overrides post
			if (!Boo_Validator::isNull($this->selected)) {
				$selected = $this->selected;
			}
			
			foreach($this->data as $key => $value) {
				if (is_array($selected)) {
					// selected is an array
					// multiple items selected
					if (in_array($key, $selected)) {
						$tmp .= "<option value=\"{$key}\" selected=\"selected\">{$value}</option>\n";
					} else {
						$tmp .= "<option value=\"{$key}\">{$value}</option>\n";
					}
				} else {
					// single item selected
					if ((string) $selected === (string) $key) { // if you use == then 0 will equal null, this hack seems to work
						$tmp .= "<option value=\"{$key}\" selected=\"selected\">{$value}</option>\n";
					} else {
						$tmp .= "<option value=\"{$key}\">{$value}</option>\n";
					}
				}
			}
		} else {
			// list is not sticky
			foreach($this->data as $key => $value) {
				$tmp .= "<option value=\"{$key}\">{$value}</option>\n";
			}
		}
		
		$tmp .= $this->htmlClose() . "\n";
		return $tmp;
	}
	
	/**
	 * @brief Determins if the list has data.
	 * 
	 * @return bool Returns TRUE if data is set, FALSE otherwise.
	 */
	public function hasData() { return !empty($this->data); }
	
	
	/**
	 * @brief HTML select of all US states.
	 * 
	 * @return Boo_Html_Select The HTML select of all US states.
	 */
	public static function htmlStatesSelect() {
		$tmp = new Boo_Html_Select;
		$tmp->setAttr('id', 'state');
		$tmp->setAttr('name', 'state');
		$tmp->setTitle('Select State');
		$tmp->setSticky(true); // the select element will remember its value from postbacks
		$tmp->setData(Boo_Validator::getStates()); // built in array of every state
		return $tmp;
	}
	
	/**
	 * @brief HTML select of all countries.
	 * 
	 * @return Boo_Html_Select The HTML select of all countries.
	 */
	public static function htmlCountriesSelect() {
		$tmp = new Boo_Html_Select;
		$tmp->setAttr('id', 'country');
		$tmp->setAttr('name', 'country');
		$tmp->setTitle('Select Country');
		$tmp->setSticky(true); // the select element will remember its value from postbacks
		$tmp->setData(Boo_Validator::getCountries()); // built in array of every state
		return $tmp;
	}
}
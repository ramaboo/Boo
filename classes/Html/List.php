<?php
/* SVN FILE: $Id: List.php 230 2009-04-23 15:55:02Z david@ramaboo.com $ */
/**
 * @brief HTML list class.
 * 
 * This class is used as a base class for all list elements.
 * 
 * @class		Boo_Html_List
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

class Boo_Html_List extends Boo_Html {
	
	/**
	 * @brief List items array.
	 */
	protected $lis = array();
	
	/**
	 * @brief Default constructor.
	 * @param string $element The HTML element to create.
	 * @return void.
	 */
	public function __construct($element) {
		parent::__construct($element);
	}
	
	/**
	 * @brief Merges list items from another list into this list.
	 * @return int Returns number of items merged.
	 * @param Boo_Html_List $list The list object to merge.
	 */
	public function merge(Boo_Html_List $list) {
		$count = 0;
		foreach ($list->getLis() as $key => $value) {
			$this->addLi($value);
			$count++;
		}
		return $count;
	}
	
	/**
	 * @brief Adds a list item.
	 * 
	 * @param mixed $li The list item to add.
	 * @return bool Returns index of item.
	 */
	public function addLi($li) {
		
		
		if ($li instanceof Boo_Html_Li) {
			$this->lis[] = $li;
		} else {
			$tmpLi = new Boo_Html_Li;
			$tmpLi->setContent($li);
			$this->lis[] = $tmpLi;
		}
		
		return count($this->lis) -1;
	}
		
	/**
	 * @brief Removes a list item.
	 * 
	 * @param int $index The list item index.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function removeLi($index) {
		$index = (int) $index;
		if (array_key_exists($index, $this->lis)) {
			unset($this->lis[$index]);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Removes a list item.
	 * 
	 * Removes all list items with a specific class.
	 * 
	 * @param string $class The search class.
	 * @return bool Returns TRUE if a list item was removed, FALSE otherwise.
	 */
	public function removeLiByClass($class) {
		$class = trim($class);
		$result = false;
		foreach ($this->lis as $key => $value) {
			if ($value->hasClass($class)) {
				unset($this->lis[$key]);
				$result = true;
			}
		}
		return $result;
	}
	
	/**
	 * @brief Sets a list item.
	 * 
	 * @param Boo_Html_Li $li The list item object.
	 * @param int $index The list item index.
	 * @return bool Function always returns TRUE.
	 */
	public function setLi($li, $index) {
		$index = (int) $index;
		if ($li instanceof Boo_Html_Li) {
			$this->lis[$index] = $li;
		} else {
			$tmpLi = new Boo_Html_Li;
			$tmpLi->setContent($li);
			$this->lis[$index] = $tmpLi;
		}
		
		return true;
	}
	
	/**
	 * @brief Returns a list item.
	 * 
	 * @param int $index The list item index.
	 * @return Boo_Html_Li The list item object on success, FALSE otherwise.
	 */
	public function getLi($index) {
		$index = (int) $index;
		if (array_key_exists($index, $this->lis)) {
			return $this->lis[$index];
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Gets a list item by HTML ID.
	 * @return Boo_Html_Li The list item object with the given ID, FALSE if not found.
	 * @param string $id The search ID;
	 */
	public function getLiById($id) {
		$id = trim($id);
		foreach ($this->lis as $key => $value) {
			if ($value->getAttr('id') == $id) {
				return $value;
			}
		}
		return false;
	}
	
	/**
	 * @brief Gets a list items index by HTML ID.
	 * @return int The list items index if found, FALSE if not found.
	 * @param string $id The search id;
	 */
	public function getLiIndexById($id) {
		$id = trim($id);
		foreach ($this->lis as $key => $value) {
			if ($value->getAttr('id') == $id) {
				return $key;
			}
		}
		return false;
	}
	
	/**
	 * @brief Removes a list item by HTML ID.
	 * @return bool Returns TRUE if item was found and removed, FALSE otherwise.
	 * @param string $id The search id;
	 */
	public function removeLiById($id) {
		$id = trim($id);
		foreach ($this->lis as $key => $value) {
			if ($value->getAttr('id') == $id) {
				unset($this->lis[$key]);
				return true;
			}
		}
		return false;
	}
	
	/**
	 * @brief Retuns all list items.
	 * 
	 * @return array Array of Boo_Html_Li objects.
	 */
	public function getLis() { return $this->lis; }
	
	/**
	 * @brief Clears all list items.
	 * @return bool Function always returns TRUE.
	 */
	public function clearLis() { $this->lis = array(); return true; }
	
	/**
	 * @brief Returns list items count.
	 * 
	 * @return int Number of list items.
	 */
	public function getCount() { return count($this->lis); }
	
	/**
	 * @brief Returns number of list items with a given class.
	 * 
	 * Will return zero if no items are found.
	 * 
	 * @return int Returns number of list items with a given class.
	 * @param string $class The search class.
	 */
	public function getCountByClass($class) {
		$class = trim($class);
		$count = 0;
		foreach ($this->lis as $key => $value) {
			if ($value->hasClass($class)) {
				$count++;
			}
		}
		return $count;
	}
	
	/**
	 * @brief Determines if list items is empty.
	 * 
	 * @return bool Returns TRUE if list items is empty, FALSE otherwise.
	 */
	public function isEmpty() { return empty($this->lis); }
	
	/**
	 * @brief Returns a dummy list item.
	* 
	 * This is used as a place holder for empty lists so they are valid xhtml.
	 * 
	 * @return Boo_Html_Li A dummy list item.
	 * @param array $attrs[optional] Array of attributes.
	 */
	public function htmlDummyLi(array $attrs = array()) {
		$li = new Boo_Html_Li;
		$li->applyAttrs($attrs);
		$li->addClass('dummy');
		
		return $li;
	}
	
	/** 
	 * @brief Returns html.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @return string HTML for the element.
	 */
	public function html(array $attrs = array()) {
		
		// list is empty return dummy item
		if ($this->isEmpty()) {
			$this->appendContent($this->htmlDummyLi());
			return parent::html($attrs);
		}
		
		$count = 1; // must start with 1 not 0
		$listCount = $this->getCount();
		
		$this->clearContent();
		foreach ($this->lis as $key => $value) {
			// helps with pass by reference issues
			$tmpValue = clone $value;
			
			// add classes if need
			if ($count == 1) {
				$tmpValue->addClass('first-child');
			}
			
			if ($count == $listCount) {
				// if array has one item then it will have both classes, this is good
				$tmpValue->addClass('last-child');
			}
			
			$this->appendContent($tmpValue);
			$count++;
		}
		return parent::html($attrs);
	}
}
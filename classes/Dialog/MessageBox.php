<?php
/* SVN FILE: $Id: MessageBox.php 215 2009-03-17 01:15:42Z david@ramaboo.com $ */
/**
 * @brief Dialog messagebox class.
 * 
 * @class		Boo_Dialog_MessageBox
 * @license 	http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.0.0
 * 
 * @todo		Rewrite with Smarty.
 */

class Boo_Dialog_MessageBox extends Boo_Dialog {
	public $list;
	public $icon;
	
	public function __construct() {
		parent::__construct();
		$this->list = new Boo_Html_Ol;
		$this->addClass('dialog');
		$this->addClass('messagebox');
		
		$this->icon = new Boo_Html_Img;
		$this->icon->setAttr('src', BOO_IMAGE_DIR_HTML . '/icons/messagebox.png');
		$this->icon->setAttr('alt', 'Powered by Boo');
		$this->icon->addClass('icon');
	}
	
	public function addMessage($message, array $attrs = array()) {
		$message = trim($message);
		$li = new Boo_Html_Li;
		$li->applyAttrs($attrs);
		$li->setContent($message);
		return $this->list->addLi($li);
		
		
	}
	
	public function getMessages() {
		$messages = array();
		foreach ($this->list->getLis() as $key => $value) {
			$messages[] = $value->getContent();
		}
		
		return $messages;
	}
	
	/**
	 * @brief Merges list items from another list into this list.
	 * @return int Returns number of items merged.
	 * @param Boo_Html_List $list The list object to merge.
	 */
	public function merge(Boo_Html_List $list) {
		return $this->list->merge($list);
	}
	
	/**
	 * @brief Sets the icon for the message box.
	 * @return bool Returns TRUE on success, FALSE otherwise
	 * @param mixed $icon Accepts either a Boo_Html_Img object or a string to use as the image source.
	 */
	public function setIcon($icon) {
		if ($icon instanceof Boo_Html_Img) {
			$this->icon = $icon;
			return true;
		} elseif (is_string($icon)) {
			return $this->icon->setAttr('src', $icon);
		} else {
			trigger_error("Icon $icon is not valid", E_USER_ERROR);
			return false;
		}
		
	}
	
	// FIX
	public function saveSession() {
	//$_SESSION['boo_messagebox'][$this->getAttr('id')] = $this->ol;
	
		$_SESSION['booMessageBox'][$this->getAttr('id')] = serialize($this->list);
	//	var_dump($_SESSION);
		return true;	
	
	}
	
	public function openSession() {
	//	echo "open";
	//	var_dump($_SESSION);
		
		if (isset($_SESSION['booMessageBox'][$this->getAttr('id')])) {
			$ol = unserialize($_SESSION['booMessageBox'][$this->getAttr('id')]);
		//	var_dump($ol);
			$this->list = $ol;
		//	echo "yippie";
			return true;
		} else {
			//echo "fail";
			return false;
		}
	}
	
	public function clearSession() {
		unset($_SESSION['booMessageBox'][$this->getAttr('id')]);
		return true;
		
	}
	
	function getMessageCount() { return $this->list->getCount(); }
	
	public function html() {
		
		$this->clearSession(); // clears session because it is displayed
		if ($this->list->isEmpty()) {
			// no messages, make invisible
			$this->setAttr('style', 'display: none;');
		}
		
		$tmp = parent::htmlOpen()
			. '<div class="messagebox-icon clearfix">' . $this->icon .'</div>'
			. '<div class="messagebox-list clearfix">'. $this->list . '</div>'
			. '<div class="messagebox-close clearfix"><a class="button button-close" href="#">Close</a></div>'
			. parent::htmlClose();
		
		return $tmp;
	}
}

<?php
/* SVN FILE: $Id: Html.php 238 2009-06-19 19:57:50Z david@ramaboo.com $ */
/**
 * @brief HTML class.
 * 
 * This class is used to generate HTML elements.
 * 
 * @class		Boo_Html
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		1.8.1
 */

// base classes
Boo_ClassLoader::load('Boo_Html_FormControl'); // must go first (base class)
Boo_ClassLoader::load('Boo_Html_List'); // must go first (base class)

// element classes
Boo_ClassLoader::load('Boo_Html_A');
Boo_ClassLoader::load('Boo_Html_Abbr');
Boo_ClassLoader::load('Boo_Html_Acronym');
Boo_ClassLoader::load('Boo_Html_Address');
Boo_ClassLoader::load('Boo_Html_Area');
Boo_ClassLoader::load('Boo_Html_B');
Boo_ClassLoader::load('Boo_Html_Base');
Boo_ClassLoader::load('Boo_Html_Bdo');
Boo_ClassLoader::load('Boo_Html_Big');
Boo_ClassLoader::load('Boo_Html_Blockquote');
Boo_ClassLoader::load('Boo_Html_Body');
Boo_ClassLoader::load('Boo_Html_Br');
Boo_ClassLoader::load('Boo_Html_Button');
Boo_ClassLoader::load('Boo_Html_Caption');
Boo_ClassLoader::load('Boo_Html_Cite');
Boo_ClassLoader::load('Boo_Html_Code');
Boo_ClassLoader::load('Boo_Html_Col');
Boo_ClassLoader::load('Boo_Html_Colgroup');
Boo_ClassLoader::load('Boo_Html_Dd');
Boo_ClassLoader::load('Boo_Html_Del');
Boo_ClassLoader::load('Boo_Html_Dfn');
Boo_ClassLoader::load('Boo_Html_Div');
Boo_ClassLoader::load('Boo_Html_Dl');
Boo_ClassLoader::load('Boo_Html_Dt');
Boo_ClassLoader::load('Boo_Html_Em');
Boo_ClassLoader::load('Boo_Html_Empty'); // not a real xhtml element
Boo_ClassLoader::load('Boo_Html_Fieldset');
Boo_ClassLoader::load('Boo_Html_Form');
Boo_ClassLoader::load('Boo_Html_H1');
Boo_ClassLoader::load('Boo_Html_H2');
Boo_ClassLoader::load('Boo_Html_H3');
Boo_ClassLoader::load('Boo_Html_H4');
Boo_ClassLoader::load('Boo_Html_H5');
Boo_ClassLoader::load('Boo_Html_H6');
Boo_ClassLoader::load('Boo_Html_Head');
Boo_ClassLoader::load('Boo_Html_Hr');
Boo_ClassLoader::load('Boo_Html_Html');
Boo_ClassLoader::load('Boo_Html_I');
Boo_ClassLoader::load('Boo_Html_Img');
Boo_ClassLoader::load('Boo_Html_Input');
Boo_ClassLoader::load('Boo_Html_Ins');
Boo_ClassLoader::load('Boo_Html_Kbd');
Boo_ClassLoader::load('Boo_Html_Label');
Boo_ClassLoader::load('Boo_Html_Legend');
Boo_ClassLoader::load('Boo_Html_Li');
Boo_ClassLoader::load('Boo_Html_Link');
Boo_ClassLoader::load('Boo_Html_List');
Boo_ClassLoader::load('Boo_Html_Map');
Boo_ClassLoader::load('Boo_Html_Meta');
Boo_ClassLoader::load('Boo_Html_Noscript');
Boo_ClassLoader::load('Boo_Html_Object');
Boo_ClassLoader::load('Boo_Html_Ol');
Boo_ClassLoader::load('Boo_Html_Optgroup');
Boo_ClassLoader::load('Boo_Html_Option');
Boo_ClassLoader::load('Boo_Html_P');
Boo_ClassLoader::load('Boo_Html_Param');
Boo_ClassLoader::load('Boo_Html_Pre');
Boo_ClassLoader::load('Boo_Html_Q');
Boo_ClassLoader::load('Boo_Html_Samp');
Boo_ClassLoader::load('Boo_Html_Script');
Boo_ClassLoader::load('Boo_Html_Select');
Boo_ClassLoader::load('Boo_Html_Small');
Boo_ClassLoader::load('Boo_Html_Span');
Boo_ClassLoader::load('Boo_Html_Strong');
Boo_ClassLoader::load('Boo_Html_Style');
Boo_ClassLoader::load('Boo_Html_Sub');
Boo_ClassLoader::load('Boo_Html_Sup');
Boo_ClassLoader::load('Boo_Html_Table');
Boo_ClassLoader::load('Boo_Html_Tbody');
Boo_ClassLoader::load('Boo_Html_Td');
Boo_ClassLoader::load('Boo_Html_Textarea');
Boo_ClassLoader::load('Boo_Html_Tfoot');
Boo_ClassLoader::load('Boo_Html_Th');
Boo_ClassLoader::load('Boo_Html_Thead');
Boo_ClassLoader::load('Boo_Html_Title');
Boo_ClassLoader::load('Boo_Html_Tr');
Boo_ClassLoader::load('Boo_Html_Tt');
Boo_ClassLoader::load('Boo_Html_Ul');
Boo_ClassLoader::load('Boo_Html_Var');

class Boo_Html {
	/**
	 * @brief HTML classes.
	 */
	protected $classes = array();
	
	/**
	 * @brief HTML attributes.
	 */
	protected $attributes = array();
	
	/**
	 * @brief HTML element name.
	 */
	protected $element = null;
	
	/**
	 * @brief HTML element content.
	 */
	protected $content = array();
	
	/**
	 * @brief List of all supported HTML elements.
	 */
	protected static $supportedElements = array(
		'a', 'abbr', 'acronym', 'address', 'area', 'b', 'base', 'bdo', 'big', 'blockquote',
		'body', 'br', 'button', 'caption', 'cite', 'code', 'col', 'colgroup', 'dd', 'del',
		'dfn', 'div', 'dl', 'dt', 'em', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
		'head', 'hr', 'html', 'i', 'img', 'input', 'ins', 'kbd', 'label', 'legend', 'li',
		'link', 'map', 'meta', 'noscript', 'object', 'ol', 'optgroup', 'option', 'p', 'param',
		'pre', 'q', 'samp', 'script', 'select', 'small', 'span', 'strong', 'style', 'sub', 'sup',
		'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title', 'tr', 'tt', 'ul', 'var');
	
	/**
	 * @brief List of HTML elements that support the common attributes.
	 * 
	 * Common attributes are:
	 * \li class
	 * \li id
	 * \li style
	 * \li title
	 * \li dir
	 * \li xml:lang
	 * \li xml:space
	 * 
	 * @see http://www.w3.org/TR/xhtml-modularization/abstract_modules.html#s_common_collection
	 * @since 2.0.0
	 */
	protected static $standardElements = array(
		'a', 'abbr', 'acronym', 'address', 'area', 'b', 'big', 'blockquote',
		'body', 'button', 'caption', 'cite', 'code', 'col', 'colgroup', 'dd', 'del',
		'dfn', 'div', 'dl', 'dt', 'em', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
		'hr', 'i', 'img', 'input', 'ins', 'kbd', 'label', 'legend', 'li',
		'link', 'noscript', 'object', 'ol', 'optgroup', 'option', 'p',
		'pre', 'q', 'samp', 'select', 'small', 'span', 'strong', 'sub', 'sup',
		'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt', 'ul', 'var');
	
	/**
	 * @brief List of HTML elements that require the clearfix class.
	 * 
	 * @todo Finish list.
	 */
	protected static $clearfixElements = array('div', 'form', 'fieldset', 'ol', 'ul', 'li', 'table');
	
	/**
	 * @brief Static count of elements.
	 */
	protected static $count = 0;
	
	/**
	 * @brief Default constructor.
	 * @param string $element[optional] The HTML element to create.
	 * @return void.
	 */
	public function __construct($element = 'div') {
		$this->setElement($element);
		
		if (BOO_CLEARFIX && $this->isClearfixElement($element)) {
			$this->addClass('clearfix');
		}
		
		if ($this->isStandardElement($element)) {
			// common classes
			$this->addClass('php');
			$this->addClass('boo');
			
			self::$count++;
		}
	}
	
	/**
	 * @brief Sets the tag name.
	 * @param string $element The tag name. Set to FALSE for tagless.
	 * @param bool $force Force non standard element to be used. Usefull for writing non standard HTML (not that you should do that).
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * 
	 * @code
	 * $html->setElement('div');
	 * @endcode
	 */
	public function setElement($element, $force = false) {
		$element = trim(strtolower($element));
		
		if (self::isSupportedElement($element) || $force || ($element == false)) {
			$this->element = $element;
			return true;
		} else {
			trigger_error("Element {$element} is not supported", E_USER_WARNING);
			return false;
		}
	}
	
	/** 
	 * @brief Returns the element name.
	 * @return string The element name.
	 */
	public function getElement() { return $this->element; }
	
	/**
	 * @brief Determins if an element is valid.
	 * @return bool Returns TRUE if element is valid, FALSE otherwise.
	 * @param string $element The element to test.
	 */
	public static function isSupportedElement($element) {
		$element = trim(strtolower($element));
		return in_array($element, self::$supportedElements);
	}
	
	/**
	 * @brief Gets an array of all supported elements.
	 * @return array Array of all supported elements.
	 */
	public static function getSupportedElements() { return self::$supportedElements; }
	
	/**
	 * @brief Determines if an element should have the clearfix class.
	 * @since 2.0.0
	 * @param string $element The element to test.
	 * @return bool Returns TRUE if element should have the clearfix class, FALSE otherwise.
	 */
	public static function isClearfixElement($element) {
		$element = trim(strtolower($element));
		return in_array($element, self::$clearfixElements);
	}
	
	/**
	 * @brief Gets an array of all clearfix elements.
	 * @since 2.0.0
	 * @return array Array of all clearfix elements.
	 */
	public static function getClearfixElements() { return self::$clearfixElements; }
	
	/**
	 * @brief Determins if the element is a standard element.
	 * 
	 * @since 2.0.0
	 * @param string $element The element to test.
	 * @return bool Retunrs TRUE if element is a standard element, FALSE otherwise.
	 */
	public static function isStandardElement($element) {
		$element = trim(strtolower($element));
		return in_array($element, self::$standardElements);
	}
	
	/**
	 * @brief Gets an array of all standard elements.
	 * @since 2.0.0
	 * @return array Array of all standard elements.
	 */
	public static function getStandardElements() { return self::$standardElements; }
	
	/**
	 * @brief Sets the attributes.
	 * @param array $attrs The attributes .
	 * @return int Returns the number of attributes set, FALSE on failure.
	 */
	public function setAttrs(array $attrs) {
		// do not use array_merge it will allow unsafe values in
		$count = 0;
		if (!empty($attrs)) {
			$this->attributes = array(); // clear array
			foreach ($attrs as $key => $value) {
				if ($this->setAttr($key, $value)) {
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Attrs should not be empty', E_USER_NOTICE); }
			return false;
		}
		return $count;
	}
	
	/**
	 * @brief Adds attributes.
	 * @param array $attrs The attributes to add.
	 * @return int Returns the number of attributes added, FALSE on failure.
	 */
	public function addAttrs(array $attrs) {
		// do not use array_merge it will allow unsafe values in
		$count = 0;
		if (!empty($attrs)) {
			foreach ($attrs as $key => $value) {
				if ($this->setAttr($key, $value)) {
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Attributes should not be empty', E_USER_NOTICE); }
			return false;
		}
		return $count;
	}
	
	/**
	 * @brief Returns an array of attributes.
	 * @param string $attr The attributes name.
	 * @return array Returns the attributes.
	 */
	public function getAttrs() {return $this->attributes; }
	
	/**
	 * @brief Convenience funciton for applying attributes.
	 * 
	 * Will only apply attributes if array is not empty.
	 * 
	 * @return int Returns the number of attributes applied, FALSE on failure.
	 * @param array $attrs The attributes array.
	 */
	public function applyAttrs(array $attrs) {
		if (!empty($attrs)) {
			return $this->addAttrs($attrs);
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Sets the attribute.
	 * 
	 * @param string $attr The attributes name.
	 * @param string $value The attributes value.
	 * 
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 * 
	 * @code
	 * $html->setAttr('id', 'myid');
	 * @endcode
	 */
	public function setAttr($attr, $value) {
		$attr = strtolower(trim($attr));
		$value = trim($value);
		
		if (Boo_Validator::isNull($value)) {
			if (BOO_DEBUG) { trigger_error('Value was null, are you sure this is what you wanted', E_USER_NOTICE); }
		}
		
		if ($attr == 'class') {
			// special clase for class attribute
			return $this->setClass($value);
		} else {
			$this->attributes[$attr] = htmlentities($value);
			return true;
		}
	}
	
	/**
	 * @brief Returns the attributes value.
	 * @param string $attr The attributes name.
	 * @return string The attributes value if attribute is set, FALSE otherwise. 
	 */
	public function getAttr($attr) {
		if (array_key_exists($attr, $this->attributes)) {
			return $this->attributes[$attr];
		} elseif ($attr == 'class') {
			return implode(' ', $this->classes);
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Determins if element has an attribute.
	 * @param string $attr The attributes name.
	 * @return bool Returns TRUE if the attribute is set (even to null), FALSE otherwise.
	 */
	public function hasAttr($attr) {
		if (array_key_exists($attr, $this->attributes)) {
			return true;
		} elseif ($attr == 'class') {
			return !empty($this->classes);
			
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Removes attribute.
	 * @param string $attr The attributes name.
	 * @return bool Returns TRUE if successfull, FALSE otherwise. 
	 */
	public function removeAttr($attr) {
		$attr = strtolower(trim($attr));
		
		if (array_key_exists($attr, $this->attributes)) {
			unset($this->attributes[$attr]);
			return true;
		} elseif ($attr == 'class') {
			$this->classes = array();
			return true;
		} else {
			return false;
		}
		
	}
	
	/**
	 * @brief Removes array of attributes.
	 * @return int Returns the number of attributes removed, FALSE on failure.
	 * @param array $attrs The attributes to remove.
	 */
	public function removeAttrs(array $attrs) {
		$count = 0;
		if (!empty($attrs)) {
			foreach ($attrs as $key => $value) {
				if ($this->removeAttr($key)) {
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Attributes should not be empty', E_USER_NOTICE); }
			return false;
		}
		return $count;
	}
	
	/**
	 * @brief Clears all attributes.
	 * 
	 * @since 2.0.0
	 * @return bool Function always returns TRUE.
	 */
	public function clearAttrs() { 
		$this->attributes = array();
		return true;
	}
	
	/**
	 * @brief Sets the elements class.
	 * 
	 * Input may be a single name, space delimited string of names, or an array of names.
	 * 
	 * @param mixed $class The class(es) to set.
	 * @return bool Returns TRUE if class was set, FALSE otherwise.
	 * 
	 * @code
	 * $html->setClass('author name');
	 * @endcode
	 */
	public function setClass($class) {
		if (empty($class)) {
			// class is empty, nothing more to do
			return false;
		}
		
		// convert string to array
		if (is_string($class)) {
			// replace spaces with commas
			$str = str_replace(' ', ',', $class);
			$class = explode(',', $str);
		} elseif (is_array($class)) {
			break;
		} else {
			trigger_error('Class is not a string or array', E_USER_WARNING);
			return false;
		}
		
		// cleanup
		array_trim($class);
		$this->classes = $class;
		
		return true;
	}
	
	/**
	 * @brief Determins if element has a given class.
	 * 
	 * @param mixed $class The class name to compare.
	 * @return bool Returns TRUE if element has class, FALSE otherwise.
	 */
	public function hasClass($class) {
		$class = trim($class);
		if (in_array($class, $this->classes)) {
			// found
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Adds class(es) to element.
	 * @param string $class The class(es) to add.
	 * @return mixded If class(es) are added then the number of additions is returned, FALSE otherwise.
	 */
	public function addClass($class) {
		if (is_string($class)) {
			$str = str_replace(' ', ',', $class);
			$class = explode(',', $str);
			
			if (count($class) == 1) {
				// single class
				$class = trim($class[0]);
				if (in_array($class, $this->classes)) {
					// already in array
					return false;
				} else {
					// add to array
					$this->classes[] = $class;
					return 1;
				}
			} else {
				// more than one class
				return $this->addClasses($class);
			}
		} elseif (is_array($class)) {
			return $this->addClasses($class);
		} else {
			trigger_error('Class must be a string or array', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Add classes to element.
	 * @return int Returns the number of classes added, FALSE on failure.
	 * @param array $classes The classes to add.
	 */
	public function addClasses(array $classes) {
		$count = 0;
		if (!empty($classes)) {
			foreach ($classes as $class) {
				if($this->addClass($class)){
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Classes should not be empty', E_USER_NOTICE); }
			return false;
		}
		
		return $count;
	}
	
	/**
	 * @brief Removes class(es) from element.
	 * @param mixed $class The class(es) to remove.
	 * @return mixed If class(es) are found then the number removed is returned, FALSE otherwise.
	 */
	public function removeClass($class) {
		if (is_string($class)) {
			$str = str_replace(' ', ',', $class);
			$class = explode(',', $str);
			
			if (count($class) == 1) {
				// single class
				$class = trim($class[0]);
				$key = array_search($class, $this->classes);
				if ($key !== false) {
					// found in array
					unset($this->classes[$key]);
					return 1;
				} else {
					// not found
					return false;
				}
			} else {
				// more than one class
				return $this->addClasses($class);
			}
		} elseif (is_array($class)) {
			return $this->removeClasses($class);
		} else {
			trigger_error('Class must be a string or array', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Removes classes from element.
	 * @return int Returns the number of classes removed, FALSE on failure.
	 * @param array $classes The classes to be removed.
	 */
	public function removeClasses(array $classes) {
		$count = 0;
		if (!empty($classes)) {
			foreach ($classes as $class) {
				if ($this->removeClass($class)) {
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Classes should not be empty', E_USER_NOTICE); }
			return false;
		}
		return $count;
	}
	
		
	/**
	 * @brief Toggles class(es) for element.
	 * @param string $class The class(es) name.
	 * @return int Returns the number of classes toggled, FALSE otherwise.
	 */
	public function toggleClass($class) {
		
		if (is_string($class)) {
			$str = str_replace(' ', ',', $class);
			$class = explode(',', $str);
			
			if (count($class) == 1) {
				// single class
				$class = trim($class[0]);
				if ($this->hasClass($class)) {
					return (int) $this->removeClass($class);
				} else {
					return (int) $this->addClass($class);
				}
			} else {
				// more than one class
				return $this->toggleClasses($class);
			}
		} elseif (is_array($class)) {
			return $this->toggleClasses($class);
		} else {
			trigger_error('Class must be a string or array', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * @brief Toggles classes for element.
	 * @return int Returns number of classes toggled, FALSE on failure
	 * @param array $classes Array of classes to toggle.
	 */
	public function toggleClasse(array $classes) {
		$count = 0;
		if (!empty($classes)) {
			foreach ($classes as $class) {
				if ($this->toggleClass($class)) {
					$count++;
				}
			}
		} else {
			if (BOO_DEBUG) { trigger_error('Classes should not be empty', E_USER_NOTICE); }
			return false;
		}	
		return $count;
	}
	
	/**
	 * @brief Clears all classes.
	 * 
	 * @since 2.0.0
	 * @return bool Function always returns TRUE.
	 */
	public function clearClasses() { 
		$this->classes = array();
		return true;
	}
	
	/**
	 * @brief Clears everything but the element.
	 * 
	 * @since 2.0.0
	 * @return bool FUnction always returns TRUE.
	 */
	public function clearAll() {
		$this->clearAttrs();
		$this->clearClasses();
		$this->clearContent();
		return true;
	}
	
	/**
	 * @brief Sets the elements content.
	 * @param string $content The content.
	 * @param bool $cleanup[optional] Cleanup content.
	 * @return bool Function always returns TRUE.
	 * 
	 * @code
	 * $html->setContent("This is my first div.");
	 * @endcode
	 */
	public function setContent($content, $cleanup = true) {
		if ($cleanup) {
			$contnet = trim($content);
		}
		$this->clearContent();
		$this->content[] = $content;
		return true;
	}
	
	/**
	 * @brief Appends content to the elements existing content.
	 * @param string $content The content.
	 * @param bool $cleanup[optional] Cleanup content.
	 * @return bool Function always returns TRUE.
	 */
	public function appendContent($content, $cleanup = true) {
		if ($cleanup) {
			$contnet = trim($content);
		}
		$this->content[] = $content;
		return true;
	}
	
	/**
	 * @brief Prepend content to the elements existing content.
	 * @param string $content The content.
	 * @param bool $cleanup[optional] Cleanup content.
	 * @return bool Function always returns TRUE.
	 */
	public function prependContent($content, $cleanup = true) {
		if ($cleanup) {
			$contnet = trim($content);
		}
		array_unshift($this->content, $content);
		return true;
	}
	
	/** 
	 * @brief Returns content.
	 * @return array Content of the element.
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @brief Clears content.
	 * @return bool Function always returns TRUE.
	 */
	public function clearContent() {
		$this->content = array();
		return true;
	}
	
	/** 
	 * @brief Returns inner HTML.
	 * @return string The inner HTML from the element.
	 */
	public function htmlInner() {
		$tmp = '';
		foreach ($this->content as $key => $value) {
			if ($value instanceof Boo_Html || ($value instanceof Html && BOO_CLASS)) {
				$tmp .= $value->html();
			} else {
				$tmp .= (string) $value; // type cast just to be sure
			}
		}
		return $tmp;
	}
	/** 
	 * @brief Returns HTML.
	 * @return string HTML for the element.
	 * @param array $attrs[optional] Array of attributes.
	 * 
	 * @code
	 * <div id="myid" class="auther name">This is my first div.</div>
	 * @endcode
	 */
	public function html(array $attrs = array()) {
		$this->applyAttrs($attrs);
		return $this->htmlOpen() . $this->htmlInner() . $this->htmlClose();
	}
	
	/** 
	 * @brief Returns opening HTML tag.
	 * @return string Opening HTML tag for the element.
	 * 
	 * @code
	 * <div id="myid" class="auther name">
	 * @endcode
	 */
	public function htmlOpen() {
		$tmp = '';
		if ($this->isTagless()) {
			return $tmp;
		}
		
		$tmp .= "<{$this->element}";
		
		if (!empty($this->classes)) {
			$tmp .= ' class="' . implode(' ', $this->classes) . '"';
		}
		
		foreach($this->attributes as $key => $value) {
			$tmp .= " {$key}=\"{$value}\"";
		}
		
		$tmp .= '>';
		return $tmp;
	}
	
	/** 
	 * @brief Returns closing HTML tag.
	 * @return string Closing HTML tag for the element.
	 * 
	 * @code
	 * </div>
	 * @endcode
	 */
	public function htmlClose() {
		$tmp = '';
		if ($this->isTagless()) {
			return $tmp;
		}
		
		$tmp .= "</{$this->element}>";
		return $tmp;
	}
	
	/**
	 * @brief Determins if element has a tag.
	 * @return bool Returns TRUE if element has a tag, FALSE otherwise (contains other tags, or is just test).
	 */
	public function isTagless() {
		return !$this->element;
	}
	
	/**
	 * @brief Determins if the object is valid.
	 * 
	 * This feature is not yet implemented! Added for future API compatibility.
	 * 
	 * @return bool Returns TRUE if object is valid, FALSE otherwise.
	 * 
	 * @todo Finish function and decide what is required for validity.
	 */
	public function isValid() {
		return true;
	}
	
	/**
	 * @brief Determins if content is empty.
	 * 
	 * @since 2.0.0
	 * @return bool Returns TRUE if content is empty, FALSE otherwise.
	 */
	public function isEmpty() { return empty($this->content); }
	
	
	/**
	 * @brief Converts object to string.
	 * @see Boo_Page::html()
	 * @since 2.0.0
	 * @return string Returns HTML for object.
	 */
	public function __toString() { return $this->html(); }
}
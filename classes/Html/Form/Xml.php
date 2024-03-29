<?php
/* SVN FILE: $Id: Xml.php 237 2009-05-25 05:47:45Z david@ramaboo.com $ */
/**
 * @brief XML HTML form class.
 * 
 * This class is used to generate HTML forms from an XML file.
 * 
 * @class		Boo_Html_Form_Xml
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.5
 */

class Boo_Html_Form_Xml extends Boo_Html_Form {
	
	/**
	 * @brief The validation method.
	 * @see Boo_Html_Form::setValidationMethod() for possible methods.
	 */
	protected $validationMethod = 'xml';
	
	/**
	 * @brief Boo_Html_Ol object for validation errors.
	 */
	protected $errors;
	
	/**
	 * @brief Boo_Io object for form.
	 */
	public $io;
	
	/**
	 * @brief SimpleXMLElement object representing the form.
	 */
	protected $xmlForm = false;
	
	/**
	 * @brief XML filename.
	 */
	protected $filename = false;
	
	/**
	 * @brief Default constructor.
	 * @param string $id[optional] Form ID to open.
	 * @return void.
	 */
	public function __construct($id = false) {
		$this->errors = new Boo_Html_Ol;
		$this->io = new Boo_Io;
		
		if ($id !== false) {
			$this->open($id);
		}
		
		parent::__construct();
	}
	
	/**
	 * @brief Sets the validation method.
	 * 
	 * Possible methods are:
	 * \li xml
	 * 
	 * @param string $method The validation method.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @todo Add more validation methods.
	 */
	public function setValidationMethod($method) {
		$method = strtolower(trim($method));
		
		switch ($method) {
			case 'xml':
				$this->validationMethod = $method;
				break;
			default:
				trigger_error("Validation method {$method} is not valid", E_USER_WARNING);
				return false;
		}
		return true;
		
	}
	
	/**
	 * @brief Gets the validation method.
	 * @return string The validation method.
	 */
	public function getValidationMethod() { return $this->validationMethod; }
	
	/**
	 * @brief Open form with an ID.
	 * 
	 * This funciton provides API compatiblity. The same result can be achieved using Boo_Html_Form::loadXmlForm().
	 * 
	 * @param string $id The form ID.
	 * @param string $filename The filename to open.
	 * @return bool Returns TRUE on success, FALSE on failure.
	 */
	public function open($id, $filename = false) {
		$this->setAttr('id', $id);
		return $this->loadXmlForm($filename, true);
	}
	
	/**
	 * @brief Sets the filename for the XML file.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @param string $filename The filename to set.
	 */
	public function setFilename($filename) {
		$filename = trim($filename);
		if (file_exists($filename)) {
			if (is_readable($filename)) {
				$this->filename = $filename;
				return true;
			} else {
				trigger_error("XML file {$filename} is not readable", E_USER_ERROR);
				return false;
			}
		} else {
			trigger_error("XML file {$filename} does not exist", E_USER_ERROR);
			return false;
		}
		
		return true;
	}
	
	/**
	 * @brief Returns the filename.
	 * @return string The filename.
	 */
	public function getFilename() { return $this->filename; }
	
	/**
	 * @brief Loads form from XML file.
	 * 
	 * @param string $filename[optional] The XML filename.
	 * @param bool $force[optional] Force load even if form is already loaded.
	 * @return bool Returns TRUE if successful, FALSE otherwise.
	 */
	public function loadXmlForm($filename = false, $force = false) {
		
		if ($this->xmlForm) {
			// form is already loaded
			if ($force === false) {
				// not forced
				return true;
			}
		}
		
		if ($filename === false) {
			if ($this->filename === false) {
				// set default
				$this->setFilename(BOO_XML_DIR . '/' . Boo_Helper::toFilenameCase($this->getAttr('id')) . '.xml');
			}
		} else {
			$this->setFilename($filename);
		}
		
		// check if xml file exists
		if (file_exists($this->filename)) {
			if (!is_readable($this->filename)) {
				trigger_error("XML file {$this->filename} is not readable", E_USER_ERROR);
				return false;
			}
			
			$xml = simplexml_load_file($this->filename);
			if ($xml === false) {
				trigger_error("XML file {$this->filename} could not be loaded", E_USER_ERROR);
				return false;
			}
		} else {
			trigger_error("XML file {$this->filename} does not exist", E_USER_ERROR);
			return false;
		}
		
		$count = 0;
		foreach ($xml->form as $form) {
			$xmlId = (string) $form['id'];
			
			$formId = $this->getAttr('id');
			
			if ($xmlId == $formId) {
				$this->xmlForm = $form;
				$count++;
				// do not break so that count can be verified
			}
		}
		
		if ($count == 0) {
			trigger_error("XML form ID {$formId} could not be found in file {$this->filename}", E_USER_ERROR);
			return false;
		} elseif ($count == 1) {
			// perfect, now set attributes
			foreach ($this->xmlForm->attributes() as $key => $value) {
				switch ($key) {
					case 'id':
						// do nothing, at this point id will already be set
						break;
					case 'tableName':
						$this->io->setTableName($value);
						break;
					case 'primaryKey':
						$this->io->setPrimaryKey($value);
						break;
						
					default:
						$this->setAttr($key, $value);
						break;
				}
			}
			return true;
			
		} else {
			// multiple forms found
			trigger_error("Multiple XML forms with ID {$formId} were found, this is not good", E_USER_ERROR);
			return false;
		}
	}
	
	/**
	 * @brief Sets the errors object.
	 * 
	 * @param Boo_Html_Ol $errors The errors object.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function setErrors(Boo_Html_Ol $errors) {
		if (!$errors->isValid()) {
			trigger_error('Errors object is not valid', E_USER_ERROR);
			return false;
		} else {
			// valid
			$this->errors = $errors;
			return true;
		}
	}
	
	/**
	 * @brief Gets the errors.
	 * 
	 * @return Boo_Html_Ol Error list as an HTML object.
	 */
	public function getErrors() { return $this->errors; }
	
	
	/**
	 * @brief Gets errors as simple array.
	 * @return array Errors in an array.
	 * @todo This could be more efficent and it removes lots of other usefull info like classes.
	 */
	public function getErrorsArray() {
		$lis = $this->errors->getLis();
		$errors = array();
		foreach ($lis as $key => $value) {
			$errors[] = $value->getContent();
		}
		
		return $errors;
	}
	
	
	/**
	 * @brief Validates a form.
	 * 
	 * @return bool Returns TRUE if valid, FALSE otherwise.
	 */
	public function validate() {
		switch ($this->validationMethod) {
			case 'xml':
				return $this->validateXml();
				break;
			default:
				trigger_error("Validation method {$this->validationMethod} is not valid", E_USER_ERROR);
				return false;
		}
	}
	
	/**
	 * @brief Determins if the form is valid.
	 * @return bool Returns TRUE if form is valid, FALSE otherwise.
	 */
	public function isValid() { return $this->validate(); }
	
	/**
	 * @brief Preloads values into \c $_POST.
	 * 
	 * @param Boo_IO $io The Boo_Io object to use data.
	 * @param bool $override[optional] Override existing values.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function preloadPost(Boo_IO $io, $override = true) {
		switch ($this->validationMethod) {
			case 'xml':
				return $this->preloadPostXml($io, $override);
				break;
			default:
				trigger_error("Validation method {$this->validationMethod} is not valid", E_USER_ERROR);
				return false;
		}
	}
	
	/**
	 * @brief Preloads values from XML file into \c $_POST.
	 * 
	 * @param Boo_IO $io The Boo_IO object to use data.
	 * @param bool $override Override existing values.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	protected function preloadPostXml(Boo_IO $io, $override) {
		$this->loadXmlForm();
		
		foreach ($this->xmlForm->children() as $child) {
			$this->handlePreloadPostXml($child, $io, $override);
			
		}
		
		return true;
	}
	
	/**
	 * @brief Handles preloading values from XML file into \a $_POST.
	 * 
	 * This function is recursive.
	 * 
	 * @param SimpleXMLElement $child The current child element.
	 * @param Boo_IO $io The Boo_IO object to use data.
	 * @param bool $override Override existing values.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	protected function handlePreloadPostXml(SimpleXMLElement $child, Boo_IO $io, $override) {
		$controlType = $child->getName(); // text, checkbox, etc...
		
		if ($this->isFormControl($controlType)) {
			$name = (string) $child['name'];
			$field = (string) $child['io'];
			if ($field) {
				
				if ($override) {
					$_POST[$name] = $io->get($field);
				} else {
					if (array_key_exists($name, $_POST)) {
						// value already exists, skip
					} else {
						$_POST[$name] = $io->get($field);
					}
				}
			}
			
			return true;
		}
		
		foreach ($child->children() as $recursiveChild) {
			$this->handlePreloadPostXML($recursiveChild, $io, $override);
		}
		
		return true;
	}
	
	/**
	 * @brief Validates a form using the XML validation method.
	 * 
	 * @param string $id[optional] Form ID.
	 * @return bool Returns TRUE if valid, FALSE otherwise.
	 */
	protected function validateXml() {
		$this->loadXmlForm();
		
		$totalValid = true;
		foreach ($this->xmlForm->children() as $child) {
			$this->handleValidateXml($child, $totalValid);
		}
		
		return $totalValid;
	}
	
	/**
	 * 
	 * Used recursivly by Boo_Html_Form_Xml::validateXml().
	 * @return bool Returns TRUE on success, FALSE on error.
	 * @param SimpleXMLElement $child Simple XML child element.
	 * @param bool $totalValid Keeps track of the validity of the entire form.
	 */
	protected function handleValidateXml(SimpleXMLElement $child, &$totalValid) {
		$controlType = $child->getName(); // text, checkbox, etc...
			
		if ($this->isFormControl($controlType)) {
			$name = (string) $child['name'];
			foreach ($child->error as $childError) {
				$validation =  (string) $childError['validation'];
				
				switch ($controlType) {
					case 'file':
					// sepcial case, this will probebly only work with Boo_Validator::isUploaded()
					$value = $name;
					break;
					
					case 'select':
						$value = _post($name);
						//echo "MOO";
						
						
						// ***************************************************************************
						// select validation code here
						
					default:
					// normal control
					$value = _post($name);
				}
				
				$required = (string) $childError['required'];
				
				if ($required) {
					$required = word_bool($required);
				} else {
					$required = false;
				}
				
				$bv = new Boo_Validator;
				$valid = $bv->validate($value, $validation, $required);
				
				if ($valid) {
					// valid do nothing
					
				} else {
					// not valid, add error
					$li = new Boo_Html_Li;
					$li->setContent((string) $childError);
					$this->errors->addLi($li);
				}
				
				// track valid though the loop
				$totalValid = $totalValid && $valid;
			}
			
			return $totalValid;
		}
		
		
		foreach ($child->children() as $recursiveChild) {
			$this->handleValidateXml($recursiveChild, $totalValid);
		}
		
		return true;
	}
	
	/**
	 * @brief Returns a list of attributes added to the element
	 *
	 * @param SimpleXMLElement $child The child.
	 * @return array The array of attributes, attributes used by the system are not returned.
	 */
	private function getFormContorlChildAttrs(SimpleXMLElement $child) {
		$results = array();
		foreach ($child->attributes() as $key=>$value) {
			
			switch ((string) $key) {
				// safe list, these values are used by the system so do not add them as attributes
				case 'class':
				case 'io':
				case 'format':
					// do nothing;
					break;
				default:
					// value is not on the safe list so add it
					$results[(string) $key] = (string) $value;
			}
		}
		return $results;
	}
	
	
	
	/**
	 * @brief Determins if a child is a form control.
	 * 
	 * @param string $childName The child name
	 * @return bool Returns TRUE if child is a form control, FALSE otherwise.
	 */
	protected function isFormControl($childName) {
		switch ($childName) {
			case 'button':
			case 'checkbox':
			case 'file':
			case 'hidden':
			case 'image':
			case 'password':
			case 'radio':
			case 'reset':
			case 'submit':
			case 'text':
			case 'select':
			case 'textarea':
				return true;
				break;
			default:
				return false;
		}
	}
	
	/**
	 * @brief Determins if a child is a HTML form control.
	 * 
	 * @param string $childName The child name
	 * @return bool Returns TRUE if child is a HTML form control, FALSE otherwise.
	 */
	protected function isFormControlHtml($childName) {
		return $childName == 'html';
	}
	
	/**
	 * @brief Determins if a child is a PHP form control.
	 * 
	 * @param string $childName The child name
	 * @return bool Returns TRUE if child is a PHP form control, FALSE otherwise.
	 */
	protected function isFormControlPhp($childName) {
		return $childName == 'php';
	}
	
	/**
	 * @brief Makes the IO object so you can use it.
	 * 
	 * Must be called before saving the IO object.
	 * 
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 */
	public function makeIo() {
		$this->loadXmlForm();
		
		foreach ($this->xmlForm->children() as $child) {
			$this->handleMakeIo($child);
		}
		
		return true;
	}
	
	/**
	 * @brief Gets the Boo_Io object;
	 * 
	 * Added for API compatibility. Boo_Html_Form_Xml::$io is public so this is 
	 * technically not needed.
	 * 
	 * @return Boo_Io Returns the Boo_Io object.
	 */
	public function getIo() {
		if ($this->io->isEmpty()) {
			// empty so make it
			$this->makeIo();
		}
		return $this->io;
	}
	
	/**
	 * @brief Handles making the IO object.
	 * 
	 * Used recursivly by Boo_Html_Form_Xml::makeIo().
	 * 
	 * @return bool Returns TRUE if form is valid, FALSE otherwise.
	 * @param SimpleXMLElement $child The Simple XML child element.
	 */
	protected function handleMakeIo(SimpleXMLElement $child) {
		
		if (!$this->isValid()) {
			trigger_error('Form is not valid, can not continue', E_USER_ERROR);
			return false;
		}
		
		$controlType = $child->getName(); // text, checkbox, etc...
		
		if ($this->isFormControl($controlType)) {
		
			$io = (string) $child['io'];
			$value = (string) $child['value'];
			$format = (string) $child['format'];
			if ($io) {
				// check name
				$name = (string) $child['name'];
				if (!$name) {
					trigger_error("XML form control type {$controlType} is missing the required name attribute", E_USER_ERROR);
					return false;
				}
				
				if (array_key_exists($name, $_POST)) {
					$setValue = $_POST[$name];
					
					if ($format) {
						$setValue = Boo_Format::format($setValue, $format);
					}
					
					$this->io->set($io, $setValue);
				} else {
					// this helps with checkboxes
					if (BOO_DEBUG) { trigger_error("Failed to find key {$name} in \$_POST, setting to FALSE", E_USER_NOTICE); }
					$this->io->set($io, false);
					
				}
				
			}
			
			return true;
		}
		
		foreach ($child->children() as $recursiveChild) {
			$this->handleMakeIo($recursiveChild);
		}
		
		return true;
	}
	
	/**
	 * @brief Adds from contorls to existing Boo_Html item.
	 * 
	 * @param SimpleXMLElement $child The XML child element.
	 * @return string Returns HTML on success, FALSE otherwise.
	 */
	private function handleFormControlChild(SimpleXMLElement $child) {
			$tmpHtml = false;
			$controlType = $child->getName(); // text, checkbox, etc...
			
			// check id
			$id = (string) $child['id'];
			if (!$id) {
				trigger_error("XML form control {$controlType} is missing the required id attribute", E_USER_ERROR);
				return false;
			}
			
			// check name
			$name= (string) $child['name'];
			if (!$name) {
				trigger_error("XML from control {$controlType} is missing the required name attribute", E_USER_ERROR);
				return false;
			}
			
			// label
			if ($child->label) {
				$label = new Boo_Html_Label;
				$label->setAttr('for', $id);
				$label->setContent((string) $child->label);
			} else {
				$label = new Boo_Html_Empty;
			}
			
			switch ($controlType) {
				case 'button':
					$input = new Boo_Html_Input_Button;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'checkbox':
					$input = new Boo_Html_Input_Checkbox;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					// wrap label around input
					$tmpHtml .= $label->htmlOpen();
					$tmpHtml .= $input->html() . $label->htmlInner() . $label->htmlClose();
					break;
					
				case 'file':
					$input = new Boo_Html_Input_File;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'hidden':
					$input = new Boo_Html_Input_Hidden;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'image':
					$input = new Boo_Html_Input_Image;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'password':
					$input = new Boo_Html_Input_Password;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'radio':
					$input = new Boo_Html_Input_Radio;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					// wrap label around input
					$tmpHtml .= $label->htmlOpen();
					$tmpHtml .= $input->html() . $label->htmlInner() . $label->htmlClose();
					break;
					
				case 'reset':
					$input = new Boo_Html_Input_Reset;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					
					break;
					
				case 'submit':
					$input = new Boo_Html_Input_Submit;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'text':
					$input = new Boo_Html_Input_Text;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'select':
					$input = new Boo_Html_Select;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$data = array();
					
					foreach ($child->data->children() as $option) {
						$key = (string) $option['value'];
						$value = (string) $option;
						
						$selected = (string) $option['selected'];
						if ($selected) {
							$input->addDefault($key);
						}
						
						$data[$key] = $value;
					}
					
					$dataSource = trim ((string) $child->data['source']);
					
					if ($dataSource) {
						// add ending semicolon if needed
						if (substr($dataSource, -1) != ';') {
							$dataSource .= ';';
						}
						
						$result = eval("return {$dataSource}");
						
						// $data = array_merge($result, $data); !!! this will not work
						// turns associative arrays with numeric keys into numerically indexed array
						
						/** @todo Write a better array merge function. */
						$data = $result + $data;
					}
					
					$input->setData($data);
					
					$title = (string) $child->data['title'];
					if (!Boo_Validator::isNull($title)) { $input->setTitle($title); }
					
					$default = (string) $child->data['default'];
					if (!Boo_Validator::isNull($default)) { $input->setDefault($default); }
					
					$selected = (string) $child->data['selected'];
					if (!Boo_Validator::isNull($selected)) { $input->setSelected($selected); }
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					break;
					
				case 'textarea':
					$input = new Boo_Html_Textarea;
					
					$input->setClass((string) $child['class']);
					$input->addAttrs($this->getFormContorlChildAttrs($child));
					
					$tmpHtml .= $label->html();
					$tmpHtml .= $input->html();
					
					break;
					
				default:
					trigger_error("XML form control {$controlType} is not valid", E_USER_ERROR);
					return false;
			}
			
			return $tmpHtml;
	}
	
	/**
	 * @brief Handles a form child.
	 * 
	 * @param SimpleXMLElement $child The form child.
	 * @return bool Returns TRUE on success, FALSE otherwise. Function is recursive.
	 */
	protected function handleFormChild(SimpleXMLElement $child) {
		$name = $child->getName();
		// form control
		if ($this->isFormControl($name)) {
			$this->appendContent($this->handleFormControlChild($child));
			return true;
		}
		
		// special html control, no attributes
		if ($this->isFormControlHtml($name)) {
			$attributes = $child->attributes();
			if (!empty($attributes)) {
				trigger_error("Form child {$name} can not have attributes", E_USER_WARNING);
				return false;
			}
			
			$this->appendContent((string) $child);
			return true;
		}
		
		// special php control, no attributes
		if ($this->isFormControlPhp($name)) {
			$attributes = $child->attributes();
			if (!empty($attributes)) {
				trigger_error("Form child {$name} can not have attributes", E_USER_WARNING);
				return false;
			}
			
			$this->appendContent(eval((string) $child));
			return true;
		}
		
		// normal html control
		$tmp = new Boo_Html($name);
		
		// set attributes
		$attrs = array();
		foreach ($child->attributes() as $key=>$value) {
			$attrs[(string) $key] = (string) $value;
			
		}
		if (!empty($attrs)) {
			$tmp->addAttrs($attrs);
		}
		
		$this->appendContent($tmp->htmlOpen());
		
		// add content if it exists
		$this->appendContent(trim((string) $child)); // trim removes extra whitespace from xml file
		
		foreach ($child->children() as $recursiveChild) {
			$this->handleFormChild($recursiveChild);
		}
		
		$this->appendContent($tmp->htmlClose());
		return true;
	}
	
	/**
	 * @brief Determins if form is posted.
	 */
	public function isPostback() {
		if (isset($_POST['_form'])) {
			return $_POST['_form'] == $this->getAttr('id');
		} else {
			return false;
		}
	}
	
	/**
	 * @brief Unsets the \c $_POST array.
	 * @return bool Function always returns TRUE.
	 */
	public function clearPost() {
		$_POST = array();
		return true;
	}
	
	/**
	 * @brief Returns the HTML for the form.
	 * 
	 * @param array $attrs[optional] Array of attributes.
	 * @return string The HTML for the form, FALSE on error.
	 */
	public function html(array $attrs = array()) {
		
		$this->loadXmlForm();
		
		$formName = new Boo_Html_Input_Hidden;
		$formName->setAttr('name', '_form');
		$formName->setAttr('value', $this->getAttr('id'));
		
		$fieldset = new Boo_Html_Fieldset;
		$fieldset->addClass('system');
		$fieldset->appendContent($formName);
		
		foreach ($this->xmlForm->children() as $child) {
			$this->handleFormChild($child);
		}
		$this->appendContent($fieldset);
		return parent::html($attrs);
	}
}
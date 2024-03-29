<?php
/* SVN FILE: $Id: Csv.php 220 2009-03-30 14:59:19Z david@ramaboo.com $ */
/**
 * @brief Comma separated values class.
 * 
 * A generic class for dealing with comma separated value data.
 * 
 * @class		Boo_Csv
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version 	1.8.0
 * @todo		Debug class.
 */

class Boo_Csv {
	
	protected $csv = false;
	protected $rows = array();
	
	/**
	 * @brief Default constructor.
	 * @return void.
	 */
	public function __construct() {}
	
	public static function getFields($text) {
		if (Boo_Validator::isNull($text)) {
			trigger_error("Text cannot be null", E_USER_WARNING);
			return false;
		}
		$fields = array(); $inString = false; $tmp = '';
		
		$j = strlen($text);
		for ($k = 0; $k < $j; $k++) {
			$char = substr($text, $k, 1);
			
			switch ($char) {
				
				case ',':
					if (!$inString) {
						// add item to fields
						$fields[] = $tmp;
						// clear temp
						$tmp = '';
					} else {
						// add comma
						$tmp .= $char;
					}
					break;
				 
				case '"':
					if ($inString) {
						$nextChar = substr($text, $k + 1, 1);
						
						if ($nextChar == '"') {
							// add quote
							$tmp .= '"';
						}
						
						$inString = false;
					} else {
						$inString = true;
					}
					break;
					
				default:
					$tmp .= $char;
			}
		}
		// last one
		$fields[] = $tmp;
		
		// trim fields
		array_trim($fields);
		return $fields;
	}
	
	public function getRows() { return $this->rows; }
	
	public function getRow($index) {
		if (array_key_exists($index, $this->rows)) {
			return $this->rows[$index];
		} else {
			return false;
		}
	}
	
	public function isEmpty() { return empty($this->rows); }
	
	public function getCsv() { return $this->csv; }
	
	public function load($csv) {
		if ($csv == '') {
			trigger_error('CSV cannot be null', E_USER_WARNING);
			return false;
		}
		
		$rows = explode("\n", $csv);
		// remove last row if needed
		if (isset($rows[count($rows) - 1]) && empty($rows[count($rows) - 1])) {
			array_pop($rows);
		}
		
		foreach ($rows as $key=>$value) {
			$rows[$key] = self::getFields($value);
		}
		
		$this->csv = $csv;
		$this->rows = $rows;
		return true;
	}
	
	public function exportRows($rows, $fieldNames = true) {
		if (count($rows) == 0) {
			trigger_error('Row count cannot be zero', E_USER_WARNING);
			return false;
		}
		$csv = '';
		if ($fieldNames) {
			// make the first line filed names
			// grab them from the first row
			$csv .= $this->exportFieldsKey($rows[0]). "\n";
		}
		
		foreach ($rows as $fields) {
			$csv .= $this->exportFields($fields) . "\n";
		}
		
		return $csv;
	}
	
	public function htmlTable($rows, $attrs = array()) {
		if (count($rows) == 0) {
			trigger_error('Row count cannot be zero', E_USER_WARNING);
			return false;
		}
		
		$tmp = "<thead>\n<tr>\n";
		foreach ($rows[0] as $key => $value){
			$tmp .= "<th>{$key}</th>\n";
			
		}
		$tmp .= "</tr>\n</thead>\n<tbody>\n";
		foreach ($rows as $fields) {
			$tmp .= "<tr>\n";
			foreach ($fields as $key => $value) {
				$tmp .= "<td>{$value}</td>\n";
			}
			$tmp .= "</tr>\n";
		}
		
		$tmp .= "</tbody>\n";
		
		$table = new Boo_Html_Table;
		$table->applyAttrs($attrs);
		$table->setContent($tmp);
		return $table;
	}
	
	public function exportFields($fields) {
		$csv = '';
		foreach ($fields as $key => $value) {
				$value = str_replace('"', '""', $value); // escape quotes
				$csv .= "\"{$value}\",";
			}
			// trim last comma
			$csv = Boo_CSV::fixLastComma($csv);
			
		return $csv;
	}
	
	public function exportFieldsKey($fields) {
		$csv = '';
		foreach ($fields as $key => $value) {
				$csv .= "\"{$key}\",";
			}
			// trim last comma
			$csv = Boo_CSV::fixLastComma($csv);
			
		return $csv;
	}
	
	/**
	 * @brief Open a file.
	 * @return bool Returns TRUE on success, FALSE otherwise.
	 * @param string $filename The filename.
	 * @todo Implement function.
	 */
	public function open($filename) {
		
	}
	
	/**
	 * @brief Strips last comma from a string.
	 * 
	 * @param string $string The string to fix.
	 * @return string The string without the last comma if present.
	 */
	public static function fixLastComma($string) {
		$string = rtrim($string, ', ');
		return $string;
	}
}

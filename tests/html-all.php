<?php
/* SVN FILE: $Id: html-all.php 236 2009-05-23 21:40:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Html object.
 * 
 * Displays one of each HTML element.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_Html
 */

require_once 'config/default.php';

safe_tests();

include 'includes/header-simple.php';
?>
<div id="main" class="clearfix">
	<h1>Standard Elements</h1>	
	<?php
		$elements = Boo_Html::getStandardElements();
		
		foreach ($elements as $key => $value) {
			$className = 'Boo_Html_' . ucfirst($value);
			echo "<h2>{$className}</h2>\n";
			
			$tmp = new $className;
			$tmp->setAttr('name', $value);
			$tmp->setAttr('id', $value);
			$text = htmlspecialchars($tmp->html());
			echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
		}
	?>
	
	<h1>Input Elements</h1>
	<h2>Boo_Html_Input_Button</h2>
	<?php
		$input = new Boo_Html_Input_Button;
		$input->setAttr('name', 'button');
		$input->setAttr('id', 'button');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Checkbox</h2>
	<?php
		$input = new Boo_Html_Input_Checkbox;
		$input->setAttr('name', 'checkbox');
		$input->setAttr('id', 'checkbox');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_File</h2>
	<?php
		$input = new Boo_Html_Input_File;
		$input->setAttr('name', 'file');
		$input->setAttr('id', 'file');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Hidden</h2>
	<?php
		$input = new Boo_Html_Input_Hidden;
		$input->setAttr('name', 'hidden');
		$input->setAttr('id', 'hidden');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Image</h2>
	<?php
		$input = new Boo_Html_Input_Image;
		$input->setAttr('name', 'image');
		$input->setAttr('id', 'image');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Password</h2>
	<?php
		$input = new Boo_Html_Input_Password;
		$input->setAttr('name', 'password');
		$input->setAttr('id', 'password');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Radio</h2>
	<?php
		$input = new Boo_Html_Input_Radio;
		$input->setAttr('name', 'radio');
		$input->setAttr('id', 'radio');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Reset</h2>
	<?php
	$input = new Boo_Html_Input_Reset;
	$input->setAttr('name', 'reset');
	$input->setAttr('id', 'reset');
	$text = htmlspecialchars($input->html());
	echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Submit</h2>
	<?php
		$input = new Boo_Html_Input_Submit;
		$input->setAttr('name', 'submit');
		$input->setAttr('id', 'submit');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	<h2>Boo_Html_Input_Text</h2>
	<?php
		$input = new Boo_Html_Input_Text;
		$input->setAttr('name', 'text');
		$input->setAttr('id', 'text');
		$text = htmlspecialchars($input->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
	
	<h1>Wired Elements</h1>
	<h2>Boo_Html_Empty</h2>
	<?php
		$empty = new Boo_Html_Empty;
		$text = htmlspecialchars($empty->html());
		echo "<textarea rows=\"2\" cols=\"100\">{$text}</textarea>\n";
	?>
</div>
<?php include 'includes/footer-simple.php'; ?>
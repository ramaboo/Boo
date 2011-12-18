<?php
/* SVN FILE: $Id: header.php 221 2009-03-30 15:05:17Z david@ramaboo.com $ */
/**
 * @brief Normal header include.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2009 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

$booPage->msgError->setIcon('/images/icons/messagebox-error.png');
$booPage->msgSuccess->setIcon('/images/icons/messagebox-success.png');
$booPage->msgWarning->setIcon('/images/icons/messagebox-warning.png');
$booPage->msgGlobal->setIcon('/images/icons/messagebox-global.png');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head profile="http://www.w3.org/2005/11/profile">
	<meta name="copyright" content="Copyright 2009 ramaboo.com" />
	<meta name="author" content="David Singer david@ramaboo.com" />
	<?php echo $booPage->htmlGeneratorMeta(); ?>
	
	<title>Boo - Tests - <?php echo $booPage->getTitle(); ?></title>
	<?php echo $booPage->htmlHeadAll(); ?>
</head>
<body>
	<div id="global" class="clearfix">
	<?php
		echo $booPage->msgGlobal->html();
		echo $booPage->msgError->html();
		echo $booPage->msgWarning->html();
		echo $booPage->msgSuccess->html();
	?>

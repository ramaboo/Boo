<?php
/* SVN FILE: $Id: boo.css.php 233 2009-05-05 07:43:48Z david@ramaboo.com $ */
/**
 * @brief Default css file for Boo.
 * 
 * This file is included automaticly by the Boo_Page object. 
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 */

require_once('../Boo.php');

header_css();

echo file_get_contents_css('lib/reset.css');
echo file_get_contents_css('lib/clearfix.css');
echo file_get_contents_css('styles.css');
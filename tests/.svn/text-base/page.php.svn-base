<?php
/* SVN FILE: $Id: timer.php 185 2009-02-08 15:48:54Z david@ramaboo.com $ */
/**
 * @brief Used for testing the Boo_Page object.
 * 
 * @file
 * @license		http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 * @link		http://code.ramaboo.com/ Boo Framework
 * @copyright	2008 David Singer
 * @author		David Singer <david@ramaboo.com>
 * @version		2.0.1
 * @see			Boo_LoremIpsum
 */

require_once 'config/default.php';

safe_scripts();

$booPage = new Boo_Page;
$booPage->redirect('../foo/?url=5#ff');

$booPage->redirect('test/?url=5');

$booPage->redirect('/moo/?url=3#fff');

$booPage->redirect('http://test.com:8080');

$booPage->redirect('https://moo.com:8908/?url=4#ff');
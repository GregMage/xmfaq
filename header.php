<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmfaq module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

include '../../mainfile.php';
require_once dirname(dirname(__FILE__)) . '/system/include/functions.php';
XoopsLoad::load('XoopsRequest');

// Config
$nb_limit = $xoopsModuleConfig['index_perpage'];
// Get handler
$question_Handler = xoops_getModuleHandler('xmfaq_question', 'xmfaq');
$category_Handler = xoops_getModuleHandler('xmfaq_category', 'xmfaq');
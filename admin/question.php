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
require dirname(__FILE__) . '/header.php';

// Header
xoops_cp_header();

// Get Action type
$op = XoopsRequest::getCmd('op', 'list');

switch ($op) {
    // list of question
    case 'list':
        default:
		// Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
        $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.tablesorter.js');
        $xoTheme->addScript('modules/system/js/admin.js');
        //navigation
        $xoopsTpl->assign('navigation', $admin_class->addNavigation('question.php'));
        $xoopsTpl->assign('renderindex', $admin_class->renderIndex());
        // Define button addItemButton
        $admin_class->addItemButton(_AM_XMFAQ_QUESTION_ADD, 'question.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $admin_class->renderButton());
        // Get start pager
        $start = XoopsRequest::getInt('start', 0);
        // Criteria
        $criteria = new CriteriaCompo();
		$criteria->setSort('question_weight ASC, question_title');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
        // question
        $question_count = $question_Handler->getCount($criteria);
        $question_arr = $question_Handler->getByLink($criteria);
        $xoopsTpl->assign('question_count', $question_count);
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
		
		// Criteria category
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('category_status', 1));
        $category_count = $category_Handler->getCount($criteria);
        // Assign Template variables
		if ($category_count > 0) {
			if ($question_count > 0) {
				foreach (array_keys($question_arr) as $i) {
					$question_id = $question_arr[$i]->getVar('question_id');
					$question['id'] = $question_id;
					$question['title'] = $question_arr[$i]->getVar('question_title');
					$question['category'] = $question_arr[$i]->getVar('category_title');
					$question['weight'] = $question_arr[$i]->getVar('question_weight');
					$question['status'] = $question_arr[$i]->getVar('question_status');
					$xoopsTpl->append_by_ref('question', $question);
					unset($question);
				}
				// Display Page Navigation
				if ($question_count > $nb_limit) {
					$nav = new XoopsPageNav($question_count, $nb_limit, $start, 'start');
					$xoopsTpl->assign('nav_menu', $nav->renderNav(4));
				}
			} else{
				$xoopsTpl->assign('message_error', _AM_XMFAQ_ERROR_QUESTION);
			}
		} else {
			$xoopsTpl->assign('message_error', _AM_XMFAQ_ERROR_CAT);
		}
        break;

	// view question
    case 'view':
        //navigation
        $xoopsTpl->assign('navigation', $admin_class->addNavigation('question.php'));
        $xoopsTpl->assign('renderindex', $admin_class->renderIndex());
        // Define button addItemButton
        $admin_class->addItemButton(_AM_XMFAQ_QUESTION_LIST, 'question.php', 'list');
        $xoopsTpl->assign('renderbutton', $admin_class->renderButton());
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        
        $xoopsTpl->assign('view', 'view');
        
        $question_id = XoopsRequest::getInt('question_id', 0);
        $question = $question_Handler->get($question_id);
		$category = $category_Handler->get($question->getVar('question_cid'));
        
        if ($question->getVar('question_status') == 0){
            $status = '<span style="color: red; font-weight:bold;">' . _AM_XMFAQ_STATUS_NA . '</span>';
        } else {
            $status = '<span style="color: green; font-weight:bold;">' . _AM_XMFAQ_STATUS_A . '</span>';
        }
        $question_arr = array(_AM_XMFAQ_QUESTION_TITLE => $question->getVar('question_title'),
                             _AM_XMFAQ_QUESTION_ANSWER => $question->getVar('question_answer', 'show'),
							 _AM_XMFAQ_CATEGORY => $category->getVar('category_title'),
                             _AM_XMFAQ_QUESTION_WEIGHT => $question->getVar('question_weight'),
                             _AM_XMFAQ_STATUS => $status
                             );
        $xoopsTpl->assign('question_arr', $question_arr);
        $xoopsTpl->assign('question_id', $question_id);
        break;

    // add question
    case 'add':
        //navigation
        $xoopsTpl->assign('navigation', $admin_class->addNavigation('question.php'));
        $xoopsTpl->assign('renderindex', $admin_class->renderIndex());
        // Define button addItemButton
        $admin_class->addItemButton(_AM_XMFAQ_QUESTION_LIST, 'question.php', 'list');
        $xoopsTpl->assign('renderbutton', $admin_class->renderButton());
        
        // Create form
        $obj  = $question_Handler->create();
        $form = $obj->getForm();
        // Assign form
        $xoopsTpl->assign('form', $form->render());
        break;

    // edit question
    case 'edit':
        //navigation
        $xoopsTpl->assign('navigation', $admin_class->addNavigation('question.php'));
        $xoopsTpl->assign('renderindex', $admin_class->renderIndex());
        // Define button addItemButton
        $admin_class->addItemButton(_AM_XMFAQ_QUESTION_ADD, 'question.php?op=add', 'add');
        $admin_class->addItemButton(_AM_XMFAQ_QUESTION_LIST, 'question.php', 'list');
        $xoopsTpl->assign('renderbutton', $admin_class->renderButton());
        
        // Create form
        $obj  = $question_Handler->get(XoopsRequest::getInt('question_id', 0));
        $form = $obj->getForm();
        // Assign form
        $xoopsTpl->assign('form', $form->render());
        break;

    // del question
    case 'del':
        // Create form
        $question_id = XoopsRequest::getInt('question_id', 0);
        $obj  = $question_Handler->get($question_id);

        if (isset($_POST['ok']) && $_POST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('question.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($question_Handler->delete($obj)) {
                redirect_header('question.php', 2, _AM_XMFAQ_REDIRECT_SAVE);
            } else {
                xoops_error($obj->getHtmlErrors());
            }
        } else {
            xoops_confirm(array(
                              'ok' => 1,
                              'question_id' => $question_id,
                              'op' => 'del'), $_SERVER['REQUEST_URI'], sprintf(_AM_XMFAQ_QUESTION_SUREDEL, $obj->getVar('question_title')));
        }
        break;
    // save question
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('question.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($_POST['question_id'])) {
            $obj = $question_Handler->get(XoopsRequest::getInt('question_id', 0));
        } else {
            $obj = $question_Handler->create();
        }
        
        $message_error = '';
        $question['title'] = XoopsRequest::getString('question_title', '', 'POST');
        $question['answer'] = XoopsRequest::getText('question_answer', '', 'POST');
		$question['cid'] = XoopsRequest::getInt('question_cid', 0, 'POST');
        $question['weight'] = $_POST['question_weight'];
        $question['status'] = XoopsRequest::getInt('question_status', 0, 'POST');
        // error
        if (intval($question['weight'])==0 && $question['weight'] != '0') {
            $message_error .= _AM_XMFAQ_ERROR_WEIGHT . '<br>';
            $question['weight'] = 0;
        }
        $obj->setVar('question_title', $question['title']);
        $obj->setVar('question_answer', $question['answer']);
		$obj->setVar('question_cid', $question['cid']);
        $obj->setVar('question_weight', $question['weight']);
        $obj->setVar('question_status', $question['status']);

        if ($message_error != '') {
            // Define button addItemButton
            $admin_class->addItemButton(_AM_XMFAQ_QUESTION_LIST, 'question.php', 'list');
            $xoopsTpl->assign('renderbutton', $admin_class->renderButton());
            $xoopsTpl->assign('message_error', $message_error);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render());
        }else{
            if ($question_Handler->insert($obj)) {			
                redirect_header('question.php', 2, _AM_XMFAQ_REDIRECT_SAVE);
            }else {
                $xoopsTpl->assign('message_error', $obj->getHtmlErrors());
            }
        }
        break;

    // update status
    case 'question_update_status':
        $question_id = XoopsRequest::getInt('question_id', 0);
        if ($question_id > 0) {
            $obj = $question_Handler->get($question_id);
            $old = $obj->getVar('question_status');
            $obj->setVar('question_status', !$old);
            if ($question_Handler->insert($obj)) {
                exit;
            }
			$xoopsTpl->assign('message_error', $obj->getHtmlErrors());
        }
        break;
}
// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xmfaq/templates/admin/xmfaq_question.tpl');
xoops_cp_footer();
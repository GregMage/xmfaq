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
include __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'xmfaq_viewcategory.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$category_id = XoopsRequest::getInt('category_id', 0);

if ($category_id == 0) {
    redirect_header('index.php', 2, _MD_XMFAQ_VIEWCATEGORY_NOCAT);
    exit();
}
$category = $categoryHandler->get($category_id);

if (count($category) == 0) {
    redirect_header('index.php', 2, _MD_XMFAQ_VIEWCATEGORY_NOCAT);
    exit();
}

if ($category->getVar('category_status') == 0) {
    redirect_header('index.php', 2, _MD_XMFAQ_VIEWCATEGORY_NACTIVE);
    exit();
}

$xoopsTpl->assign('category_title', $category->getVar('category_title'));
$xoopsTpl->assign('category_description', $category->getVar('category_description', 'show'));
// Criteria
$criteria = new CriteriaCompo();
$criteria->setSort('question_weight ASC, question_title');
$criteria->setOrder('ASC');
$criteria->add(new Criteria('question_status', 1));
$criteria->add(new Criteria('question_cid', $category_id));
$question_arr   = $questionHandler->getall($criteria);
$question_count = $questionHandler->getCount($criteria);
$xoopsTpl->assign('question_count', $question_count);
$count = 1;
if ($question_count > 0) {
    foreach (array_keys($question_arr) as $i) {
        $question_id        = $question_arr[$i]->getVar('question_id');
        $question['id']     = $question_id;
        $question['title']  = $question_arr[$i]->getVar('question_title');
        $question['answer'] = $question_arr[$i]->getVar('question_answer', 'show');
        $question['count']  = $count;
        $xoopsTpl->append_by_ref('question', $question);
        $count++;
        unset($question);
    }
}

//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', strip_tags($category->getVar('category_title') . ' - ' . $xoopsModule->name()));
//description
/*if ($content->getVar('content_mdescription') == ''){
    $xoTheme->addMeta('meta', 'description', $content->getVar('content_title'));
} else {
    $xoTheme->addMeta('meta', 'description', $content->getVar('content_mdescription'));
}

//keywords
$xoTheme->addMeta('meta', 'keywords', $content->getVar('mkeyword'));*/

include XOOPS_ROOT_PATH . '/footer.php';

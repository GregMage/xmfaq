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
$xoopsOption['template_main'] = 'xmfaq_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$keywords = '';

$xoopsTpl->assign('index_header', $xoopsModuleConfig['index_header']);
$xoopsTpl->assign('index_footer', $xoopsModuleConfig['index_footer']);
$xoopsTpl->assign('index_columncategory', $xoopsModuleConfig['index_columncat']);
// Get start pager
$start = XoopsRequest::getInt('start', 0);
// Criteria
$criteria = new CriteriaCompo();
$criteria->setSort('category_weight ASC, category_title');
$criteria->setOrder('ASC');
$criteria->setStart($start);
$criteria->setLimit($nb_limit);
$criteria->add(new Criteria('category_status', 1));
$category_arr         = $categoryHandler->getall($criteria);
$category_count_total = $categoryHandler->getCount($criteria);
$category_count       = count($category_arr);
$xoopsTpl->assign('category_count', $category_count);
$count     = 1;
$count_row = 1;
if ($category_count > 0) {
    foreach (array_keys($category_arr) as $i) {
        $category_id             = $category_arr[$i]->getVar('category_id');
        $category['id']          = $category_id;
        $category['title']       = $category_arr[$i]->getVar('category_title');
        $category['description'] = $category_arr[$i]->getVar('category_description', 'show');
        $category['count']       = $count;
        if ($count_row == $count) {
            $category['row'] = true;
            $count_row       = $count_row + $xoopsModuleConfig['index_columncat'];
        } else {
            $category['row'] = false;
        }
        if ($count == $category_count) {
            $category['end'] = true;
        } else {
            $category['end'] = false;
        }
        $xoopsTpl->append_by_ref('category', $category);
        $count++;
        $keywords .= $category['title'] . ',';
        unset($category);
    }
    // Display Page Navigation
    if ($category_count_total > $nb_limit) {
        $nav = new XoopsPageNav($category_count_total, $nb_limit, $start, 'start');
        $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
    }
}
//SEO
//description
$xoTheme->addMeta('meta', 'description', strip_tags($xoopsModule->name()));
//keywords
$keywords = substr($keywords, 0, -1);
$xoTheme->addMeta('meta', 'keywords', $keywords);

include XOOPS_ROOT_PATH . '/footer.php';

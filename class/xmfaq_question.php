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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmfaq_question
 */
class xmfaq_question extends XoopsObject
{
    // constructor
    /**
     * xmfaq_question constructor.
     */
    public function __construct()
    {
        //parent::__construct;
        $this->initVar('question_id', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('question_cid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('question_title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('question_answer', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('question_weight', XOBJ_DTYPE_INT, 0, false, 5);
        $this->initVar('question_status', XOBJ_DTYPE_INT, null, false, 10);

        //pour les jointures:
        $this->initVar('category_title', XOBJ_DTYPE_TXTBOX, null, false);
    }

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        global $xoopsModuleConfig;

        //form title
        $title = $this->isNew() ? sprintf(_AM_XMFAQ_ADD) : sprintf(_AM_XMFAQ_EDIT);

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);

        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('question_id', $this->getVar('question_id')));
            $status = $this->getVar('question_status');
            $weight = $this->getVar('question_weight');
        } else {
            $status = 1;
            $weight = 0;
        }

        // title
        $form->addElement(new XoopsFormText(_AM_XMFAQ_QUESTION_TITLE, 'question_title', 50, 255, $this->getVar('question_title')), true);

        // text
        $editor_configs           = array();
        $editor_configs['name']   = 'question_answer';
        $editor_configs['value']  = $this->getVar('question_answer', 'e');
        $editor_configs['rows']   = 20;
        $editor_configs['cols']   = 160;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $xoopsModuleConfig['admin_editor'];
        $form->addElement(new XoopsFormEditor(_AM_XMFAQ_QUESTION_ANSWER, 'question_answer', $editor_configs), true);

        //category
        $categoryHandler = xoops_getModuleHandler('xmfaq_category', 'xmfaq');
        $criteria         = new CriteriaCompo();
        $criteria->add(new Criteria('category_status', 1));
        $criteria->setSort('category_weight ASC, category_title');
        $criteria->setOrder('ASC');
        $category_arr   = $categoryHandler->getall($criteria);
        $category_count = $categoryHandler->getCount($criteria);
        if ($category_count == 0) {
            redirect_header('category.php', 2, _AM_XMFAQ_ERROR_CAT);
        }

        $cat = new XoopsFormSelect(_AM_XMFAQ_CATEGORY, 'question_cid', $this->getVar('question_cid'));
        foreach (array_keys($category_arr) as $i) {
            $cat->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_title'));
        }
        $form->addElement($cat);

        // weight
        $form->addElement(new XoopsFormText(_AM_XMFAQ_QUESTION_WEIGHT, 'question_weight', 5, 5, $weight), true);

        // status
        $form_status = new XoopsFormRadio(_AM_XMFAQ_STATUS, 'question_status', $status);
        $options     = array(1 => _AM_XMFAQ_STATUS_A, 0 => _AM_XMFAQ_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submitt
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * Class xmfaqxmfaq_questionHandler
 */
class xmfaqxmfaq_questionHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmfaqxmfaq_questionHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct(&$db)
    {
        parent::__construct($db, 'xmfaq_question', 'xmfaq_question', 'question_id', 'question_title');
    }
}

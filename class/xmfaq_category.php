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

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class xmfaq_category extends XoopsObject
{
// constructor
    function __construct()
    {
        //$this->XoopsObject();
        $this->initVar('category_id',XOBJ_DTYPE_INT,null,false,11);
        $this->initVar('category_title',XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('category_description',XOBJ_DTYPE_TXTAREA, null, false);
        // use html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('category_weight',XOBJ_DTYPE_INT,null,false,11);
        $this->initVar('category_status',XOBJ_DTYPE_INT,null,false,1);
    }
    function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }
    function xmfaq_category()
    {
        $this->__construct();
    }
    function getForm($action = false)
    {
        $upload_size = 500000;
        global $xoopsModuleConfig, $xoopsUser;
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        
        //form title
        $title = $this->isNew() ? sprintf(_AM_XMFAQ_ADD) : sprintf(_AM_XMFAQ_EDIT);
        
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('category_id', $this->getVar('category_id')));
            $status = $this->getVar('category_status');
            $weight = $this->getVar('category_weight');
        } else {
            $status = 1;
            $weight = 0;
        }

        // title
        $form->addElement(new XoopsFormText(_AM_XMFAQ_CATEGORY_TITLE, 'category_title', 50, 255, $this->getVar('category_title')), true);

        // description
        $editor_configs=array();
        $editor_configs["name"] ="category_description";
        $editor_configs["value"] = $this->getVar('category_description', 'e');
        $editor_configs["rows"] = 20;
        $editor_configs["cols"] = 160;
        $editor_configs["width"] = "100%";
        $editor_configs["height"] = "400px";
        $editor_configs["editor"] = $xoopsModuleConfig['admin_editor'];
        $form->addElement( new XoopsFormEditor(_AM_XMFAQ_CATEGORY_DESC, "category_description", $editor_configs), false);
        // weight
        $form->addElement(new XoopsFormText(_AM_XMFAQ_CATEGORY_WEIGHT, 'category_weight', 5, 5, $weight), true);

        // status
        $form_status = new XoopsFormRadio(_AM_XMFAQ_STATUS, 'category_status', $status);
        $options = array(1 => _AM_XMFAQ_STATUS_A, 0 =>_AM_XMFAQ_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submitt
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

class xmfaqxmfaq_categoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, "xmfaq_category", 'xmfaq_category', 'category_id', 'category_title');
    }
}
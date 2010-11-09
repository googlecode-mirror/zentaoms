<?php
/**
 * The control file of company module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class company extends control
{
    /* 构造函数。*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('dept');
        $this->app->loadLang('user');
        $this->company->setMenu();
    }

    /* 公司首页。*/
    public function index()
    {
        $this->locate($this->createLink('company', 'browse'));
    }

    /* 浏览某一个公司。*/
    public function browse($deptID = 0)
    {
        $this->lang->set('menugroup.company', 'company');
        $childDeptIds = $this->dept->getAllChildID($deptID);

        $this->company->setMenu($deptID);

        $header['title'] = $this->lang->company->index . $this->lang->colon . $this->lang->dept->common;
        $position[]      = $this->lang->dept->common;

        $this->view->header      = $header;
        $this->view->position    = $position;
        $this->view->users       = $this->dept->getUsers($childDeptIds);
        $this->view->deptTree    = $this->dept->getTreeMenu($rooteDeptID = 0, array('deptModel', 'createMemberLink'));
        $this->view->parentDepts = $this->dept->getParents($deptID);
        $this->view->deptID      = $deptID;

        $this->display();
    }

    /* 新增一个公司。*/
    public function create()
    {
        if(!empty($_POST))
        {
            $this->company->create();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('admin', 'browsecompany'), 'parent'));
        }

        $this->lang->set('menugroup.company', 'admin');
        $this->lang->company->menu = $this->lang->admin->menu;

        $header['title'] = $this->lang->admin->common . $this->lang->colon . $this->lang->company->create;
        $position[]      = html::a($this->createLink('admin', 'browsecompany'), $this->lang->admin->company);
        $position[]      = $this->lang->company->create;
        $this->view->header   = $header;
        $this->view->position = $position;

        $this->display();
    }

    /* 编辑一个公司。*/
    public function edit()
    {
        if(!empty($_POST))
        {
            $this->company->update();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::alert($this->lang->company->successSaved));
        }

        $header['title'] = $this->lang->company->common . $this->lang->colon . $this->lang->company->edit;
        $position[]      = $this->lang->company->edit;
        $this->view->header    = $header;
        $this->view->position  = $position;
        $this->view->company   = $this->company->getById($this->app->company->id);

        $this->display();
    }

    /* 删除公司。*/
    public function delete($companyID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->company->confirmDelete, $this->createLink('company', 'delete', "companyID=$companyID&confirm=yes"));
            exit;
        }
        else
        {
            $this->company->delete($companyID);
            echo js::locate($this->createLink('admin', 'browseCompany'), 'parent');
            exit;
        }
    }
}

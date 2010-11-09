<?php
/**
 * The control file of dept module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dept
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class dept extends control
{
    const NEW_CHILD_COUNT = 5;

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('company')->setMenu();
    }

    /* 部门列表。*/
    public function browse($deptID = 0)
    {
        $header['title'] = $this->lang->dept->manage . $this->lang->colon . $this->app->company->name;
        $position[]      = $this->lang->dept->manage;

        $parentDepts = $this->dept->getParents($deptID);
        $this->view->header      = $header;
        $this->view->position    = $position;
        $this->view->deptID      = $deptID;
        $this->view->depts       = $this->dept->getTreeMenu($rooteDeptID = 0, array('deptmodel', 'createManageLink'));
        $this->view->parentDepts = $parentDepts;
        $this->view->sons        = $this->dept->getSons($deptID);
        $this->display();
    }

    /* 编辑部门。*/
    public function edit($moduleID)
    {
        if(!empty($_POST))
        {
            if($this->product->update($_POST)) die(js::locate($this->createLink($this->moduleName, 'index', "product=$_POST[id]"), 'parent'));
        }

        $product = $this->product->getByID($productID);
        $header['title'] = $this->lang->product->edit . $this->lang->colon . $product->name;
        $this->view->header  = $header;
        $this->view->product = $product;
        $this->display();
    }

    /* 更新排序。*/
    public function updateOrder()
    {
        if(!empty($_POST))
        {
            $this->dept->updateOrder($_POST['orders']);
            die(js::reload('parent'));
        }
    }

    /* 维护下级部门。*/
    public function manageChild()
    {
        if(!empty($_POST))
        {
            $this->dept->manageChild($_POST['parentDeptID'], $_POST['depts']);
            die(js::reload('parent'));
        }
    }

    /* 删除某一个部门。*/
    public function delete($deptID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->dept->confirmDelete, $this->createLink('dept', 'delete', "deptID=$deptID&confirm=yes"));
            exit;
        }
        else
        {
            $this->dept->delete($deptID);
            die(js::reload('parent'));
        }
    }
}

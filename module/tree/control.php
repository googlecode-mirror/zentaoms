<?php
/**
 * The control file of tree module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    /* 模块列表。*/
    public function browse($rootID, $viewType, $currentModuleID = 0)
    {
        /* 根据视图的不同，获得相应的产品或者文档库。*/
        if(strpos('story|bug|case', $viewType) !== false)
        {
            $product = $this->loadModel('product')->getById($rootID);
            $this->view->root = $product;
            $this->view->productModules = $this->tree->getOptionMenu($rootID, 'story');
        }
        elseif(strpos($viewType, 'doc') !== false)
        {
            $this->loadModel('doc');
            if($rootID == 'product' or $rootID == 'project')
            {
                $viewType  = $rootID . 'doc';
                $lib->id   = $rootID;
                $lib->name = $this->lang->doc->systemLibs[$rootID];
                $this->view->root = $lib;
            }
            else
            {
                $viewType = 'customdoc';
                $lib = $this->loadModel('doc')->getLibById($rootID);
                $this->view->root = $lib;
            }
        }

        if($viewType == 'story')
        {
            /* 设置菜单。*/
            $this->product->setMenu($this->product->getPairs(), $rootID, 'story');
            $this->lang->tree->menu = $this->lang->product->menu;
            $this->lang->set('menugroup.tree', 'product');

            /* 设置导航。*/
            $header['title'] = $this->lang->tree->manageProduct . $this->lang->colon . $product->name;
            $position[]      = html::a($this->createLink('product', 'browse', "product=$rootID"), $product->name);
            $position[]      = $this->lang->tree->manageProduct;
        }
        elseif($viewType == 'bug')
        {
            /* 设置菜单。*/
            $this->loadModel('bug')->setMenu($this->product->getPairs(), $rootID);
            $this->lang->tree->menu = $this->lang->bug->menu;
            $this->lang->set('menugroup.tree', 'qa');

            $header['title'] = $this->lang->tree->manageBug . $this->lang->colon . $product->name;
            $position[]      = html::a($this->createLink('bug', 'browse', "product=$rootID"), $product->name);
            $position[]      = $this->lang->tree->manageBug;
        }
        elseif($viewType == 'case')
        {
            /* 设置菜单。*/
            $this->loadModel('testcase')->setMenu($this->product->getPairs(), $rootID);
            $this->lang->tree->menu = $this->lang->testcase->menu;
            $this->lang->set('menugroup.tree', 'qa');

            $header['title'] = $this->lang->tree->manageCase . $this->lang->colon . $product->name;
            $position[]      = html::a($this->createLink('testcase', 'browse', "product=$rootID"), $product->name);
            $position[]      = $this->lang->tree->manageCase;
        }
        elseif(strpos($viewType, 'doc') !== false)
        {
            /* 设置菜单。*/
            $this->doc->setMenu($this->doc->getLibs(), $rootID, 'doc');
            $this->lang->tree->menu = $this->lang->doc->menu;
            $this->lang->set('menugroup.tree', 'doc');

            $header['title'] = $this->lang->tree->manageCustomDoc . $this->lang->colon . $lib->name;
            $position[]      = html::a($this->createLink('doc', 'browse', "libID=$rootID"), $lib->name);
            $position[]      = $this->lang->tree->manageCustomDoc;
        }

        $parentModules = $this->tree->getParents($currentModuleID);
        $this->view->header          = $header;
        $this->view->position        = $position;
        $this->view->rootID          = $rootID;
        $this->view->viewType        = $viewType;
        $this->view->modules         = $this->tree->getTreeMenu($rootID, $viewType, $rooteModuleID = 0, array('treeModel', 'createManageLink'));
        $this->view->sons            = $this->tree->getSons($rootID, $currentModuleID, $viewType);
        $this->view->currentModuleID = $currentModuleID;
        $this->view->parentModules   = $parentModules;
        $this->display();
    }

    /* 编辑模块。*/
    public function edit($moduleID)
    {
        if(!empty($_POST))
        {
            $this->tree->update($moduleID);
            echo js::alert($this->lang->tree->successSave);
            die(js::reload('parent'));
        }
        $this->view->module     = $this->tree->getById($moduleID);
        $this->view->optionMenu = $this->tree->getOptionMenu($this->view->module->root, $this->view->module->type);
        $this->view->users      = $this->loadModel('user')->getPairs('noclosed');

        /* 去掉自己和child。*/
        $childs = $this->tree->getAllChildId($moduleID);
        foreach($childs as $childModuleID) unset($this->view->optionMenu[$childModuleID]);

        die($this->display());
    }

    /* 更新排序。*/
    public function updateOrder()
    {
        if(!empty($_POST))
        {
            $this->tree->updateOrder($_POST['orders']);
            die(js::reload('parent'));
        }
    }

    /* 维护子菜单。*/
    public function manageChild($rootID, $viewType)
    {
        if(!empty($_POST))
        {
            $this->tree->manageChild($rootID, $viewType, $_POST['parentModuleID'], $_POST['modules']);
            die(js::reload('parent'));
        }
    }

    /* 删除某一个模块。*/
    public function delete($rootID, $moduleID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->tree->confirmDelete, $this->createLink('tree', 'delete', "rootID=$rootID&moduleID=$moduleID&confirm=yes"));
            exit;
        }
        else
        {
            $this->tree->delete($moduleID);
            die(js::reload('parent'));
        }
    }

    /* ajax请求： 返回某一个产品的模块列表。*/
    public function ajaxGetOptionMenu($rootID, $viewType = 'product', $rootModuleID = 0)
    {
        $optionMenu = $this->tree->getOptionMenu($rootID, $viewType, $rootModuleID);
        die( html::select("module", $optionMenu, '', 'onchange=setAssignedTo()'));
    }

    /* ajax请求： 返回某一个模块的son模块.*/
    public function ajaxGetSonModules($moduleID, $rootID = 0)
    {
        if($moduleID) die(json_encode($this->dao->findByParent($moduleID)->from(TABLE_MODULE)->fetchPairs('id', 'name')));
        $modules = $this->dao->select('id, name')->from(TABLE_MODULE)
            ->where('root')->eq($rootID)
            ->andWhere('parent')->eq('0')
            ->andWhere('type')->eq('story')
            ->fetchPairs();
        foreach($modules as $key => $name) $modules[$key] = str_replace(" ","&nbsp;","$name");
        die(json_encode($modules));
    }
}

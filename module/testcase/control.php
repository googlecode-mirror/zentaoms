<?php
/**
 * The control file of case currentModule of ZenTaoMS.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.  
 *
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     case
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class testcase extends control
{
    private $products = array();

    /* 构造函数，加载story, release, tree等模块。*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('product');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->view->products = $this->products = $this->product->getPairs();
    }

    /* case首页。*/
    public function index()
    {
        $this->locate($this->createLink('testcase', 'browse'));
    }

    /* 浏览一个产品下面的case。*/
    public function browse($productID = 0, $browseType = 'byModule', $param = 0, $orderBy = 'id|desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* 构造搜索表单。*/
        $this->config->testcase->search['actionURL'] = $this->createLink('testcase', 'browse', "productID=$productID&browseType=bySearch");
        $this->assign('searchForm', $this->fetch('search', 'buildForm', $this->config->testcase->search));

        /* 设置浏览模式，产品ID和模块ID。 */
        $browseType = strtolower($browseType);
        $productID = common::saveProductState($productID, key($this->products));
        $moduleID  = ($browseType == 'bymodule') ? (int)$param : 0;

        /* 设置菜单，登记session。*/
        $this->testcase->setMenu($this->products, $productID);
        $this->session->set('caseList', $this->app->getURI(true));

        /* 加载分页类。*/
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* 如果是按照模块查找，或者列出所有。*/
        if($browseType == 'bymodule' or $browseType == 'all')
        {
            $childModuleIds    = $this->tree->getAllChildId($moduleID);
            $this->view->cases = $this->testcase->getModuleCases($productID, $childModuleIds, $orderBy, $pager);
        }
        elseif($browseType == 'bysearch')
        {
            if($this->session->testcaseQuery == false) $this->session->set('testcaseQuery', ' 1 = 1');
            $this->view->cases = $this->dao->select('*')->from(TABLE_CASE)->where($this->session->testcaseQuery)->andWhere('product')->eq($productID)->orderBy($orderBy)->page($pager)->fetchAll();
        }

        /* 赋值。*/
        $this->view->header->title = $this->products[$productID] . $this->lang->colon . $this->lang->testcase->common;
        $this->view->position[]    = html::a($this->createLink('testcase', 'browse', "productID=$productID"), $this->products[$productID]);
        $this->view->position[]    = $this->lang->testcase->common;
        $this->view->productID     = $productID;
        $this->view->productName   = $this->products[$productID];
        $this->view->moduleTree    = $this->tree->getTreeMenu($productID, $viewType = 'case', $rooteModuleID = 0, array('treeModel', 'createCaseLink'));
        $this->view->moduleID      = $moduleID;
        $this->view->pager         = $pager;
        $this->view->users         = $this->user->getPairs($this->app->company->id, 'noletter');
        $this->view->orderBy       = $orderBy;
        $this->view->browseType    = $browseType;
        $this->view->param         = $param;

        $this->display();
    }

    /* 创建case。*/
    public function create($productID, $moduleID = 0)
    {
        $this->loadModel('story');
        if(!empty($_POST))
        {
            $caseID = $this->testcase->create();
            if(dao::isError()) die(js::error(dao::getError()));
            $this->loadModel('action');
            $this->action->create('case', $caseID, 'Opened');
            die(js::locate($this->createLink('testcase', 'browse', "productID=$_POST[product]&browseType=byModule&param=$_POST[module]"), 'parent'));
        }
        if(empty($this->products)) $this->locate($this->createLink('product', 'create'));

        $productID       = common::saveProductState($productID, key($this->products));
        $currentModuleID = (int)$moduleID;

        /* 设置菜单。*/
        $this->testcase->setMenu($this->products, $productID);

        $header['title'] = $this->products[$productID] . $this->lang->colon . $this->lang->testcase->create;
        $position[]      = html::a($this->createLink('testcase', 'browse', "productID=$productID"), $this->products[$productID]);
        $position[]      = $this->lang->testcase->create;

        $users = $this->user->getPairs($this->app->company->id);
        $this->assign('header',        $header);
        $this->assign('position',      $position);
        $this->assign('productID',     $productID);
        $this->assign('users',         $users);           
        $this->assign('productName',   $this->products[$productID]);
        $this->assign('moduleOptionMenu',  $this->tree->getOptionMenu($productID, $viewType = 'case', $rooteModuleID = 0));
        $this->assign('currentModuleID',   $currentModuleID);
        $this->assign('stories',       $this->story->getProductStoryPairs($productID));

        $this->display();
    }

    /* 查看一个case。*/
    public function view($caseID)
    {
        $this->loadModel('action');
        $case = $this->testcase->getById($caseID);
        $productID = $case->product;
        $header['title'] = $this->products[$productID] . $this->lang->colon . $this->lang->testcase->view;
        $position[]      = html::a($this->createLink('testcase', 'browse', "productID=$productID"), $this->products[$productID]);
        $position[]      = $this->lang->testcase->view;

        /* 设置菜单。*/
        $this->testcase->setMenu($this->products, $productID);

        $users   = $this->user->getPairs($this->app->company->id, 'noletter');
        $actions = $this->action->getList('case', $caseID);

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('case',     $case);
        $this->assign('actions',  $actions);
        $this->assign('productName', $this->products[$productID]);
        $this->assign('modulePath',  $this->tree->getParents($case->module));

        $this->display();
    }

    /* 编辑一个Bug。*/
    public function edit($caseID)
    {
        $this->loadModel('story');

        /* 更新case信息。*/
        if(!empty($_POST))
        {
            $changes = $this->testcase->update($caseID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($this->post->comment != '' or !empty($changes))
            {
                $this->loadModel('action');
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $actionID = $this->action->create('case', $caseID, $action, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }
            die(js::locate($this->createLink('testcase', 'view', "caseID=$caseID"), 'parent'));
        }

        /* 生成表单。*/
        $case            = $this->testcase->getById($caseID);
        $productID       = $case->product;
        $currentModuleID = $case->module;
        $header['title'] = $this->products[$productID] . $this->lang->colon . $this->lang->testcase->edit;
        $position[]      = html::a($this->createLink('testcase', 'browse', "productID=$productID"), $this->products[$productID]);
        $position[]      = $this->lang->testcase->edit;

        /* 设置菜单。*/
        $this->testcase->setMenu($this->products, $productID);

        $users = $this->user->getPairs($this->app->company->id);
        $this->assign('header',        $header);
        $this->assign('position',      $position);
        $this->assign('productID',     $productID);
        $this->assign('productName',   $this->products[$productID]);
        $this->assign('moduleOptionMenu',  $this->tree->getOptionMenu($productID, $viewType = 'case', $rooteModuleID = 0));
        $this->assign('currentModuleID',   $currentModuleID);
        $this->assign('users',   $users);           
        $this->assign('stories', $this->story->getProductStoryPairs($productID));

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('case',      $case);

        $this->display();
    }

    public function delete($id)
    {
        $header['title'] = $this->lang->page->delete;
        $this->assign('header', $header);
        $this->display();
    }
}

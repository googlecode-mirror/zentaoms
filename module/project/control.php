<?php
/**
 * The control file of project module of ZenTaoMS.
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
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class project extends control
{
    private $projects;

    /* 构造函数，加载product, task, story等模块。*/
    public function __construct()
    {
        parent::__construct();
        $this->projects = $this->project->getPairs();
    }

    /* 项目视图首页，暂时跳转到浏览页面。*/
    public function index()
    {
        if(empty($this->projects)) $this->locate($this->createLink('project', 'create'));
        $this->locate($this->createLink($this->moduleName, 'task'));
    }

    /* 浏览某一个项目。*/
    public function browse($projectID = 0)
    {
        $this->locate($this->createLink($this->moduleName, 'task', "productID=$projectID"));
    }

    /* task, story, bug等方法的一些公共操作。*/
    private function commonAction($projectID = 0)
    {
        /* 加载product模块。*/
        $this->loadModel('product');

        /* 获取当前项目的详细信息，相关产品，子项目以及团队成员。*/
        $projectID     = common::saveProjectState($projectID, array_keys($this->projects));
        $project       = $this->project->findByID($projectID);
        $products      = $this->project->getProducts($project->id);
        $childProjects = $this->project->getChildProjects($project->id);
        $teamMembers   = $this->project->getTeamMembers($project->id);

        /* 将其赋值到模板系统。*/
        $this->assign('projects',      $this->projects);
        $this->assign('project',       $project);
        $this->assign('childProjects', $childProjects);
        $this->assign('products',      $products);
        $this->assign('teamMembers',   $teamMembers);

        return $project;
    }

    /* 浏览某一个项目下面的任务。*/
    public function task($projectID = 0, $orderBy = 'status|desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        /* 加载任务模块。*/
        $this->loadModel('task');

        /* 公共的操作。*/
        $project   = $this->commonAction($projectID);
        $projectID = $project->id;

        /* 记录用户当前选择的列表。*/
        $this->app->session->set('taskList',  $this->app->getURI(true));
        $this->app->session->set('storyList', $this->app->getURI(true));

        /* 设定header和position信息。*/
        $header['title'] = $project->name . $this->lang->colon . $this->lang->project->task;
        $position[]      = html::a($this->createLink('project', 'browse', "projectID=$projectID"), $project->name);
        $position[]      = $this->lang->project->task;

        /* 分页操作。*/
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $tasks = $this->task->getProjectTasks($projectID, $orderBy, $pager);

        /* 赋值。*/
        $this->assign('header',     $header);
        $this->assign('position',   $position);
        $this->assign('tasks',      $tasks);
        $this->assign('tabID',      'task');
        $this->assign('pager',      $pager->get());
        $this->assign('recTotal',   $pager->recTotal);
        $this->assign('recPerPage', $pager->recPerPage);
        $this->assign('orderBy',    $orderBy);

        $this->display();
    }

    /* 浏览某一个项目下面的需求。*/
    public function story($projectID = 0, $orderBy = 'status|desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        /* 加载story, user模块，加载task模块的语言。*/
        $this->loadModel('story');
        $this->loadModel('user');
        $this->app->loadLang('task');

        /* 记录用户当前选择的列表。*/
        $this->app->session->set('storyList', $this->app->getURI(true));

        /* 公共的操作。*/
        $project = $this->commonAction($projectID);

        /* 设定header和position信息。*/
        $header['title'] = $project->name . $this->lang->colon . $this->lang->project->story;
        $position[]      = html::a($this->createLink('project', 'browse', "projectID=$projectID"), $project->name);
        $position[]      = $this->lang->project->story;

        /* 分页操作。*/
        $this->app->loadClass('pager', $static = true);
        $pager   = new pager($recTotal, $recPerPage, $pageID);
        $stories = $this->story->getProjectStories($projectID, $orderBy, $pager);
        $users   = $this->user->getPairs($this->app->company->id, 'noletter');

        /* 赋值。*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('stories',  $stories);
        $this->assign('tabID',    'story');
        $this->assign('pager',    $pager->get());
        $this->assign('orderBy',  $orderBy);
        $this->assign('users',    $users);

        $this->display();
    }

    /* 浏览某一个项目下面的bug。*/
    public function bug($projectID = 0, $orderBy = 'status,id|desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        /* 加载bug和user模块。*/
        $this->loadModel('bug');
        $this->loadModel('user');

        /* 登记session。*/
        $this->session->set('bugList', $this->app->getURI(true));

        /* 公共的操作。*/
        $project = $this->commonAction($projectID);

        /* 设定header和position信息。*/
        $header['title'] = $project->name . $this->lang->colon . $this->lang->project->bug;
        $position[]      = html::a($this->createLink('project', 'browse', "projectID=$projectID"), $project->name);
        $position[]      = $this->lang->project->bug;

        /* 分页操作。*/
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $bugs  = $this->bug->getProjectBugs($projectID, $orderBy, $pager);
        $users = $this->user->getPairs($this->app->company->id, 'noletter');

        /* 赋值。*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('bugs',     $bugs);
        $this->assign('tabID',    'bug');
        $this->assign('pager',    $pager->get());
        $this->assign('orderBy',  $orderBy);
        $this->assign('users',    $users);

        $this->display();
    }

    /* 某一个项目的燃烧图。*/
    public function burn($projectID = 0)
    {
        $this->loadModel('report');
        /* 公共的操作。*/
        $project = $this->commonAction($projectID);

        /* 设定header和position信息。*/
        $header['title'] = $project->name . $this->lang->colon . $this->lang->project->burn;
        $position[]      = html::a($this->createLink('project', 'browse', "projectID=$projectID"), $project->name);
        $position[]      = $this->lang->project->burn;

        /* 赋值。*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('tabID',    'burn');
        $this->assign('charts',   $this->report->createChart('line', $this->createLink('project', 'burnData', "project=$projectID", 'xml')));
        $this->display();
    }

    /* 燃烧图所需要的数据。*/
    public function burnData($projectID = 0)
    {
        $this->loadModel('report');
        $sets = $this->project->getBurnData($projectID);
        die($this->report->createSingleXML($sets, $this->lang->project->charts->burn->graph));
    }

    /* 创建一个项目。*/
    public function create()
    {
        if(!empty($_POST))
        {
            $projectID = $this->project->create();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('project', 'browse', "projectID=$projectID"), 'parent'));
        }

        $header['title'] = $this->lang->project->create;
        $position[]      = $header['title'];
        $projects        = array('' => '') + $this->projects;

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('projects', $projects);
        $this->display();
    }

    /* 编辑一个项目。*/
    public function edit($projectID)
    {
        $browseProjectLink = $this->createLink('project', 'browse', "projectID=$projectID");
        if(!empty($_POST))
        {
            $this->project->update($projectID);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($browseProjectLink, 'parent'));
        }
        $projects = array('' => '') + $this->projects;
        $project  = $this->project->findById($projectID);

        /* 从列表中删除当前项目。*/
        unset($projects[$projectID]);

        /* 标题和位置信息。*/
        $header['title'] = $this->lang->project->edit . $this->lang->colon . $project->name;
        $position[]      = html::a($browseProjectLink, $project->name);
        $position[]      = $this->lang->project->edit;

        /* 赋值。*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('projects', $projects);
        $this->assign('project',  $project);

        $this->display();
    }

    /* 删除一个项目。*/
    public function delete($projectID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm(sprintf($this->lang->project->confirmDelete, $this->projects[$projectID]), $this->createLink('project', 'delete', "projectID=$projectID&confirm=yes"));
            exit;
        }
        else
        {
            $this->project->delete($projectID);
            echo js::locate($this->createLink('project', 'browse'), 'parent');
            exit;
        }
    }

    /* 维护相关的产品。*/
    public function manageProducts($projectID)
    {
        $browseProjectLink = $this->createLink('project', 'browse', "projectID=$projectID");
        if(!empty($_POST))
        {
            $this->project->updateProducts($projectID);
            if(dao::isError()) dis(js::error(dao::getError()));
            die(js::locate($browseProjectLink));
        }

        $this->loadModel('product');
        $project  = $this->project->findById($projectID);

        /* 标题和位置信息。*/
        $header['title'] = $this->lang->project->manageProducts . $this->lang->colon . $project->name;
        $position[]      = html::a($browseProjectLink, $project->name);
        $position[]      = $this->lang->project->manageProducts;

        $allProducts    = $this->product->getPairs();
        $linkedProducts = $this->project->getProducts($project->id);
        $linkedProducts = join(',', array_keys($linkedProducts));

        /* 赋值。*/
        $this->assign('header',         $header);
        $this->assign('position',       $position);
        $this->assign('allProducts',    $allProducts);
        $this->assign('linkedProducts', $linkedProducts);

        $this->display();
    }

    /* 维护子项目。*/
    public function manageChilds($projectID)
    {
        $browseProjectLink = $this->createLink('project', 'browse', "projectID=$projectID");
        if(!empty($_POST))
        {
            $this->project->updateChilds($projectID);
            die(js::locate($browseProjectLink));
        }
        $project  = $this->project->findById($projectID);
        $projects = $this->projects;
        unset($projects[$projectID]);
        unset($projects[$project->parent]);
        if(empty($projects)) $this->locate($browseProjectLink);

        /* 标题和位置信息。*/
        $header['title'] = $this->lang->project->manageChilds . $this->lang->colon . $project->name;
        $position[]      = html::a($browseProjectLink, $project->name);
        $position[]      = $this->lang->project->manageChilds;

        $childProjects = $this->project->getChildProjects($project->id);
        $childProjects = join(",", array_keys($childProjects));

        /* 赋值。*/
        $this->assign('header',        $header);
        $this->assign('position',      $position);
        $this->assign('projects',      $projects);
        $this->assign('childProjects', $childProjects);

        $this->display();
    }
    
    /* 维护团队成员。*/
    public function manageMembers($projectID = 0)
    {
        $browseProjectLink = $this->createLink('project', 'browse', "projectID=$projectID");
        if(!empty($_POST))
        {
            $this->project->manageMembers($projectID);
            $this->locate($browseProjectLink);
            exit;
        }
        $this->loadModel('user');

        $project = $this->project->findById($projectID);
        $users   = $this->user->getPairs($this->app->company->id, 'noclosed');
        $users   = array('' => '') + $users;
        $members = $this->project->getTeamMembers($projectID);

        $header['title'] = $this->lang->project->manageMembers . $this->lang->colon . $project->name;
        $position[]      = html::a($browseProjectLink, $project->name);
        $position[]      = $this->lang->project->manageMembers;
        $this->assign('header',   $header);
        $this->assign('position', $position);

        $this->assign('project', $project);
        $this->assign('users',   $users);
        $this->assign('members', $members);
        $this->display();
    }

    /* 移除一个成员。*/
    public function unlinkMember($projectID, $account, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->project->confirmUnlinkMember, $this->createLink('project', 'unlinkMember', "projectID=$projectID&account=$account&confirm=yes"));
            exit;
        }
        else
        {
            $this->project->unlinkMember($projectID, $account);
            echo js::locate($this->createLink('project', 'browse', "projectID=$projectID"), 'parent');
            exit;
        }
    }

    /* 关联需求。*/
    public function linkStory($projectID = 0)
    {
        /* 获得项目和相关产品信息。如果没有相关产品，则跳转到产品关联页面。*/
        $project    = $this->project->findById($projectID);
        $products   = $this->project->getProducts($projectID);
        $browseLink = $this->createLink('project', 'story', "projectID=$projectID");

        if(empty($products))
        {
            echo js::alert($this->lang->project->errorNoLinkedProducts);
            die(js::locate($this->createLink('project', 'manageproducts', "projectID=$projectID")));
        }

        /* 更新数据库。*/
        if(!empty($_POST))
        {
            $this->project->linkStory($projectID);
            die(js::locate($browseLink, 'parent'));
            exit;
        }

        /* 加载数据。*/
        $this->loadModel('story');

        $header['title'] = $project->name . $this->lang->colon . $this->lang->project->linkStory;
        $position[]      = html::a($browseLink, $project->name);
        $position[]      = $this->lang->project->linkStory;

        $allStories = $this->story->getProductStories(array_keys($products));
        $prjStories = $this->story->getProjectStoryPairs($projectID);

        $this->assign('header',     $header);
        $this->assign('position',   $position);
        $this->assign('project',    $project);
        $this->assign('products',   $products);
        $this->assign('allStories', $allStories);
        $this->assign('prjStories', $prjStories);
        $this->display();
    }

    /* 移除一个需求。*/
    public function unlinkStory($projectID, $storyID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->project->confirmUnlinkStory, $this->createLink('project', 'unlinkstory', "projectID=$projectID&storyID=$storyID&confirm=yes"));
            exit;
        }
        else
        {
            $this->project->unlinkStory($projectID, $storyID);
            echo js::locate($this->app->session->storyList, 'parent');
            exit;
        }
    }
}

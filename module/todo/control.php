<?php
/**
 * The control file of todo module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 青岛易软天创网络科技有限公司(www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     todo
 * @version     $Id$
 * @link        http://www.zentaoms.com
 */
class todo extends control
{
    /* 构造函数。*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('task');
        $this->loadModel('bug');
        $this->loadModel('my')->setMenu();
    }

    /* 添加todo。*/
    public function create($date = 'today', $account = '')
    {
        if($date == 'today') $date = $this->todo->today();
        if($account == '')   $account = $this->app->user->account;
        if(!empty($_POST))
        {
            $todoID = $this->todo->create($date, $account);
            if(dao::isError()) die(js::error(dao::getError()));
            $this->loadModel('action')->create('todo', $todoID, 'opened');
            die(js::locate($this->createLink('my', 'todo', "date=$_POST[date]"), 'parent'));
        }

        $header['title'] = $this->lang->my->common . $this->lang->colon . $this->lang->todo->create;
        $position[]      = $this->lang->todo->create;

        $this->view->header   = $header;
        $this->view->position = $position;
        $this->view->dates    = $this->todo->buildDateList(0, $this->config->todo->dates->end);
        $this->view->date     = $date;
        $this->view->times    = $this->todo->buildTimeList();
        $this->view->time     = $this->todo->now();
        $this->display();
    }

    /* 编辑todo。*/
    public function edit($todoID)
    {
        if(!empty($_POST))
        {
            $changes = $this->todo->update($todoID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($changes)
            {
                $actionID = $this->loadModel('action')->create('todo', $todoID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }
            die(js::locate(inlink('view', "todoID=$todoID"), 'parent'));
        }

        /* 获取todo信息，判断是否是私人事务。*/
        $todo = $this->todo->getById($todoID);
        if($todo->private and $this->app->user->account != $todo->account) die('private');

        $header['title'] = $this->lang->my->common . $this->lang->colon . $this->lang->todo->edit;
        $position[]      = $this->lang->todo->edit;

        $this->view->header   = $header;
        $this->view->position = $position;
        $this->view->dates    = $this->todo->buildDateList();
        $this->view->times    = $this->todo->buildTimeList();
        $this->view->todo     = $todo;
        $this->display();
    }

    /* 查看todo。*/
    public function view($todoID, $from = 'company')
    {
        $todo = $this->todo->getById($todoID);
        if(!$todo) die(js::error($this->lang->notFound) . js::locate('back'));

        /* 登记session。*/
        $this->session->set('taskList', $this->app->getURI(true));
        $this->session->set('bugList',  $this->app->getURI(true));

        $this->lang->todo->menu = $this->lang->user->menu;
        $this->loadModel('user')->setMenu($this->user->getPairs(), $todo->account);
        $this->lang->set('menugroup.todo', $from);

        $this->view->header->title = $this->lang->todo->view;
        $this->view->position[]    = $this->lang->todo->view;
        $this->view->todo          = $todo;
        $this->view->times         = $this->todo->buildTimeList();
        $this->view->actions       = $this->loadModel('action')->getList('todo', $todoID);
        $this->view->from          = $from;

        $this->display();
    }

    /* 删除一个todo。*/
    public function delete($todoID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->todo->confirmDelete, $this->createLink('todo', 'delete', "todoID=$todoID&confirm=yes"));
            exit;
        }
        else
        {
            $this->dao->delete()->from(TABLE_TODO)->where('id')->eq($todoID)->exec();
            $this->loadModel('action')->create('todo', $todoID, 'erased');
            die(js::locate($this->session->todoList, 'parent'));
        }
    }

    /* 切换todo的状态。*/
    public function mark($todoID, $status)
    {
        $this->todo->mark($todoID, $status);
        $todo = $this->todo->getById($todoID);
        if($todo->status == 'done')
        {
            if($todo->type == 'bug' or $todo->type == 'task')
            {
                $confirmNote = 'confirm' . ucfirst($todo->type);
                $confirmURL  = $this->createLink($todo->type, 'view', "id=$todo->idvalue");
                $cancelURL   = $this->server->HTTP_REFERER;
                die(js::confirm(sprintf($this->lang->todo->$confirmNote, $todo->idvalue), $confirmURL, $cancelURL, 'parent', 'parent'));
            }
        }
        die(js::reload('parent'));
    }

    /* 批量导入今天。*/
    public function import2Today()
    {
        $todos = $this->post->todos;
        $today = $this->todo->today();
        $this->dao->update(TABLE_TODO)->set('date')->eq($today)->where('id')->in($todos)->exec();
        die(js::reload('parent'));
    }
}

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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     todo
 * @version     $Id$
 * @link        http://www.zentao.cn
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
            $this->todo->create($date, $account);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('my', 'todo', "date=$_POST[date]"), 'parent'));
        }

        $header['title'] = $this->lang->my->common . $this->lang->colon . $this->lang->todo->create;
        $position[]      = $this->lang->todo->create;

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('dates',    $this->todo->buildDateList(0, 3));
        $this->assign('date',     $date);
        $this->assign('times',    $this->todo->buildTimeList());
        $this->assign('time',     $this->todo->now());
        $this->display();
    }

    /* 编辑todo。*/
    public function edit($todoID)
    {
        if(!empty($_POST))
        {
            $this->todo->update($todoID);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('my', 'todo', "date=$_POST[date]"), 'parent'));
        }

        /* 获取todo信息，判断是否是私人事务。*/
        $todo = $this->todo->getById($todoID);
        if($todo->private and $this->app->user->account != $todo->account) die('private');

        $header['title'] = $this->lang->my->common . $this->lang->colon . $this->lang->todo->edit;
        $position[]      = $this->lang->todo->edit;

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('dates',    $this->todo->buildDateList());
        $this->assign('times',    $this->todo->buildTimeList());
        $this->assign('todo',     $todo);
        $this->display();
    }

    /* 查看todo。*/
    public function view($todoID)
    {
        $todo = $this->todo->getById($todoID);
        $this->lang->todo->menu = $this->lang->user->menu;
        $this->loadModel('user')->setMenu($this->user->getPairs(), $todo->account);
        $this->lang->set('menugroup.todo', 'company');

        $this->view->header->title = $this->lang->todo->view;
        $this->view->position[]    = $this->lang->todo->view;
        $this->view->todo          = $todo;
        $this->view->times         = $this->todo->buildTimeList();

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
            $todo = $this->todo->getById($todoID);
            $this->todo->delete($todoID);
            echo js::locate($this->createLink('my', 'todo', "date={$todo->date}"), 'parent');
            exit;
        }
    }

    /* 切换todo的状态。*/
    public function mark($todoID, $status)
    {
        $this->todo->mark($todoID, $status);
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

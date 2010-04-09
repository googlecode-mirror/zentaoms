<?php
/**
 * The control file of user module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     user
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class user extends control
{
    private $referer;

    /* ���캯����*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('admin');
        $this->loadModel('dept');
    }

    public function view($account)
    {
        $this->locate($this->createLink('user', 'todo', "account=$account"));
    }

    /* �û���todo�б�*/
    public function todo($account, $type = 'today', $status = 'all')
    {
        /* ����todo model��*/
        $this->loadModel('todo');
        $this->lang->set('menugroup.user', 'company');
        $user = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();

        /* ���ò˵���*/
        $this->user->setMenu($this->user->getPairs('noempty|noclosed'), $account);

        $todos = $this->todo->getList($type, $account, $status);
        $date  = (int)$type == 0 ? $this->todo->today() : $type;

        /* �趨header��position��Ϣ��*/
        $header['title'] = $this->lang->company->orgView . $this->lang->colon . $this->lang->user->todo;
        $position[]      = $this->lang->user->todo;

        /* ��ֵ��*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('tabID',    'todo');
        $this->assign('dates',    $this->todo->buildDateList()); 
        $this->assign('date',     $date);
        $this->assign('todos',    $todos);
        $this->assign('user',     $user);
        $this->assign('account',  $account);
        $this->assign('type',     $type);

        $this->display();
    }

    /* �û���task�б�*/
    public function task($account)
    {
        $this->session->set('taskList', $this->app->getURI(true));

        /* ����task model��*/
        $this->loadModel('task');
        $this->lang->set('menugroup.user', 'company');
        $user = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();

        /* ���ò˵���*/
        $this->user->setMenu($this->user->getPairs('noempty|noclosed'), $account);
 
        /* �趨header��position��Ϣ��*/
        $header['title'] = $this->lang->user->common . $this->lang->colon . $this->lang->user->task;
        $position[]      = $this->lang->user->task;

        /* ��ֵ��*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('tabID',    'task');
        $this->assign('tasks',    $this->task->getUserTasks($account));
        $this->assign('user',     $this->dao->findByAccount($account)->from(TABLE_USER)->fetch());

        $this->display();
    }

    /* �û���bug�б�*/
    public function bug($account)
    {
        $this->session->set('bugList', $this->app->getURI(true));

        /* ����bug model��*/
        $this->loadModel('bug');
        $this->lang->set('menugroup.user', 'company');
        $user = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();

        /* ���ò˵���*/
        $this->user->setMenu($this->user->getPairs('noempty|noclosed'), $account);
 
        /* �趨header��position��Ϣ��*/
        $header['title'] = $this->lang->user->common . $this->lang->colon . $this->lang->user->bug;
        $position[]      = $this->lang->user->bug;

        /* ��ֵ��*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('tabID',    'bug');
        $this->assign('bugs',     $this->user->getBugs($account));
        $this->assign('user',     $this->dao->findByAccount($account)->from(TABLE_USER)->fetch());

        $this->display();
    }

    /* �û���project�б�*/
    public function project($account)
    {
        /* ����project model��*/
        $this->loadModel('project');
        $this->lang->set('menugroup.user', 'company');
        $user = $this->dao->findByAccount($account)->from(TABLE_USER)->fetch();

        /* ���ò˵���*/
        $this->user->setMenu($this->user->getPairs('noempty|noclosed'), $account);

        /* �趨header��position��Ϣ��*/
        $header['title'] = $this->lang->user->common . $this->lang->colon . $this->lang->user->project;
        $position[]      = $this->lang->user->project;

        /* ��ֵ��*/
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('tabID',    'project');
        $this->assign('projects', $this->user->getProjects($account));
        $this->assign('user',     $this->dao->findByAccount($account)->from(TABLE_USER)->fetch());

        $this->display();
    }

    /* �鿴���˵�����*/
    public function profile($account)
    {
        $header['title'] = $this->lang->user->common . $this->lang->colon . $this->lang->user->profile;
        $position[]      = $this->lang->user->profile;

        /* ���ò˵���*/
        $this->user->setMenu($this->user->getPairs('noempty|noclosed'), $account);

        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('user',     $this->user->getById($account));

        $this->display();
    }

    /* ����referer��Ϣ��*/
    private function setReferer($referer = 0)
    {
        if(!empty($referer))
        {
            $this->referer = helper::safe64Decode($referer);
        }
        else
        {
            $this->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        }
    }

    /* ����һ���û���*/
    public function create($deptID = 0, $from = 'admin')
    {
        $this->lang->set('menugroup.user', $from);
        $this->lang->user->menu = $this->lang->company->menu;

        if(!empty($_POST))
        {
            $this->user->create();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('company', 'browse'), 'parent'));
        }

        $header['title'] = $this->lang->admin->common . $this->lang->colon . $this->lang->user->create;
        $position[]      = html::a($this->createLink('admin', 'browseuser') , $this->lang->admin->user);
        $position[]      = $this->lang->user->create;
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('depts',    $this->dept->getOptionMenu());
        $this->assign('deptID',   $deptID);

        $this->display();
    }

    /* �༭һ���û���*/
    public function edit($userID, $from = 'admin')
    {
        $this->lang->set('menugroup.user', $from);
        $this->lang->user->menu = $this->lang->company->menu;
        if(!empty($_POST))
        {
            $this->user->update($userID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($from == 'admin')
            {
                die(js::locate($this->createLink('admin', 'browseuser'), 'parent'));
            }
            else
            {
                die(js::locate($this->createLink('company', 'browse'), 'parent'));
            }
        }

        $header['title'] = $this->lang->admin->common . $this->lang->colon . $this->lang->user->edit;
        $position[]      = $this->lang->user->edit;
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('user',     $this->user->getById($userID));
        $this->assign('depts',    $this->dept->getOptionMenu());

        $this->display();
    }

    /* ɾ��һ���û���*/
    public function delete($userID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->user->confirmDelete, $this->createLink('user', 'delete', "userID=$userID&confirm=yes")));
        }
        else
        {
            $this->user->delete($userID);
            die(js::locate($this->createLink('company', 'browse'), 'parent'));
        }
    }

    /* ����һ���û���*/
    public function activate($userID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->user->confirmActivate, $this->createLink('user', 'activate', "userID=$userID&confirm=yes")));
        }
        else
        {
            $this->user->activate($userID);
            die(js::locate($this->createLink('company', 'browse'), 'parent'));
        }
    }

    /**
     * ��½ϵͳ������û������֤����ȡ����Ȩ��
     * 
     * @access public
     * @return void
     */
    public function login($referer = '')
    {
        $this->setReferer($referer);

        $loginLink = $this->createLink('user', 'login');
        $denyLink  = $this->createLink('user', 'deny');

        /* ����û��Ѿ���¼������ԭ����ҳ�档*/
        if($this->user->isLogon())
        {
            if(strpos($this->referer, $loginLink) === false and 
               strpos($this->referer, $denyLink)  === false and 
               strpos($this->referer, $this->app->company->pms) !== false
            )
            {
                $this->locate($this->referer);
            }
            else
            {
                $this->locate($this->createLink($this->config->default->module));
            }
        }

        /* �û��ύ�˵�½��Ϣ�������û�����ݡ�*/
        if(!empty($_POST))
        {
            $user = $this->user->identify($this->post->account, $this->post->password);
            if($user)
            {
                /* ���û�������Ȩ�����Ǽ�session��*/
                $user->rights = $this->user->authorize($this->post->account);
                $this->session->set('user', $user);
                $this->app->user = $this->session->user;

                /* ��¼��¼��¼��*/
                $this->loadModel('action')->create('user', $user->id, 'login');

                /* POST������������referer��Ϣ���ҷ�user/login.html, ��user/deny.html�����Ұ�����ǰϵͳ��������*/
                if(isset($_POST['referer'])  and 
                   !empty($_POST['referer']) and 
                   strpos($_POST['referer'], $loginLink) === false and 
                   strpos($_POST['referer'], $denyLink)  === false and 
                   strpos($_POST['referer'], $this->app->company->pms) !== false
                )
                {
                    $this->locate($_POST['referer']);
                }
                else
                {
                    $this->locate($this->createLink($this->config->default->module));
                }
            }
            else
            {
                $this->locate($this->createLink('user', 'login'));
            }
        }
        else
        {
            $header['title'] = $this->lang->user->login;
            $this->assign('header',  $header);
            $this->assign('referer', $this->referer);
            $this->display();
        }
    }

    /* ��������ҳ�档*/
    public function deny($module, $method, $refererBeforeDeny = '')
    {
        $this->setReferer();
        $header['title'] = $this->lang->user->deny;
        $this->assign('header',   $header);
        $this->assign('module',   $module);
        $this->assign('method',   $method);
        $this->assign('denyPage', $this->referer);                 // �������޵�ҳ�档
        $this->assign('refererBeforeDeny', $refererBeforeDeny);    // ����ҳ��֮ǰ��refererҳ�档
        $this->app->loadLang($module);
        $this->app->loadLang('index');
        $this->display();
    }

    /**
     * �˳�ϵͳ��
     * 
     * @access public
     * @return void
     */
    public function logout($referer = 0)
    {
        $this->loadModel('action')->create('user', $this->app->user->id, 'logout');
        session_destroy();
        $vars = !empty($referer) ? "referer=$referer" : '';
        $this->locate($this->createLink('user', 'login', $vars));
    }
}

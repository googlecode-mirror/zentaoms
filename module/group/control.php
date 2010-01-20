<?php
/**
 * The control file of group module of ZenTaoMS.
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
 * @package     group
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class group extends control
{
    /* 构造函数。*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('admin');
        $this->loadModel('user');
    }

    /* 分组列表。*/
    public function browse($companyID = 0)
    {
        if($companyID == 0) $companyID = $this->app->company->id;

        $header['title'] = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->browse;
        $position[]      = $this->lang->group->browse;

        $groups     = $this->group->getList($companyID);
        $groupUsers = array();
        foreach($groups as $group) $groupUsers[$group->id] = $this->group->getUserPairs($group->id);

        $this->assign('header',     $header);
        $this->assign('position',   $position);
        $this->assign('groups',     $groups);
        $this->assign('groupUsers', $groupUsers);

        $this->display();
    }

    /* 创建一个用户组。*/
    public function create($companyID = 0)
    {
        if($companyID == 0) $companyID = $this->app->company->id;
        if(!empty($_POST))
        {
            $this->group->create($companyID);
            die(js::locate($this->createLink('group', 'browse'), 'parent'));
        }

        $header['title'] = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->create;
        $position[]      = $this->lang->group->create;
        $this->assign('header',   $header);
        $this->assign('position', $position);

        $this->display();
    }

    /* 编辑一个用户。*/
    public function edit($groupID)
    {
       if(!empty($_POST))
        {
            $this->group->update($groupID);
            die(js::locate($this->createLink('group', 'browse'), 'parent'));
        }

        $header['title'] = $this->lang->company->orgView . $this->lang->colon . $this->lang->group->edit;
        $position[]      = $this->lang->group->edit;
        $this->assign('header',   $header);
        $this->assign('position', $position);
        $this->assign('group',    $this->group->getById($groupID));

        $this->display();
    }

    /* 维护权限。*/
    public function managePriv($groupID)
    {
        if(!empty($_POST))
        {
            $this->group->updatePriv($groupID);
            die(js::alert($this->lang->group->successSaved));
        }

        $group      = $this->group->getById($groupID);
        $groupPrivs = $this->group->getPrivs($groupID);

        $this->view->header->title = $this->lang->company->common . $this->lang->colon . $group->name . $this->lang->colon . $this->lang->group->managePriv;
        $this->view->position[]    = html::a($this->createLink('admin', 'browsegroup', "companyid={$this->app->company->id}"), $this->lang->admin->group);
        $this->view->position[]    = $group->name . $this->lang->colon . $this->lang->group->managePriv;

        $this->view->group      = $group;
        $this->view->groupPrivs = $groupPrivs;

        /* 加载每一个模块的语言文件。*/
        foreach($this->lang->resource as $moduleName => $action) $this->app->loadLang($moduleName);
        $this->display();
    }

    /* 维护用户。*/
    public function manageMember($groupID)
    {
        if(!empty($_POST))
        {
            $this->group->updateUser($groupID);
            die(js::locate($this->createLink('group', 'browse'), 'parent'));
        }
        $group      = $this->group->getById($groupID);
        $groupUsers = $this->group->getUserPairs($groupID);
        $groupUsers = join(',', array_keys($groupUsers));
        $allUsers   = $this->user->getPairs('noclosed|noempty|noletter');

        $header['title'] = $this->lang->admin->common . $this->lang->colon . $group->name . $this->lang->colon . $this->lang->group->manageMember;
        $position[]      = html::a($this->createLink('admin', 'browsegroup', "companyid={$this->app->company->id}"), $this->lang->admin->group);
        $position[]      = $group->name . $this->lang->colon . $this->lang->group->manageMember;

        $this->assign('header',     $header);
        $this->assign('position',   $position);
        $this->assign('group',      $group);
        $this->assign('groupUsers', $groupUsers);
        $this->assign('allUsers',   $allUsers);

        $this->display();
    }

    /* 删除一个分组。*/
    public function delete($groupID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->group->confirmDelete, $this->createLink('group', 'delete', "groupID=$groupID&confirm=yes")));
        }
        else
        {
            $this->group->delete($groupID);
            die(js::locate($this->createLink('group', 'browse'), 'parent'));
        }
    }
}

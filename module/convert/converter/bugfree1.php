<?php
/**
 * The model file of bugfree version 1 convert of ZenTaoMS.
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
 * @package     convert
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class bugfree1ConvertModel extends bugfreeConvertModel
{
    /* ִ��ת����*/
    public function execute()
    {
        $this->clear();
        $this->convertGroup();
        $result['users']    = $this->convertUser();
        $result['projects'] = $this->convertProject();
        $result['modules']  = $this->convertModule();
        $result['bugs']     = $this->convertBug();
        $result['actions']  = $this->convertAction();
        $result['files']    = $this->convertFile();
        $this->loadModel('tree')->fixModulePath();
        return $result;
    }

    /* ת���û����顣*/
    public function convertGroup()
    {
        $groups = $this->dao->dbh($this->sourceDBH)
            ->select("{$this->app->company->id} AS company, groupID AS id, groupName AS name, groupUser AS users")
            ->from('BugGroup')
            ->fetchAll('id');
        foreach($groups as $groupID => $group)
        {
            /* �������û���ֳ����顣*/
            $groupUsers = explode(',', $group->users);
            unset($group->id);
            unset($group->users);

            /* ���뵽group���С�*/
            $this->dao->dbh($this->dbh)->insert(TABLE_GROUP)->data($group)->exec();
            $zentaoGroupID = $this->dao->lastInsertId();

            /* �����˻���group�Ķ�Ӧ��ϵ��*/
            foreach($groupUsers as $account)
            {
                if(empty($account)) continue;
                $this->dao->dbh($this->dbh)->insert(TABLE_USERGROUP)->set('`group`')->eq($zentaoGroupID)->set('account')->eq($account)->exec();
            }
        }
    }

    /* ת���û���*/
    public function convertUser()
    {
        /* ��ѯ��ǰϵͳ�д��ڵ��û���*/
        $activeUsers = $this->dao
            ->dbh($this->sourceDBH)
            ->select("{$this->app->company->id} AS company, username AS account, userpassword AS password, realname, email")
            ->from('BugUser')
            ->orderBy('userID ASC')
            ->fetchAll('account');

        /* �����������ֹ����û���*/
        $allUsers = $this->dao->select("distinct(username) AS account")->from('BugHistory')->fetchPairs();

        /* �ϲ����ߡ�*/
        foreach($allUsers as $key => $account)
        {
            if(isset($activeUsers[$account])) 
            {
                $allUsers[$key] = $activeUsers[$account];
            }
            else
            {
                $allUsers[$key] = array('company' => $this->app->company->id, 'account' => $account, 'realname' => $account, 'status' => 'delete');
            }
        }
        foreach($activeUsers as $account => $user) if(!isset($allUsers[$account])) $allUsers[$account] = $user;

        /* ���뵽zentao���ݿ��С�*/
        $convertCount = 0;
        foreach($allUsers as $account => $user)
        {
            if(!$this->dao->dbh($this->dbh)->findByAccount($account)->from(TABLE_USER)->fetch('account'))
            {
                $this->dao->dbh($this->dbh)->insert(TABLE_USER)->data($user)->exec();
                $convertCount ++;
            }
            else
            {
                self::$info['users'][] = sprintf($this->lang->convert->errorUserExists, $account);
            }
        }
        return $convertCount;
    }

    /* ת����ĿΪ��Ʒ��*/
    public function convertProject()
    {
        $projects = $this->dao->dbh($this->sourceDBH)->select("projectID AS id, projectName AS name, {$this->app->company->id} AS company")->from('BugProject')->fetchAll('id');
        foreach($projects as $projectID => $project)
        {
            unset($project->id);
            $this->dao->dbh($this->dbh)->insert(TABLE_PRODUCT)->data($project)->exec();
            $this->map['product'][$projectID] = $this->dao->lastInsertID();
        }
        return count($projects);
    }

    /* ת��ԭ����ģ��ΪBug��ͼģ�顣*/
    public function convertModule()
    {
        $this->map['module'][0] = 0;
        $modules = $this->dao
            ->dbh($this->sourceDBH)
            ->select(
                'moduleID AS id, 
                projectID AS product, 
                moduleName AS name, 
                moduleGrade AS grade, 
                parentID AS parent, 
                "bug" AS view')
            ->from('BugModule')
            ->orderBy('id ASC')
            ->fetchAll('id');
        foreach($modules as $moduleID => $module)
        {
            $module->product = $this->map['product'][$module->product];
            unset($module->id);
            $this->dao->dbh($this->dbh)->insert(TABLE_MODULE)->data($module)->exec();
            $this->map['module'][$moduleID] = $this->dao->lastInsertID();
        }

        /* ����parent��*/
        foreach($modules as $oldModuleID => $module)
        {
            $newModuleID = $this->map['module'][$oldModuleID];
            $newParentID = $this->map['module'][$module->parent];
            $this->dao->dbh($this->dbh)->update(TABLE_MODULE)->set('parent')->eq($newParentID)->where('id')->eq($newModuleID)->exec();
        }
        return count($modules);
    }

    /* ת��Bug��*/
    public function convertBug()
    {
        $bugs = $this->dao
            ->dbh($this->sourceDBH)
            ->select('
            bugID AS id, 
            projectID AS product, 
            moduleID AS module,
            bugTitle AS title,
            bugSeverity AS severity,
            bugType AS type,
            bugOS AS os,
            bugStatus AS status,
            mailto,
            openedBy, openedDate, openedBuild,
            assignedTo, assignedDate,
            resolvedBy, resolution, resolvedBuild, resolvedDate,
            closedBy, closedDate,
            lastEditedBy, lastEditedDate,
            linkID as duplicateBug
            ')
            ->from('BugInfo')
            ->orderBy('bugID')
            ->fetchAll('id');
        foreach($bugs as $bugID => $bug)
        {
            /* ����Bug���ݡ�*/
            $bugID = (int)$bugID;
            unset($bug->id);
            if($bug->assignedTo == 'Closed') $bug->assignedTo = 'closed';
            $bug->type       = strtolower($bug->type);
            $bug->os         = strtolower($bug->os);
            $bug->browser    = 'all';
            $bug->resolution = str_replace(' ','', strtolower($bug->resolution));
            $bug->product    = $this->map['product'][$bug->product];
            $bug->module     = $this->map['module'][$bug->module];
            $this->dao->dbh($this->dbh)->insert(TABLE_BUG)->data($bug)->exec();
            $this->map['bug'][$bugID] = $this->dao->lastInsertID();
        }

        /* ����duplicateBug�� */
        foreach($this->map['bug'] as $oldBugID => $newBugID)
        {
            $this->dao->dbh($this->dbh)->update(TABLE_BUG)->set('duplicateBug')->eq($newBugID)->where('duplicateBug')->eq($oldBugID)->exec();
        }
        return count($bugs);
    }

    /* ת����ʷ��¼��*/
    public function convertAction()
    {
        $actions = $this->dao
            ->dbh($this->sourceDBH)
            ->select(
                "{$this->app->company->id} AS company, 
                'bug' AS objectType, 
                bugID AS objectID, 
                userName AS actor, 
                action, 
                fullInfo AS comment, 
                actionDate AS date")
            ->from('BugHistory')
            ->orderBy('bugID, historyID')
            ->fetchGroup('objectID');
        $convertCount = 0;
        foreach($actions as $bugID => $bugActions)
        {
            /* ���ת��֮���bugID��*/
            $bugID       = (int)$bugID;
            $zentaoBugID = $this->map['bug'][$bugID];

            /* ����action��*/
            foreach($bugActions as $key => $action)
            {
                $action->objectID = $zentaoBugID;
                if($key == 0)
                {
                    $this->dao->dbh($this->dbh)->update(TABLE_BUG)->set('steps')->eq($action->comment)->where('id')->eq($zentaoBugID)->exec();
                    $action->comment = '';
                }
                $this->dao->dbh($this->dbh)->insert(TABLE_ACTION)->data($action)->exec();
                $convertCount ++;
            }
        }
        return $convertCount;
    }

    /* ת��������*/
    public function convertFile()
    {
        $this->setPath();
        $files = $this->dao->dbh($this->sourceDBH)
            ->select(
                "{$this->app->company->id} AS company, 
                fileName AS pathname,
                fileTitle AS title,
                fileType AS extension,
                fileSize AS size,
                'bug' AS objectType,
                bugID AS objectID,
                addUser AS addedBy,
                addDate AS addedDate
                ")
            ->from('BugFile')
            ->orderBy('fileID')
            ->fetchAll();
        foreach($files as $file)
        {
            $file->objectID = $this->map['bug'][(int)$file->objectID];
            if(strpos($file->size, 'KB')) $file->size = (int)(str_replace('KB', '', $file->size) * 1024); 
            if(strpos($file->size, 'MB')) $file->size = (int)(str_replace('MB', '', $file->size) * 1024 * 1024); 
            $this->dao->dbh($this->dbh)->insert(TABLE_FILE)->data($file)->exec();

            /* �����ļ���*/
            $soureFile = $this->filePath . $file->pathname;
            if(!file_exists($soureFile))
            {
                self::$info['files'][] = sprintf($this->lang->convert->errorFileNotExits, $soureFile);
                continue;
            }
            $targetFile = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . $file->pathname;
            $targetPath = dirname($targetFile);
            if(!is_dir($targetPath)) mkdir($targetPath, 0777, true);
            if(!copy($soureFile, $targetFile))
            {
                self::$info['files'][] = sprintf($this->lang->convert->errorCopyFailed, $targetFile);
            }
        }
        return count($files);
    }
}

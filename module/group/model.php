<?php
/**
 * The model file of group module of ZenTaoMS.
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
 * @package     group
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class groupModel extends model
{
    /* 为某一个公司添加分组。*/
    public function create()
    {
        $group = fixer::input('post')
            ->setDefault('company', $this->app->company->id)
            ->specialChars('name, desc')
            ->get();
        return $this->dao->insert(TABLE_GROUP)->data($group)->batchCheck($this->config->group->create->requiredFields, 'notempty')->exec();
    }

    /* 更新某一个分组信息。*/
    public function update($groupID)
    {
        extract($_POST);
        $sql = "UPDATE " . TABLE_GROUP . " SET `name` = '$name', `desc` = '$desc' WHERE id = '$groupID'";
        return $this->dbh->exec($sql);
    }

    /* 复制一个分组。*/
    public function copy($groupID)
    {
        $group = fixer::input('post')
            ->setDefault('company', $this->app->company->id)
            ->specialChars('name, desc')
            ->remove('options')
            ->get();
        $this->dao->insert(TABLE_GROUP)
            ->data($group)
            ->check('name', 'unique')
            ->check('name', 'notempty')
            ->exec();
        if($this->post->options == false) return;
        if(!dao::isError())
        {
            $newGroupID = $this->dao->lastInsertID();
            $options    = join(',', $this->post->options);
            if(strpos($options, 'copyPriv') !== false) $this->copyPriv($groupID, $newGroupID);
            if(strpos($options, 'copyUser') !== false) $this->copyUser($groupID, $newGroupID);
        }
    }

    /* 拷贝权限。*/
    private function copyPriv($fromGroup, $toGroup)
    {
        $privs = $this->dao->findByGroup($fromGroup)->from(TABLE_GROUPPRIV)->fetchAll();
        foreach($privs as $priv)
        {
            $priv->group = $toGroup;
            $this->dao->insert(TABLE_GROUPPRIV)->data($priv)->exec();
        }
    }

    /* 拷贝用户。*/
    private function copyUser($fromGroup, $toGroup)
    {
        $users = $this->dao->findByGroup($fromGroup)->from(TABLE_USERGROUP)->fetchAll();
        foreach($users as $user)
        {
            $user->group = $toGroup;
            $this->dao->insert(TABLE_USERGROUP)->data($user)->exec();
        }
    }

    /* 获取某一个公司的分组列表。*/
    public function getList($companyID)
    {
        return $this->dao->findByCompany($companyID)->from(TABLE_GROUP)->fetchAll();
    }

    /* 获得分组的key => value对。*/
    public function getPairs()
    {
        return $this->dao->findByCompany($this->app->company->id)->fields('id, name')->from(TABLE_GROUP)->fetchPairs();
    }

    /* 通过 id获取某一个分组信息。*/
    public function getByID($groupID)
    {
        $sql = "SELECT * FROM " . TABLE_GROUP . " WHERE id = '$groupID'";
        return $this->dbh->query($sql)->fetch();
    }

    /* 获得分组的权限列表。*/
    public function getPrivs($groupID)
    {
        $privs = array();
        $sql   = "SELECT module, method FROM " . TABLE_GROUPPRIV . " WHERE `group` = '$groupID' ORDER BY module";
        $stmt  = $this->dbh->query($sql);
        while($priv = $stmt->fetch()) $privs[$priv->module][$priv->method] = $priv->method;
        return $privs;
    }
    
    /* 获得分组的用户列表。*/
    public function getUserPairs($groupID)
    {
        return $this->dao->select('t2.account, t2.realname')
            ->from(TABLE_USERGROUP)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
            ->where('`group`')->eq((int)$groupID)
            ->fetchPairs();
    }

    /* 删除一个分组信息。*/
    public function delete($groupID)
    {
        $sqls[] = "DELETE FROM " . TABLE_GROUP     . " WHERE id    = '$groupID'";
        $sqls[] = "DELETE FROM " . TABLE_USERGROUP . " WHERE `group` = '$groupID'";
        $sqls[] = "DELETE FROM " . TABLE_GROUPPRIV . " WHERE `group` = '$groupID'";
        foreach($sqls as $sql) $this->dbh->exec($sql);
    }

    /* 更新权限。*/
    public function updatePriv($groupID)
    {
        $sql = "DELETE FROM " . TABLE_GROUPPRIV . " WHERE `group` = '$groupID'";
        $this->dbh->exec($sql);
        if(empty($_POST['actions'])) return;
        foreach($_POST['actions'] as $moduleName => $moduleActions)
        {
            foreach($moduleActions as $actionName)
            {
                $sql = "INSERT INTO " . TABLE_GROUPPRIV . " VALUES('$groupID', '$moduleName', '$actionName')";
                $this->dbh->exec($sql);
            }
        }
    }

    /* 更新成员。*/
    public function updateUser($groupID)
    {
        $sql = "DELETE FROM " . TABLE_USERGROUP . " WHERE `group` = '$groupID'";
        $this->dbh->exec($sql);
        if(empty($_POST['members'])) return;
        foreach($_POST['members'] as $account)
        {
            $sql = "INSERT INTO " . TABLE_USERGROUP . " VALUES('$account', '$groupID')";
            $this->dbh->exec($sql);
        }
    }
}

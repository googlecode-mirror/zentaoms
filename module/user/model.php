<?php
/**
 * The model file of user module of ZenTaoMS.
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
?>
<?php
class userModel extends model
{
    /* ���ò˵���*/
    public function setMenu($users, $account)
    {
        $methodName = $this->app->getMethodName();
        $selectHtml = html::select('account', $users, $account, "onchange=\"switchAccount(this.value, '$methodName')\"");
        common::setMenuVars($this->lang->user->menu, 'account', $selectHtml);
        common::setMenuVars($this->lang->user->menu, 'todo',    $account);
        common::setMenuVars($this->lang->user->menu, 'task',    $account);
        common::setMenuVars($this->lang->user->menu, 'bug',     $account);
        common::setMenuVars($this->lang->user->menu, 'project', $account);
        common::setMenuVars($this->lang->user->menu, 'profile', $account);
    }

    /* ���ĳһ����˾���û��б�*/
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_USER)->where('deleted')->eq(0)->orderBy('account')->fetchAll();
    }

    /* ���account=>realname���б�params: noletter|noempty|noclosed��*/
    public function getPairs($params = '')
    {
        $users = $this->dao->select('account, realname')->from(TABLE_USER)->orderBy('account')->fetchPairs();
        foreach($users as $account => $realName)
        {
            $firstLetter = ucfirst(substr($account, 0, 1)) . ':';
            if(strpos($params, 'noletter') !== false) $firstLetter =  '';
            $users[$account] =  $firstLetter . ($realName ? $realName : $account);
        }
        if(strpos($params, 'noempty')  === false) $users = array('' => '') + $users;
        if(strpos($params, 'noclosed') === false) $users = $users + array('closed' => 'Closed');
        return $users;
    }

    /* ����û�����ʵ������email��ַ�б�*/
    public function getRealNameAndEmails($users)
    {
        $users = $this->dao->select('account, email, realname')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account');
        if(!$users) return array();
        foreach($users as $account => $user) if($user->realname == '') $user->realname = $account;
        return $users;
    }

    /* ͨ��id��ȡĳһ���û�����Ϣ��*/
    public function getById($userID)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->onCaseOf(is_numeric($userID))->where('id')->eq((int)$userID)->endCase()
            ->onCaseOf(!is_numeric($userID))->where('account')->eq($userID)->endCase()
            ->fetch();
        if(!$user) return false;
        $user->last = date(DT_DATETIME1, $user->last);
        return $user;
    }

    /* ����һ���û���*/
    public function create()
    {
        /* �ȼ�������Ƿ���Ϲ���*/
        if(!$this->checkPassword()) return;

        $user = fixer::input('post')
            ->setDefault('join', '0000-00-00')
            ->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
            ->setIF($this->post->password1 == false, 'password', '')
            ->remove('password1, password2')
            ->get();

        $this->dao->insert(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck($this->config->user->create->requiredFields, 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->exec();
    }

    /* ����һ���û���*/
    public function update($userID)
    {
        /* �ȼ�������Ƿ���Ϲ���*/
        if(!$this->checkPassword()) return;

        /* ���������ļ�飬�������ݿ⡣*/
        $userID = (int)$userID;
        $user = fixer::input('post')
            ->setDefault('join', '0000-00-00')
            ->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
            ->remove('password1, password2')
            ->get();

        $this->dao->update(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck($this->config->user->edit->requiredFields, 'notempty')
            ->check('account', 'unique', "id != '$userID'")
            ->check('account', 'account')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->where('id')->eq((int)$userID)
            ->exec();
    }

    /* ��������Ƿ����Ҫ��*/
    public function checkPassword()
    {
        if($this->post->password1 != false)
        {
            if($this->post->password1 != $this->post->password2) dao::$errors['password'][] = $this->lang->error->passwordsame;
            if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password'][] = $this->lang->error->passwordrule;
        }
        return !dao::isError();
    }
    
    /**
     * ��֤�û�����ݡ�
     * 
     * @param   string $account     �û��˺�
     * @param   string $password    �û�����
     * @access  public
     * @return  object
     */
    public function identify($account, $password)
    {
        $account  = filter_var($account,  FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        if(!$account or !$password) return false;

        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('account')->eq($account)
            ->andWhere('password')->eq(md5($password))
            ->andWhere('deleted')->eq(0)
            ->fetch();
        if($user)
        {
            $ip   = $_SERVER['REMOTE_ADDR'];
            $last = time();
            $this->dao->update(TABLE_USER)->set('visits = visits + 1')->set('ip')->eq($ip)->set('last')->eq($last)->where('account')->eq($account)->exec();
            $user->last = date(DT_DATETIME1, $user->last);
        }
        return $user;
    }

    /**
     * ȡ�ö��û�����Ȩ��
     * 
     * @param   string $account   �û��˺�
     * @access  public
     * @return  array             �����û�Ȩ�޵����顣
     */
    public function authorize($account)
    {
        $account = filter_var($account, FILTER_SANITIZE_STRING);
        if(!$account) return false;

        $rights = array();
        if($account == 'guest')
        {
            $sql = $this->dao->select('module, method')->from(TABLE_GROUP)->alias('t1')->leftJoin(TABLE_GROUPPRIV)->alias('t2')
                ->on('t1.id = t2.group')->where('t1.name')->eq('guest');
        }
        else
        {
            $sql = $this->dao->select('module, method')->from(TABLE_USERGROUP)->alias('t1')->leftJoin(TABLE_GROUPPRIV)->alias('t2')
                ->on('t1.group = t2.group')
                ->where('t1.account')->eq($account);
        }
        $stmt = $sql->query();
        if(!$stmt) return $rights;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $rights[strtolower($row['module'])][strtolower($row['method'])] = true;
        }
        return $rights;
    }

    /* 
    /**
     * �ж��û��Ƿ����ߡ�
     * 
     * @access public
     * @return bool
     */
    public function isLogon()
    {
        return (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['user']->account != 'guest');
    }

    /* ����û������ķ��顣*/
    public function getGroups($account)
    {
        return $this->dao->findByAccount($account)->from(TABLE_USERGROUP)->fields('`group`')->fetchPairs();
    }

    /* ����û��������Ŀ�б�*/
    public function getProjects($account)
    {
        return $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->where('t1.account')->eq($account)
            ->fetchAll();
    }

    /* ����û���Bug�б�*/
    public function getBugs($account)
    {
        return $this->dao->findByAssignedTo($account)->from(TABLE_BUG)->andWhere('deleted')->eq(0)->fetchAll();
    }
}

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
 * @copyright   Copyright: 2009 Chunsheng Wang
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
        $selectHtml = html::select('account', $users, $account, "onchange=switchAccount(this.value)");
        common::setMenuVars($this->lang->user->menu, 'account', $selectHtml);
        common::setMenuVars($this->lang->user->menu, 'todo',    $account);
        common::setMenuVars($this->lang->user->menu, 'task',    $account);
        common::setMenuVars($this->lang->user->menu, 'bug',     $account);
        common::setMenuVars($this->lang->user->menu, 'project', $account);
        common::setMenuVars($this->lang->user->menu, 'profile', $account);
    }

    /* ���ĳһ����˾���û��б�*/
    public function getList($companyID)
    {
        return $this->dao->select('*')->from(TABLE_USER)->where('company')->eq((int)$companyID)->orderBy('account')->fetchAll();
    }

    /* ���account=>realname���б�params: noletter|noempty|noclosed��*/
    public function getPairs($companyID = 0, $params = '')
    {
        if($companyID == 0) $companyID = $this->app->company->id;
        $users = $this->dao->select('account, realname')->from(TABLE_USER)->where('company')->eq((int)$companyID)->orderBy('account')->fetchPairs();
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
        $where = $userID > 0 ? " WHERE id = '$userID'" : " WHERE account = '$userID'";
        $sql = "SELECT * FROM " . TABLE_USER .  $where;
        $user = $this->dbh->query($sql)->fetch();
        if($user) $user->last = date('Y-m-d H:i:s', $user->last);
        return $user;
    }

    /* ����һ���û���*/
    function create($companyID)
    {
        /* �ȼ�������Ƿ���Ϲ���*/
        if(!$this->checkPassword()) return;

        $user = fixer::input('post')
            ->add('company', (int)$companyID)
            ->setDefault('join', '0000-00-00')
            ->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
            ->setIF($this->post->password1 == false, 'password', '')
            ->remove('password1, password2')
            ->get();

        $this->dao->insert(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck('account, realname, password', 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->exec();
    }

    /* ����һ���û���*/
    function update($userID)
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
            ->batchCheck('account, realname', 'notempty')
            ->check('account', 'unique', "id != '$userID'")
            ->check('account', 'account')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->where('id')->eq((int)$userID)
            ->exec();
    }

    /* ��������Ƿ����Ҫ��*/
    function checkPassword()
    {
        if($this->post->password1 != false)
        {
            if($this->post->password1 != $this->post->password2) dao::$errors['password'][] = $this->lang->error->passwordsame;
            if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password'][] = $this->lang->error->passwordrule;
        }
        return !dao::isError();
    }
    
    /* ɾ��һ���û���*/
    function delete($userID)
    {
        $sql = "DELETE FROM " . TABLE_USER . " WHERE id = '$userID' LIMIT 1";
        return $this->dbh->exec($sql);
    }

    /**
     * ��֤�û�����ݡ�
     * 
     * @param   string $account     �û��˺�
     * @param   string $password    �û�����
     * @access  public
     * @return  object
     */
    public function identify($account, $password, $companyID)
    {
        $account  = filter_var($account,  FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        if(!$account or !$password) return false;

        $sql  = "SELECT * FROM " . TABLE_USER . " WHERE account  = '$account' AND password = md5('$password') AND company  = '$companyID' LIMIT 1";
        $user = $this->dbh->query($sql)->fetch();
        if($user)
        {
            $ip   = $_SERVER['REMOTE_ADDR'];
            $last = time();
            $sql  = "UPDATE " . TABLE_USER . " SET visits = visits + 1, ip = '$ip', last = '$last' WHERE account = '$account'";
            $this->dbh->exec($sql);
            $user->last = date('Y-m-d H:i:s', $user->last);
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
            $sql = "SELECT module, method FROM " . TABLE_GROUP . " AS t1 LEFT JOIN " . TABLE_GROUPPRIV . " AS t2
                    ON t1.id = t2.group
                 WHERE t1.name = 'guest'";
        }
        else
        {
            $sql = "SELECT module, method FROM " . TABLE_USERGROUP . " AS t1 LEFT JOIN " . TABLE_GROUPPRIV . " AS t2
                ON t1.group = t2.group
                WHERE t1.account = '$account'";
        }
        $stmt = $this->dbh->query($sql);
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

    /* ����û��������Ŀ�б�*/
    public function getProjects($account)
    {
        $sql = "SELECT T1.*, T2.* FROM " . TABLE_TEAM . " AS T1 LEFT JOIN " .TABLE_PROJECT . " AS T2 ON T1.project = T2.id WHERE T1.account = '$account'";
        return $this->dbh->query($sql)->fetchAll();
    }

    /* ����û���Bug�б�*/
    public function getBugs($account)
    {
        $sql = "SELECT * FROM " . TABLE_BUG . " WHERE assignedTO = '$account'";
        return $this->dbh->query($sql)->fetchAll();
    }
}

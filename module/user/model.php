<?php
/**
 * The model file of user module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
class userModel extends model
{
    /* 设置菜单。*/
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

    /* 获得某一个公司的用户列表。*/
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_USER)->where('deleted')->eq(0)->orderBy('account')->fetchAll();
    }

    /* 获得account=>realname的列表。params: noletter|noempty|noclosed|nodeleted。*/
    public function getPairs($params = '')
    {
        $users = $this->dao->select('account, realname')->from(TABLE_USER)
            ->beginIF(strpos($params, 'nodeleted') !== false)
            ->where('deleted')->eq(0)
            ->fi()
            ->orderBy('account')->fetchPairs();
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
    
    /* 追加已经删除的用户。*/
    public function setDeleted($users, $deleteds = '')
    {
        $deleteds = explode(',', $deleteds);
        foreach($deleteds as $deleted)
        {
            if(!isset($users[$deleted])) $users[$deleted] = $deleted . $this->lang->user->deleted;
        }
        return $users;
    }

    /* 获得用户的真实姓名和email地址列表。*/
    public function getRealNameAndEmails($users)
    {
        $users = $this->dao->select('account, email, realname')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account');
        if(!$users) return array();
        foreach($users as $account => $user) if($user->realname == '') $user->realname = $account;
        return $users;
    }

    /* 通过id获取某一个用户的信息。*/
    public function getById($userID)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(is_numeric($userID))->where('id')->eq((int)$userID)->fi()
            ->beginIF(!is_numeric($userID))->where('account')->eq($userID)->fi()
            ->fetch();
        if(!$user) return false;
        $user->last = date(DT_DATETIME1, $user->last);
        return $user;
    }

    /* 新增一个用户。*/
    public function create()
    {
        /* 先检查密码是否符合规则。*/
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

    /* 更新一个用户。*/
    public function update($userID)
    {
        /* 先检查密码是否符合规则。*/
        if(!$this->checkPassword()) return;

        /* 进行其他的检查，更新数据库。*/
        $userID = (int)$userID;
        $user = fixer::input('post')
            ->setIF(isset($_POST['join']) and $this->post->join == '', 'join', '0000-00-00')
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

    /* 检查密码是否符合要求。*/
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
     * 验证用户的身份。
     * 
     * @param   string $account     用户账号
     * @param   string $password    用户密码
     * @access  public
     * @return  object
     */
    public function identify($account, $password)
    {
        if(!$account or !$password) return false;

        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('account')->eq($account)
            ->beginIF(strlen($password) != 32)
            ->andWhere('password')->eq(md5($password))
            ->fi()
            ->andWhere('deleted')->eq(0)
            ->fetch();

        /* 密码长度为32位，改用md5 hash方式验证。*/
        if(strlen($password) == 32)
        {
            $hash = $this->session->rand ? md5($user->password . $this->session->rand) : $user->password;
            $user = $password == $hash ? $user : '';
        }

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
     * 取得对用户的授权。
     * 
     * @param   string $account   用户账号
     * @access  public
     * @return  array             包含用户权限的数组。
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
     * 判断用户是否在线。
     * 
     * @access public
     * @return bool
     */
    public function isLogon()
    {
        return (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['user']->account != 'guest');
    }

    /* 获得用户所属的分组。*/
    public function getGroups($account)
    {
        return $this->dao->findByAccount($account)->from(TABLE_USERGROUP)->fields('`group`')->fetchPairs();
    }

    /* 获得用户参与的项目列表。*/
    public function getProjects($account)
    {
        return $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->where('t1.account')->eq($account)
            ->andWhere('t2.deleted')->eq(0)
            ->fetchAll();
    }

    /* 获得用户的Bug列表。*/
    public function getBugs($account)
    {
        return $this->dao->findByAssignedTo($account)->from(TABLE_BUG)->andWhere('deleted')->eq(0)->fetchAll();
    }
}

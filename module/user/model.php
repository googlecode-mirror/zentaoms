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
    /* ���ĳһ����˾���û��б�*/
    public function getList($companyID)
    {
        $sql = "SELECT * FROM " . TABLE_USER . " WHERE company = '$companyID' ORDER BY id";
        return $this->dbh->query($sql)->fetchAll();
    }

    /* ���account=>realname���б�*/
    function getPairs($companyID = 0)
    {
        if($companyID == 0) $companyID = $this->app->company->id;
        return $this->dao->select('account, realname')->from(TABLE_USER)->where('company')->eq((int)$companyID)->fetchPairs();
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
        extract($_POST);
        $sql = "INSERT INTO " . TABLE_USER . "(account, realname, email, gendar, `join`, password, company, dept) 
                VALUES('$account', '$realname', '$email', '$gendar', '$join', MD5('$password'), '$companyID', '$dept')";
        return $this->dbh->query($sql);
    }

    /* ����һ���û���*/
    function update($userID)
    {
        extract($_POST);
        if(empty($password))
        {
            $password = 'password';
        }
        else
        {
            $password = "MD5('$password')";
        }
        $sql = "UPDATE " . TABLE_USER . " SET account = '$account', realname = '$realname', email = '$email', gendar = '$gendar', `join` = '$join', password = $password, dept = '$dept' WHERE id = '$userID' LIMIT 1";
        return $this->dbh->exec($sql);
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

     /* ����û��������б�*/
    public function getTasks($account)
    {
        $sql = "SELECT T1.*, T2.name AS projectName, T2.id AS projectID, T3.id AS storyID, T3.title AS storyTitle FROM " . TABLE_TASK . " AS T1 
                LEFT JOIN " .TABLE_PROJECT . " AS T2 ON T1.project = T2.id 
                LEFT JOIN " . TABLE_STORY  . " AS T3 ON T1.story = T3.id 
                WHERE T1.owner = '$account'";
        return $this->dbh->query($sql)->fetchAll();
    }
    
     /* ����û���Bug�б�*/
    public function getBugs($account)
    {
        $sql = "SELECT * FROM " . TABLE_BUG . " WHERE assignedTO = '$account'";
        return $this->dbh->query($sql)->fetchAll();
    }

    /* ����˻�����Ӧ����ʵ������*/
    public function getRealNames($accounts)
    {
        $sql = "SELECT account, realname FROM " . TABLE_USER . " WHERE account " . helper::dbIN($accounts);
        return $this->fetchPairs($sql);
    }
}

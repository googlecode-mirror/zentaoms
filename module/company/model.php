<?php
/**
 * The model file of company module of ZenTaoMS.
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
 * @package     company
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class companyModel extends model
{
    /* ���ò˵���*/
    public function setMenu($dept = 0)
    {
        common::setMenuVars($this->lang->company->menu, 'addUser', array($this->app->company->id, $dept));
    }

    /* ��ù�˾�б�*/
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_COMPANY)->fetchAll();
    }

    /* ��õ�һ����˾��*/
    public function getFirst()
    {
        return $this->dao->select('*')->from(TABLE_COMPANY)->orderBy('id')->limit(1)->fetch();
    }
    
    /**
     * ͨ���������ҹ�˾��Ϣ��
     * 
     * @param   string  $domain     ���ʵ����������Ϊ�գ���ȡHTTP_HOST������
     * @access  public
     * @return  object
     */
    public function getByDomain($domain = '')
    {
        if(empty($domain)) $domain = $_SERVER['HTTP_HOST'];
        return $this->dao->findByPMS($domain)->from(TABLE_COMPANY)->fetch();
    }

    /* ͨ��id��ȡ��˾��Ϣ��*/
    public function getByID($companyID = '')
    {
        return $this->dao->findById((int)$companyID)->from(TABLE_COMPANY)->fetch();
    }

    /* ����һ����˾��*/
    public function create()
    {
        $company = fixer::input('post')->get();
        $this->dao->insert(TABLE_COMPANY)
            ->data($company)
            ->autoCheck()
            ->batchCheck('name, pms', 'notempty')
            ->batchCheck('name,pms', 'unique')
            ->exec();
    }

    /* ����һ����˾��Ϣ��*/
    public function update($companyID)
    {
        $company = fixer::input('post')->get();
        $this->dao->update(TABLE_COMPANY)
            ->data($company)
            ->autoCheck()
            ->batchCheck('name, pms', 'notempty')
            ->batchCheck('name,pms', 'unique', "id != '$companyID'")
            ->where('id')->eq($companyID)
            ->exec();
    }
    
    /* ɾ��һ����˾��*/
    public function delete($companyID)
    {
        return $this->dao->delete()->from(TABLE_COMPANY)->where('id')->eq((int)$companyID)->limit(1)->exec();
    }
}

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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     company
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class companyModel extends model
{
    /* ��ù�˾�б�*/
    function getList()
    {
        $sql = "SELECT * FROM " . TABLE_COMPANY;
        $stmt = $this->dbh->query($sql);
        return $stmt->fetchAll();
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
        if(empty($domain)) $domain = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $sql  = 'SELECT * FROM ' . TABLE_COMPANY . " WHERE `pms` = '$domain' LIMIT 1";
        return $this->dbh->query($sql)->fetch();
    }

    /* ͨ��id��ȡ��˾��Ϣ��*/
    public function getByID($companyID = '')
    {
        $sql  = 'SELECT * FROM ' . TABLE_COMPANY . " WHERE `id` = '$companyID' LIMIT 1";
        return $this->dbh->query($sql)->fetch();
    }

    /* ����һ����˾��*/
    function create()
    {
        extract($_POST);
        $sql = "INSERT INTO " . TABLE_COMPANY . " (name, phone, fax, address, zipcode, website, backyard, pms, guest) 
                VALUES('$name', '$phone', '$fax', '$address', '$zipcode', '$website', '$backyard', '$pms', '$guest')";
        return $this->dbh->exec($sql);
    }

    /* ����һ����˾��Ϣ��*/
    function update($companyID)
    {
        extract($_POST);
        $sql = "UPDATE " . TABLE_COMPANY . " SET name = '$name', phone = '$phone', fax = '$fax', address = '$address', 
                zipcode = '$zipcode', website = '$website', backyard = '$backyard', pms = '$pms', guest = '$guest' 
                WHERE id = '$companyID' LIMIT 1";
        return $this->dbh->exec($sql);
    }
    
    /* ɾ��һ����˾��*/
    function delete($companyID)
    {
        return $this->dbh->query("DELETE FROM " . TABLE_COMPANY . " WHERE id = '$companyID' LIMIT 1");
    }
}

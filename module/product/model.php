<?php
/**
 * The model file of product module of ZenTaoMS.
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
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class productModel extends model
{
    /* ���ò˵���*/
    public function setMenu($products, $productID)
    {
        $selectHtml = html::select('productID', $products, $productID, "onchange=\"switchProduct(this.value, 'product');\"");
        common::setMenuVars($this->lang->product->menu, 'list',   $selectHtml . $this->lang->arrow);
        common::setMenuVars($this->lang->product->menu, 'story',  $productID);
        common::setMenuVars($this->lang->product->menu, 'edit',   $productID);
        common::setMenuVars($this->lang->product->menu, 'delete', $productID);
        common::setMenuVars($this->lang->product->menu, 'module', $productID);
    }

    /* ͨ��ID��ȡ��Ʒ��Ϣ��*/
    public function findByID($productID)
    {
        return $this->dao->findById($productID)->from(TABLE_PRODUCT)->fetch();
    }

    /* ��ȡ��Ʒ�б�*/
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_PRODUCT)->where('company')->eq($this->app->company->id)->fetchAll('id');
    }

    /* ��ȡ��Ʒid=>name�б�*/
    public function getPairs()
    {
        return $this->dao->select('id,name')->from(TABLE_PRODUCT)->where('company')->eq($this->app->company->id)->fetchPairs();
    }

    /* ������Ʒ��*/
    function create()
    {
        /* �������ݡ�*/
        $product = fixer::input('post')
            ->add('company', $this->app->company->id)
            ->stripTags('name,code')
            ->specialChars('desc')
            ->get();
        $this->dao->insert(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck('name,code', 'notempty')
            ->check('name', 'unique')
            ->check('code', 'unique')
            ->exec();
        return $this->dao->lastInsertID();
    }

    /* ���²�Ʒ��*/
    function update($productID)
    {
        /* �������ݡ�*/
        $productID = (int)$productID;
        $product = fixer::input('post')
            ->stripTags('name,code')
            ->specialChars('desc')
            ->get();
        $this->dao->update(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck('name,code', 'notempty')
            ->check('name', 'unique', "id != $productID")
            ->check('code', 'unique', "id != $productID")
            ->where('id')->eq($productID)
            ->exec();
    }
    
    /* ɾ��ĳһ����Ʒ��*/
    public function delete($productID)
    {
        return $this->dao->delete()->from(TABLE_PRODUCT)->where('id')->eq((int)$productID)->andWhere('company')->eq($this->app->company->id)->limit(1)->exec();
    }

    /* ��ȡ��Ʒ����Ŀid=>value�б�*/
    public function getProjectPairs($productID)
    {
        $projects = $this->dao->select('t2.id, t2.name')
            ->from(TABLE_PROJECTPRODUCT)->alias('t1')->leftJoin(TABLE_PROJECT)->alias('t2')
            ->on('t1.project = t2.id')
            ->where('t1.product')->eq((int)$productID)
            ->orderBy('t1.project desc')
            ->fetchPairs();
        $projects = array('' => '') +  $projects;
        return $projects;
    }
}

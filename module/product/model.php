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
 * @copyright   Copyright 2009-2010 �ൺ�����촴����Ƽ����޹�˾(www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentaoms.com
 */
?>
<?php
class productModel extends model
{
    /* ���ò˵���*/
    public function setMenu($products, $productID, $extra = '')
    {
        /* ��õ�ǰ��ģ��ͷ��������ݸ�switchProduct��������ҳ����תʹ�á�*/
        $currentModule = $this->app->getModuleName();
        $currentMethod = $this->app->getMethodName();

        $selectHtml = html::select('productID', $products, $productID, "onchange=\"switchProduct(this.value, '$currentModule', '$currentMethod', '$extra');\"");
        common::setMenuVars($this->lang->product->menu, 'list',   $selectHtml . $this->lang->arrow);
        common::setMenuVars($this->lang->product->menu, 'story',  $productID);
        common::setMenuVars($this->lang->product->menu, 'plan',   $productID);
        common::setMenuVars($this->lang->product->menu, 'roadmap',$productID);
        common::setMenuVars($this->lang->product->menu, 'release',$productID);
        common::setMenuVars($this->lang->product->menu, 'view',   $productID);
        common::setMenuVars($this->lang->product->menu, 'edit',   $productID);
        common::setMenuVars($this->lang->product->menu, 'delete', $productID);
        common::setMenuVars($this->lang->product->menu, 'module', $productID);
    }

    /* ͨ��ID��ȡ��Ʒ��Ϣ��*/
    public function getById($productID)
    {
        return $this->dao->findById($productID)->from(TABLE_PRODUCT)->fetch();
    }

    /* ��ȡ��Ʒ�б�*/
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->fetchAll('id');
    }

    /* ��ȡ��Ʒid=>name�б�*/
    public function getPairs()
    {
        $mode = $this->cookie->productMode;
        return $this->dao->select('id,name')
            ->from(TABLE_PRODUCT)
            ->where('deleted')->eq(0)
            ->onCaseOf($mode == 'noclosed')->andWhere('status')->ne('closed')->endCase()
            ->fetchPairs();
    }

    /* ��ȡ��Ʒ�ĵ�״̬���顣*/
    public function getStatusGroups()
    {
        $products = $this->dao->select('id, name, status')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->fetchGroup('status');
    }

    /* ������Ʒ��*/
    public function create()
    {
        /* �������ݡ�*/
        $product = fixer::input('post')
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
    public function update($productID)
    {
        /* �������ݡ�*/
        $productID = (int)$productID;
        $oldProduct = $this->getById($productID);
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
        if(!dao::isError()) return common::createChanges($oldProduct, $product);
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

    /* �����Ʒ·��ͼ��*/
    public function getRoadmap($productID)
    {
        $plans    = $this->loadModel('productplan')->getList($productID);
        $releases = $this->loadModel('release')->getList($productID);
        $roadmap  = array();
        if(is_array($releases)) $releases = array_reverse($releases);
        foreach($releases as $release)
        {
            $year = substr($release->date, 0, 4);
            $roadmap[$year][] = $release;
        }
        foreach($plans as $plan)
        {
            if($plan->end != '0000-00-00' and strtotime($plan->end) - time() <= 0) continue;
            $year = substr($plan->end, 0, 4);
            $roadmap[$year][] = $plan;
        }
        arsort($roadmap);
        return $roadmap;
    }
}

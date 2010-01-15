<?php
/**
 * The model file of release module of ZenTaoMS.
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
 * @package     release
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class releaseModel extends model
{
    /* 获取release详细信息。*/
    public function getByID($releaseID)
    {
        return $this->dao->select('t1.*, t2.name as buildName, t3.name as productName')
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_BUILD)->alias('t2')->on('t1.build = t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t1.product = t3.id')
            ->where('t1.id')->eq((int)$releaseID)
            ->orderBy('t1.id DESC')
            ->fetch();
    }

    /* 查找release列表。*/
    public function getList($productID)
    {
        return $this->dao->select('t1.*, t2.name as productName, t3.name as buildName')
            ->from(TABLE_RELEASE)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')->on('t1.product = t2.id')
            ->leftJoin(TABLE_BUILD)->alias('t3')->on('t1.build = t3.id')
            ->where('t1.product')->eq((int)$productID)
            ->orderBy('t1.id DESC')
            ->fetchAll();
    }

    /* 创建。*/
    public function create($productID)
    {
        $release = fixer::input('post')
            ->stripTags('name')
            ->specialChars('desc')
            ->add('product', (int)$productID)
            ->get();
        $this->dao->insert(TABLE_RELEASE)->data($release)->autoCheck()->batchCheck('name,date,build', 'notempty')->exec();
        if(!dao::isError()) return $this->dao->lastInsertID();
    }

    /* 编辑。*/
    public function update($releaseID)
    {
        $release = fixer::input('post')
            ->stripTags('name')
            ->specialChars('desc')
            ->get();
        $this->dao->update(TABLE_RELEASE)->data($release)->autoCheck()->batchCheck('name,date,build', 'notempty')->where('id')->eq((int)$releaseID)->exec();
    }

    /* 删除release。*/
    public function delete($releaseID)
    {
        return $this->dao->delete()->from(TABLE_RELEASE)->where('id')->eq((int)$releaseID)->exec();
    }
}

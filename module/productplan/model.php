<?php
/**
 * The model file of productplan module of ZenTaoMS.
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
 * @package     productplan
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class productplanModel extends model
{
    /* 获取计划信息。*/
    public function getByID($planID)
    {
        return $this->dao->findByID((int)$planID)->from(TABLE_PRODUCTPLAN)->fetch();
    }

    /* 获取列表。*/
    public function getList($product = 0)
    {
        return $this->dao->select('*')->from(TABLE_PRODUCTPLAN)->where('product')->eq($product)->orderBy('begin')->fetchAll();
    }

    /* 获取name=>value的键值对。*/
    public function getPairs($product = 0)
    {
        return array('' => '') + $this->dao->select('id,title')->from(TABLE_PRODUCTPLAN)->where('product')->eq((int)$product)->orderBy('begin')->fetchPairs();
    }

    /* 创建。*/
    public function create($product)
    {
        $plan = fixer::input('post')
            ->stripTags('title')
            ->specialChars('desc')
            ->get();
        $this->dao->insert(TABLE_PRODUCTPLAN)->data($plan)->autoCheck()->batchCheck($this->config->productplan->create->requiredFields, 'notempty')->exec();
        if(!dao::isError()) return $this->dao->lastInsertID();
    }

    /* 编辑。*/
    public function update($planID)
    {
        $plan = fixer::input('post')
            ->stripTags('title')
            ->specialChars('desc')
            ->get();
        $this->dao->update(TABLE_PRODUCTPLAN)->data($plan)->autoCheck()->batchCheck($this->config->productplan->edit->requiredFields, 'notempty')->where('id')->eq((int)$planID)->exec();
    }

    /* 删除计划。*/
    public function delete($planID)
    {
        return $this->dao->delete()->from(TABLE_PRODUCTPLAN)->where('id')->eq((int)$planID)->exec();
    }

    /* 关联需求。*/
    public function linkStory($planID)
    {
        $this->loadModel('story');
        foreach($this->post->stories as $storyID)
        {
            $this->dao->update(TABLE_STORY)->set('plan')->eq((int)$planID)->where('id')->eq((int)$storyID)->exec();
            $this->story->setStage($storyID);
        }        
    }

    /* 移除需求。*/
    public function unlinkStory($storyID)
    {
        $this->dao->update(TABLE_STORY)->set('plan')->eq(0)->where('id')->eq((int)$storyID)->exec();
        $this->loadModel('story')->setStage($storyID);
    }
}

<?php
/**
 * The model file of story module of ZenTaoMS.
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
 * @package     story
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class storyModel extends model
{
    /* 获取某一条需求的信息。*/
    public function findByID($storyID)
    {
        return $this->dao->findById((int)$storyID)->from(TABLE_STORY)->fetch();
    }

    /* 新增需求。*/
    function create()
    {
        $now   = date('Y-m-d H:i:s', time());
        $story = fixer::input('post')
            ->cleanInt('product,module,pri')
            ->cleanFloat('estimate')
            ->stripTags('title')
            ->specialChars('spec')
            ->add('openedBy', $this->app->user->account)
            ->add('openedDate', $now)
            ->add('assignedDate', 0)
            ->setIF($this->post->assignedTo != '', 'assignedDate', $now)
            ->get();
        $this->dao->insert(TABLE_STORY)->data($story)->autoCheck()->check('title', 'notempty')->exec();
        if(!dao::isError()) return $this->dao->lastInsertID();
    }

    /* 更新需求。*/
    function update($storyID)
    {
        $now      = date('Y-m-d H:i:s', time());
        $oldStory = $this->findByID($storyID);
        $story    = fixer::input('post')
            ->cleanInt('product,module,pri')
            ->stripTags('title')
            ->specialChars('spec')
            ->remove('comment')
            ->add('assignedDate', $oldStory->assignedDate)
            ->add('lastEditedBy', $this->app->user->account)
            ->add('lastEditedDate', $now)
            ->setIF($this->post->assignedTo != $oldStory->assignedTo, 'assignedDate', $now)
            ->get();
        $this->dao->update(TABLE_STORY)->data($story)->autoCheck()->check('title', 'notempty')->where('id')->eq((int)$storyID)->exec();
        if(!dao::isError()) return common::createChanges($oldStory, $story);
    }
    
    /* 删除一条需求。*/
    function delete($storyID)
    {
        $this->dao->delete()->from(TABLE_STORY)->where('id')->eq((int)$storyID)->limit(1)->exec();
    }
    
    /* 获得某一个产品某一个模块下面的所有需求列表。*/
    function getProductStories($productID = 0, $moduleIds = 0, $orderBy = 'id|desc', $pager = null)
    {
        $sql = $this->dao->select('*')->from(TABLE_STORY)->where('product')->in($productID);
        if(!empty($moduleIds)) $sql->andWhere('module')->in($moduleIds);
        $stories = $sql->orderBy($orderBy)->page($pager)->fetchAll();
        return $stories;
    }

    /* 获得某一个产品某一个模块下面的所有需求id=>title列表。*/
    function getProductStoryPair($productID = 0, $moduleIds = 0, $order = 'id|desc')
    {
        $where  = $productID > 0 ? " WHERE `product`" . helper::dbIN($productID) : '';
        $where .= !empty($moduleIds) ? " AND module " . helper::dbIN($moduleIds) : '';
        $sql    = "SELECT id, title FROM " . TABLE_STORY . $where . ' ORDER BY ' . str_replace('|', ' ', $order);
        return $this->fetchPairs($sql);
    }

    /* 获得某一个项目相关的所有需求列表。*/
    function getProjectStories($projectID = 0, $orderBy='id|desc', $pager = null)
    {
        return $this->dao->select('t1.*, t2.*')->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
            ->where('t1.project')->eq((int)$projectID)
            ->orderBy($orderBy)
            ->page($pager)->fetchAll();
    }

    /* 获得某一个项目相关的需求id=>title的列表。*/
    function getProjectStoryPair($projectID = 0)
    {
        $stories = $this->dao->select('t2.id, t2.title, t2.module, t3.name AS product')
            ->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')
            ->on('t1.story = t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')
            ->on('t1.product = t3.id')
            ->where('t1.project')->eq((int)$projectID)
            ->fetchAll();

        /* 查找每个story所对应的模块名称。*/
        foreach($stories as $story) $modules[] = $story->module;
        $moduleNames = $this->dao->select('id, name')->from(TABLE_MODULE)->where('id')->in($modules)->fetchPairs();

        /* 重新组织每一个story的展示方式。*/
        $storyPairs = array();
        foreach($stories as $story) $storyPairs[$story->id] = $story->product . '/' . ($story->module > 0 ? $moduleNames[$story->module] . '/' : '') . $story->title;
        return $storyPairs;
    }

    /* 从story列表中提取所有出现过的账户。*/
    public function extractAccountsFromList($stories)
    {
        $accounts = array();
        foreach($stories as $story)
        {
            if(!empty($story->openedBy))     $accounts[] = $story->openedBy;
            if(!empty($story->assignedTo))   $accounts[] = $story->assignedTo;
            if(!empty($story->closedBy))     $accounts[] = $story->closedBy;
            if(!empty($story->lastEditedBy)) $accounts[] = $story->lastEditedBy;
        }
        return array_unique($accounts);
    }

    /* 从一条story中提取所有出现过的账户。*/
    public function extractAccountsFromSingle($story)
    {
        $accounts = array();
        if(!empty($story->openedBy))     $accounts[] = $story->openedBy;
        if(!empty($story->assignedTo))   $accounts[] = $story->assignedTo;
        if(!empty($story->closedBy))     $accounts[] = $story->closedBy;
        if(!empty($story->lastEditedBy)) $accounts[] = $story->lastEditedBy;
        return array_unique($accounts);
    }
}

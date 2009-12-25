<?php
/**
 * The browse view file of product module of ZenTaoMS.
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
<?php include '../../common/header.html.php';?>
<?php include '../../common/treeview.html.php';?>
<script language='Javascript'>
/* 切换浏览方式。*/
function browseByModule()
{
    $('#mainbox').addClass('yui-t7');
    $('#treebox').removeClass('hidden');
    $('#featuremodule').addClass('active');
    $('#featureall').removeClass('active');
}
</script>

<div class='yui-d0'>
  <div id='featurebar'>
    <div class='f-left'>
      <span id='featureall'><?php echo html::a($this->createLink('product', 'browse', "productID=$productID"), $lang->product->allStory);?></span>
      <span id='featuremodule' onclick='browseByModule()'><?php echo $lang->product->moduleStory;?></span>
    </div>
    <div class='f-right'>
      <?php if(common::hasPriv('story', 'create')) echo html::a($this->createLink('story', 'create', "productID=$productID&moduleID=$moduleID"), $lang->story->create); ?>
    </div>
  </div>
</div>

<div class='yui-d0 <?php if($browseType == 'module') echo 'yui-t7';?>' id='mainbox'>
  <div class='yui-b <?php if($browseType != 'module') echo 'hidden';?>' id='treebox'>
    <div class='box-title'><?php echo $productName;?></div>
    <div class='box-content'>
      <?php echo $moduleTree;?>
      <div class='a-right'>
        <?php if(common::hasPriv('product', 'edit'))   echo html::a($this->createLink('product', 'edit',   "productID=$productID"), $lang->edit);?>
        <?php if(common::hasPriv('product', 'delete')) echo html::a($this->createLink('product', 'delete', "productID=$productID&confirm=no"),   $lang->delete, 'hiddenwin');?>
        <?php if(common::hasPriv('tree', 'browse'))    echo html::a($this->createLink('tree',    'browse', "productID=$productID&view=product"), $lang->tree->manage);?>
      </div>
    </div>
  </div>

  <div class="yui-main">
    <div class="yui-b">
      <table class='table-1 fixed'>
        <thead>
          <tr class='colhead'>
            <?php $vars = "productID=$productID&moduleID=$moduleID&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage";?>
            <th><?php common::printOrderLink('id',  $orderBy, $vars, $lang->story->id);?></th>
            <th><?php common::printOrderLink('pri', $orderBy, $vars, $lang->story->pri);?></th>
            <th class='w-p40'><?php common::printOrderLink('title', $orderBy, $vars, $lang->story->title);?></th>
            <th><?php common::printOrderLink('plan',           $orderBy, $vars, $lang->story->plan);?></th>
            <th><?php common::printOrderLink('assignedTo',     $orderBy, $vars, $lang->story->assignedTo);?></th>
            <th><?php common::printOrderLink('openedBy',       $orderBy, $vars, $lang->story->openedBy);?></th>
            <th><?php common::printOrderLink('estimate',       $orderBy, $vars, $lang->story->estimate);?></th>
            <th><?php common::printOrderLink('status',         $orderBy, $vars, $lang->story->status);?></th>
            <th><?php common::printOrderLink('lastEditedDate', $orderBy, $vars, $lang->story->lastEditedDate);?></th>
            <th><?php echo $lang->action;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($stories as $key => $story):?>
          <?php
          $viewLink = $this->createLink('story', 'view', "storyID=$story->id");
          $canView  = common::hasPriv('story', 'view');
          ?>
          <tr class='a-center'>
            <td><?php if($canView) echo html::a($viewLink, sprintf('%03d', $story->id)); else printf('%03d', $story->id);?></td>
            <td><?php echo $story->pri;?></td>
            <td class='a-left nobr'><nobr><?php echo $story->title;?></nobr></td>
            <td><?php echo $story->planTitle;?></td>
            <td><?php echo $users[$story->assignedTo];?></td>
            <td><?php echo $users[$story->openedBy];?></td>
            <td><?php echo $story->estimate;?></td>
            <td class='<?php echo $story->status;?>'><?php $statusList = (array)$lang->story->statusList; echo $statusList[$story->status];?></td>
            <td><?php echo substr($story->lastEditedDate, 5, 11);?></td>
            <td>
              <?php if(common::hasPriv('story', 'edit'))   echo html::a($this->createLink('story', 'edit',   "story={$story->id}"), $lang->edit);?>
              <?php if(common::hasPriv('story', 'delete')) echo html::a($this->createLink('story', 'delete', "story={$story->id}&confirm=no"), $lang->delete, 'hiddenwin');?>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <?php echo $pager;?>
    </div>
  </div>
</div>  
<script language='javascript'>
$('#module<?php echo $moduleID;?>').addClass('active')
$('#feature<?php echo $browseType;?>').addClass('active')
</script>
<?php include '../../common/footer.html.php';?>

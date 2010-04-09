<?php
/**
 * The task view file of project module of ZenTaoMS.
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
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<?php include './taskheader.html.php';?>
<div class='yui-d0'>
  <table class='table-1 fixed colored tablesorter'>
    <?php $vars = "projectID=$project->id&status=all&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage"; ?>
    <thead>
    <tr class='colhead'>
      <th><?php common::printOrderLink('id',       $orderBy, $vars, $lang->task->id);?></th>
      <th><?php common::printOrderLink('pri',      $orderBy, $vars, $lang->task->pri);?></th>
      <th class='w-p20'><?php common::printOrderLink('name',     $orderBy, $vars, $lang->task->name);?></th>
      <th><?php common::printOrderLink('owner',    $orderBy, $vars, $lang->task->owner);?></th>
      <th><?php common::printOrderLink('estimate', $orderBy, $vars, $lang->task->estimate);?></th>
      <th><?php common::printOrderLink('consumed', $orderBy, $vars, $lang->task->consumed);?></th>
      <th><?php common::printOrderLink('left',     $orderBy, $vars, $lang->task->left);?></th>
      <th><?php common::printOrderLink('type',     $orderBy, $vars, $lang->task->type);?></th>
      <th><?php common::printOrderLink('deadline', $orderBy, $vars, $lang->task->deadline);?></th>
      <th><?php common::printOrderLink('status',   $orderBy, $vars, $lang->task->status);?></th>
      <th class='w-p20'><?php common::printOrderLink('story',    $orderBy, $vars, $lang->task->story);?></th>
      <th class='w-100px'><?php echo $lang->actions;?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($tasks as $task):?>
    <?php $class = $task->owner == $app->user->account ? 'style=color:red' : '';?>
    <tr class='a-center'>
      <td><?php if(!common::printLink('task', 'view', "task=$task->id", sprintf('%03d', $task->id))) printf('%03d', $task->id);?></td>
      <td><?php echo $task->pri;?></td>
      <td class='a-left nobr'><?php if(!common::printLink('task', 'view', "task=$task->id", $task->name)) echo $task->name;?></td>
      <td <?php echo $class;?>><?php echo $task->ownerRealName;?></td>
      <td><?php echo $task->estimate;?></td>
      <td><?php echo $task->consumed;?></td>
      <td><?php echo $task->left;?></td>
      <td><?php echo $lang->task->typeList[$task->type];?></td>
      <td class=<?php if(isset($task->delay)) echo 'delayed';?>><?php if(substr($task->deadline, 0, 4) > 0) echo $task->deadline;?></td>
      <td class=<?php echo $task->status;?> >
        <?php
        if($task->storyStatus == 'active' and $task->latestStoryVersion > $task->storyVersion)
        {
            echo "<span class='warning'>{$lang->story->changed}</span> ";
        }
        else
        {
            echo $lang->task->statusList[$task->status];
        }
        ?>
      </td>
      <td class='a-left nobr'>
        <?php 
        if($task->storyID)
        {
            if(common::hasPriv('story', 'view')) echo html::a($this->createLink('story', 'view', "storyid=$task->storyID"), $task->storyTitle);
            else echo $task->storyTitle;
        }
        ?>
      </td>
      <td>
        <?php common::printLink('task', 'edit',   "taskid=$task->id", $lang->edit);?>
        <?php 
        if($browseType == 'needconfirm')
        {
            common::printLink('task', 'confirmStoryChange', "taskid=$task->id", $lang->confirm, 'hiddenwin');
        }
        else
        {
            common::printLink('task', 'delete', "projectID=$task->project&taskid=$task->id", $lang->delete, 'hiddenwin');
        }
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
  </table>
  <div class='a-right'><?php echo $pager;?></div>
</div>  
<script language='Javascript'>$('#<?php echo $browseType;?>').addClass('active');</script>
<?php include '../../common/view/footer.html.php';?>

<?php
/**
 * The task group view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treetable.html.php';?>
<?php include './taskheader.html.php';?>
<div class='g'><div class='u-1'>
  <table class='table-1' id='treetable'>
    <tr class='colhead'>
      <th></th>
      <th><?php echo $lang->task->name;?></th>
      <th class='w-pri'><?php echo $lang->priAB;?></th>
      <th class='w-user'><?php echo $lang->task->assignedTo;?></th>
      <th class='w-user'><?php echo $lang->task->finishedBy;?></th>
      <th><?php echo $lang->task->estimateAB;?></th>
      <th><?php echo $lang->task->consumedAB;?></th>
      <th><?php echo $lang->task->leftAB;?></th>
      <th><?php echo $lang->typeAB;?></th>
      <th><?php echo $lang->task->deadlineAB;?></th>
      <th colspan='2' class='a-left'><?php echo $lang->task->status;?></th>
    </tr>
    <?php $i = 0;?>
    <?php foreach($tasks as $groupKey => $groupTasks):?>
    <?php $groupClass = ($i % 2 == 0) ? 'even' : 'bg-yellow'; $i ++;?>
    <tr id='node-<?php echo $groupKey;?>'>
      <td class='<?php echo $groupClass;?> a-center f-16px strong'><?php echo $groupKey;?></td>
      <td colspan='10'><?php if($groupByList) echo $groupByList[$groupKey];?></td>
    </tr>
      <?php foreach($groupTasks as $task):?>
      <?php $assignedToClass = $task->assignedTo == $app->user->account ? 'style=color:red' : '';?>
      <tr id='<?php echo $task->id;?>' class='a-center child-of-node-<?php echo $groupKey;?>'>
        <td class='<?php echo $groupClass;?>'></td>
        <td class='a-left'>&nbsp;<?php echo $task->id . $lang->colon; if(common::hasPriv('task', 'view')) echo html::a($this->createLink('task', 'view', "task=$task->id"), $task->name); else echo $task->name;?></td>
        <td><?php echo $task->pri;?></td>
        <td <?php echo $assignedToClass;?>><?php echo $task->assignedToRealName;?></td>
        <td><?php echo $users[$task->finishedBy];?></td>
        <td><?php echo $task->estimate;?></td>
        <td><?php echo $task->consumed;?></td>
        <td><?php echo $task->left;?></td>
        <td><?php echo $lang->task->typeList[$task->type];?></td>
        <td class=<?php if(isset($task->delay)) echo 'delayed';?>><?php if(substr($task->deadline, 0, 4) > 0) echo $task->deadline;?></td>
        <td class=<?php echo $task->status;?> ><?php echo $lang->task->statusList[$task->status];?></td>
        <td>
          <?php if(common::hasPriv('task', 'edit'))   echo html::a($this->createLink('task', 'edit',   "taskid=$task->id"), $lang->edit);?>
          <?php if(common::hasPriv('task', 'delete')) echo html::a($this->createLink('task', 'delete', "projectID=$task->project&taskid=$task->id"), $lang->delete, 'hiddenwin');?>
        </td>
      </tr>
      <?php endforeach;?>
    <?php endforeach;?>
  </table>
</div>  
<script language='Javascript'>$('#<?php echo $browseType;?>Tab').addClass('active');</script>
<?php include '../../common/view/footer.html.php';?>

<?php
/**
 * The view file of task module of ZenTaoMS.
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
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>

<div class='yui-d0'>
  <div id='titlebar'>
    <div id='main'>TASK #<?php echo $task->id . $lang->colon . $task->name;?></div>
    <div>
    <?php
    //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'logEfforts', "taskID=$task->id", $lang->task->buttonLogEfforts))) echo $lang->task->buttonLogEfforts . ' ';
    //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'close',      "taskID=$task->id", $lang->task->buttonClose)))      echo $lang->task->buttonClose . ' ';
    //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'cancel',     "taskID=$task->id", $lang->task->buttonCancel)))     echo $lang->task->buttonCancel . ' ';
    //if(!($task->status == 'closed' or $task->status == 'cancel'  and common::printLink('task', 'activate',   "taskID=$task->id", $lang->task->buttonActivate)))   echo $lang->task->buttonActivate . ' ';
    if(!common::printLink('task', 'edit',  "taskID=$task->id", $lang->task->buttonEdit)) echo $lang->task->buttonEdit . ' ';
    if(!common::printLink('task', 'delete',"projectID=$task->project&taskID=$task->id", $lang->task->buttonDelete, 'hiddenwin')) echo $lang->task->buttonDelete . ' ';
    echo html::a($app->session->taskList,  $lang->task->buttonBackToList);
    ?>
    </div>
  </div>
</div>

<div class='yui-d0 yui-t8'>
  <div class='yui-main'>
    <div class='yui-b'>
      <fieldset>
        <legend><?php echo $lang->task->legendDesc;?></legend>
        <div><?php echo nl2br($task->desc);?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->files;?></legend>
        <div><?php foreach($task->files as $file) echo html::a($this->createLink('file', 'download', "fileID=$file->id"), $file->title, '_blank');?></div>
      </fieldset>
      <?php include '../../common/action.html.php';?>
      <div class='a-center f-16px strong'>
        <?php
        //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'logEfforts', "taskID=$task->id", $lang->task->buttonLogEfforts))) echo $lang->task->buttonLogEfforts . ' ';
        //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'close',      "taskID=$task->id", $lang->task->buttonClose)))      echo $lang->task->buttonClose . ' ';
        //if(!($task->status != 'closed' and $task->status != 'cancel' and common::printLink('task', 'cancel',     "taskID=$task->id", $lang->task->buttonCancel)))     echo $lang->task->buttonCancel . ' ';
        //if(!($task->status == 'closed' or $task->status == 'cancel'  and common::printLink('task', 'activate',   "taskID=$task->id", $lang->task->buttonActivate)))   echo $lang->task->buttonActivate . ' ';
        if(!common::printLink('task', 'edit', "taskID=$task->id", $lang->task->buttonEdit)) echo $lang->task->buttonEdit . ' ';
        if(!common::printLink('task', 'delete',"projectID=$task->project&taskID=$task->id", $lang->task->buttonDelete, 'hiddenwin')) echo $lang->task->buttonDelete . ' ';
        echo html::a($app->session->taskList,  $lang->task->buttonBackToList);
        ?>
      </div>
    </div>
  </div>
  <div class='yui-b'>
    <fieldset>
      <legend><?php echo $lang->task->legendBasic;?></legend>
      <table class='table-1'> 
        <tr>
          <th class='rowhead w-p20'><?php echo $lang->task->project;?></th>
          <td><?php if(!common::printLink('project', 'task', "projectID=$task->project", $project->name)) echo $project->name;?></td>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->story;?></th>
          <td><?php if($task->storyTitle and !common::printLink('story', 'view', "storyID=$task->story", $task->storyTitle)) echo $task->storyTitle;?>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->owner;?></th>
          <td><?php echo $task->ownerRealName;?> 
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->type;?></th>
          <td><?php echo $lang->task->typeList[$task->type];?></td>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->status;?></th>
          <td><?php $lang->show($lang->task->statusList, $task->status);?></td>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->pri;?></th>
          <td><?php $lang->show($lang->task->priList, $task->pri);?></td>
        </tr>
      </table>
    </fieldset>
    <fieldset>
      <legend><?php echo $lang->task->legendEffort;?></legend>
      <table class='table-1'> 
        <tr>
          <th class='rowhead'><?php echo $lang->task->deadline;?></th>
          <td>
            <?php
            echo $task->deadline;
            if(isset($task->delay)) printf($lang->task->delayWarning, $task->delay);
            ?>
          </td>
        </tr>  
        <tr>
          <th class='rowhead w-p20'><?php echo $lang->task->estimate;?></th>
          <td><?php echo $task->estimate . $lang->workingHour;?></td>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->consumed;?></th>
          <td><?php echo $task->consumed . $lang->workingHour;?></td>
        </tr>  
        <tr>
          <th class='rowhead'><?php echo $lang->task->left;?></th>
          <td><?php echo $task->left . $lang->workingHour;?></td>
        </tr>
          
      </table>
    </fieldset>
   </div>
</div>
<?php include '../../common/footer.html.php';?>

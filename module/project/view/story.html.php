<?php
/**
 * The story view file of project module of ZenTaoMS.
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
<?php include '../../common/view/colorbox.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<script language='javascript'>
$(document).ready(function()
{
    $("a.iframe").colorbox({width:640, height:480, iframe:true, transition:'none'});
});
</script>
<div class="yui-d0">                 
  <div id='featurebar'>
    <div class='f-left'>
    </div>
    <div class='f-right'>
      <?php if(common::hasPriv('project', 'linkstory')) echo html::a($this->createLink('project', 'linkstory', "project=$project->id"), $lang->project->linkStory);?>
    </div>
  </div>
</div>

<div class='yui-d0'>
  <table class='table-1 tablesorter fixed'>
    <thead>
      <tr class='colhead'>
        <th><?php echo $lang->story->id;?></th>
        <th><?php echo $lang->story->pri;?></th>
        <th class='w-p50'><?php echo $lang->story->title;?></th>
        <th><?php echo $lang->story->assignedTo;?></th>
        <th><?php echo $lang->story->openedBy;?></th>
        <th><?php echo $lang->story->estimate;?></th>
        <th><?php echo $lang->story->status;?></th>
        <th><?php echo $lang->story->stage;?></th>
        <th class='w-150px'><?php echo $lang->actions;?></th>
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
        <td class='a-left nobr'>
          <?php
          echo $story->title;
          if($storyTasks[$story->id] > 0)
          {
              echo ' ' . html::a($this->createLink('story', 'tasks', "storyID=$story->id&projectID=$project->id"), '('. $storyTasks[$story->id] . ')', '', 'class=iframe');
          }
          else
          {
            echo ' (0)';
          }
          ?> 
        </td>
        <td><?php echo $users[$story->assignedTo];?></td>
        <td><?php echo $users[$story->openedBy];?></td>
        <td><?php echo $story->estimate;?></td>
        <td class='<?php echo $story->status;?>'><?php echo $lang->story->statusList[$story->status];?></td>
        <td><?php echo $lang->story->stageList[$story->stage];?></td>
        <td>
          <?php if(common::hasPriv('task', 'create'))         echo html::a($this->createLink('task', 'create',   "projectID={$project->id}&story={$story->id}"), $lang->task->create);?>
          <?php if(common::hasPriv('project', 'unlinkStory')) echo html::a($this->createLink('project', 'unlinkStory', "projectID={$project->id}&story={$story->id}&confirm=no"), $lang->project->unlinkStory, 'hiddenwin');?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>  
<?php include '../../common/view/footer.html.php';?>

<?php
/**
 * The import view file of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<form method='post' enctype='multipart/form-data' target='hiddenwin'>
  <table class='table-1 colored'>
    <tr class='colhead'>
      <th class='w-id'>       <?php echo $lang->task->importBug;?></th>
      <th class='w-id'>       <?php echo $lang->idAB;?></th>
      <th class='hidden'></th>
      <th class='w-severity'> <?php echo $lang->bug->severityAB;?></th>
      <th class='w-pri'>      <?php echo $lang->priAB;?></th>
      <th><?php echo $lang->bug->title;?></th>
      <th class='w-80px'><?php echo $lang->bug->statusAB;?></th>
      <th class='w-80px'><?php echo $lang->task->pri;?></th>
      <th class='w-150px'><?php echo $lang->task->assignedTo;?></th>
      <th class='w-50px'><?php echo $lang->task->estimateBatch;?></th>
    </tr>
    <?php foreach($bugs as $bug):?>
    <tr class='a-center'>
      <td><?php echo html::checkbox("import[$bug->id]", '');?> </td>
      <?php $class = ($bug->status == 'active' or $bug->status == 'reactivated') ? 'active' . $bug->severity : $bug->status;?>
      <td class='linkbox <?php echo $class;?>'><?php echo sprintf('%03d', $bug->id);?></td>
      <td class='hidden'><?php echo html::input("id[$bug->id]", $bug->id);?></td>
      <td><?php echo $lang->bug->severityList[$bug->severity]?></td>
      <td><?php echo $lang->bug->priList[$bug->pri]?></td>
      <td class='a-left nobr'><?php echo $bug->title;?></td>
      <td><?php echo $lang->bug->statusList[$bug->status];?></td>
      <td><?php echo html::select("pri[$bug->id]", $lang->task->priList, 3);?></td>
      <td><?php echo html::select("assignedTo[$bug->id]", $users, '');?></td>
      <td><?php echo html::input("estimate[$bug->id]", '', 'size=4');?></td>
    </tr>
    <?php endforeach;?>
      <tr>
      <td colspan='9'>
        <div class='f-left'>
          <?php 
          foreach($lang->bug->statusList as $status => $label)
          {
              if($status != 'active') continue;
              rsort($this->lang->bug->severityList);
              foreach($this->lang->bug->severityList as $severity) 
              {
                  echo "<span class='$status$severity'> {$lang->bug->severity}:$severity </span> ";
              }
          }
          ?>
        </div>
          <div class='f-right'><?php $pager->show();?></div>
        </td>
      </tr>
      <tr><td colspan='9' class='a-center'><?php echo html::submitButton($lang->task->importBug) . html::resetButton();?></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>

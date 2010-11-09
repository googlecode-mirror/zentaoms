<?php
/**
 * The edit view of testtask module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     testtask
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script language='javascript'>KE.show({id:'desc', items:simpleTools, filterMode:true, imageUploadJson: createLink('file', 'ajaxUpload')});</script>
<div class='yui-d0'>
  <form method='post' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->testtask->edit;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->project;?></th>
        <td><?php echo html::select('project', $projects, $task->project, 'class=select-3');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->build;?></th>
        <td><?php echo html::select('build', $builds, $task->build, 'class=select-3');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->begin;?></th>
        <td><?php echo html::input('begin', $task->begin, "class='text-3 date'");?>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->end;?></th>
        <td><?php echo html::input('end', $task->end, "class='text-3 date'");?>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->status;?></th>
        <td><?php echo html::select('status', $lang->testtask->statusList, $task->status,  "class='select-3'");?>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->name;?></th>
        <td><?php echo html::input('name', $task->name, "class='text-1'");?>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->testtask->desc;?></th>
        <td><?php echo html::textarea('desc', htmlspecialchars($task->desc), "rows=10 class='area-1'");?>
      </tr>  
      <tr>
        <td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?> </td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>

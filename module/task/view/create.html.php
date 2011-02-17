<?php
/**
 * The create view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<style>.button-c {padding:2px} </style>
<script language='javascript'>
/* Copy story title as task title. */
function copyStoryTitle()
{
    var storyTitle = $('#story option:selected').text();
    storyTitle = storyTitle.substr(storyTitle.lastIndexOf(':')+ 1);
    $('#name').attr('value', storyTitle);
}

/* Set the assignedTos field. */
function setOwners(result)
{
    if(result == 'affair')
    {
        $('#assignedTo').attr('size', 4);
        $('#assignedTo').attr('multiple', 'multiple');
    }
    else
    {
        $('#assignedTo').removeAttr('size');
        $('#assignedTo').removeAttr('multiple');
    }
}

/* Set the story priview link. */
function setPreview()
{
    if(!$('#story').val())
    {
        $('#preview').addClass('hidden');
    }
    else
    {
        storyLink = createLink('story', 'view', "storyID=" + $('#story').val());
        $('#preview').removeClass('hidden');
        $('#preview').attr('href', storyLink);
    }
}

var userList = "<?php echo join(',', array_keys($users));?>".split(',');
$(document).ready(function()
{
    setPreview();
    $("#mailto").autocomplete(userList, { multiple: true, mustMatch: true});
});
</script>
<div class='g'><div class='u-1'>
  <form method='post' enctype='multipart/form-data' target='hiddenwin'>
    <table align='center' class='table-1 a-left'> 
      <caption><?php echo $lang->task->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->task->project;?></th>
        <td><?php echo $project->name;?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->task->pri;?></th>
        <td><?php echo html::select('pri', $lang->task->priList, '', 'class=select-3');?> 
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->estimate;?></th>
        <td><?php echo html::input('estimate', '', "class='text-3'");?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->deadline;?></th>
        <td><?php echo html::input('deadline', '', "class='text-3 date'");?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->type;?></th>
        <td><?php echo html::select('type', $lang->task->typeList, '', 'class=select-3 onchange="setOwners(this.value)"');?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->assignedTo;?></th>
        <td><?php echo html::select('assignedTo[]', $members, '', 'class=select-3');?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->mailto;?></th>
        <td> <?php echo html::input('mailto', '', 'class=text-1');?> </td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->task->story;?></th>
        <td>
          <?php echo html::select('story', $stories, $storyID, 'class=select-1 onchange=setPreview();');?>
          <a href='' id='preview' class='iframe' target='_blank'><?php echo $lang->preview;?></a>
        </td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->task->name;?></th>
        <td>
          <?php
          echo html::input('name', '', "class='text-1'");
          echo html::commonButton($lang->task->copyStoryTitle, 'onclick=copyStoryTitle()');?>
        </td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->task->desc;?></th>
        <td><?php echo html::textarea('desc', '', "rows='7' class='area-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->files;?></th>
        <td class='a-left'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>  
      
      <tr>
        <th class='rowhead'><?php echo $lang->task->afterSubmit;?></th>
        <td><?php echo html::radio('after', $lang->task->afterChoices, 'continueAdding');?></td> 
      </tr>
      <tr>
        <td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td>
      </tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

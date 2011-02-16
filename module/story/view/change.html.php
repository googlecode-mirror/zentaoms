<?php
/**
 * The change view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='yui-d0'><div class='u-1'>
  <form method='post' enctype='multipart/form-data' target='hiddenwin'>
  <table class='table-1'>
    <caption><?php echo $lang->story->change;?></caption>
    <tr>
      <th class='rowhead'><?php echo $lang->story->reviewedBy;?></th>
      <td><?php echo html::select('assignedTo', $users, $story->assignedTo, 'class="select-3"') . html::checkbox('needNotReview', $lang->story->needNotReview, '', "id='needNotReview'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->title;?></th>
      <td><?php echo html::input('title', $story->title, 'class="text-1"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->spec;?></th>
      <td><?php echo html::textarea('spec', htmlspecialchars($story->spec), 'rows=8 class="area-1"');?><br /> <?php echo $lang->story->specTemplate;?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->story->comment;?></th>
      <td><?php echo html::textarea('comment', '', 'rows=5 class="area-1"');?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->attatch;?></th>
      <td><?php echo $this->fetch('file', 'buildform', 'filecount=2');?></td>
    </tr>
  </table>
  <div class='a-center'>
    <?php 
    echo html::submitButton();
    echo html::linkButton($lang->goback, $app->session->storyList ? $app->session->storyList : inlink('view', "storyID=$story->id"));
    ?>
  </div>
  <?php include './affected.html.php';?>
  <?php include '../../common/view/action.html.php';?>
  </form>
</div></div>
<?php include '../../common/view/footer.html.php';?>

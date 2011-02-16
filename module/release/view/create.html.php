<?php
/**
 * The create view of release module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     release
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='g'><div class='u-1'>
  <form method='post' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->release->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->release->name;?></th>
        <td><?php echo html::input('name', '', "class='text-3'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->release->build;?></th>
        <td><?php echo html::select('build', $builds, '', 'class="select-3"');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->release->date;?></th>
        <td><?php echo html::input('date', helper::today(), "class='text-3 date'");?></td>
      </tr>  
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->release->desc;?></th>
        <td><?php echo html::textarea('desc', '', "rows='20' class='area-1'");?></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

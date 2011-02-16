<?php
/**
 * The create view of productplan module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     productplan
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
      <caption><?php echo $lang->productplan->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->productplan->product;?></th>
        <td><?php echo $product->name;?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productplan->title;?></th>
        <td><?php echo html::input('title', '', "class='text-3'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productplan->begin;?></th>
        <td><?php echo html::input('begin', '', "class='text-3 date'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productplan->end;?></th>
        <td><?php echo html::input('end', '', "class='text-3 date'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productplan->desc;?></th>
        <td><?php echo html::textarea('desc', '', "rows='10' class='area-1'");?></td>
      </tr>  
      <tr>
        <td colspan='2' class='a-center'>
          <?php 
          echo html::submitButton();
          echo html::resetButton();
          echo html::hidden('product', $product->id);
          ?>
        </td>
      </tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

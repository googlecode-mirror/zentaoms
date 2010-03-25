<?php
/**
 * The create view of build module of ZenTaoMS.
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
 * @package     build
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='yui-d0'>
  <form method='post' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->build->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->build->product;?></th>
        <td><?php echo html::select('product', $products, '', "class='select-3'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->name;?></th>
        <td><?php echo html::input('name', '', "class='text-3'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->builder;?></th>
        <td><?php echo html::select('builder', $users, $app->user->account, 'class="select-3"');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->date;?></th>
        <td><?php echo html::input('date', helper::today(), "class='text-3 date'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->scmPath;?></th>
        <td><?php echo html::input('scmPath', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->filePath;?></th>
        <td><?php echo html::input('filePath', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->build->desc;?></th>
        <td><?php echo html::textarea('desc', '', "rows='5' class='area-1'");?></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

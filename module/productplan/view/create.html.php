<?php
/**
 * The create view of productPlan module of ZenTaoMS.
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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     productPlan
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<div class='yui-d0'>
  <form method='post' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->productPlan->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->productPlan->product;?></th>
        <td><?php echo $product->name;?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productPlan->title;?></th>
        <td><input type='text' name='title' class='text-3' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productPlan->begin;?></th>
        <td><input type='text' name='begin' class='text-3' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productPlan->end;?></th>
        <td><input type='text' name='end' class='text-3' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->productPlan->desc;?></th>
        <td><textarea name='desc' rows='5' class='area-1'></textarea></td>
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
<?php include '../../common/footer.html.php';?>

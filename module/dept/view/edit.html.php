<?php
/**
 * The edit view of product module of ZenTaoMS.
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
 * @package     product
 * @version     $Id: edit.html.php 1325 2009-09-16 07:41:23Z wwccss $
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<div id='doc3'>
  <form method='post' target='hiddenwin'>
    <table align='center' class='table-4'> 
      <caption><?php echo $lang->product->edit;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->product->name;?></th>
        <td class='a-left'><input type='text' name='name' value='<?php echo $product->name;?>' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->code;?></th>
        <td class='a-left'><input type='text' name='code' value='<?php echo $product->code;?>' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->desc;?></th>
        <td class='a-left'><textarea name='desc' style='width:100%' rows='5'><?php echo $product->desc;?></textarea></td>
      </tr>  
      <tr>
        <td colspan='2'>
          <input type='submit' value='<?php echo $lang->product->saveButton;?>' accesskey='S' />
          <input type='reset'  value='<?php echo $lang->reset;?>' />
          <input type='hidden' value='<?php echo $product->id;?>' name='id' />
        </td>
      </tr>
    </table>
  </form>
</div>  
<?php include '../../common/footer.html.php';?>

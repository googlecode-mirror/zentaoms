<?php
/**
 * The create view of product module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<script language='Javascript'>
function setWhite(acl)
{
    acl == 'custom' ? $('#whitelistBox').removeClass('hidden') : $('#whitelistBox').addClass('hidden');
}
</script>
<div class='yui-d0'>
  <form method='post' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->product->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->product->name;?></th>
        <td><?php echo html::input('name', '', "class='text-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->code;?></th>
        <td><?php echo html::input('code', '', "class='text-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->bugOwner;?></th>
        <td><?php echo html::select('bugOwner', $users, $this->app->user->account, "class='select-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->status;?></th>
        <td><?php echo html::select('status', $lang->product->statusList, '', "class='select-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->desc;?></th>
        <td><?php echo html::textarea('desc', '', "rows='5' class='area-1'");?></textarea></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->acl;?></th>
        <td><?php echo html::radio('acl', $lang->product->aclList, 'open', "onclick='setWhite(this.value);'");?></td>
      </tr>  
      <tr id='whitelistBox' class='hidden'>
        <th class='rowhead'><?php echo $lang->product->whitelist;?></th>
        <td><?php echo html::checkbox('whitelist', $groups);?></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

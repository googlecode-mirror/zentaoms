<?php
/**
 * The edit view of product module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
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
    <table align='center' class='table-1'> 
      <caption><?php echo $lang->product->edit;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->product->name;?></th>
        <td><?php echo html::input('name', $product->name, "class='text-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->code;?></th>
        <td><?php echo html::input('code', $product->code, "class='text-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->bugOwner;?></th>
        <td><?php echo html::select('bugOwner', $users, $product->bugOwner, "class='select-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->status;?></th>
        <td><?php echo html::select('status', $lang->product->statusList, $product->status, "class='select-2'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->desc;?></th>
        <td><?php echo html::textarea('desc', $product->desc, "rows='5' class='area-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->acl;?></th>
        <td><?php echo html::radio('acl', $lang->product->aclList, $product->acl, "onclick='setWhite(this.value);'");?></td>
      </tr>  
      <tr id='whitelistBox' <?php if($product->acl != 'custom') echo "class='hidden'";?>>
        <th class='rowhead'><?php echo $lang->product->whitelist;?></th>
        <td><?php echo html::checkbox('whitelist', $groups, $product->whitelist);?></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>

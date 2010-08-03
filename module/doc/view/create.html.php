<?php
/**
 * The create view of doc module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 青岛易软天创网络科技有限公司(www.cnezsoft.com)
 * @author      Jia Fu <fujia@cnezsoft.com>
 * @package     doc
 * @version     $Id: create.html.php 975 2010-07-29 03:30:25Z jajacn@126.com $
 * @link        http://www.zentaoms.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<script language='Javascript'>
function loadProducts(project)
{
    link = createLink('project', 'ajaxGetProducts', 'projectID=' + project);
    $('#productBox').load(link);
}
</script>
<div class='yui-d0'>
  <form method='post' enctype='multipart/form-data' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->doc->create;?></caption>
      <?php if($libID == 'product'):?>
      <tr>
        <th class='rowhead'><?php echo $lang->doc->product;?></th>
        <td><?php echo html::select('product', $products, $productID, "class='select-3'");?></td>
      </tr>  
      <?php elseif($libID == 'project'):?>
      <tr>
        <th class='rowhead'><?php echo $lang->doc->project;?></th>
        <td><?php echo html::select('project', $projects, $projectID, "class='select-3' onchange=loadProducts(this.value);");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->doc->product;?></th>
        <td><span id='productBox'><?php echo html::select('product', $products, '', "class='select-3'");?></span></td>
      </tr>  
      <?php endif;?>
      <tr>
        <th class='rowhead'><?php echo $lang->doc->module;?></th>
        <td><?php echo html::select('module', $moduleOptionMenu, $moduleID, "class='select-3'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->doc->title;?></th>
        <td><?php echo html::input('title', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->doc->files;?></th>
        <td><?php echo $this->fetch('file', 'buildform', 'fileCount=2');?></td>
      </tr>  
      <tr>
        <td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton() . html::hidden('lib', $libID);?></td>
      </tr>
    </table>
  </form>
</div>
<?php include './footer.html.php';?>

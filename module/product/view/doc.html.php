<?php
/**
 * The doc view file of product module of ZenTaoMS.
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
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentaoms.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<div class='yui-d0'>

  <table class='table-6 fixed colored tablesorter' align='center'>
    <caption class='caption-tr'><?php common::printLink('doc', 'create', "libID=product&productID={$product->id}", $lang->doc->create);?></caption>
    <thead>
      <tr class='colhead'>
        <th class='w-id'><?php echo $lang->idAB;?></th>
        <th><?php echo $lang->doc->module;?></th>
        <th><?php echo $lang->doc->title;?></th>
        <th><?php echo $lang->doc->addedBy;?></th>
        <th><?php echo $lang->doc->addedDate;?></th>
        <th class='w-100px {sorter:false}'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($docs as $key => $doc):?>
      <?php
      $viewLink = $this->createLink('doc', 'view', "docID=$doc->id");
      $canView  = common::hasPriv('doc', 'view');
      ?>
      <tr class='a-center'>
        <td><?php if($canView) echo html::a($viewLink, sprintf('%03d', $doc->id)); else printf('%03d', $doc->id);?></td>
        <td><?php echo $modules[$doc->module];?></td>
        <td class='a-left nobr'><nobr><?php echo html::a($viewLink, $doc->title);?></nobr></td>
        <td><?php echo $users[$doc->addedBy];?></td>
        <td><?php echo $doc->addedDate;?></td>
        <td>
          <?php 
          $vars = "doc={$doc->id}";
          if(!common::printLink('doc', 'edit',   $vars, $lang->edit)) echo $lang->edit;
          if(!common::printLink('doc', 'delete', $vars, $lang->delete)) echo $lang->delete;
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>  
<?php include '../../common/view/footer.html.php';?>

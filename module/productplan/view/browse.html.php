<?php
/**
 * The browse view file of plan module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     plan
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<table class='table-1 tablesorter fixed'>
  <caption class='caption-tr'>
    <div class='f-left'><?php echo $lang->productplan->browse;?></div>
    <div class='f-right'><?php common::printLink('productplan', 'create', "productID=$product->id", $lang->productplan->create);?></div>
  </caption>
  <thead>
  <tr class='colhead'>
    <th class='w-id'><?php echo $lang->idAB;?></th>
    <th class='w-100px'><?php echo $lang->productplan->begin;?></th>
    <th class='w-100px'><?php echo $lang->productplan->end;?></th>
    <th><?php echo $lang->productplan->title;?></th>
    <th class='w-p50'><?php echo $lang->productplan->desc;?></th>
    <th class="w-130px {sorter: false}"><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($plans as $plan):?>
  <tr class='a-center'>
    <td><?php echo html::a(inlink('view', "id=$plan->id"), $plan->id);?></td>
    <td><?php echo $plan->begin;?></td>
    <td><?php echo $plan->end;?></td>
    <td class='a-left' title="<?php echo $plan->title?>"><?php echo html::a(inlink('view', "id=$plan->id"), $plan->title);?></td>
    <td class='a-left content' title="<?php echo $plan->desc?>"><?php echo $plan->desc;?></td>
    <td class='a-right'>
      <?php
      common::printLink('productplan', 'linkstory', "planID=$plan->id", $lang->productplan->linkStory);
      common::printIcon('productplan', 'edit', "planID=$plan->id", '', 'list');
      common::printIcon('productplan', 'delete', "planID=$plan->id", '', 'list', '', 'hiddenwin');
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>
<?php include '../../common/view/footer.html.php';?>

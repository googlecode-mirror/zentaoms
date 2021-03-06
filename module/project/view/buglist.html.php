<?php $_GET['onlybody'] = 'no';?>
<table class='table-1 fixed colored tablesorter' id='bugList'>
  <caption class='caption-tl pb-10px'>
    <div class='f-left'>
      <?php 
      echo $lang->project->bug;
      if($build) echo '<span class="red">(Build:' . $build->name . ')</span>';
      ?>
    </div>
    <div class='f-right'><?php common::printIcon('bug', 'create', "productID=$productID&extra=projectID=$project->id");?></div>
  </caption>
  <thead>
  <tr class='colhead'>
    <?php $vars = "projectID={$project->id}&orderBy=%s&build=$buildID&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
    <th class='w-id'>      <?php common::printOrderLink('id',           $orderBy, $vars, $lang->idAB);?></th>
    <th class='w-severity'><?php common::printOrderLink('severity',     $orderBy, $vars, $lang->bug->severityAB);?></th>
    <th class='w-pri'>     <?php common::printOrderLink('pri',          $orderBy, $vars, $lang->priAB);?></th>
    <th>                   <?php common::printOrderLink('title',        $orderBy, $vars, $lang->bug->title);?></th>
    <th class='w-user'>    <?php common::printOrderLink('openedBy',     $orderBy, $vars, $lang->openedByAB);?></th>
    <th class='w-user'>    <?php common::printOrderLink('assignedTo',   $orderBy, $vars, $lang->assignedToAB);?></th>
    <th class='w-user'>    <?php common::printOrderLink('resolvedBy',   $orderBy, $vars, $lang->bug->resolvedBy);?></th>
    <th class='w-resolution'><?php common::printOrderLink('resolution', $orderBy, $vars, $lang->bug->resolutionAB);?></th>
    <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($bugs as $bug):?>
  <tr class='a-center'>
    <td><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id"), $bug->id, '_blank');?></td>
    <td><span class='<?php echo 'severity' . $lang->bug->severityList[$bug->severity]?>'><?php echo $lang->bug->severityList[$bug->severity]?></span></td>
    <td><span class='<?php echo 'pri' . $lang->bug->priList[$bug->pri]?>'><?php echo $lang->bug->priList[$bug->pri]?></span></td>
    <td class='a-left' title="<?php echo $bug->title?>"><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id"), $bug->title);?></td>
    <td><?php echo $users[$bug->openedBy];?></td>
    <td><?php echo $users[$bug->assignedTo];?></td>
    <td><?php echo $users[$bug->resolvedBy];?></td>
    <td><?php echo $lang->bug->resolutionList[$bug->resolution];?></td>
    <td class='a-right'>
      <?php
      $params = "bugID=$bug->id";
      common::printIcon('bug', 'confirmBug', $params, $bug, 'list', '', '', 'iframe', true);
      common::printIcon('bug', 'assignTo',   $params, '',   'list', '', '', 'iframe', true);
      common::printIcon('bug', 'resolve',    $params, $bug, 'list', '', '', 'iframe', true);
      common::printIcon('bug', 'close',      $params, $bug, 'list', '', '', 'iframe', true);
      common::printIcon('bug', 'edit',       $params, $bug, 'list');
      common::printIcon('bug', 'create',     "product=$bug->product&extra=bugID=$bug->id", $bug, 'list', 'copy');
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='9'><?php $pager->show();?></td></tr></table>
</table>

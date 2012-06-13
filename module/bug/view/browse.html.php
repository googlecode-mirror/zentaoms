<?php
/**
 * The browse view file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<script language='Javascript'>
var browseType = '<?php echo $browseType;?>';
var moduleID   = '<?php echo $moduleID;?>';
var customed   = <?php echo (int)$customed;?>;
</script>

<div id='featurebar'>
  <div class='f-left'>
    <?php
    echo "<span id='bymoduleTab' onclick=\"browseByModule('$browseType')\"><a href='#'>" . $lang->bug->moduleBugs . "</a></span> ";
    echo "<span id='assigntomeTab'>"    . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=assignToMe&param=0"),    $lang->bug->assignToMe)    . "</span>";
    echo "<span id='openedbymeTab'>"    . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=openedByMe&param=0"),    $lang->bug->openedByMe)    . "</span>";
    echo "<span id='resolvedbymeTab'>"  . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=resolvedByMe&param=0"),  $lang->bug->resolvedByMe)  . "</span>";
    echo "<span id='assigntonullTab'>"  . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=assignToNull&param=0"),  $lang->bug->assignToNull)  . "</span>";
    echo "<span id='unresolvedTab'>"    . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=unResolved&param=0"),    $lang->bug->unResolved)    . "</span>";
    echo "<span id='unclosedTab'>"      . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=unclosed&param=0"),      $lang->bug->unclosed)      . "</span>";
    echo "<span id='longlifebugsTab'>"  . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=longLifeBugs&param=0"),  $lang->bug->longLifeBugs)  . "</span>";
    echo "<span id='postponedbugsTab'>" . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=postponedBugs&param=0"), $lang->bug->postponedBugs) . "</span>";
    echo "<span id='allTab'>"           . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=all&param=0&orderBy=$orderBy&recTotal=0&recPerPage=200"), $lang->bug->allBugs) . "</span>";
    echo "<span id='needconfirmTab'>"   . html::a($this->createLink('bug', 'browse', "productid=$productID&browseType=needconfirm&param=0"), $lang->bug->needConfirm) . "</span>";
    echo "<span id='bysearchTab'><a href='#'><span class='icon-search'></span>{$lang->bug->byQuery}</a></span> ";
    ?>
  </div>
  <div class='f-right'>
    <?php if($browseType != 'needconfirm') common::printLink('bug', 'export', "productID=$productID&orderBy=$orderBy", $lang->export, '', 'class="export"'); ?>
    <?php common::printLink('bug', 'customFields', '', $lang->bug->customFields, '', "class='iframe'"); ?>
    <?php common::printLink('bug', 'report', "productID=$productID&browseType=$browseType&moduleID=$moduleID", $lang->bug->report->common); ?>
    <?php common::printLink('bug', 'create', "productID=$productID&extra=moduleID=$moduleID", $lang->bug->create); ?>
  </div>
</div>
<div id='querybox' class='<?php if($browseType !='bysearch') echo 'hidden';?>'><?php echo $searchForm;?></div>

<?php if($customed){include 'browse.custom.html.php'; exit;}?>

<table class='cont-lt1'>
  <tr valign='top'>
    <td class='side <?php echo $treeClass;?>' id='treebox'>
      <div class='box-title'><?php echo $productName;?></div>
      <div class='box-content'>
        <?php echo $moduleTree;?>
        <div class='a-right'>
          <?php if(common::hasPriv('tree', 'browse')) echo html::a($this->createLink('tree', 'browse', "productID=$productID&view=bug"), $lang->tree->manage);?>
        </div>
      </div>
    </td>
    <td class='divider <?php echo $treeClass;?>'></td>
    <td>
       <?php $vars = "productID=$productID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
      <table class='table-1 fixed colored tablesorter datatable border-sep'>
        <thead>
        <tr class='colhead'>
          <th class='w-id'>       <?php common::printOrderLink('id',       $orderBy, $vars, $lang->idAB);?></th>
          <th class='w-severity'> <?php common::printOrderLink('severity', $orderBy, $vars, $lang->bug->severityAB);?></th>
          <th class='w-pri'>      <?php common::printOrderLink('pri',      $orderBy, $vars, $lang->priAB);?></th>

          <th><?php common::printOrderLink('title', $orderBy, $vars, $lang->bug->title);?></th>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <th class='w-80px'><?php common::printOrderLink('status',     $orderBy, $vars, $lang->bug->statusAB);?></th>
          <?php endif;?>

          <?php if($browseType == 'needconfirm'):?>
          <th class='w-p85'<?php common::printOrderLink('story', $orderBy, $vars, $lang->bug->story);?></th>
          <th class='w-120px'><?php echo $lang->actions;?></th>
          <?php else:?>
          <th class='w-user'><?php common::printOrderLink('openedBy',         $orderBy, $vars, $lang->openedByAB);?></th>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <th class='w-date'>  <?php common::printOrderLink('openedDate', $orderBy, $vars, $lang->bug->openedDateAB);?></th>
          <?php endif;?>

          <th class='w-user'><?php common::printOrderLink('assignedTo',       $orderBy, $vars, $lang->assignedToAB);?></th>
          <th class='w-user'><?php common::printOrderLink('resolvedBy',       $orderBy, $vars, $lang->bug->resolvedByAB);?></th>
          <th class='w-resolution'><?php common::printOrderLink('resolution', $orderBy, $vars, $lang->bug->resolutionAB);?></th>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <th class='w-date'>  <?php common::printOrderLink('resolvedDate', $orderBy, $vars, $lang->bug->resolvedDateAB);?></th>
          <?php endif;?>

          <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
          <?php endif;?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($bugs as $bug):?>
        <?php $bugLink = inlink('view', "bugID=$bug->id");?>
        <tr class='a-center'>
          <?php $class = $bug->status == 'active' ? 'active' . $bug->severity : $bug->status;?>
          <td class='<?php echo $class;?>'> <?php echo html::a($bugLink, sprintf('%03d', $bug->id));?> </td>
          <td><?php echo $lang->bug->severityList[$bug->severity]?></td>
          <td><?php echo $lang->bug->priList[$bug->pri]?></td>

          <?php $class = 'confirm' . $bug->confirmed;?>
          <td class='a-left nobr'><?php echo "<span class='$class'>[{$lang->bug->confirmedList[$bug->confirmed]}] </span>" . html::a($bugLink, $bug->title);?></td>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <td><?php echo $lang->bug->statusList[$bug->status];?></td>
          <?php endif;?>

          <?php if($browseType == 'needconfirm'):?>
          <td class='a-left nobr'><?php echo html::a($this->createLink('story', 'view', "stoyID=$bug->story"), $bug->storyTitle, '_blank');?></td>
          <td><?php echo html::a(inlink('confirmStoryChange', "bugID=$bug->id"), $lang->confirm, 'hiddenwin')?></td>
          <?php else:?>
          <td><?php echo $users[$bug->openedBy];?></td>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <td><?php echo substr($bug->openedDate, 5, 11)?></td>
          <?php endif;?>

          <td <?php if($bug->assignedTo == $this->app->user->account) echo 'class="red"';?>><?php echo $users[$bug->assignedTo];?></td>
          <td><?php echo $users[$bug->resolvedBy];?></td>
          <td><?php echo $lang->bug->resolutionList[$bug->resolution];?></td>

          <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
          <td><?php echo substr($bug->resolvedDate, 5, 11)?></td>
          <?php endif;?>

          <td>
            <?php
            $params = "bugID=$bug->id";
            if(!($bug->status == 'active'   and common::printLink('bug', 'resolve', $params, $lang->bug->buttonResolve))) echo $lang->bug->buttonResolve . ' ';
            if(!($bug->status == 'resolved' and common::printLink('bug', 'close',   $params, $lang->bug->buttonClose)))   echo $lang->bug->buttonClose . ' ';
            common::printLink('bug', 'edit', $params, $lang->bug->buttonEdit);
            if($this->cookie->windowWidth >= $this->config->wideSize) common::printLink('bug', 'create', "product=$bug->product&extra=bugID=$bug->id", $lang->bug->buttonCopy);
            ?>
          </td>
          <?php endif;?>
        </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
            <?php $columns = $this->cookie->windowWidth >= $this->config->wideSize ? 12 : 9;?>
            <td colspan='<?php echo $columns;?>'>
              <div class='f-left'>
                <?php 
                foreach($lang->bug->statusList as $status => $label)
                {
                    if($status != 'active')
                    {
                        echo "<span class='$status'> $label </span> ";
                        continue;
                    }
                    rsort($this->lang->bug->severityList);
                    foreach($this->lang->bug->severityList as $severity) 
                    {
                        echo "<span class='$status$severity'> {$lang->bug->severity}:$severity </span> ";
                    }
                }
                ?>
              </div>
              <div class='f-right'><?php $pager->show();?></div>
            </td>
          </tr>
        </tfoot>
      </table>
    </td>
  </tr>
</table>  
<?php include '../../common/view/footer.html.php';?>

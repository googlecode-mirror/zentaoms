<?php
/**
 * The view file of case module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: view.html.php 594 2010-03-27 13:44:07Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/table2csv.html.php';?>
<script language='javascript'>
$(document).ready(function()
{
    $("a.iframe").colorbox({width:900, height:600, iframe:true, transition:'none'});
});

function checkall(checker)
{
    $('input').each(function() 
    {
        $(this).attr("checked", checker.checked)
    });
}
/* 切换至按模块浏览。*/
function browseByModule(active)
{
    $('#mainbox').addClass('yui-t1');
    $('#treebox').removeClass('hidden');
    $('#bymoduleTab').addClass('active');
    $('#' + active + 'Tab').removeClass('active');
}
</script>
<div class='g'><div class='u-1'>
  <div id='featurebar'>
    <div class='f-left'>
      <?php
      echo "<span id='bymoduleTab' onclick=\"browseByModule('$browseType')\"><a href='#'>" . $lang->testtask->byModule . "</a></span> ";
      echo "<span id='allTab'>" . html::a($this->inlink('cases', "taskID=$taskID&browseType=all&param=0"), $lang->testtask->allCases) . "</span>";
      echo "<span id='assignedtomeTab'>" . html::a($this->inlink('cases', "taskID=$taskID&browseType=assignedtome&param=0"), $lang->testtask->assignedToMe) . "</span>";
      ?>
    </div>
    <div class='f-right'>
      <?php
      echo html::export2csv($lang->exportCSV, $lang->setFileName);
      common::printLink('testtask', 'linkcase', "taskID=$task->id", $lang->testtask->linkCase);
      echo html::a($this->session->testtaskList, $lang->goback);
      ?>
    </div>
  </div>
</div>

<div class='yui-d0 <?php if($browseType == 'bymodule') echo 'yui-t1';?>' id='mainbox'>
  <div class='yui-main'>
    <div class='yui-b'>
      <form method='post' action='<?php echo inlink('batchAssign', "task=$task->id");?>' target='hiddenwin'>
      <table class='table-1 tablesorter datatable mb-zero fixed'>
        <thead>
          <tr class='colhead'>
            <th class='w-id'><nobr><?php echo $lang->idAB;?></nobr></th>
            <th class='w-pri'><?php echo $lang->priAB;?></th>
            <th><?php echo $lang->testcase->title;?></th>
            <th><?php echo $lang->testcase->type;?></th>
            <th><?php echo $lang->testtask->assignedTo;?></th>
            <th class='w-user'><?php echo $lang->testtask->lastRun;?></th>
            <th class='w-80px'><?php echo $lang->testtask->lastResult;?></th>
            <th class='w-status'><?php echo $lang->statusAB;?></th>
            <th class='w-160px {sorter: false}'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($runs as $run):?>
          <tr class='a-center'>
            <td class='a-left'><?php echo "<input type='checkbox' name='cases[]' value='$run->case' /> ";  printf('%03d', $run->case);?></td>
            <td><?php echo $run->pri?></td>
            <td class='a-left nobr'><?php echo html::a($this->createLink('testcase', 'view', "caseID=$run->case&version=$run->version"), $run->title, '_blank');?>
            </td>
            <td><?php echo $lang->testcase->typeList[$run->type];?></td>
            <td><?php $assignedTo = $users[$run->assignedTo]; echo substr($assignedTo, strpos($assignedTo, ':') + 1);?></td>
            <td><?php if(!helper::isZeroDate($run->lastRun)) echo date(DT_MONTHTIME1, strtotime($run->lastRun));?></td>
            <td class='<?php echo $run->lastResult;?>'><?php if($run->lastResult) echo $lang->testcase->resultList[$run->lastResult];?></td>
            <td class='<?php echo $run->status;?>'><?php echo $lang->testtask->statusList[$run->status];?></td>
            <td>
              <?php
              common::printLink('testtask', 'runcase',    "id=$run->id", $lang->testtask->runCase, '', 'class="iframe"');
              common::printLink('testtask', 'results',    "id=$run->id", $lang->testtask->results, '', 'class="iframe"');
              common::printLink('bug',      'create',     "product=$productID&extra=projectID=$task->project,buildID=$task->build,caseID=$run->case,runID=$run->id", $lang->testtask->createBug);
              common::printLink('testtask', 'unlinkcase', "id=$run->id", $lang->testtask->unlinkCase, 'hiddenwin');
              ?>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <table class='table-1'>
        <tr>
          <td><nobr><?php echo "<input type='checkbox' onclick='checkall(this);'> " . $lang->selectAll;?></nobr></td>
          <td colspan='9'>
            <?php
            echo html::select('assignedTo', $users);
            echo html::submitButton($lang->testtask->assign);
            ?>
          </td>
        </tr>
      </table>
      </form>
    </div>
  </div>
  <div class='yui-b  <?php if($browseType != 'bymodule') echo 'hidden';?>' id='treebox'>
    <div class='box-title'><?php echo $productName;?></div>
    <div class='box-content'><?php echo $moduleTree;?></div>
  </div>
</div>
<script language="Javascript">
$("#<?php echo $browseType;?>Tab").addClass('active');
$("#module<?php echo $moduleID;?>").addClass('active'); 
</script>
<?php include '../../common/view/footer.html.php';?>

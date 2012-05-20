<?php
/**
 * The todo view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<form method='post' target='hiddenwin' action='<?php echo $this->createLink('todo', 'import2Today');?>' id='todoform'>
  <div id='featurebar'>
    <div class='f-left'>
      <?php 
      echo '<span id="yesterday">'. html::a(inlink('todo', "date=yesterday"), $lang->todo->yesterdayTodos). '</span>';
      echo '<span id="today">'    . html::a(inlink('todo', "date=today"),     $lang->todo->todayTodos)    . '</span>';
      echo '<span id="thisweek">' . html::a(inlink('todo', "date=thisweek"),  $lang->todo->thisWeekTodos) . '</span>';
      echo '<span id="lastweek">' . html::a(inlink('todo', "date=lastweek"),  $lang->todo->lastWeekTodos) . '</span>';
      echo '<span id="thismonth">'. html::a(inlink('todo', "date=thismonth"), $lang->todo->thismonthTodos). '</span>';
      echo '<span id="lastmonth">' . html::a(inlink('todo', "date=lastmonth"), $lang->todo->lastmonthTodos). '</span>';
      echo '<span id="thisseason">'. html::a(inlink('todo', "date=thisseason"),$lang->todo->thisseasonTodos).'</span>';
      echo '<span id="thisyear">'  . html::a(inlink('todo', "date=thisyear"),  $lang->todo->thisyearTodos) . '</span>';
      echo '<span id="future">'   . html::a(inlink('todo', "date=future"),    $lang->todo->futureTodos)   . '</span>';
      echo '<span id="all">'      . html::a(inlink('todo', "date=all"),       $lang->todo->allDaysTodos)  . '</span>';
      echo '<span id="before">'   . html::a(inlink('todo', "date=before&account={$app->user->account}&status=undone"), $lang->todo->allUndone) . '</span>';
      echo "<span id='$date'>"    . html::input('date', $date,"class='select-2 date'") . '</span>';
      ?>
      <script>$('#<?php echo $type;?>').addClass('active')</script>
    </div>
    <div class='f-right'>
      <?php 
      common::printLink('todo', 'export', "account=$account&orderBy=id_desc", $lang->export, '', 'class="export"');
      common::printLink('todo', 'batchCreate', "", $lang->todo->batchCreate);
      echo html::a($this->createLink('todo', 'create', "date=$date"), $lang->todo->create);
      ?>
    </div>
  </div>
  <table class='table-1 tablesorter'>
    <thead>
    <tr class='colhead'>
      <th class='w-id'><?php echo $lang->idAB;?></th>
      <th class='w-date'><?php echo $lang->todo->date;?></th>
      <th class='w-type'><?php echo $lang->todo->type;?></th>
      <th class='w-pri'><?php echo $lang->priAB;?></th>
      <th><?php echo $lang->todo->name;?></th>
      <th class='w-hour'><?php echo $lang->todo->beginAB;?></th>
      <th class='w-hour'><?php echo $lang->todo->endAB;?></th>
      <th class='w-status'><?php echo $lang->todo->status;?></th>
      <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($todos as $todo):?>
    <tr class='a-center'>
      <td class='a-left'>
        <?php
        if($importFuture) echo "<input type='checkbox' name='todos[]' value='$todo->id' /> ";
        echo $todo->id;
        ?>
      </td>
      <td><?php echo $todo->date == '2030-01-01' ? $lang->todo->dayInFuture : $todo->date;?></td>
      <td><?php echo $lang->todo->typeList->{$todo->type};?></td>
      <td><?php echo $todo->pri;?></td>
      <td class='a-left'><?php echo html::a($this->createLink('todo', 'view', "id=$todo->id&from=my"), $todo->name);?></td>
      <td><?php echo $todo->begin;?></td>
      <td><?php echo $todo->end;?></td>
      <td class='<?php echo $todo->status;?>'><?php echo $lang->todo->statusList[$todo->status];?></td>
      <td>
        <?php 
        echo html::a($this->createLink('todo', 'mark',   "id=$todo->id&status=$todo->status"), $lang->todo->{'mark'.ucfirst($todo->status)}, 'hiddenwin');
        echo html::a($this->createLink('todo', 'view',   "id=$todo->id&from=my"), $lang->todo->viewAB);
        echo html::a($this->createLink('todo', 'edit',   "id=$todo->id"), $lang->edit);
        echo html::a($this->createLink('todo', 'delete', "id=$todo->id"), $lang->delete, 'hiddenwin');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <?php if($importFuture || $type == 'all'):?>
    <tfoot>
      <tr>
        <td colspan='9'>
        <?php if($importFuture):?>
        <div class='f-left'><input type='submit' value='<?php echo $lang->todo->import2Today;?>' /></div>
        <?php endif;?>
        <?php if($type == 'all') $pager->show();?>
        </td>
      </tr>
    </tfoot>
    <?php endif;?>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>

<div id='featurebar'>
  <div class='f-left'>
  <?php
    echo "<span id='byprojectTab' onclick='browseByProject()'>"; common::printLink('project', 'task',"project=$project->id", $lang->project->projectTasks); echo '</span>';
    echo "<span id='bymoduleTab'  onclick='browseByModule()'>";  common::printLink('project', 'task',"project=$project->id&type=byModule", $lang->project->moduleTask); echo '</span>';
    echo "<span id='allTab'>"         ; common::printLink('project', 'task', "project=$project->id&type=all",          $lang->project->allTasks);     echo  '</span>' ;
    echo "<span id='assignedtomeTab'>"; common::printLink('project', 'task', "project=$project->id&type=assignedtome", $lang->project->assignedToMe); echo  '</span>' ;
    echo "<span id='finishedbymeTab'>"; common::printLink('project', 'task', "project=$project->id&type=finishedbyme", $lang->project->finishedByMe); echo  '</span>' ;
    echo "<span id='waitTab'>"        ; common::printLink('project', 'task', "project=$project->id&type=wait",         $lang->project->statusWait);   echo  '</span>' ;
    echo "<span id='doingTab'>"       ; common::printLink('project', 'task', "project=$project->id&type=doing",        $lang->project->statusDoing);  echo  '</span>' ;
    echo "<span id='doneTab'>"        ; common::printLink('project', 'task', "project=$project->id&type=done",         $lang->project->statusDone);   echo  '</span>' ;
    echo "<span id='closedTab'>"      ; common::printLink('project', 'task', "project=$project->id&type=closed",       $lang->project->statusClosed); echo  '</span>' ;
    echo "<span id='delayedTab'>"     ; common::printLink('project', 'task', "project=$project->id&type=delayed",      $lang->project->delayed);      echo  '</span>' ;

    echo "<span id='groupTab'>";
    echo html::select('groupBy', $lang->project->groups, isset($groupBy) ? $groupBy : '', "onchange='switchGroup({$project->id}, this.value)'");
    echo "</span>";
    echo "<span id='needconfirmTab'>"; common::printLink('project', 'task',  "project=$project->id&status=needConfirm",$lang->project->listTaskNeedConfrim); echo  '</span>' ;
    echo "<span id='bysearchTab'><a href='#'><span class='icon-search'></span>{$lang->project->byQuery}</a></span> ";
    ?>
  </div>
  <div class='f-right'>
    <?php 
    if($browseType != 'needconfirm') common::printLink('task', 'export', "projectID=$projectID&orderBy=$orderBy", '&nbsp;', '', "class='export icon-green-big-export' title='{$lang->export}'");
    common::printLink('project', 'importTask', "project=$project->id", $lang->project->importTask);
    common::printLink('project', 'importBug', "projectID=$project->id", $lang->project->importBug);
    common::printLink('task', 'report', "project=$project->id&browseType=$browseType", '&nbsp;', '', "class='icon-green-big-report' title='{$lang->task->report->common}'");
    common::printLink('task', 'batchCreate', "projectID=$project->id", '&nbsp;', '', "class='icon-green-big-task-batchCreate' title='{$lang->task->batchCreate}'");
    common::printLink('task', 'create', "project=$project->id", '&nbsp;', '', "class='icon-green-big-task-create' title='{$lang->task->create}'");
    ?>
  </div>
</div>

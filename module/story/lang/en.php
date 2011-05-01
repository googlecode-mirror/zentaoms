<?php
/**
 * The story module English file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->story->browse      = "Browse";
$lang->story->create      = "Create";
$lang->story->change      = "Change";
$lang->story->changed     = 'Changed';
$lang->story->review      = 'Review';
$lang->story->edit        = "Edit";
$lang->story->close       = 'Close';
$lang->story->activate    = 'Activate';
$lang->story->delete      = "Delete";
$lang->story->view        = "Info";
$lang->story->tasks       = "Tasks";
$lang->story->taskCount   = 'Tasks count';
$lang->story->bugs        = "Bug";
$lang->story->linkStory   = 'Related story';
$lang->story->export      = "Export";
$lang->story->reportChart = "Report";

$lang->story->common         = 'Story';
$lang->story->id             = 'ID';
$lang->story->product        = 'Product';
$lang->story->module         = 'Module';
$lang->story->release        = 'Release';
$lang->story->bug            = 'Related Bug';
$lang->story->title          = 'Title';
$lang->story->spec           = 'Spec';
$lang->story->verify         = 'Verify';
$lang->story->type           = 'Type ';
$lang->story->pri            = 'Priority';
$lang->story->estimate       = 'Estimate';
$lang->story->estimateAB     = 'Estimate';
$lang->story->status         = 'Status';
$lang->story->stage          = 'Stage';
$lang->story->stageAB        = 'Stage';
$lang->story->mailto         = 'Mailto';
$lang->story->openedBy       = 'Opened by';
$lang->story->openedDate     = 'Opened date';
$lang->story->assignedTo     = 'Assigned to';
$lang->story->assignedDate   = 'Assigned date';
$lang->story->lastEditedBy   = 'Last edited by';
$lang->story->lastEditedDate = 'Last edited date';
$lang->story->lastEdited     = 'Last edited';
$lang->story->closedBy       = 'Closed by';
$lang->story->closedDate     = 'Closed date';
$lang->story->closedReason   = 'Closed reason';
$lang->story->rejectedReason = 'Reject reason';
$lang->story->reviewedBy     = 'Reviewed by';
$lang->story->reviewedDate   = 'Reviewed date';
$lang->story->version        = 'Version';
$lang->story->project        = 'Project';
$lang->story->plan           = 'Plan';
$lang->story->planAB         = 'Plan';
$lang->story->comment        = 'Comment';
$lang->story->linkStories    = 'Related story';
$lang->story->childStories   = 'Child story';
$lang->story->duplicateStory = 'Duplicate story';
$lang->story->reviewResult   = 'Reviewed result';
$lang->story->preVersion     = 'Pre version';
$lang->story->keywords       = 'Keyword';

$lang->story->statusList['']          = '';
$lang->story->statusList['draft']     = 'Draft';
$lang->story->statusList['active']    = 'Active';
$lang->story->statusList['closed']    = 'Closed';
$lang->story->statusList['changed']   = 'Changed';

$lang->story->stageList['']           = '';
$lang->story->stageList['wait']       = 'Waitting';
$lang->story->stageList['planned']    = 'Planned';
$lang->story->stageList['projected']  = 'Projected';
$lang->story->stageList['developing'] = 'Developing';
$lang->story->stageList['developed']  = 'Developed';
$lang->story->stageList['testing']    = 'Testing';
$lang->story->stageList['tested']     = 'Tested';
$lang->story->stageList['verified']   = 'Verified';
$lang->story->stageList['released']   = 'Released';

$lang->story->reasonList['']           = '';
$lang->story->reasonList['done']       = 'Done';
$lang->story->reasonList['subdivided'] = 'Subdivided';
$lang->story->reasonList['duplicate']  = 'Duplicate';
$lang->story->reasonList['postponed']  = 'Postponed';
$lang->story->reasonList['willnotdo']  = "Won't do";
$lang->story->reasonList['cancel']     = 'Canceled';
$lang->story->reasonList['bydesign']   = 'By design';
//$lang->story->reasonList['isbug']      = '是个Bug';

$lang->story->reviewResultList['']       = '';
$lang->story->reviewResultList['pass']   = 'Pass';
$lang->story->reviewResultList['revert'] = 'Revert';
$lang->story->reviewResultList['clarify']= 'Clarify';
$lang->story->reviewResultList['reject'] = 'Reject';

$lang->story->priList[]   = '';
$lang->story->priList[3]  = '3';
$lang->story->priList[1]  = '1';
$lang->story->priList[2]  = '2';
$lang->story->priList[4]  = '4';

$lang->story->legendBasicInfo      = 'Basic info';
$lang->story->legendLifeTime       = 'Life time';
$lang->story->legendRelated        = 'Related info';
$lang->story->legendMailto         = 'Maitto';
$lang->story->legendAttatch        = 'Files';
$lang->story->legendProjectAndTask = 'Project & task';
$lang->story->legendLinkStories    = 'Related story';
$lang->story->legendChildStories   = 'Child story';
$lang->story->legendSpec           = 'Spec';
$lang->story->legendVerify         = 'Verify standard';
$lang->story->legendHistory        = 'History';
$lang->story->legendVersion        = 'Versions';
$lang->story->legendMisc           = 'Misc';

$lang->story->lblChange            = 'Change';
$lang->story->lblReview            = 'Review';
$lang->story->lblActivate          = 'Activate';
$lang->story->lblClose             = 'Close';

$lang->story->affectedProjects     = 'Affected projects';
$lang->story->affectedBugs         = 'Affected bugs';
$lang->story->affectedCases        = 'Affected cases';

$lang->story->specTemplate          = "Recommend template:：As <<i class='red'>a type of user</i>>,I want <<i class='red'>some goals</i>>,so that <<i class='red'>some reason</i>>.";
$lang->story->needNotReview         = "needn't review";
$lang->story->confirmDelete         = "Are you sure to delete this story?";
$lang->story->errorFormat           = 'Error format';
$lang->story->errorEmptyTitle       = "Title can't be empty";
$lang->story->mustChooseResult      = 'Must choose s result';
$lang->story->mustChoosePreVersion  = 'Must select an version to revert';
$lang->story->ajaxGetProjectStories = 'API:Project stories';
$lang->story->ajaxGetProductStories = 'API:Product stories';

$lang->story->action->reviewed            = array('main' => '$date, Reviewed by <strong>$actor</strong>, result is <strong>$extra</strong>.', 'extra' => $lang->story->reviewResultList);
$lang->story->action->closed              = array('main' => '$date, Closed by <strong>$actor</strong>, reason is <strong>$extra</strong>.', 'extra' => $lang->story->reasonList);
$lang->story->action->linked2plan         = array('main' => '$date, Linked to plan <strong>$extra</strong> by <strong>$actor</strong>.'); 
$lang->story->action->unlinkedfromplan    = array('main' => '$date, Removed from <stong>$extra></strong> by <strong>$actor</strong>'); 
$lang->story->action->linked2project      = array('main' => '$date, Linked to project <strong>$extra</strong> by <strong>$actor</strong>.'); 
$lang->story->action->unlinkedfromproject = array('main' => '$date, Removed from project <strontg>$extra</strong> by <strong>$actor</strong>.');

/* Report*/
$lang->story->report->common        = 'Report';
$lang->story->report->select        = 'Select';
$lang->story->report->create        = 'Creat';
$lang->story->report->selectAll     = 'All';
$lang->story->report->selectReverse = 'Reverse';

$lang->story->report->charts['storysPerProduct']        = 'Product storys';
$lang->story->report->charts['storysPerModule']         = 'Module storys';
$lang->story->report->charts['storysPerPlan']           = 'Plan storys';
$lang->story->report->charts['storysPerStatus']         = 'Sotrys of status';
$lang->story->report->charts['storysPerStage']          = 'Storys of stage';
$lang->story->report->charts['storysPerPri']            = 'Storys of priority';
$lang->story->report->charts['storysPerEstimate']       = 'Storys of Estimate';
$lang->story->report->charts['storysPerOpenedBy']       = 'Opened by user';
$lang->story->report->charts['storysPerAssignedTo']     = 'Assigned to user';
$lang->story->report->charts['storysPerClosedReason']   = 'Storys for reason';
$lang->story->report->charts['storysPerChange']         = 'Storys of change';

$lang->story->report->options->swf                     = 'pie2d';
$lang->story->report->options->width                   = 'auto';
$lang->story->report->options->height                  = 300;
$lang->story->report->options->graph->baseFontSize     = 12;
$lang->story->report->options->graph->showNames        = 1;
$lang->story->report->options->graph->formatNumber     = 1;
$lang->story->report->options->graph->decimalPrecision = 0;
$lang->story->report->options->graph->animation        = 0;
$lang->story->report->options->graph->rotateNames      = 0;
$lang->story->report->options->graph->yAxisName        = 'COUNT';
$lang->story->report->options->graph->pieRadius        = 100; // 饼图直径。
$lang->story->report->options->graph->showColumnShadow = 0;   // 是否显示柱状图阴影。

$lang->story->report->storysPerProduct->graph->xAxisName      = 'Product';
$lang->story->report->storysPerModule->graph->xAxisName       = 'Module';
$lang->story->report->storysPerPlan->graph->xAxisName         = 'Plan';
$lang->story->report->storysPerStatus->graph->xAxisName       = 'Status';
$lang->story->report->storysPerStage->graph->xAxisName        = 'Stage';
$lang->story->report->storysPerPri->graph->xAxisName          = 'Priority';
$lang->story->report->storysPerOpenedBy->graph->xAxisName     = 'Opened by';
$lang->story->report->storysPerAssignedTo->graph->xAxisName   = 'Assigned to';
$lang->story->report->storysPerClosedReason->graph->xAxisName = 'Closed reason';

$lang->story->report->storysPerEstimate->swf                = 'column2d';
$lang->story->report->storysPerEstimate->height             = 400;
$lang->story->report->storysPerEstimate->graph->xAxisName   = 'Estimate';
$lang->story->report->storysPerEstimate->graph->rotateNames = 1;

$lang->story->report->storysPerChange->swf                 = 'column2d';
$lang->story->report->storysPerChange->height              = 400;
$lang->story->report->storysPerChange->graph->xAxisName    = 'Change';
$lang->story->report->storysPerChange->graph->rotateNames  = 1;

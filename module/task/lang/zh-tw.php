<?php
/**
 * The task module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: zh-tw.php 1326 2010-11-28 13:10:34Z wwccss $
 * @link        http://www.zentao.net
 */
$lang->task->index     = "任務一覽";
$lang->task->create    = "新增任務";
$lang->task->import    = "導入之前未完任務";
$lang->task->edit      = "更新任務";
$lang->task->delete    = "刪除任務";
$lang->task->view      = "查看任務";
$lang->task->logEfforts= "記錄工時";
$lang->task->start     = "開始任務";
$lang->task->finish    = "完成任務";
$lang->task->close     = "關閉任務";
$lang->task->cancel    = "取消任務";
$lang->task->activate  = "激活任務";
$lang->task->confirmStoryChange = "確認需求變動";

$lang->task->common       = '任務';
$lang->task->id           = '編號';
$lang->task->project      = '所屬項目';
$lang->task->story        = '相關需求';
$lang->task->storyVersion = '需求版本';
$lang->task->name         = '任務名稱';
$lang->task->type         = '任務類型';
$lang->task->pri          = '優先順序';
$lang->task->mailto       = '抄送給';
$lang->task->estimate     = '最初預計';
$lang->task->estimateAB   = '預計';
$lang->task->left         = '預計剩餘';
$lang->task->leftAB       = '剩餘';
$lang->task->consumed     = '已經消耗';
$lang->task->consumedAB   = '消耗';
$lang->task->deadline     = '截止日期';
$lang->task->deadlineAB   = '截止';
$lang->task->status       = '任務狀態';
$lang->task->statusCustom = '狀態排序';
$lang->task->desc         = '任務描述';
$lang->task->assignedTo   = '指派給';
$lang->task->assignedDate = '指派日期';
$lang->task->openedBy     = '由誰創建';
$lang->task->openedDate   = '創建日期';
$lang->task->finishedBy   = '由誰完成';
$lang->task->finishedDate = '完成時間';
$lang->task->canceledBy   = '由誰取消';
$lang->task->canceledDate = '取消時間';
$lang->task->closedBy     = '由誰關閉';
$lang->task->closedDate   = '關閉時間';
$lang->task->closedReason = '關閉原因';
$lang->task->lastEdited   = '最後編輯';

$lang->task->statusList['wait']    = '未開始';
$lang->task->statusList['doing']   = '進行中';
$lang->task->statusList['done']    = '已完成';
$lang->task->statusList['cancel']  = '已取消';
$lang->task->statusList['closed']  = '已關閉';

$lang->task->typeList[''] = '';
$lang->task->typeList['design'] = '設計';
$lang->task->typeList['devel']  = '開發';
$lang->task->typeList['test']   = '測試';
$lang->task->typeList['study']  = '研究';
$lang->task->typeList['discuss']= '討論';
$lang->task->typeList['ui']     = '界面';
$lang->task->typeList['affair'] = '事務';
$lang->task->typeList['misc']   = '其他';

$lang->task->priList[0] = '';
$lang->task->priList[3]  = '3';
$lang->task->priList[1]  = '1';
$lang->task->priList[2]  = '2';
$lang->task->priList[4]  = '4';

$lang->task->reasonList['']       = '';
$lang->task->reasonList['done']   = '已完成';
$lang->task->reasonList['cancel'] = '已取消';

$lang->task->afterChoices['continueAdding'] = '繼續為該需求添加任務';
$lang->task->afterChoices['toTastList']     = '返回任務列表';
$lang->task->afterChoices['toStoryList']    = '返回需求列表';

$lang->task->buttonEdit       = '編輯';
$lang->task->buttonClose      = '關閉';
$lang->task->buttonCancel     = '取消';
$lang->task->buttonActivate   = '激活';
$lang->task->buttonLogEfforts = '記錄工時';
$lang->task->buttonDelete     = '刪除';
$lang->task->buttonBackToList = '返回';
$lang->task->buttonStart      = '開始';
$lang->task->buttonDone       = '完成';

$lang->task->legendBasic  = '基本信息';
$lang->task->legendEffort = '工時信息';
$lang->task->legendLife   = '任務的一生';
$lang->task->legendDesc   = '任務描述';
$lang->task->legendAction = '操作';

$lang->task->ajaxGetUserTasks    = "介面:我的任務";
$lang->task->ajaxGetProjectTasks = "介面:項目任務";
$lang->task->confirmDelete       = "您確定要刪除這個任務嗎？";
$lang->task->copyStoryTitle      = "同需求";
$lang->task->afterSubmit         = "添加之後";
$lang->task->successSaved        = "成功添加，";
$lang->task->delayWarning        = " <strong class='delayed f-14px'> 延期%s天 </strong>";

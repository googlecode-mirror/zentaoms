<?php
/**
 * The task module zh-cn file of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->task->index     = "任务一览";
$lang->task->create    = "新增任务";
$lang->task->import    = "导入之前未完任务";
$lang->task->edit      = "更新任务";
$lang->task->delete    = "删除任务";
$lang->task->view      = "查看任务";
$lang->task->logEfforts= "记录工时";
$lang->task->start     = "开始任务";
$lang->task->complete  = "完成任务";
$lang->task->close     = "关闭任务";
$lang->task->cancel    = "取消任务";
$lang->task->activate  = "激活任务";
$lang->task->confirmStoryChange = "确认需求变动";

$lang->task->common       = '任务';
$lang->task->id           = '编号';
$lang->task->project      = '所属项目';
$lang->task->story        = '相关需求';
$lang->task->storyVersion = '需求版本';
$lang->task->name         = '任务名称';
$lang->task->type         = '任务类型';
$lang->task->pri          = '优先级';
$lang->task->owner        = '指派给';
$lang->task->mailto       = '抄送给';
$lang->task->estimate     = '最初预计';
$lang->task->estimateAB   = '预计';
$lang->task->left         = '预计剩余';
$lang->task->leftAB       = '剩余';
$lang->task->consumed     = '已经消耗';
$lang->task->consumedAB   = '消耗';
$lang->task->deadline     = '截止日期';
$lang->task->deadlineAB   = '截止';
$lang->task->status       = '任务状态';
$lang->task->desc         = '任务描述';
$lang->task->statusCustom = '状态排序';

$lang->task->statusList['wait']    = '未开始';
$lang->task->statusList['doing']   = '进行中';
$lang->task->statusList['done']    = '已完成';
$lang->task->statusList['cancel']  = '已取消';

$lang->task->typeList[''] = '';
$lang->task->typeList['design'] = '设计';
$lang->task->typeList['devel']  = '开发';
$lang->task->typeList['test']   = '测试';
$lang->task->typeList['study']  = '研究';
$lang->task->typeList['discuss']= '讨论';
$lang->task->typeList['ui']     = '界面';
$lang->task->typeList['affair'] = '事务';
$lang->task->typeList['misc']   = '其他';

$lang->task->priList[0] = '';
$lang->task->priList[3]  = '3';
$lang->task->priList[1]  = '1';
$lang->task->priList[2]  = '2';
$lang->task->priList[4]  = '4';

$lang->task->afterChoices['continueAdding'] = '继续为该需求添加任务';
$lang->task->afterChoices['toTastList']     = '返回任务列表';
$lang->task->afterChoices['toStoryList']    = '返回需求列表';

$lang->task->buttonEdit       = '编辑';
$lang->task->buttonClose      = '关闭';
$lang->task->buttonCancel     = '取消';
$lang->task->buttonActivate   = '激活';
$lang->task->buttonLogEfforts = '记录工时';
$lang->task->buttonDelete     = '删除';
$lang->task->buttonBackToList = '返回';
$lang->task->buttonStart      = '开始';
$lang->task->buttonDone       = '完成';

$lang->task->legendBasic  = '基本信息';
$lang->task->legendEffort = '工时信息';
$lang->task->legendDesc   = '任务描述';
$lang->task->legendAction = '操作';

$lang->task->ajaxGetUserTasks    = "接口:我的任务";
$lang->task->ajaxGetProjectTasks = "接口:项目任务";
$lang->task->confirmDelete       = "您确定要删除这个任务吗？";
$lang->task->copyStoryTitle      = "同需求";
$lang->task->afterSubmit         = "添加之后";
$lang->task->successSaved        = "成功添加，";
$lang->task->delayWarning        = " <strong class='delayed f-14px'> 延期%s天 </strong>";

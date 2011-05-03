<?php
global $lang;
$config->task->create->requiredFields   = 'name,estimate,type,pri';
$config->task->edit->requiredFields     = $config->task->create->requiredFields;
$config->task->start->requiredFields    = 'estimate';
$config->task->finish->requiredFields   = 'consumed';
$config->task->activate->requiredFields = 'left';

$config->task->search['module']                   = 'task';
$config->task->search['fields']['name']           = $lang->task->name;
$config->task->search['fields']['assignedTo']     = $lang->task->assignedTo;
$config->task->search['fields']['id']             = $lang->task->id;
$config->task->search['fields']['status']         = $lang->task->status;
$config->task->search['fields']['pri']            = $lang->task->pri;
$config->task->search['fields']['type']           = $lang->task->type;

$config->task->search['params']['name']         = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->task->search['params']['assignedTo']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->task->search['params']['status']       = array('operator' => '=',       'control' => 'select', 'values' => $lang->task->statusList);
$config->task->search['params']['pri']          = array('operator' => '=',       'control' => 'select', 'values' => $lang->task->priList);
$config->task->search['params']['type']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->task->typeList);

$config->task->editor->create = array('id' => 'desc', 'tools' => 'simpleTools');
$config->task->editor->edit   = array('id' => 'desc', 'tools' => 'simpleTools');

$config->task->exportFields = '
    id, project, story,
    name, desc,
    type, pri,  deadline, status,estimate, consumed, left,
    mailto,
    openedBy, openedDate, assignedTo, assignedDate, 
    finishedBy, finishedDate, canceledBy, canceledDate,
    closedBy, closedDate, closedReason,
    lastEditedBy, lastEditedDate,files
    ';

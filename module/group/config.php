<?php
$config->group = new stdclass();
$config->group->showUsers = 20;
$config->group->create = new stdclass();
$config->group->edit   = new stdclass();
$config->group->create->requiredFields = 'name';
$config->group->edit->requiredFields   = 'name';

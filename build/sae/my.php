<?php
$config->installed   = false;
$config->debug       = false;
$config->requestType = 'PATH_INFO';

$config->db->host        = SAE_MYSQL_HOST_M;
$config->db->slaveHost   = SAE_MYSQL_HOST_S;
$config->db->port        = SAE_MYSQL_PORT;
$config->db->name        = SAE_MYSQL_DB;
$config->db->user        = SAE_MYSQL_USER;
$config->db->password    = SAE_MYSQL_PASS;
$config->db->prefix      = 'zt_';
$config->db->checkCentOS = false;

$config->slaveDB->host        = SAE_MYSQL_HOST_S;
$config->slaveDB->port        = SAE_MYSQL_PORT;
$config->slaveDB->name        = SAE_MYSQL_DB;
$config->slaveDB->user        = SAE_MYSQL_USER;
$config->slaveDB->password    = SAE_MYSQL_PASS;
$config->slaveDB->checkCentOS = false;

$config->webRoot         = '/';
$config->default->domain = $_SERVER['HTTP_HOST'];
$config->default->lang   = 'zh-cn';

$config->sae->storage->domain = 'zentao';

$saeDB  = new saemysql();
$saeSQL = "SELECT COUNT(`id`) FROM `" . $config->db->prefix . "config` WHERE 1 LIMIT 0,10";
if($saeDB->getData($saeSQL)) $config->installed = true;
$saeDB->closeDb();

$appRoot      = dirname(dirname(__FILE__)) . '/' ;
$htaccessFile = $appRoot . 'htaccess';
if(file_exists($htaccessFile)) rename($htaccessFile, str_replace('htaccess', '.htaccss', $htaccessFile));

$tmpRoot = $appRoot . '/tmp/';
if(!is_dir($tmpRoot)) 
{
    mkdir($tmpRoot, 0777);
    mkdir($tmpRoot . 'cache', 0777);
    mkdir($tmpRoot . 'extension', 0777);
    mkdir($tmpRoot . 'log', 0777);
    mkdir($tmpRoot . 'model', 0777);
    mkdir($tmpRoot . 'svn', 0777);
}

$dataRoot = $appRoot . 'data/';
if(!is_dir($dataRoot))
{
    mkdir($dataRoot, 0777);
    mkdir($dataRoot . 'upload', 0777);
}

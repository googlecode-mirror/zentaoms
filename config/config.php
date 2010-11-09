<?php
/**
 * The config file of ZenTaoPMS
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/* 基本参数设定。*/
$config->version     = '1.3';             // 版本号，切勿修改。
$config->encoding    = 'UTF-8';           // 网站的编码。
$config->cookiePath  = '/';               // cookie的有效路径。
$config->cookieLife  = time() + 2592000;  // cookie的生命周期。
$config->timezone    = 'Asia/Shanghai';   // 时区设置，详细的列表，请访问 http://www.php.net/manual/en/timezones.php

/* 请求方式设置。*/
$config->requestType = 'PATH_INFO';       // 如何获取当前请求的信息，可选值：PATH_INFO|GET
$config->pathType    = 'clean';           // requestType=PATH_INFO: 请求url的格式，可选值为full|clean，full格式会带有参数名称，clean则只有取值。
$config->requestFix  = '-';               // requestType=PATH_INFO: 请求url的分隔符，可选值为斜线、减号。后面两种形式有助于SEO。
$config->moduleVar   = 'm';               // requestType=GET: 模块变量名。
$config->methodVar   = 'f';               // requestType=GET: 方法变量名。
$config->viewVar     = 't';               // requestType=GET: 模板变量名。
$config->sessionVar  = 'sid';             // requestType=GET: session变量名。

/* 视图和主题。*/
$config->views       = ',html,json,csv,'; // 支持的视图列表。
$config->themes      = 'default,blue';    // 支持的主题列表。

/* 支持的语言列表。*/
$config->langs['zh-cn'] = '中文简体';
$config->langs['zh-tw'] = '中文繁體';
$config->langs['en']    = 'English';
$config->langs['ja']    = 'Japanese';
$config->langs['ko']    = 'Korean';

/* 默认参数设定。*/
$config->default->view   = 'html';             // 默认的视图格式。
$config->default->lang   = 'zh-cn';            // 默认的语言。
$config->default->theme  = 'default';          // 默认的主题。
$config->default->module = 'index';            // 默认的模块。当请求中没有指定模块时，加载该模块。
$config->default->method = 'index';            // 默认的方法。当请求中没有指定方法或者指定的方法不存在时，调用该方法。

/* 上传附件参数设定。*/
$config->file->dangers = 'php,jsp,py,rb,asp,'; // 不允许上传的文件类型列表。
$config->file->maxSize = 1024 * 1024;          // 允许上传的文件大小，单位为字节。

/* 数据库参数设定。*/
$config->db->persistant = false;               // 是否打开持久连接。
$config->db->driver     = 'mysql';             // pdo的驱动类型，目前暂时只支持mysql。
$config->db->dao        = true;                // 是否使用DAO。
$config->db->encoding   = 'UTF8';              // 数据库的编码。
$config->db->strictMode = false;               // 关闭MySQL的严格模式。

/* 通过对象引用全局变量。*/
$config->super2OBJ = true;

/* 包含自定义配置文件。*/
$myConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'my.php';
if(file_exists($myConfig)) include $myConfig;
if(!isset($config->db->prefix)) $config->db->prefix = 'zt_';

/* 数据表的定义。*/
define('TABLE_COMPANY',        $config->db->prefix . 'company');
define('TABLE_DEPT',           $config->db->prefix . 'dept');
define('TABLE_CONFIG',         $config->db->prefix . 'config');
define('TABLE_USER',           $config->db->prefix . 'user');
define('TABLE_TODO',           $config->db->prefix . 'todo');
define('TABLE_GROUP',          $config->db->prefix . 'group');
define('TABLE_GROUPPRIV',      $config->db->prefix . 'groupPriv');
define('TABLE_USERGROUP',      $config->db->prefix . 'userGroup');
define('TABLE_USERQUERY',      $config->db->prefix . 'userQuery');

define('TABLE_BUG',            $config->db->prefix . 'bug');
define('TABLE_CASE',           $config->db->prefix . 'case');
define('TABLE_CASESTEP',       $config->db->prefix . 'caseStep');
define('TABLE_TESTTASK',       $config->db->prefix . 'testTask');
define('TABLE_TESTRUN',        $config->db->prefix . 'testRun');
define('TABLE_TESTRESULT',     $config->db->prefix . 'testResult');
define('TABLE_USERTPL',        $config->db->prefix . 'userTPL');

define('TABLE_PRODUCT',        $config->db->prefix . 'product');
define('TABLE_STORY',          $config->db->prefix . 'story');
define('TABLE_STORYSPEC',      $config->db->prefix . 'storySpec');
define('TABLE_PRODUCTPLAN',    $config->db->prefix . 'productPlan');
define('TABLE_RELEASE',        $config->db->prefix . 'release');

define('TABLE_PROJECT',        $config->db->prefix . 'project');
define('TABLE_TASK',           $config->db->prefix . 'task');
define('TABLE_TEAM',           $config->db->prefix . 'team');
define('TABLE_PROJECTPRODUCT', $config->db->prefix . 'projectProduct');
define('TABLE_PROJECTSTORY',   $config->db->prefix . 'projectStory');
define('TABLE_TASKESTIMATE',   $config->db->prefix . 'taskEstimate');
define('TABLE_EFFORT',         $config->db->prefix . 'effort');
define('TABLE_BURN',           $config->db->prefix . 'burn');
define('TABLE_BUILD',          $config->db->prefix . 'build');

define('TABLE_DOCLIB',         $config->db->prefix . 'docLib');
define('TABLE_DOC',            $config->db->prefix . 'doc');

define('TABLE_MODULE',         $config->db->prefix . 'module');
define('TABLE_ACTION',         $config->db->prefix . 'action');
define('TABLE_FILE',           $config->db->prefix . 'file');
define('TABLE_HISTORY',        $config->db->prefix . 'history');

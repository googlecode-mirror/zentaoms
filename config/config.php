<?php
/**
 * The config file of ZenTaoMS
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *                                                                             
 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.  
 *
 * @copyright   Copyright 2009-2010 �ൺ�����촴����Ƽ����޹�˾(www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentaoms.com
 */
/* ���������趨��*/
$config->version     = '1.1';             // �汾�ţ������޸ġ�
$config->encoding    = 'UTF-8';           // ��վ�ı��롣
$config->cookiePath  = '/';               // cookie����Ч·����
$config->cookieLife  = time() + 2592000;  // cookie���������ڡ�
$config->timezone    = 'Asia/Shanghai';   // ʱ�����ã���ϸ���б������ http://www.php.net/manual/en/timezones.php

/* ����ʽ���á�*/
$config->requestType = 'PATH_INFO';       // ��λ�ȡ��ǰ�������Ϣ����ѡֵ��PATH_INFO|GET
$config->pathType    = 'clean';           // requestType=PATH_INFO: ����url�ĸ�ʽ����ѡֵΪfull|clean��full��ʽ����в������ƣ�clean��ֻ��ȡֵ��
$config->requestFix  = '-';               // requestType=PATH_INFO: ����url�ķָ�������ѡֵΪб�ߡ����š�����������ʽ������SEO��
$config->moduleVar   = 'm';               // requestType=GET: ģ���������
$config->methodVar   = 'f';               // requestType=GET: ������������
$config->viewVar     = 't';               // requestType=GET: ģ���������
$config->sessionVar  = 'sid';             // requestType=GET: session��������

/* ��ͼ�����⡣*/
$config->views       = ',html,json,csv,'; // ֧�ֵ���ͼ�б�
$config->themes      = 'default,blue';    // ֧�ֵ������б�

/* ֧�ֵ������б�*/
$config->langs['zh-cn'] = 'Chinese Simplified';

/* Ĭ�ϲ����趨��*/
$config->default->view   = 'html';             // Ĭ�ϵ���ͼ��ʽ��
$config->default->lang   = 'zh-cn';            // Ĭ�ϵ����ԡ�
$config->default->theme  = 'default';          // Ĭ�ϵ����⡣
$config->default->module = 'index';            // Ĭ�ϵ�ģ�顣��������û��ָ��ģ��ʱ�����ظ�ģ�顣
$config->default->method = 'index';            // Ĭ�ϵķ�������������û��ָ����������ָ���ķ���������ʱ�����ø÷�����

/* �ϴ����������趨��*/
$config->file->dangers = 'php,jsp,py,rb,asp,'; // �������ϴ����ļ������б�
$config->file->maxSize = 1024 * 1024;          // �����ϴ����ļ���С����λΪ�ֽڡ�

/* ���ݿ�����趨��*/
$config->db->persistant = false;               // �Ƿ�򿪳־����ӡ�
$config->db->driver     = 'mysql';             // pdo���������ͣ�Ŀǰ��ʱֻ֧��mysql��
$config->db->dao        = true;                // �Ƿ�ʹ��DAO��
$config->db->encoding   = 'UTF8';              // ���ݿ�ı��롣
$config->db->strictMode = false;               // �ر�MySQL���ϸ�ģʽ��

/* ͨ����������ȫ�ֱ�����*/
$config->super2OBJ = true;

/* �����Զ��������ļ���*/
$myConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'my.php';
if(file_exists($myConfig)) include $myConfig;
if(!isset($config->db->prefix)) $config->db->prefix = 'zt_';

/* ���ݱ�Ķ��塣*/
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

define('TABLE_MODULE',         $config->db->prefix . 'module');
define('TABLE_ACTION',         $config->db->prefix . 'action');
define('TABLE_FILE',           $config->db->prefix . 'file');
define('TABLE_HISTORY',        $config->db->prefix . 'history');

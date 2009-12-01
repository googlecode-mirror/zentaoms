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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
$config->version     = '0.2 alpha';      // �汾�ţ������޸ġ�
$config->debug       = true;             // �Ƿ��debug���ܡ�
$config->webRoot     = '/';               // web��վ�ĸ�Ŀ¼��
$config->encoding    = 'UTF-8';           // ��վ�ı��롣
$config->cookiePath  = '/';               // cookie����Ч·����
$config->cookieLife  = time() + 2592000;  // cookie���������ڡ�

$config->requestType = 'PATH_INFO';       // ��λ�ȡ��ǰ�������Ϣ����ѡֵ��PATH_INFO|GET
$config->pathType    = 'clean';           // requestType=PATH_INFO: ����url�ĸ�ʽ����ѡֵΪfull|clean��full��ʽ����в������ƣ�clean��ֻ��ȡֵ��
$config->strictParams= false;             // ���ݲ����������Ƿ��뷽��������������ȫһ�¡������Ϊfalse������Ҫ��֤˳��һ�¡�
$config->requestFix  = '-';               // requestType=PATH_INFO: ����url�ķָ�������ѡֵΪб�ߡ��»��ߡ����š�����������ʽ������SEO��
$config->moduleVar   = 'm';               // requestType=GET: ģ���������
$config->methodVar   = 'f';               // requestType=GET: ������������
$config->viewVar     = 't';               // requestType=GET: ģ���������

$config->views       = ',html,xml,json,txt,csv,doc,pdf,'; // ֧�ֵ���ͼ�б�
$config->langs       = 'zh-cn,zh-tw,zh-hk,en';            // ֧�ֵ������б�
$config->themes      = 'default';                         // ֧�ֵ������б�

$config->super2OBJ   = true;    // �Ƿ�ͨ������������ȫ�ֱ�����

$config->default->view   = 'html';                      // Ĭ�ϵ���ͼ��ʽ��
$config->default->lang   = 'zh-cn';                     // Ĭ�ϵ����ԡ�
$config->default->theme  = 'default';                   // Ĭ�ϵ����⡣
$config->default->module = 'index';                     // Ĭ�ϵ�ģ�顣��������û��ָ��ģ��ʱ�����ظ�ģ�顣
$config->default->method = 'index';                     // Ĭ�ϵķ�������������û��ָ����������ָ���ķ���������ʱ�����ø÷�����
$config->default->domain = 'pms.easysoft.com';          // Ĭ�ϵ��������������е�����û�ж�Ӧ�ļ�¼ʱ��ʹ�ô�Ĭ��������Ӧ�Ĺ�˾��Ϣ��

$config->file->dangers = 'php,jsp,py,rb,asp,';          // �������ϴ����ļ������б�
$config->file->maxSize = 1024 * 1024;                   // �����ϴ����ļ���С����λΪ�ֽڡ�

$config->db->errorMode  = PDO::ERRMODE_EXCEPTION;       // PDO�Ĵ���ģʽ: PDO::ERRMODE_SILENT|PDO::ERRMODE_WARNING|PDO::ERRMODE_EXCEPTION
$config->db->persistant = false;                        // �Ƿ�򿪳־����ӡ�
$config->db->driver     = 'mysql';                      // pdo���������ͣ�Ŀǰ��ʱֻ֧��mysql��
$config->db->host       = '127.0.0.1';                  // mysql������
$config->db->port       = '3306';                       // mysql�����˿ںš�
$config->db->name       = 'zentao';                     // ���ݿ����ơ�
$config->db->user       = 'root';                       // ���ݿ��û�����
$config->db->password   = '';                           // ���롣
$config->db->encoding   = 'UTF8';                       // ���ݿ�ı��롣
$config->db->prefix     = 'zt_';                        // ���ݱ�ǰ׺��
$config->db->dao        = true;                         // �Ƿ�ʹ��DAO��
define('TABLE_ACTION',         $config->db->prefix . 'action');
define('TABLE_BUG',            $config->db->prefix . 'bug');
define('TABLE_BUILD',          $config->db->prefix . 'build');
define('TABLE_CASE',           $config->db->prefix . 'case');
define('TABLE_CASERESULT',     $config->db->prefix . 'caseResult');
define('TABLE_CASESTEP',       $config->db->prefix . 'caseStep');
define('TABLE_COMPANY',        $config->db->prefix . 'company');
define('TABLE_CONFIG',         $config->db->prefix . 'config');
define('TABLE_DEPT',           $config->db->prefix . 'dept');
define('TABLE_EFFORT',         $config->db->prefix . 'effort');
define('TABLE_FILE',           $config->db->prefix . 'file');
define('TABLE_HISTORY',        $config->db->prefix . 'history');
define('TABLE_MODULE',         $config->db->prefix . 'module');
define('TABLE_USER',           $config->db->prefix . 'user');
define('TABLE_GROUP',          $config->db->prefix . 'group');
define('TABLE_USERGROUP',      $config->db->prefix . 'userGroup');
define('TABLE_GROUPPRIV',      $config->db->prefix . 'groupPriv');
define('TABLE_PLANCASE',       $config->db->prefix . 'planCase');
define('TABLE_PRODUCT',        $config->db->prefix . 'product');
define('TABLE_RELEASE',        $config->db->prefix . 'release');
define('TABLE_RELEATION',      $config->db->prefix . 'releation');
define('TABLE_RESULTSTEP',     $config->db->prefix . 'resultStep');
define('TABLE_PROJECT',        $config->db->prefix . 'project');
define('TABLE_TEAM',           $config->db->prefix . 'team');
define('TABLE_STORY',          $config->db->prefix . 'story');
define('TABLE_PROJECTSTORY',   $config->db->prefix . 'projectStory');
define('TABLE_TASK',           $config->db->prefix . 'task');
define('TABLE_TASKESTIMATE',   $config->db->prefix . 'taskEstimate');
define('TABLE_TESTPLAN',       $config->db->prefix . 'testPlan');
define('TABLE_PROJECTPRODUCT', $config->db->prefix . 'projectProduct');
define('TABLE_TODO',           $config->db->prefix . 'todo');
define('TABLE_BURN',           $config->db->prefix . 'burn');

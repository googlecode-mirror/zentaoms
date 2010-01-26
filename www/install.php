<?php
/**
 * The install router file of ZenTaoMS.
 *
 * All request should be routed by this router.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

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
error_reporting(E_ALL);
session_start();
define('IN_INSTALL', true);

/* ������������ļ���*/
include '../../../framework/router.class.php';
include '../../../framework/control.class.php';
include '../../../framework/model.class.php';
include '../../../framework/helper.class.php';
include './myrouter.class.php';

/* ʵ����·�ɶ��󣬼������ã����ӵ����ݿ⡣*/
$app    = router::createApp('pms', '', 'myRouter');
$config = $app->loadConfig('common');

/* ����Ƿ��Ѿ���װ����*/
if(!isset($_SESSION['installing']) and isset($config->installed) and $config->installed) die(header('location: index.php'));

/* ��������config���������а�װ��*/
$config->set('requestType', 'GET');
$config->set('debug', true);
$config->set('default.module', 'install');

/* ����Ѿ����������ļ������Զ����ӵ����ݿ⡣*/
if(isset($config->installed) and $config->installed) $dbh = $app->connectDB();

/* ���ÿͻ�����ʹ�õ����ԡ����*/
$app->setClientLang();
$app->setClientTheme();

/* ���������ļ������ع���ģ�顣*/
$lang = $app->loadLang('common');

/* ������Ӧ��lib�ļ��������ó�ȫ�ֱ��������á�*/
$app->loadClass('front',  $static = true);
$app->loadClass('filter', $static = true);
$app->setSuperVars();

/* ����������֤Ȩ�ޣ�������Ӧ��ģ�顣*/
$app->parseRequest();
$app->loadModule();

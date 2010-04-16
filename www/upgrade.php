<?php
/**
 * The upgrade router file of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
error_reporting(0);

/* ������������ļ���*/
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* ʵ����·�ɶ��󣬼������ã����ӵ����ݿ⡣*/
$app    = router::createApp('pms', dirname(dirname(__FILE__)));
$config = $app->loadConfig('common');
$app->setDebug();

/* ��������config����������������*/
$config->set('requestType', 'GET');
$config->set('debug', true);
$config->set('default.module', 'upgrade');

/* ���ӵ����ݿ⡣*/
$dbh = $app->connectDB();

/* ���ÿͻ�����ʹ�õ����ԡ����*/
$app->setClientLang();
$app->setClientTheme();

/* ���������ļ������ع���ģ�顣*/
$lang   = $app->loadLang('common');
$common = $app->loadCommon();

/* ������Ӧ��lib�ļ��������ó�ȫ�ֱ��������á�*/
$app->loadClass('front',  $static = true);
$app->loadClass('filter', $static = true);
$app->setSuperVars();

/* ����Ƿ��Ѿ������µİ汾��*/
$config->installedVersion = $common->loadModel('setting')->getVersion();
if(version_compare($config->version, $config->installedVersion) <= 0) die(header('location: index.php'));

/* ����������֤Ȩ�ޣ�������Ӧ��ģ�顣*/
$app->parseRequest();
$app->loadModule();

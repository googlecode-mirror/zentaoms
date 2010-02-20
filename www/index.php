<?php
/**
 * The router file of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
/* ��¼�ʼ��ʱ�䡣*/
$timeStart = _getTime();

/* ������������ļ���*/
include '../../../framework/router.class.php';
include '../../../framework/control.class.php';
include '../../../framework/model.class.php';
include '../../../framework/helper.class.php';

/* ʵ����·�ɶ��󣬼������ã����ӵ����ݿ⡣*/
$app    = router::createApp('pms');
$config = $app->loadConfig('common');

/* ����Ƿ��Ѿ���װ��*/
if(!isset($config->installed) or !$config->installed) die(header('location: install.php'));

/* ���ӵ����ݿ⡣*/
$dbh = $app->connectDB();

/* ����debugѡ�����ô�����Ϣ��*/
$config->debug ? error_reporting(E_ALL) : error_reporting(0);

/* �����debugģʽ����¼sql��ѯ��*/
if($config->debug) register_shutdown_function('_saveSQL');

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

/* ����������֤Ȩ�ޣ�������Ӧ��ģ�顣*/
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Debug��Ϣ�����ҳ���ִ��ʱ����ڴ�ռ�á�*/
if($config->debug)
{
    $timeUsed = round(_getTime() - $timeStart, 4) * 1000;
    $memory   = round(memory_get_peak_usage() / 1024, 1);
    $querys   = count(dao::$querys);
    echo "<div id='debugbar'>TIME: $timeUsed ms, MEM: $memory KB, SQL: $querys.  </div>";
    echo '<style>body{padding-bottom:50px}</style>';
}

/* ��ȡϵͳʱ�䣬΢��Ϊ��λ��*/
function _getTime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

/* ����query��¼��*/
function _saveSQL()
{
    global $app;
    $sqlLog = $app->getLogRoot() . 'sql.' . date('Ymd') . '.log';
    $fh = @fopen($sqlLog, 'a');
    if(!$fh) return false;
    fwrite($fh, date('Ymd H:i:s') . ": " . $app->getURI() . "\n");
    foreach(dao::$querys as $query) fwrite($fh, "  $query\n");
    fwrite($fh, "\n");
    fclose($fh);
}

/* print_r��*/
function a($var)
{
    echo "<xmp class='a-left'>";
    print_r($var);
    echo "</xmp>";
}

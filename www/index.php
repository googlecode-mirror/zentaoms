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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     ZenTaoMS
 * @version     $Id: index.php 1433 2009-10-20 13:27:08Z wwccss $
 * @link        http://www.zentao.cn
 */
error_reporting(E_ALL);

/* ��¼�ʼ��ʱ�䡣*/
$timeStart = _getTime();

/* ������������ļ���*/
include '../../../framework/router.class.php';
include '../../../framework/control.class.php';
include '../../../framework/model.class.php';
include '../../../framework/helper.class.php';
include './myrouter.class.php';

/* ʵ����·�ɶ��󣬼������ã����ӵ����ݿ⡣*/
$app    = router::createApp('pms', '', 'myRouter');
$config = $app->loadConfig('common');
$dbh    = $app->connectDB();
setRevision();

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

/* �����debugģʽ����¼sql��ѯ��*/
if($config->debug) register_shutdown_function('_saveQuery');

/* ����������֤Ȩ�ޣ�������Ӧ��ģ�顣*/
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Debug��Ϣ�����ҳ���ִ��ʱ����ڴ�ռ�á�*/
$timeUsed = round(_getTime() - $timeStart, 4) * 1000;
$memory   = round(memory_get_peak_usage() / 1024, 1);

if(!$config->debug) exit;
$querys = count(dao::$querys);

echo <<<EOT
<div>
<strong>TIME</strong>: $timeUsed ms,
<strong>MEM</strong>: $memory KB,
<strong>SQL</strong>: $querys. 
</div>
EOT;

/* ��ȡϵͳʱ�䣬΢��Ϊ��λ��*/
function _getTime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

/* ����query��¼��*/
function _saveQuery()
{
    global $app;
    $fh = fopen('/tmp/zentao.log', 'a');
    fwrite($fh, date('Ymd H:i:s') . ": " . $app->getURI() . "\n");
    foreach(dao::$querys as $query) fwrite($fh, "  $query\n");
    fwrite($fh, "\n");
    fclose($fh);
}

/* print_r��*/
function a($var)
{
    echo "<xmp>";
    print_r($var);
    echo "</xmp>";
}

/* ����svn�汾�š�*/
function setRevision()
{
    global $config;
    $revisionTxt = dirname(dirname(__FILE__)) . '/cache/revision.txt';
    if(file_exists($revisionTxt))
    {
        list($revision, $date) = file($revisionTxt);
        $config->set('svn.revision', $revision);
        $config->set('svn.lastDate', $date);
    }
    else
    {
        $config->set('svn.revision', '');
        $config->set('svn.lastDate', '');
    }
}

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
 * @copyright   Copyright 2009-2010 青岛易软天创网络科技有限公司(www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
error_reporting(0);

/* 包含必须的类文件。*/
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* 实例化路由对象，加载配置，连接到数据库。*/
$app    = router::createApp('pms', dirname(dirname(__FILE__)));
$config = $app->loadConfig('common');

/* 重新设置config参数，进行升级。*/
$config->set('requestType', 'GET');
$config->set('debug', true);
$config->set('default.module', 'upgrade');
$app->setDebug();

/* 连接到数据库。*/
$dbh = $app->connectDB();

/* 设置客户端所使用的语言、风格。*/
$app->setClientLang();
$app->setClientTheme();

/* 加载语言文件，加载公共模块。*/
$lang   = $app->loadLang('common');
$common = $app->loadCommon();

/* 加载相应的lib文件，并设置超全局变量的引用。*/
$app->loadClass('front',  $static = true);
$app->loadClass('filter', $static = true);
$app->setSuperVars();

/* 检查是否已经是最新的版本。*/
$config->installedVersion = $common->loadModel('setting')->getVersion();
if(version_compare($config->version, $config->installedVersion) <= 0) die(header('location: index.php'));

/* 处理请求，验证权限，加载相应的模块。*/
$app->parseRequest();
$app->loadModule();

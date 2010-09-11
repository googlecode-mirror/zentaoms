<?php
/**
 * The control file of common module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 青岛易软天创网络科技有限公司(www.cnezsoft.com)
 * @author      Chen congzhi <congzhi@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.zentao.net
 */
include '../config/config.php';

if(!isset($argv[1]))
{
    die("Please input the directory path of 'module'! For example, c:\zentao\home\zentao\module\ \n");
}

$modules    = array();
$moduleRoot = $argv[1];

if(is_dir($moduleRoot))
{
    if($dh = opendir($moduleRoot))
    {
        while($module = readdir($dh))
        {
            if(strpos(basename($module), '.') === false) $modules[] = $module;
        }
        closedir($dh);
    }
}
else
{
    die("The module you input does not exist. \n");
}

foreach($modules as $module)
{ 
    /*  设定各个目录。*/
    $optRoot      = $moduleRoot . DIRECTORY_SEPARATOR. $module . DIRECTORY_SEPARATOR . 'opt';
    $optControl   = $optRoot . DIRECTORY_SEPARATOR . 'control';
    $optModel     = $optRoot . DIRECTORY_SEPARATOR . 'model';
    $optView      = $optRoot . DIRECTORY_SEPARATOR . 'view';
    $optConfig    = $optRoot . DIRECTORY_SEPARATOR . 'config';
    $optLang      = $optRoot . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;

    /* 建立各个扩展目录 */
    if(!file_exists($optRoot))    mkdir($optRoot,    0777);
    if(!file_exists($optControl)) mkdir($optControl, 0777);      
    if(!file_exists($optModel))   mkdir($optModel,   0777);
    if(!file_exists($optView))    mkdir($optView,    0777);
    if(!file_exists($optConfig))  mkdir($optConfig,  0777);
    if(!file_exists($optLang))    mkdir($optLang,    0777);

    /* 创建语言目录。*/
    $langs = array_keys($config->langs);
    foreach($langs as $lang)
    {
        $langPath = $optLang . $lang;
        if(!file_exists($langPath)) mkdir($langPath, 0777);
    }

    echo "init $module ... \n";
}

<?php
/**
 * The bug view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php if(isonlybody()) die(include './buglist.html.php')?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<?php include './buglist.html.php'?>
<?php include '../../common/view/footer.html.php';?>

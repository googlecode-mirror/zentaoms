<?php
/**
 * The export2csv view file of file module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
echo '"'. implode('","', $fields) . '"' . "\n";
foreach($rows as $row)
{
    echo '"'. implode('","', (array)$row) . '"' . "\n";
}

<?php
/**
 * The html template file of execute method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<table align='center' class='table-5 f-14px'>
  <caption><?php echo $lang->upgrade->$result;?></caption>
  <tr>
    <td>
    <?php
    if($result == 'fail')
    {
        echo nl2br(join('\n', $errors));
    }
    else
    {
        echo html::linkButton($lang->upgrade->tohome, 'index.php');
    }
    ?>
    </td>
  </tr>
</table>
<?php
if(!empty($extensionsName))
{
    echo "<h3>{$lang->upgrade->forbiddenExt}</h3>";
    echo '<ul>';
    foreach($incompatibleExts as $extensionName) echo "<li>$extensionName</li>";
    echo '</ul>';
}
?>
<?php include '../../common/view/footer.lite.html.php';?>

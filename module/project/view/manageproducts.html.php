<?php
/**
 * The manage product view of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<style>span{display:block; float:left; width:200px}</style>
<div class='yui-d0'>
  <form method='post'>
    <table align='center' class='table-4'> 
      <caption><?php echo $lang->project->manageProducts;?></caption>
      <tr>
        <td><?php echo html::checkbox("products", $allProducts, $linkedProducts);?></td>
      </tr>
      <tr><td class='a-center'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>

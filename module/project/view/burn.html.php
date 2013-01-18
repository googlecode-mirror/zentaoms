<?php
/**
 * The burn view file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include './taskheader.html.php';?>
<script>$('#burnTab').addClass('active');</script>
<div class='a-center'>
  <?php
  echo $charts; 
  common::printLink('project', 'computeBurn', 'reload=yes', $lang->project->computeBurn, 'hiddenwin');
  printf($lang->project->howToUpdateBurn, $this->createLink('help', 'field', 'module=project&method-burn&field=updateburn'));
  ?>
</div>
<?php include '../../common/view/footer.html.php';?>

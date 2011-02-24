<?php
/**
 * The html template file of login method of user module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id$
 */
include '../../common/view/header.lite.html.php';
?>
<div class='outer pt-200px'>
<form method='post' target='hiddenwin'>
  <table align='center' class='table-4'> 
    <caption id='welcome'><?php printf($lang->welcome, $app->company->name);?></caption>
    <tr>
      <td class='rowhead'><?php echo $lang->user->account;?>：</td>  
      <td><input class='text-2' type='text' name='account' id='account' /></td>
    </tr>  
    <tr>
      <td class='rowhead'><?php echo $lang->user->password;?>：</td>  
      <td><input class='text-2' type='password' name='password' /></td>
    </tr>
    <tr>
      <td class='rowhead' valign='top'>Language:</td>  
      <td><?php echo html::select('lang', $config->langs, $this->app->getClientLang(), 'class=select-2 onchange=selectLang(this.value)');?></td>
    </tr>
    <tr><td></td><td id='keeplogin'><?php echo html::checkBox('keepLogin', $lang->user->keepLogin, $keepLogin);?></td></tr>
    <tr>
      <td colspan='2' class='a-center'>
      <?php 
      echo html::submitButton($lang->login);
      if($app->company->guest) echo html::linkButton($lang->user->asGuest, $this->createLink($config->default->module));
      echo html::hidden('referer', $referer);
      ?>
      </td>
    </tr>  
  </table>
  <div id='poweredby'>
    powered by <a href='http://www.zentao.net' target='_blank'>ZenTaoPMS</a>(<?php echo $config->version;?>)
    <?php echo $lang->sponser;?>
    <br />
  <script src='http://www.zentao.net/check.php?v=<?php echo $config->version;?>&s=<?php echo $s;?>'></script>
  </div>
</form>
<?php include '../../common/view/footer.lite.html.php';?>

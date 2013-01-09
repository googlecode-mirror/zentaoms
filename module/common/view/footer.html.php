  </div>
  <?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
  <iframe frameborder='0' name='hiddenwin' id='hiddenwin' scrolling='no' class='<?php $config->debug ? print("debugwin") : print('hidden')?>'></iframe>
  <div id='divider'></div>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
</div>
<div id='footer'>
  <table class='cont' >
    <tr>
      <td class='w-p50 'id='crumbs'><?php commonModel::printBreadMenu($this->moduleName, isset($position) ? $position : ''); ?></td>
      <td class='a-right' id='poweredby'>
        <span>Powered by <a href='http://www.zentao.net' target='_blank'>ZenTaoPMS</a> (<?php echo $config->version;?>)</span>
        <?php echo $lang->proVersion;?>
        <?php if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) echo html::a($this->createLink('misc', 'downNotify'), $lang->downNotify);?>
      </td>
    </tr>
  </table>
</div>
<?php endif;?>
<script laguage='Javascript'>
$().ready(function()
{
    <?php
    /* The code for select flow.*/
    if(!(isset($this->app->config->flow) or strpos($this->config->version, 'pro') !== false or strpos($this->app->company->admins, ",{$this->app->user->account},") === false))
    {
        echo "\$.colorbox({href:" . json_encode($this->createLink('index', 'index', 'type=flow')) . ", open:true, width:800, height:400, iframe:true});\n";
    }
    ?>
})
<?php $onlybody = (!empty($_GET['onlybody']) and $_GET['onlybody'] == 'yes') ? 'yes' : ''?>
var onlybody = '<?php echo $onlybody?>';
<?php if(isset($pageJS)) echo $pageJS;?>
</script>
<?php 
$extPath      = dirname(dirname(dirname(realpath($viewFile)))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
</body>
</html>

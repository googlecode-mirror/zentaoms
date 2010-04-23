<?php include '../../common/view/header.lite.html.php';?>
<style>body{background:white; margin:20px 10px 0 0; padding-right:20px}</style>
<div class='yui-d0 yui-t1'>
  <div class='yui-b a-center'>
   <img src='theme/default/images/main/logo2.png' /><br />
   <h3>版本1.0rc1</h3>
  </div>
  <div class='yui-main'>
  <div class='yui-b'>
  <table class='table-1'>
    <tr class='colhead'>
      <?php
      $groups = array_keys((array)$lang->misc->zentao);
      foreach($groups as $group)
      {
          echo "<th class='w-p25'>关于禅道</th>";
      }
      ?>
    </tr>
    <tr class='a-left' valign='top'>
      <?php foreach($lang->misc->zentao as $groupItems):?>
      <td>
        <ul>
          <?php foreach($groupItems as $item):?>
          <li><?php echo $item;?></li>
          <?php endforeach;?>
        </ul>
      </td>
      <?php endforeach;?>
    </tr>
  </table>
  <div class='a-right'><?php echo $lang->misc->copyright;?></div>
  </div>
  </div>
</div>
</body>
</html>

<script language='Javascript'>
var fold   = '<?php echo $lang->fold;?>';
var unfold = '<?php echo $lang->unfold;?>';
function switchChange(historyID,type)
{
    if(type == unfold)
    {
        $('#switchButton' + historyID).val(fold);
        $('#changeBox' + historyID).show();
        $('#changeBox' + historyID).prev('.changeDiff').show();
    }
    else
    {
        $('#switchButton' + historyID).val(unfold);
        $('#changeBox' + historyID).hide();
        $('#changeBox' + historyID).prev('.changeDiff').hide();
    }
}

function toggleStripTags(obj)
{
    var boxObj  = $(obj).next();
    var oldDiff = '';
    var newDiff = '';
    $(boxObj).find('blockquote').each(function(){
        oldDiff = $(this).html();
        newDiff = $(this).next().html();
        $(this).html(newDiff);
        $(this).next().html(oldDiff);
    })
}

function toggleShow()
{
    $('.changes').each(function(){
        var box = $(this).parent();
        var switchButtonID = ($(box).find('span').find("input[type='button']").attr('id'));
        switchChange(switchButtonID.replace('switchButton', ''), $('#' + switchButtonID).val());
    })
}

$(function(){
    var diffButton = "<input type='button' onclick='toggleStripTags(this)' class='hidden changeDiff' value='<?php echo $lang->action->toggleDiff?>' >";
    var newBoxID = ''
    var oldBoxID = ''
    $('blockquote').each(function(){
        newBoxID = $(this).parent().attr('id');
        if(newBoxID != oldBoxID) 
        {
            oldBoxID = newBoxID;
            if($(this).html() != $(this).next().html()) $(this).parent().before(diffButton);
        }
    })
})
</script>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<script src='<?php echo $jsRoot;?>jquery/reverseorder/raw.js' type='text/javascript'></script>

<?php if(!isset($actionTheme)) $actionTheme = 'fieldset';?>
<?php if($actionTheme == 'fieldset'):?>
<div id='actionbox'>
<fieldset>
  <legend>
    <span onclick='$("#historyItem li").reverseOrder();' class='hand'> <?php echo $lang->history . "[<span title='$lang->reverse' class='log-reverse'>&nbsp;</span>]";?></span>
    <span onclick='toggleShow();' class='hand'><?php echo "[<span title='$lang->switchDisplay' class='switchDisplay'>&nbsp;</span>]";?></span>
  </legend>
<?php else:?>
<table class='table-1' id='actionbox'>
  <caption>
    <span onclick='$("#historyItem li").reverseOrder();' class='hand'> <?php echo $lang->history . "[<span title='$lang->reverse' class='log-reverse'>&nbsp;</span>]";?></span>
    <span onclick='toggleShow();' class='hand'><?php echo "[<span title='$lang->switchDisplay' class='switchDisplay'>&nbsp;</span>]";?></span>
  </caption>
  <tr><td>
<?php endif;?>

  <ol id='historyItem'>
    <?php $i = 1; ?>
    <?php foreach($actions as $action):?>
    <li value='<?php echo $i ++;?>'>
      <?php
      if(isset($users[$action->actor])) $action->actor = $users[$action->actor];
      if($action->action == 'assigned' and isset($users[$action->extra]) ) $action->extra = $users[$action->extra];
      if(strpos($action->actor, ':') !== false) $action->actor = substr($action->actor, strpos($action->actor, ':') + 1);
      ?>
      <span>
        <?php $this->action->printAction($action);?>
        <?php if(!empty($action->history)) echo html::commonButton($lang->unfold, "id=switchButton$i onclick=switchChange($i,this.value)");?>
      </span>
      <?php if(!empty($action->comment) or !empty($action->history)):?>
      <?php if(!empty($action->comment)) echo "<div class='history'>";?>
        <div class='changes hidden' id='changeBox<?php echo $i;?>'>
        <?php echo $this->action->printChanges($action->objectType, $action->history);?>
        </div>
        <?php if($action->comment) echo nl2br($action->comment);?>
      <?php if(!empty($action->comment)) echo "</div>";?>
      <?php endif;?>
    </li>
    <?php endforeach;?>
  </ol>

<?php if($actionTheme == 'fieldset'):?>
</fieldset>
<?php else:?>
</td></tr></table>
<?php endif;?>
</div>

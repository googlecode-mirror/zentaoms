<div id='fileform'>
<?php for($i = 0; $i < $fileCount; $i ++):?>
<input type='file' name='files[]' id="file<?php echo $i;?>"  tabindex='-1' />
<label id='label<?php echo $i;?>' tabindex='-1'><?php echo $lang->file->label;?></label><input type='text' id='label<?php echo $i;?>' name='labels[]' class='text-3' tabindex='-1' /><br />
<?php endfor;?>
</div>
<script language='javascript'>
function setFileFormWidth(percent)
{
    totalWidth = Math.round($('#fileform').parent().width() * percent);
    titleWidth = totalWidth - $('#file0').width() - $('#label0').width();
    if(!$.browser.mozilla) titleWidth -= 10;
    $('#fileform .text-3').css('width', titleWidth + 'px');
};
$(function(){setFileFormWidth(<?php echo $percent;?>)});
</script>

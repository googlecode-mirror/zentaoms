$(function()
{
    $('#' + browseType + 'Tab').addClass('active');
    if(browseType == 'bysearch')search();
});

$(document).ready(function() 
{
    if($('a.export').size()) $("a.export").colorbox({width:400, height:200, iframe:true, transition:'elastic', speed:350, scrolling:true});
})

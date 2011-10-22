/* Switch to module browse. */
function browseByModule(active)
{
    $('.side').removeClass('hidden');
    $('.divider').removeClass('hidden');
    $('#bymoduleTab').addClass('active');
    $('#' + active + 'Tab').removeClass('active');
    $('#bysearchTab').removeClass('active');
    $('#querybox').addClass('hidden');
}

/* Swtich to search module. */
function browseBySearch(active)
{
    $('#querybox').removeClass('hidden');
    $('.side').addClass('hidden');
    $('.divider').addClass('hidden');
    $('#' + active + 'Tab').removeClass('active');
    $('#bysearchTab').addClass('active');
    $('#bymoduleTab').removeClass('active');
}

$(document).ready(function()
{
    $("a.runcase").colorbox({width:900, height:600, iframe:true, transition:'none'});
    $('#' + browseType + 'Tab').addClass('active');
    $('#module' + moduleID).addClass('active'); 
});

$(document).ready(function() 
{
    if($('a.export').size()) $("a.export").colorbox({width:400, height:200, iframe:true, transition:'elastic', speed:350, scrolling:true});
    $(".results").colorbox({width:900, height:600, iframe:true, transition:'none'});
})

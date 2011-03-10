/* Browse by module. */
function browseByModule()
{
    $('#treebox').removeClass('hidden');
    $('.divider').removeClass('hidden');
    $('#bymoduleTab').addClass('active');
    $('#allTab').removeClass('active');
    $('#bysearchTab').removeClass('active');
    $('#querybox').addClass('hidden');
}
/* By search. */
function search()
{
    $('#treebox').addClass('hidden');
    $('.divider').addClass('hidden');
    $('#querybox').removeClass('hidden');
    $('#bymoduleTab').removeClass('active');
    $('#bysearchTab').addClass('active');
}

$(function(){
    $('#' + browseType + 'Tab').addClass('active');
    if(browseType == "bysearch")search();
});

function loadStoriesAndBugs(buildID,productID)
{
    link = createLink('release', 'ajaxGetStoriesAndBugs', 'buildID=' + buildID + '&productID=' + productID);
    $('#linkStoriesAndBugs').load(link);
}

$(document).ready(function()
{
    $("a.preview").colorbox({width:1000, height:600, iframe:true, transition:'elastic', speed:350, scrolling:false});
})

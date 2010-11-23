<?php
/**
 * The create view of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/alert.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<style>
#project, #product  {width:200px}
#module, #task      {width:400px}
#severity, #browser {width:113px}
#story{width:605px}
#steps{width:100%}
.text-1 {width: 85%}
</style>
<script language='Javascript'>
/**
 * Load all fields. 
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadAll(productID)
{
    $('#taskIdBox').get(0).innerHTML = '<select id="task"></select>';  // Reset the task.
    loadModuleMenu(productID);
    loadProductStories(productID);
    loadProductProjects(productID);
    loadProductBuilds(productID); 
    setAssignedTo(); 
}

/**
 * Load module menu.
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadModuleMenu(productID)
{
    link = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=bug');
    $('#moduleIdBox').load(link);
}

/**
 * Load product stories 
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadProductStories(productID)
{
    link = createLink('story', 'ajaxGetProductStories', 'productID=' + productID);
    $('#storyIdBox').load(link);
}

/**
 * Load projects of product. 
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadProductProjects(productID)
{
    link = createLink('product', 'ajaxGetProjects', 'productID=' + productID);
    $('#projectIdBox').load(link);
}

/**
 * Load product builds.
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadProductBuilds(productID)
{
    link = createLink('build', 'ajaxGetProductBuilds', 'productID=' + productID + '&varName=openedBuild');
    $('#buildBox').load(link);
}

/**
 * Load project related bugs and taskes.
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadProjectRelated(projectID)
{
    if(projectID)
    {
        loadProjectTasks(projectID);
        loadProjectStories(projectID);
        loadProjectBuilds(projectID);
    }
    else
    {
        $('#taskIdBox').get(0).innerHTML = '';
        loadProductStories($('#product').get(0).value);
        loadProductBuilds($('#product').get(0).value);
    }
}

/**
 * Load project taskes.
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadProjectTasks(projectID)
{
    link = createLink('task', 'ajaxGetProjectTasks', 'projectID=' + projectID);
    $('#taskIdBox').load(link);
}

/**
 * Load project stories.
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadProjectStories(projectID)
{
    productID = $('#product').get(0).value; 
    link = createLink('story', 'ajaxGetProjectStories', 'projectID=' + projectID + '&productID=' + productID);
    $('#storyIdBox').load(link);
}

/**
 * Set the assignedTo field.
 * 
 * @access public
 * @return void
 */
function setAssignedTo()
{
    link = createLink('bug', 'ajaxGetModuleOwner', 'moduleID=' + $('#module').val() + '&productID=' + $('#product').val());
    $.get(link, function(owner)
    {
        $('#assignedTo').val(owner);
    });
}

/**
 * Load project builds.
 * 
 * @param  int $projectID 
 * @access public
 * @return void
 */
function loadProjectBuilds(projectID)
{
    link = createLink('build', 'ajaxGetProjectBuilds', 'projectID=' + projectID + '&productID=' + $('#product').val() + '&varName=openedBuild');
    $('#buildBox').load(link);
}

var userList = "<?php echo join(',', array_keys($users));?>".split(',');
$(function() {
    $("#mailto").autocomplete(userList, { multiple: true, mustMatch: true});
    setAssignedTo();
})

</script>
<div class='yui-d0'>
  <form method='post' enctype='multipart/form-data' target='hiddenwin'>
    <table class='table-1'> 
      <caption><?php echo $lang->bug->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->bug->lblProductAndModule;?></th>
        <td>
          <?php echo html::select('product', $products, $productID, "onchange='loadAll(this.value)' class='select-2'");?>
          <span id='moduleIdBox'><?php echo html::select('module', $moduleOptionMenu, $moduleID, "onchange='setAssignedTo()' class='select-3'");?></span>
        </td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->bug->lblProjectAndTask;?></th>
        <td>
          <span id='projectIdBox'><?php echo html::select('project', $projects, $projectID, 'onchange=loadProjectRelated(this.value)');?></span>
          <span id='taskIdBox'><?php echo html::select('task', $tasks, $taskID);?></span>
        </td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->bug->lblStory;?></th>
        <td>
          <span id='storyIdBox'><?php echo html::select('story', $stories, $storyID);?></span>
        </td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->bug->openedBuild;?></th>
        <td>
          <span id='buildBox'><?php echo html::select('openedBuild[]', $builds, $buildID, 'size=3 multiple=multiple class=select-3');?></span>
        </td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->bug->lblTypeAndSeverity;?></th>
        <td> 
          <?php echo html::select('type', $lang->bug->typeList, 'codeerror', 'class=select-2');?> 
          <?php echo html::select('severity', $lang->bug->severityList, '', 'class=select-2');?>
        </td>
      </tr>
      <tr>
        <th class='rowhead'><nobr><?php echo $lang->bug->lblSystemBrowserAndHardware;?></nobr></th>
        <td>
          <?php echo html::select('os', $lang->bug->osList, $os, 'class=select-2');?>
          <?php echo html::select('browser', $lang->bug->browserList, $browser, 'class=select-2');?>
        </td>
      </tr>
      <tr>
        <th class='rowhead'><nobr><?php echo $lang->bug->lblAssignedTo;?></nobr></th>
        <td> <?php echo html::select('assignedTo', $users, $assignedTo, 'class=select-3');?></td>
      </tr>
      <tr>
        <th class='rowhead'><nobr><?php echo $lang->bug->lblMailto;?></nobr></th>
        <td> <?php echo html::input('mailto', $mailto, 'class=text-1');?> </td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->bug->title;?></th>
        <td><?php echo html::input('title', $title, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->bug->steps;?></th>
        <td>
          <table class='w-p100 bd-none'>
            <tr class='bd-none' valign='top'>
              <td class='w-p85 bd-none padding-zero'><?php echo html::textarea('steps', $steps, "rows='10'");?></td>
              <td class='bd-none pl-10px' id='tplBox'><?php echo $this->fetch('bug', 'buildTemplates');?></td>
            </tr>
          </table>
        </td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->bug->keywords;?></th>
        <td><?php echo html::input('keywords', $keywords, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->bug->files;?></th>
        <td><?php echo $this->fetch('file', 'buildform', 'fileCount=2&percent=0.85');?></td>
      </tr>  
      <tr>
        <td colspan='2' class='a-center'>
          <?php echo html::submitButton() . html::resetButton() . html::hidden('case', $caseID);?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>

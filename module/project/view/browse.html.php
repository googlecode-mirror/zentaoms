<?php
/**
 * The browse view file of project module of ZenTaoMS.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.  
 *
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     project
 * @version     $Id: browse.html.php 1353 2009-09-24 09:28:35Z wwccss $
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<?php include '../../common/tablesorter.html.php';?>
<script src="<?php echo $jsRoot;?>misc/sorttable.js" type="text/javascript"></script>
<script language='javascript'>
function selectProject(projectID)
{
    link = createLink('project', 'browse', 'projectID=' + projectID);
    location.href=link;
}
</script>
<div class="yui-d0 yui-t3">                 
  <div class="yui-b">
    <table class='table-1'>
      <caption>
        <?php echo $lang->project->selectProject;?>
        <?php echo html::select('projectID', $projects, $project->id, 'onchange="selectProject(this.value);" style="width:200px"');?>
      </caption>
      <tr>
        <th class='rowhead'><?php echo $lang->project->name;?></th>
        <td><?php echo $project->name;?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->project->code;?></th>
        <td><?php echo $project->code;?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->project->begin;?></th>
        <td><?php echo $project->begin;?></td>
      </tr>
      <tr>
        <th class='rowhead'><?php echo $lang->project->end;?></th>
        <td><?php echo $project->end;?></td>
      </tr>
      <!--
      <tr>
        <th class='rowhead'><?php echo $lang->project->status;?></th>
        <td><?php echo $project->status;?></td>
      </tr>
      -->
      <tr>
        <td colspan='2' class='a-right'>
        <?php
        if(common::hasPriv('project', 'edit'))   echo html::a($this->createLink('project', 'edit',   "projectID=$project->id"), $lang->project->edit);
        if(common::hasPriv('project', 'delete')) echo html::a($this->createLink('project', 'delete', "projectID=$project->id"), $lang->project->delete, 'hiddenwin');
        //echo html::a($this->createLink('tree',    'browse', "productID=$productID&view=product"), $lang->tree->manage);
        ?>
        </td>
      </tr>
    </table>
    <table align='center' class='table-1'>
      <caption>
        <?php echo $lang->project->products;?>
      </caption>
      <tr>
        <td>
          <?php foreach($products as $productID => $productName) echo html::a($this->createLink('product', 'browse', "productID=$productID"), $productName) . '<br />';?>
          <div class='a-right'>
          <?php
          if(common::hasPriv('project', 'manageproducts')) echo html::a($this->createLink('project', 'manageproducts', "projectID=$project->id"), $lang->project->manageProducts);
          if(common::hasPriv('project', 'linkstory'))      echo html::a($this->createLink('project', 'linkstory',      "projectID=$project->id"), $lang->project->linkStory);
          ?>
          </div>
        </td>
      </tr>
    </table>
    <!--
    <table align='center' class='table-1'>
      <caption>
        <?php echo $lang->project->childProjects;?>
      </caption>
      <tr>
        <td>
          <?php foreach($childProjects as $childProjectID => $childProjectName) echo html::a($this->createLink('project', 'browse', "projectID=$childProjectID"), $childProjectName) . '<br />';?>
          <div class='a-right'>
          <?php echo html::a($this->createLink('project', 'managechilds', "projectID=$project->id"), $lang->project->manageChilds) . '<br />';?>
          </div>
        </td>
      </tr>
    </table>-->
    <table align='center' class='table-1'>
      <caption>
        <?php echo $lang->project->team . $lang->colon . $project->team; ?>
      </caption>
      <thead>
      <tr>
        <th><?php echo $lang->team->account;?></th>
        <th><?php echo $lang->team->role;?></th>
        <th><?php echo $lang->team->joinDate;?></th>
        <th><?php echo $lang->team->workingHour;?></th>
        <?php if(common::hasPriv('project', 'unlinkmember')) echo "<th>$lang->action</th>";?>
      </tr>
      </thead>
      <tbody>
      <?php foreach($teamMembers as $member):?>
      <tr class='a-center'>
        <td>
          <?php 
          if(common::hasPriv('user', 'view')) echo html::a($this->createLink('user', 'view', "account=$member->account"), $member->realname);
          else echo $member->realname;
          ?>
        </td>
        <td><?php echo $member->role;?></td>
        <td><?php echo substr($member->joinDate, 2);?></td>
        <td><?php echo $member->workingHour;?></td>
        <?php if(common::hasPriv('project', 'unlinkmember')) echo "<td>" . html::a($this->createLink('project', 'unlinkmember', "projectID=$project->id&account=$member->account"), $lang->project->unlinkMember, 'hiddenwin') . '</td>';?>
      </tr>
      <?php endforeach;?>
      </tbody>     
    </table>
    <div class='a-right'>
    <?php if(common::hasPriv('project', 'managemembers')) echo html::a($this->createLink('project', 'managemembers', "projectID=$project->id"), $lang->project->manageMembers) . '<br />';?>
    </div>

  </div>
  <div class="yui-main">
    <div class="yui-b">
      <div id='tabbar' class='yui-d0'>
        <ul>
          <?php
          echo "<li><nobr>$project->name</nobr></li>";
          echo "<li id='tasktab'><nobr>"  . html::a($this->createLink('project', 'browse', "projectID=$project->id&tabID=task"),  $lang->project->tasks) . "</nobr></li>";
          echo "<li id='storytab'><nobr>" . html::a($this->createLink('project', 'browse', "projectID=$project->id&tabID=story"), $lang->project->stories) . "</nobr></li>";
          //echo "<li id='bugtab'><nobr>"   . html::a($this->createLink('project', 'browse', "projectID=$project->id&tabID=bug"),   $lang->project->bugs) . "</nobr></li>";
          //echo "<li id='burntab'><nobr>"  . html::a($this->createLink('project', 'browse', "projectID=$project->id&tabID=burn"),  $lang->project->burndown) . "</nobr></li>";
          echo <<<EOT
<script language="Javascript">
$("#{$tabID}tab").addClass('active');
</script>
EOT;
        ?>
        </ul>
        <?php if($tabID == 'task' and common::hasPriv('task', 'create')) :?>
        <div><?php echo html::a($this->createLink('task', 'create', "project=$project->id"), $lang->task->create);?></div>
        <?php elseif($tabID == 'story' and common::hasPriv('project', 'linkstory')) :?>
        <div><?php echo html::a($this->createLink('project', 'linkstory', "project=$project->id"), $lang->project->linkStory);?></div>
        <?php endif;?>
      </div>
      <?php include $tabID . '.html.php';?>
    </div>
  </div>
</div>  
<?php include '../../common/footer.html.php';?>

<div class='block' id='projectbox'>
<?php if(count($projectStats) == 0):?>
<table class='table-1 a-center' height='100%'>
  <caption><?php echo $lang->my->home->projects;?></caption>
  <tr>
    <td valign='middle'><?php printf($lang->my->home->noProjectsTip, $this->createLink('project', 'create'));?></td>
  </tr>
</table>
<?php else:?>
  <table class='table-1 fixed colored'>
    <tr class='colhead'>
      <th class='w-150px'><?php echo $lang->project->name;?></th>
      <th class='w-date'><?php echo $lang->project->end;?></th>
      <th class='w-50px'><?php echo $lang->project->totalEstimate;?></th>
      <th class='w-50px'><?php echo $lang->project->totalConsumed;?></th>
      <th class='w-50px'><?php echo $lang->project->totalLeft;?></th>
      <th class='w-150px'><?php echo $lang->project->progess;?></th>
      <th><?php echo $lang->project->burn;?></th>
    </tr>
    <?php foreach($projectStats as $project):?>
    <tr class='a-center'>
      <td class='a-left'><?php echo html::a($this->createLink('project', 'index', 'project=' . $project->id), $project->name);?></td>
      <td><?php echo $project->end;?></td>
      <td><?php echo $project->hours->totalEstimate;?></td>
      <td><?php echo $project->hours->totalConsumed;?></td>
      <td><?php echo $project->hours->totalLeft;?></td>
      <td class='a-left w-150px'>
        <img src='theme/default/images/main/green.png' width=<?php echo $project->hours->progress;?> height='13' text-align: />
        <small><?php echo $project->hours->progress;?>%</small>
      </td>
      <td class='projectline a-left' values='<?php echo join(',', $project->burns);?>'></td>
   </tr>
   <?php endforeach;?>
  </table>
<?php endif;?>
</div>

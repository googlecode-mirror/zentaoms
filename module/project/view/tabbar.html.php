<ul>
<?php
echo "<li><nobr>$project->name</nobr></li>";
echo "<li id='tasktab'><nobr>"  . html::a($this->createLink('project', 'task',  "projectID=$project->id"),  $lang->project->tasks) . "</nobr></li>";
echo "<li id='storytab'><nobr>" . html::a($this->createLink('project', 'story', "projectID=$project->id"),  $lang->project->stories) . "</nobr></li>";
echo "<li id='bugtab'><nobr>"   . html::a($this->createLink('project', 'bug',   "projectID=$project->id"),  $lang->project->bugs) . "</nobr></li>";
//echo "<li id='burntab'><nobr>"  . html::a($this->createLink('project', 'burn',  "projectID=$project->id"),  $lang->project->burndown) . "</nobr></li>";
echo <<<EOT
<script language="Javascript">
$("#{$tabID}tab").addClass('active');
</script>
EOT;
?>
</ul>

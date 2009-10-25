<?php
/**
 * The todo view file of dashboard module of ZenTaoMS.
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
 * @package     dashboard
 * @version     $Id: todo.html.php 1406 2009-10-12 07:49:52Z wwccss $
 * @link        http://www.zentao.cn
 */
?>
<?php include './header.html.php';?>
<table class='table-1 tablesorter'>
  <thead>
  <tr>
    <th><?php echo $lang->todo->id;?></th>
    <th><?php echo $lang->todo->type;?></th>
    <th><?php echo $lang->todo->pri;?></th>
    <th><?php echo $lang->todo->name;?></th>
    <th><?php echo $lang->todo->begin;?></th>
    <th><?php echo $lang->todo->end;?></th>
    <!--<th><?php echo $lang->todo->desc;?></th>-->
    <th><?php echo $lang->todo->status;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($todos as $todo):?>
  <tr class='a-center'>
    <td><?php echo $todo->id;?></td>
    <td><?php echo $lang->todo->typeList->{$todo->type};?></td>
    <td><?php echo $todo->pri;?></td>
    <td class='a-left'>
	  <?php 
	  $link = '';
	  if($todo->type == 'bug'  and common::hasPriv('bug', 'view'))  $link = $this->createLink('bug',  'view', "id={$todo->idvalue}");
	  if($todo->type == 'task' and common::hasPriv('task', 'edit')) $link = $this->createLink('task', 'edit', "id={$todo->idvalue}");
	  $link != '' ? print(html::a($link, $todo->name, '_blank')) : print($todo->name);
	  ?>
	</td>
    <td><?php echo $todo->begin;?></td>
    <td><?php echo $todo->end;?></td>
    <!--<td><?php echo $todo->desc;?></td>-->
	<td class='<?php echo $todo->status;?>'><?php echo $lang->todo->statusList->{$todo->status};?></td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>
<?php include './footer.html.php';?>

<?php
/**
 * The browse view file of group module of ZenTaoMS.
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
 * @package     group
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<div class='yui-d0'>                 
  <table align='center' class='table-1'>
    <tr class='colhead nobr'>
     <th><?php echo $lang->group->id;?></th>
     <th><?php echo $lang->group->name;?></th>
     <th><?php echo $lang->group->desc;?></th>
     <th class='w-p60'><?php echo $lang->group->users;?></th>
     <th><?php echo $lang->actions;?></th>
   </tr>
   <?php foreach($groups as $group):?>
   <tr class='a-center'>
     <td><?php echo $group->id;?></td>
     <td><?php echo $group->name;?></td>
     <td class='a-left'><?php echo $group->desc;?></td>
     <td class='a-left'><?php foreach($groupUsers[$group->id] as $user) echo $user . ' ';?></td>
     <td class='nobr'>
       <?php common::printLink('group', 'edit',         "groupID=$group->id", $lang->group->edit);?>
       <?php common::printLink('group', 'managepriv',   "groupID=$group->id", $lang->group->managePriv);?>
       <?php common::printLink('group', 'managemember', "groupID=$group->id", $lang->group->manageMember);?>
       <?php common::printLink('group', 'delete',       "groupID=$group->id", $lang->group->delete, "hiddenwin");?>
     </td>
   </tr>
   <?php endforeach;?>
  </table>
  <div class='a-right'><?php echo html::a($this->createLink('group', 'create'), $lang->group->create);?></div>
</div>  
<?php include '../../common/footer.html.php';?>

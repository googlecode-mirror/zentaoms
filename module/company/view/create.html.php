<?php
/**
 * The create view of company module of ZenTaoMS.
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
 * @package     company
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<div id='doc3'>
  <form method='post'>
    <table align='center' class='table-3 a-left'> 
      <caption><?php echo $lang->company->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->company->name;?></th>
        <td><input type='text' name='name' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->phone;?></th>
        <td><input type='text' name='phone' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->fax;?></th>
        <td><input type='text' name='fax' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->address;?></th>
        <td><input type='text' name='address' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->zipcode;?></th>
        <td><input type='text' name='zipcode' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->website;?></th>
        <td><input type='text' name='website' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->backyard;?></th>
        <td><input type='text' name='backyard' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->pms;?></th>
        <td><input type='text' name='pms' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->company->guest;?></th>
        <td><input type='text' name='guest' /></td>
      </tr>  
      <tr>
        <td colspan='2' class='a-center'><input type='submit' /></td>
      </tr>
    </table>
  </form>
</div>  
<?php include '../../common/footer.html.php';?>

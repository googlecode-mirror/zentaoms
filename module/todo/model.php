<?php
/**
 * The model file of todo module of ZenTaoMS.
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
 * @package     todo
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
?>
<?php
class todoModel extends model
{
    /* 新增一个todo。*/
    public function create($date, $account)
    {
        $todo = fixer::input('post')
            ->add('account', $this->app->user->account)
            ->add('idvalue', 0)
            ->stripTags('type, name')
            ->specialChars('desc')
            ->cleanInt('date, pri, begin, end, private')
            ->setIF($this->post->type != 'custom', 'name', '')
            ->setIF($this->post->type == 'bug',  'idvalue', $this->post->bug)
            ->setIF($this->post->type == 'task', 'idvalue', $this->post->task)
            ->setIF($this->post->begin == false, 'begin', '2400')
            ->setIF($this->post->end   == false, 'end', '2400')
            ->remove('bug, task')
            ->get();
        $this->dao->insert(TABLE_TODO)->data($todo)->autoCheck()->checkIF($todo->type == 'custom', 'name', 'notempty')->exec();
    }

    /* 更新一个todo。*/
    public function update($todoID)
    {
        $todo = fixer::input('post')
            ->stripTags('type, name')
            ->cleanInt('date, pri, begin, end, private')
            ->specialChars('desc')
            ->setIF($this->post->type != 'custom', 'name',  '')
            ->setIF($this->post->begin == false, 'begin', '2400')
            ->setIF($this->post->end   == false, 'end', '2400')
            ->get();
        $this->dao->update(TABLE_TODO)->data($todo)->autoCheck()->checkIF($todo->type == 'custom', 'name', 'notempty')->where('id')->eq($todoID)->exec();
    }
    
    /* 删除一个todo。*/
    public function delete($todoID)
    {
        return $this->dao->delete()->from(TABLE_TODO)->where('id')->eq((int)$todoID)->exec();
    }

    /* 更改状态。*/
    public function mark($todoID, $status)
    {
        $status = ($status == 'done') ? 'wait' : 'done';
        return $this->dao->update(TABLE_TODO)->set('status')->eq($status)->where('id')->eq((int)$todoID)->exec();
    }

    /* 获得一条todo信息。*/
    public function findByID($todoID)
    {
        $todo = $this->dao->findById((int)$todoID)->from(TABLE_TODO)->fetch();
        if($todo->type == 'task') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_TASK)->fetch('name');
        if($todo->type == 'bug')  $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_BUG)->fetch('title');
        $todo->name = stripslashes($todo->name);
        $todo->desc = stripslashes($todo->desc);
        $todo->date = str_replace('-', '', $todo->date);
        return $todo;
    }

    /* 获得用户的todo列表。*/
    public function getList($date = 'today', $account = '')
    {
        $todos = array();
        if($date == 'today') $date = $this->today();
        if($account == '')   $account = $this->app->user->account;
        $stmt = $this->dao->select('*')->from(TABLE_TODO)->where('account')->eq($account)->andWhere('date')->eq($date)->orderBy('status, begin')->query();
        while($todo = $stmt->fetch())
        {
            if($todo->type == 'task') $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_TASK)->fetch('name');
            if($todo->type == 'bug')  $todo->name = $this->dao->findById($todo->idvalue)->from(TABLE_BUG)->fetch('title');
            $todo->begin = $this->fdaoatTime($todo->begin);
            $todo->end   = $this->fdaoatTime($todo->end);

            /* 如果是私人事务，且当前用户非本人，更改标题。*/
            if($todo->private and $this->app->user->account != $todo->account) $todo->name = $this->lang->todo->thisIsPrivate;
            $todos[] = $todo;
        }
        return $todos;
    }

    /* 生成日期列表。*/
    public function buildDateList($before = 7, $after = 7)
    {
        $today = strtotime(date('Y-m-d', time()));
        $delta = 60 * 60 * 24;
        $dates = array();
        $weekList     = range(1, 7);
        $weekDateList = explode(',', $this->lang->todo->weekDateList);
        for($i = -1 * $before; $i <= $after; $i ++)
        {
            $time   = $today + $i * $delta;
            $label  = date('Y-m-d', $time);
            if($i == 0)
            {
                $label .= " ({$this->lang->todo->today})";
            }
            else
            {
                $label .= str_replace($weekList, $weekDateList, date(" ({$this->lang->todo->week}N)", $time));
            }
            $date   = date('Ymd', $time);
            $dates[$date] = $label;
        }
        return $dates;
    }

    /* 生成时钟列表。*/
    public function buildTimeList($begin = 9, $end = 22, $delta = 15)
    {
        $times = array();
        for($hour = $begin; $hour <= $end; $hour ++)
        {
            for($minutes = 0; $minutes < 60; $minutes += $delta)
            {
                $time  = sprintf('%02d%02d', $hour, $minutes);
                $label = sprintf('%02d:%02d', $hour, $minutes);
                $times[$time] = $label;
            }
        }
        return $times;
    }

    /* 获得当天日期。*/
    public function today()
    {
        return date('Ymd', time());
    }

    /* 获得当前的时间。*/
    public function now($delta = 15)
    {
        $range = range($delta, 60 - $delta, $delta);
        $hour   = date('H', time());
        $minute = date('i', time());

        if($minute > 60 - $delta)
        {
            $hour += 1;
            $minute = 00;
        }
        else
        {
            for($i = 0; $i < $delta; $i ++)
            {
                if(in_array($minute + $i, $range))
                {
                    $minute = $minute + $i;
                    break;
                }
            }
        }

        return sprintf('%02d%02d', $hour, $minute);
    }

    /* 格式化时间显示。*/
    public function fdaoatTime($time)
    {
        if(strlen($time) != 4 or $time == '2400') return '';
        return substr($time, 0, 2) . ':' . substr($time, 2, 2);
    }
}

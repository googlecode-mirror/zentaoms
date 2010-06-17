<?php
/**
 * The control file of index module of ZenTaoMS.
 *
 * When requests the root of a website, this index module will be called.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright   Copyright 2009-2010 青岛易软天创网络科技有限公司(www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentaoms.com
 */
class index extends control
{
    /* 构造函数。*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('project');
        $this->loadModel('product');
    }

    public function index()
    {
        $this->loadModel('report');
        $this->view->header->title = $this->lang->index->common;

        $burns    = array();
        $projects = $this->project->getList('doing');
        foreach($projects as $project)
        {
            $dataXML = $this->report->createSingleXML($this->project->getBurnData($project->id), $this->lang->project->charts->burn->graph);
            $burns[$project->id] = $this->report->createJSChart('line', $dataXML, 'auto', 260);
        }
        $projectGroups = array_chunk($projects, 2);

        $this->view->projectGroups = $projectGroups;
        $this->view->burns         = $burns;
        $this->view->counts        = count($projects);
        $this->view->actions       = $this->loadModel('action')->getDynamic('all', 30);
        $this->view->users         = $this->loadModel('user')->getPairs('noletter');
        $this->view->users['guest']= 'guest';    // append the guest account.
        $this->display();
    }

    /* 测试扩展机制。*/
    public function testext()
    {
        echo $this->fetch('misc', 'getsid');
    }
}

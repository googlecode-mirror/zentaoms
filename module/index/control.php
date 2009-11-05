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
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     ZenTaoMS
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class index extends control
{
    /* ���캯����*/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('project');
        $this->loadModel('product');
    }

    public function index()
    {
        $this->loadModel('report');
        $header['title'] = $this->lang->index->common;

        $projects = $this->project->getList('doing');
        $products = array_values($this->product->getList());

        foreach($projects as $project)
        {
            $burns[$project->id] = $this->report->createChart('line', $this->createLink('project', 'burnData', "project=$project->id", 'xml'), 300, 300);
        }

        $this->assign('header',   $header);
        $this->assign('projects', $projects);
        $this->assign('products', $products);
        $this->assign('burns',    $burns);
        $this->display();
    }
}

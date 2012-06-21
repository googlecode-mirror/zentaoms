<?php
/**
 * The control file of report module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class report extends control
{
    public function index()
    {
        $this->locate(inlink('projectdeviation')); 
    }
    
    public function projectDeviation()
    {
        $this->view->header->title = $this->lang->report->projectDeviation;
        $this->view->projects      = $this->report->getProjects();
        $this->display();
    }
}

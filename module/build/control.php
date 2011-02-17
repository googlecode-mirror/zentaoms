<?php
/**
 * The control file of build module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     build
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class build extends control
{
    /**
     * Create a buld.
     * 
     * @param  int    $projectID 
     * @access public
     * @return void
     */
    public function create($projectID)
    {
        if(!empty($_POST))
        {
            $buildID = $this->build->create($projectID);
            if(dao::isError()) die(js::error(dao::getError()));
            $this->loadModel('action')->create('build', $buildID, 'opened');
            die(js::locate($this->createLink('project', 'build', "project=$projectID"), 'parent'));
        }

        /* Set menu. */
        $this->loadModel('project')->setMenu($this->project->getPairs(), $projectID);

        /* Assign. */
        $this->view->header->title = $this->lang->build->create;
        $this->view->products = $this->project->getProducts($projectID);
        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Edit a build.
     * 
     * @param  int    $buildID 
     * @access public
     * @return void
     */
    public function edit($buildID)
    {
        if(!empty($_POST))
        {
            $changes = $this->build->update($buildID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($changes)
            {
                $actionID = $this->loadModel('action')->create('build', $buildID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }
            die(js::locate(inlink('view', "buildID=$buildID"), 'parent'));
        }

        /* Set menu. */
        $build = $this->build->getById((int)$buildID);
        $this->loadModel('project')->setMenu($this->project->getPairs(), $build->project);

        /* Assign. */
        $this->view->header->title = $this->lang->build->edit;
        $this->view->position[]    = $this->lang->build->edit;
        $this->view->products      = $this->project->getProducts($build->project);
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->build         = $build;
        $this->display();
    }
                                                          
    /**
     * View a build.
     * 
     * @param  int    $buildID 
     * @access public
     * @return void
     */
    public function view($buildID)
    {
        /* Set menu. */
        $build = $this->build->getById((int)$buildID);
        if(!$build) die(js::error($this->lang->notFound) . js::locate('back'));

        $this->loadModel('project')->setMenu($this->project->getPairs(), $build->project);

        /* Assign. */
        $this->view->header->title = $this->lang->build->view;
        $this->view->position[]    = $this->lang->build->view;
        $this->view->products      = $this->project->getProducts($build->project);
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->build         = $build;
        $this->view->actions       = $this->loadModel('action')->getList('build', $buildID);
        $this->display();
    }
 
    /**
     * Delete a build.
     * 
     * @param  int    $buildID 
     * @param  string $confirm  yes|noe
     * @access public
     * @return void
     */
    public function delete($buildID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->build->confirmDelete, $this->createLink('build', 'delete', "buildID=$buildID&confirm=yes")));
        }
        else
        {
            $build = $this->build->getById($buildID);
            $this->build->delete(TABLE_BUILD, $buildID);
            die(js::locate($this->createLink('project', 'build', "projectID=$build->project"), 'parent'));
        }
    }

    /**
     * AJAX: get builds of a product in html select.
     * 
     * @param  int    $productID 
     * @param  string $varName      the name of the select object to create
     * @param  string $build        build to selected
     * @access public
     * @return string
     */
    public function ajaxGetProductBuilds($productID, $varName, $build = '')
    {
        if($varName == 'openedBuild')   die(html::select($varName . '[]', $this->build->getProductBuildPairs($productID, 'noempty'), $build, 'size=4 class=select-3 multiple'));
        if($varName == 'resolvedBuild') die(html::select($varName, $this->build->getProductBuildPairs($productID, 'noempty'), $build, 'class=select-3'));
    }

    /**
     * AJAX: get builds of a project in html select.
     * 
     * @param  int    $projectID
     * @param  string $varName      the name of the select object to create
     * @param  string $build        build to selected
     * @access public
     * @return string
     */
    public function ajaxGetProjectBuilds($projectID, $productID, $varName, $build = '')
    {
        if($varName == 'openedBuild')   die(html::select($varName . '[]', $this->build->getProjectBuildPairs($projectID, $productID, 'noempty'), $build, 'size=4 class=select-3 multiple'));
        if($varName == 'resolvedBuild') die(html::select($varName, $this->build->getProjectBuildPairs($projectID, $productID, 'noempty'), $build, 'class=select-3'));
    }
}

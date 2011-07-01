<?php
/**
 * The control file of convert currentModule of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     convert
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class convert extends control
{
    /**
     * Index page of convert.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->convert->saveState();
        $this->view->header->title = $this->lang->convert->common;
        $this->display();
    }

    /**
     * Select the source system.
     * 
     * @access public
     * @return void
     */
    public function selectSource()
    {
        $this->view->header->title = $this->lang->convert->common . $this->lang->colon;
        $this->display();
    }

    /**
     * Set configs of converter.
     *
     * This is the extrance of every system. It will call the set function of corresponding module.
     * 
     * @access public
     * @return void
     */
    public function setConfig()
    {
        if(!$this->post->source) 
        {
            echo js::alert($this->lang->convert->mustSelectSource);
            die(js::locate('back'));
        }
        list($sourceName, $version) = explode('_', $this->post->source);
        $setFunc = "set$sourceName";
        $this->view->header->title = $this->lang->convert->setting;
        $this->view->source  = $sourceName;
        $this->view->version = $version;
        $this->view->setting = $this->fetch('convert', $setFunc, "version=$version");
        $this->display();
    }

    /**
     * The setting page of bugfree.
     * 
     * @param  string    $version 
     * @access public
     * @return void
     */
    public function setBugFree($version)
    {
        $this->view->source      = 'BugFree';
        $this->view->version     = $version;
        $this->view->tablePrefix = $version > 1 ? 'bf_' : '';
        $this->view->dbName      = $version > 1 ? 'bugfree2' : 'BugFree';
        $this->view->dbCharset   = 'utf8';
        $this->display();
    }

    /**
     * The setting page of Redmine.
     * 
     * @param  string    $version 
     * @access public
     * @return void
     */
    public function setRedmine($version)
    {
        $this->view->source      = 'Redmine';
        $this->view->version     = $version;
        $this->view->dbName      = 'redmine';
        $this->view->dbCharset   = 'utf8';
        $this->display();
    }

    /**
     * Check config. Same as setConfig.
     * 
     * @access public
     * @return void
     */
    public function checkConfig()
    {
        $checkFunc = 'check' . $this->post->source;
        $this->view->header->title = $this->lang->convert->checkConfig;
        $this->view->source        = $this->post->source;
        $this->view->checkResult   = $this->fetch('convert', $checkFunc, "version={$this->post->version}");
        $this->display();
    }

    /**
     * Check settings of bugfree.
     * 
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function checkBugFree($version)
    {
        helper::import('./converter/bugfree.php');
        $converter = new bugfreeConvertModel();

        /* Check it. */
        $checkInfo['db'] = $converter->connectDB();
        //if(is_object($checkInfo['db'])) $checkInfo['table'] = $converter->checkTables();
        $checkInfo['path'] = $converter->checkPath();

        /* Compute the checking result. */
        $result = 'pass';
        if(!is_object($checkInfo['db']) or !$checkInfo['path']) $result = 'fail';

        /* Assign. */
        $this->view->version   = $version;
        $this->view->source    = 'bugfree';
        $this->view->result    = $result;
        $this->view->checkInfo = $checkInfo;
        $this->display();
    }

    /**
     * Check settings of Redmine.
     * 
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function checkRedmine($version)
    {
        helper::import('./converter/redmine.php');
        $converter = new redmineConvertModel();

        /* Check it. */
        $checkInfo['db'] = $converter->connectDB();
        //if(is_object($checkInfo['db'])) $checkInfo['table'] = $converter->checkTables();
        $checkInfo['path'] = $converter->checkPath();

        /* Compute the checking result. */
        $result = 'pass';
        if(!is_object($checkInfo['db']) or !$checkInfo['path']) $result = 'fail';

        /* Assign. */
        $this->view->version   = $version;
        $this->view->source    = 'Redmine';
        $this->view->result    = $result;
        $this->view->checkInfo = $checkInfo;
        $this->display();
    }

    public function setParam()
    {
        if()
        if(!empty($_POST))
        {
            foreach($this->post as $issueType => $aimType)
            {
                if('bug' == $aimType) convertBug($issueType);
                elseif('task' == $aimType) convertTask($issueType);
                elseif('story' == $aimType) convertStory($issueType);
                else die('errer');
            }
        }
        $trackers = $this->dao->dbh($this->sourceDBH)->select('name')->from('trackers')->fetchAll('id', $autoCompany = false);

        $this->view->trackers = $trackers;
        $this->display();
    }

   /**
     * Execute the converting.
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $convertFunc = 'convert' . $this->post->source;
        $this->view->header->title = $this->lang->convert->execute;
        $this->view->source        = $this->post->source;
        $this->view->version       = $this->post->version;
        $this->view->executeResult = $this->fetch('convert', $convertFunc, "version={$this->post->version}");
        $this->display();
    }

    /**
     * Convert bugfree.
     * 
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function convertBugFree($version)
    {
        helper::import('./converter/bugfree.php');
        helper::import("./converter/bugfree$version.php");
        $className = "bugfree{$version}ConvertModel";
        $converter = new $className();
        $this->view->version = $version;
        $this->view->result  = $converter->execute($version);
        $this->view->info    = bugfreeConvertModel::$info;
        $this->display();
    }

    public function convertRedmine($version)
    {
        helper::import('./converter/redmine.php');
        helper::import("./converter/redmine$version.php");
        $className = "redmine11ConvertModel";
        $converter = new $className();
        $this->view->version = $version;
        $this->view->result  = $converter->execute($version);
        $this->view->info    = bugfreeConvertModel::$info;
        $this->display();
    }

}

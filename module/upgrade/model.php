<?php
/**
 * The model file of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
class upgradeModel extends model
{
    static $errors = array();

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('setting');
    }

    /**
     * The execute method. According to the $fromVersion call related methods.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return void
     */
    public function execute($fromVersion)
    {
        if($fromVersion == '0_3beta')
        {
            $this->upgradeFrom0_3To0_4();
            $this->upgradeFrom0_4To0_5();
            $this->upgradeFrom0_5To0_6();
            $this->upgradeFrom0_6To1_0_B();
            $this->upgradeFrom1_0betaTo1_0rc1();
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '0_4beta')
        {
            $this->upgradeFrom0_4To0_5();
            $this->upgradeFrom0_5To0_6();
            $this->upgradeFrom0_6To1_0_B();
            $this->upgradeFrom1_0betaTo1_0rc1();
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '0_5beta')
        {
            $this->upgradeFrom0_5To0_6();
            $this->upgradeFrom0_6To1_0_B();
            $this->upgradeFrom1_0betaTo1_0rc1();
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '0_6beta')
        {
            $this->upgradeFrom0_6To1_0_B();
            $this->upgradeFrom1_0betaTo1_0rc1();
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_0beta')
        {
            $this->upgradeFrom1_0betaTo1_0rc1();
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_0rc1')
        {
            $this->upgradeFrom1_0rc1To1_0rc2();
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_0rc2')
        {
            $this->upgradeFrom1_0rc2To1_0stable();
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_0')
        {
            $this->upgradeFrom1_0stableTo1_0_1();
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_0_1')
        {
            $this->upgradeFrom1_0_1To1_1();
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_1')
        {
            $this->upgradeFrom1_1To1_2();
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_2')
        {
            $this->upgradeFrom1_2To1_3();
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_3')
        {
            $this->upgradeFrom1_3To1_4();
            $this->upgradeFrom1_4To1_5();
        }
        elseif($fromVersion == '1_4')
        {
            $this->upgradeFrom1_4To1_5();
        }

        $this->setting->setSN();
    }

    /**
     * Create the confirm contents.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return string
     */
    public function getConfirm($fromVersion)
    {
        $confirmContent = '';
        if($fromVersion == '0_3beta')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.4'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.5'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.6'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '0_4beta')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.4'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.5'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.6'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '0_5beta')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.5'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.6'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '0_6beta')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('0.6'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_0beta')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_0rc1')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.rc1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_0rc2' || $fromVersion == '1_0' || $fromVersion == '1_0_1')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_1')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_2')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_3')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }
        elseif($fromVersion == '1_4')
        {
            $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
        }


        return str_replace('zt_', $this->config->db->prefix, $confirmContent);
    }

    /**
     * Upgrade from 0.3 to 0.4
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom0_3To0_4()
    {
        $this->execSQL($this->getUpgradeFile('0.3'));
        if(!$this->isError()) $this->setting->updateVersion('0.4 beta');
    }

    /**
     * Upgrade from 0.4 to 0.5
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom0_4To0_5()
    {
        $this->execSQL($this->getUpgradeFile('0.4'));
        if(!$this->isError()) $this->setting->updateVersion('0.5 beta');
    }

    /**
     * Upgrade from 0.5 to 0.6.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom0_5To0_6()
    {
        $this->execSQL($this->getUpgradeFile('0.5'));
        if(!$this->isError()) $this->setting->updateVersion('0.6 beta');
    }

    /**
     * Upgrade from 0.6 to 1.0 beta.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom0_6To1_0_B()
    {
        $this->execSQL($this->getUpgradeFile('0.6'));
        if(!$this->isError()) $this->setting->updateVersion('1.0beta');
    }

    /**
     * Upgrade from 1.0 beta to 1.0 rc1.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_0betaTo1_0rc1()
    {
        $this->execSQL($this->getUpgradeFile('1.0.beta'));
        $this->updateCompany();
        if(!$this->isError()) $this->setting->updateVersion('1.0rc1');
    }

    /**
     * Upgrade from 1.0 rc1 to 1.0 rc2.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_0rc1To1_0rc2()
    {
        $this->execSQL($this->getUpgradeFile('1.0.rc1'));
        if(!$this->isError()) $this->setting->updateVersion('1.0rc2');
    }

    /**
     * Upgrade from 1.0 rc2 to 1.0 stable.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_0rc2To1_0stable()
    {
        $this->setting->updateVersion('1.0');
    }

    /**
     * Upgrade from 1.0 stable to 1.0.1.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_0stableTo1_0_1()
    {
        $this->setting->updateVersion('1.0.1');
    }

    /**
     * Upgrade from 1.0.1 to 1.1.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_0_1To1_1()
    {
        $this->execSQL($this->getUpgradeFile('1.0.1'));
        if(!$this->isError()) $this->setting->updateVersion('1.1');
    }

    /**
     * Upgrade from 1.1 to 1.2.
     *
     * @access private
     * @return void
     */
    private function upgradeFrom1_1To1_2()
    {
        $this->execSQL($this->getUpgradeFile('1.1'));
        if(!$this->isError()) $this->setting->updateVersion('1.2');
    }

    /**
     * Upgrade from 1.2 to 1.3.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_2To1_3()
    {
        $this->execSQL($this->getUpgradeFile('1.2'));
        $this->updateUBB();
        $this->updateNL1_2();
        if(!$this->isError()) $this->setting->updateVersion('1.3');
    }

    /**
     * Upgrade from 1.3 to 1.4.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_3To1_4()
    {
        $this->execSQL($this->getUpgradeFile('1.3'));
        $this->updateNL1_3();
        $this->updateTasks();
        if(!$this->isError()) $this->setting->updateVersion('1.4');
    }
    /**
     * Upgrade from 1.4 to 1.5.
     * 
     * @access private
     * @return void
     */
    private function upgradeFrom1_4To1_5()
    {
        $this->execSQL($this->getUpgradeFile('1.4'));
        if(!$this->isError()) $this->setting->updateVersion('1.5');
    }

    /**
     * Update company field.
     *
     * This method is used to update since 1.0 beta. Any new tables added after 1.0 beta should skip.
     *
     * @access private
     * @return void
     */
    private function updateCompany()
    {
        /* Get user defined constants. */
        $constants     = get_defined_constants(true);
        $userConstants = $constants['user'];

        /* Update tables. */
        foreach($userConstants as $key => $value)
        {
            if(strpos($key, 'TABLE') === false) continue;
            if($key == 'TABLE_COMPANY'    or 
                $key == 'TABLE_CONFIG'    or 
                $key == 'TABLE_USERQUERY' or
                $key == 'TABLE_DOCLIB'    or
                $key == 'TABLE_DOC'       or
                $key == 'TABLE_USERTPL'
            ) continue;
            $this->dbh->query("UPDATE $value SET company = '{$this->app->company->id}'");
        }
    }

    /**
     * Update ubb code in bug table and user Templates table to html.
     * 
     * @access private
     * @return void
     */
    private function updateUBB()
    {
        $bugs = $this->dao->select('id, steps')->from(TABLE_BUG)->fetchAll();
        $userTemplates = $this->dao->select('id, content')->from(TABLE_USERTPL)->fetchAll();
            
        foreach($bugs as $id => $bug)
        {
            $bug->steps = html::parseUBB($bug->steps);
            $this->dao->update(TABLE_BUG)->data($bug)->where('id')->eq($bug->id)->exec();
        }
        foreach($userTemplates as $template)
        {
            $template->content = html::parseUBB($template->content);
            $this->dao->update(TABLE_USERTPL)->data($template)->where('id')->eq($template->id)->exec();
        }
    }

    /**
     * Update nl to br from 1.2 version.
     * 
     * @access public
     * @return void
     */
    public function updateNL1_2()
    {
        $tasks     = $this->dao->select('id, `desc`')->from(TABLE_TASK)->fetchAll();
        $stories   = $this->dao->select('story, version, spec')->from(TABLE_STORYSPEC)->fetchAll();
        $todos     = $this->dao->select('id, `desc`')->from(TABLE_TODO)->fetchAll();
        $testTasks = $this->dao->select('id, `desc`')->from(TABLE_TESTTASK)->fetchAll();

        foreach($tasks as $task)
        {
            $task->desc = nl2br($task->desc);
            $this->dao->update(TABLE_TASK)->data($task)->where('id')->eq($task->id)->exec();
        }
        foreach($stories as $story)
        {
            $story->spec = nl2br($story->spec);
            $this->dao->update(TABLE_STORYSPEC)->data($story)->where('story')->eq($story->story)->andWhere('version')->eq($story->version)->exec();
        }

        foreach($todos as $todo)
        {
            $todo->desc = nl2br($todo->desc);
            $this->dao->update(TABLE_TODO)->data($todo)->where('id')->eq($todo->id)->exec();
        }

        foreach($testTasks as $testtask)
        {
            $testtask->desc = nl2br($testtask->desc);
            $this->dao->update(TABLE_TESTTASK)->data($testtask)->where('id')->eq($testtask->id)->exec();
        }
    }

    /**
     * Update nl to br from 1.3 version.
     * 
     * @access public
     * @return void
     */
    public function updateNL1_3()
    {
        $products = $this->dao->select('id, `desc`')->from(TABLE_PRODUCT)->fetchAll();
        $plans    = $this->dao->select('id, `desc`')->from(TABLE_PRODUCTPLAN)->fetchAll();
        $releases = $this->dao->select('id, `desc`')->from(TABLE_RELEASE)->fetchAll();
        $projects = $this->dao->select('id, `desc`, goal')->from(TABLE_PROJECT)->fetchAll();
        $builds   = $this->dao->select('id, `desc`')->from(TABLE_BUILD)->fetchAll();

        foreach($products as $product)
        {
            $product->desc = nl2br($product->desc);
            $this->dao->update(TABLE_PRODUCT)->data($product)->where('id')->eq($product->id)->exec();
        }

        foreach($plans as $plan)
        {
            $plan->desc = nl2br($plan->desc);
            $this->dao->update(TABLE_PRODUCTPLAN)->data($plan)->where('id')->eq($plan->id)->exec();
        }

        foreach($releases as $release)
        {
            $release->desc = nl2br($release->desc);
            $this->dao->update(TABLE_RELEASE)->data($release)->where('id')->eq($release->id)->exec();
        }

        foreach($projects as $project)
        {
            $project->desc = nl2br($project->desc);
            $project->goal = nl2br($project->goal);
            $this->dao->update(TABLE_PROJECT)->data($project)->where('id')->eq($project->id)->exec();
        }

        foreach($builds as $build)
        {
            $build->desc = nl2br($build->desc);
            $this->dao->update(TABLE_BUILD)->data($build)->where('id')->eq($build->id)->exec();
        }
    }

    /**
     * Update task fields.
     * 
     * @access public
     * @return void
     */
    public function updateTasks()
    {
        /* Get all actions of tasks. */
        $actions = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq('task')
            ->orderBy('id')
            ->fetchAll('id');

        /* Get histories about status field. */
        $histories = $this->dao->select()->from(TABLE_HISTORY)
            ->where('action')->in(array_keys($actions))
            ->andWhere('field')->eq('status')
            ->orderBy('id')
            ->fetchGroup('action');

        $tasks = array();
        foreach($actions as $action)
        {
            if(!isset($tasks[$action->objectID]))
            {
                $tasks[$action->objectID] = new stdclass;
            }
            $task = $tasks[$action->objectID];

            $task->id   = $action->objectID;
            $actionType = strtolower($action->action);

            /* Set the openedBy info. */
            if($actionType == 'opened')
            {
                $task->openedBy   = $action->actor;
                $task->openedDate = $action->date;
            }
            else
            {
                if(!isset($histories[$action->id])) continue;

                $actionHistories = $histories[$action->id];
                foreach($actionHistories as $history)
                {
                    /* Finished by. */
                    if($history->new == 'done')
                    {
                        $task->finishedBy   = $action->actor;
                        $task->finishedDate = $action->date;
                        $action->action     = 'finished';
                    }
                    /* Canceled By. */
                    elseif($history->new == 'cancel')
                    {
                        $task->canceledBy   = $action->actor;
                        $task->canceledDate = $action->date;
                        $action->action     = 'canceled';
                    }
                }

                /* Last edited by .*/
                $task->lastEditedBy   = $action->actor;
                $task->lastEditedDate = $action->date;

                /* Update action type. */
                $this->dao->update(TABLE_ACTION)->set('action')->eq($action->action)->where('id')->eq($action->id)->exec(false);
            }
        }

        /* Update db. */
        foreach($tasks as $task)
        {
            $this->dao->update(TABLE_TASK)->data($task, false)->where('id')->eq($task->id)->exec(false);
        }

        $this->dao->update(TABLE_TASK)->set('assignedTo=openedBy, assignedDate = finishedDate')->where('status')->eq('done')->exec(false);
        $this->dao->update(TABLE_TASK)->set('assignedTo=openedBy, assignedDate = canceledDate')->where('status')->eq('cancel')->exec(false);

        /* Update action name. */
    }

    /**
     * Get the upgrade sql file.
     * 
     * @param  string $version 
     * @access private
     * @return string
     */
    private function getUpgradeFile($version)
    {
        return $this->app->getAppRoot() . 'db' . $this->app->getPathFix() . 'update' . $version . '.sql';
    }

    /**
     * Execute a sql.
     * 
     * @param  string  $sqlFile 
     * @access private
     * @return void
     */
    private function execSQL($sqlFile)
    {
        $mysqlVersion = $this->loadModel('install')->getMysqlVersion();

        /* Read the sql file to lines, remove the comment lines, then join theme by ';'. */
        $sqls = explode("\n", file_get_contents($sqlFile));
        foreach($sqls as $key => $line) 
        {
            $line       = trim($line);
            $sqls[$key] = $line;
            if(strpos($line, '--') !== false or empty($line)) unset($sqls[$key]);
        }
        $sqls = explode(';', join("\n", $sqls));

        foreach($sqls as $sql)
        {
            $sql = trim($sql);
            if(empty($sql)) continue;

            if($mysqlVersion <= 4.1)
            {
                $sql = str_replace('DEFAULT CHARSET=utf8', '', $sql);
                $sql = str_replace('CHARACTER SET utf8 COLLATE utf8_general_ci', '', $sql);
            }

            $sql = str_replace('zt_', $this->config->db->prefix, $sql);
            try
            {
                $this->dbh->exec($sql);
            }
            catch (PDOException $e) 
            {
                self::$errors[] = $e->getMessage() . "<p>The sql is: $sql</p>";
            }
        }
    }

    /**
     * Judge any error occers.
     * 
     * @access public
     * @return bool
     */
    public function isError()
    {
        return !empty(self::$errors);
    }

    /**
     * Get errors during the upgrading.
     * 
     * @access public
     * @return array
     */
    public function getError()
    {
        $errors = self::$errors;
        self::$errors = array();
        return $errors;
    }
}

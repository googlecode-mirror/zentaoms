<?php
/**
 * The model file of svn module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     svn
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php
class svnModel extends model
{
    /**
     * The svn binary client.
     * 
     * @var int   
     * @access public
     */
    public $client;

    /**
     * Repos.
     * 
     * @var array 
     * @access public
     */
    public $repos = array(); 

    /**
     * The log root.
     * 
     * @var string
     * @access public
     */
    public $logRoot = '';

    /**
     * Users 
     * 
     * @var array 
     * @access public
     */
    public $users = array();


    /**
     * The construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setRepos();
        $this->setLogRoot();
        $this->loadModel('action');
    }

    /**
     * Set the repos.
     * 
     * @access public
     * @return void
     */
    public function setRepos()
    {
        if(!$this->config->svn->repos) die("You must set one svn repo.\n");
        $this->repos = $this->config->svn->repos;
    }

    /**
     * Set the log root.
     * 
     * @access public
     * @return void
     */
    public function setLogRoot()
    {
        $this->logRoot = $this->app->getTmpRoot() . 'svn/';
        if(!is_dir($this->logRoot)) mkdir($this->logRoot);
    }

    /**
     * Run. 
     * 
     * @access public
     * @return void
     */
    public function run()
    {
        foreach($this->repos as $name => $repo)
        {
            $this->printLog("begin repo $name");
            $repo = (object)$repo;
            $repo->name = $name;
            $this->setRepo($repo);

            $savedRevision = $this->getSavedRevision();
            $this->printLog("start from revision $savedRevision");
            $logs = $this->getRepoLogs($repo, $savedRevision);
            $this->printLog("get " . count($logs) . " logs");

            $this->printLog('begin parse logs');
            foreach($logs as $log)
            {
                $this->printLog("paring log {$log->revision}");
                if($log->revision == $savedRevision)
                {
                    $this->printLog("{$log->revision} alread parsed, ommit it");
                    continue;
                }

                $this->printLog("comment is\n----------\n" . trim($log->msg) . "\n----------");
                $objects = $this->parseComment($log->msg);
                if($objects)
                {
                    $this->printLog('extract' . 
                        'story' . join(' ', $objects['stories']) . 
                        ' task' . join(' ', $objects['tasks']) . 
                        ' bug'  . join(',', $objects['bugs']));

                    $this->saveAction2PMS($objects, $log);
                }
                else
                {
                    $this->printLog('no objects found' . "\n");
                }
                if($log->revision > $savedRevision) $savedRevision = $log->revision;
            }
            $this->saveLastRevision($savedRevision);
            $this->printLog("save revision $savedRevision");
            $this->printLog("\n\nrepo $name finished");
        }
    }

    /**
     * Set repo.
     * 
     * @param  object    $repo 
     * @access public
     * @return void
     */
    public function setRepo($repo)
    {
        $this->setClient($repo);
        $this->setLogFile($repo->name);
    }

    /**
     * Set the svn binary client of a repo.
     * 
     * @param  object    $repo 
     * @access public
     * @return void
     */
    public function setClient($repo)
    {
        if($this->config->svn->client == '') die("You must set the svn client file.\n");
        $this->client = $this->config->svn->client . " --non-interactive";
        if(isset($repo->username)) $this->client .= " --username '$repo->username' --password '$repo->password' --no-auth-cache";
    }

    /**
     * Set the log file of a repo.
     * 
     * @param  string    $repoName 
     * @access public
     * @return void
     */
    public function setLogFile($repoName)
    {
        $this->logFile = $this->logRoot . $repoName;
    }

    /**
     * Get repo logs.
     * 
     * @param  object  $repo 
     * @param  int     $fromRevision 
     * @access public
     * @return array
     */
    public function getRepoLogs($repo, $fromRevision)
    {
        $parsedLogs = array();

        /* The svn log command. */
        $cmd  = $this->client . " log -r $fromRevision:HEAD -v --xml $repo->path";
        $logs = `$cmd`;
        $logs = simplexml_load_string($logs);    // Convert it to object.

        /* Process logs. */
        foreach($logs->logentry as $entry)
        {
            /* Get author, revision, msg, date attributes. */
            $parsedLog = new stdClass();
            $parsedLog->author   = (string)$entry->author; 
            $parsedLog->revision = (int)$entry['revision']; 
            $parsedLog->msg      = trim((string)$entry->msg);
            $parsedLog->date     = date('Y-m-d H:i:s', strtotime($entry->date));

            /* Process files. */
            $parsedLog->files = array();
            foreach ($entry->paths as $key => $paths)
            {
                $parsedFiles = array();
                foreach($paths as $path)
                {
                    $action = (string)$path['action'];
                    $parsedFiles[$action][] = (string)$path;
                }
            }
            $parsedLog->files = $parsedFiles;

            /* Appended to the $parsedLogs. */
            $parsedLogs[] = $parsedLog;
        }
        return $parsedLogs;
    }

    /**
     * Parse the comment of svn, extract object id list from it.
     * 
     * @param  string    $comment 
     * @access public
     * @return array
     */
    public function parseComment($comment)
    {
        $stories = array(); 
        $tasks   = array();
        $bugs    = array();

        // bug|story|task(case insensitive) + some space + #|:|：(Chinese) + id lists(maybe join with space or ,)
        // $comment = "bug # 1,2,3,4 Bug:1 2 3 4 5 story:9999,1234566 story:456,1234566";
        $commonReg = "(?:\s){0,}(?:#|:|：){0,}([0-9, ]{1,})";
        $taskReg  = '/task' .  $commonReg . '/i';
        $storyReg = '/story' . $commonReg . '/i';
        $bugReg   = '/bug'   . $commonReg . '/i';

        if(preg_match_all($storyReg, $comment, $result)) $stories = join(' ', $result[1]);
        if(preg_match_all($taskReg, $comment, $result))  $tasks   = join(' ', $result[1]);
        if(preg_match_all($bugReg, $comment, $result))   $bugs    = join(' ', $result[1]);

        if($stories) $stories = array_unique(explode(' ', str_replace(',', ' ', $stories)));
        if($tasks)   $tasks   = array_unique(explode(' ', str_replace(',', ' ', $tasks)));
        if($bugs)    $bugs    = array_unique(explode(' ', str_replace(',', ' ', $bugs)));

        if(!$stories and !$tasks and !$bugs) return array();
        return array('stories' => $stories, 'tasks' => $tasks, 'bugs' => $bugs);
    }

    /**
     * Save action to pms.
     * 
     * @param  array    $objects 
     * @param  object   $log 
     * @access public
     * @return void
     */
    public function saveAction2PMS($objects, $log)
    {
        $action->actor   = $log->author;
        $action->action  = 'svncommited';
        $action->date    = $log->date;
        $action->comment = $log->msg;
        $action->extra   = $log->revision;

        $changes = $this->createActionChanges($log);

        if($objects['stories'])
        {
            $products = $this->getStoryProducts($objects['stories']);
            foreach($objects['stories'] as $storyID)
            {
                $storyID = (int)$storyID;
                if(!isset($products[$storyID])) continue;

                $action->objectType = 'story';
                $action->objectID   = $storyID;
                $action->product    = $products[$storyID];
                $action->project    = 0;

                $this->saveRecord($action, $changes);
            }
        }

        if($objects['tasks'])
        {
            $productsAndProjects = $this->getTaskProductsAndProjects($objects['tasks']);
            foreach($objects['tasks'] as $taskID)
            {
                $taskID = (int)$taskID;
                if(!isset($productsAndProjects[$taskID])) continue;

                $action->objectType = 'task';
                $action->objectID   = $taskID;
                $action->product    = $productsAndProjects[$taskID]['product'];
                $action->project    = $productsAndProjects[$taskID]['project'];

                $this->saveRecord($action, $changes);
            }
        }

        if($objects['bugs'])
        {
            $productsAndProjects = $this->getBugProductsAndProjects($objects['bugs']);

            foreach($objects['bugs'] as $bugID)
            {
                $bugID = (int)$bugID;
                if(!isset($productsAndProjects[$bugID])) continue;

                $action->objectType = 'bug';
                $action->objectID   = $bugID;
                $action->product    = $productsAndProjects[$bugID]->product;
                $action->project    = $productsAndProjects[$bugID]->project;

                $this->saveRecord($action, $changes);
            }
        }
    }

    /**
     * Save an action to pms.
     * 
     * @param  object $action
     * @param  object $log
     * @access public
     * @return bool
     */
    public function saveRecord($action, $changes)
    {
        $record = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq($action->objectType)
            ->andWhere('objectID')->eq($action->objectID)
            ->andWhere('extra')->eq($action->extra)
            ->andWhere('action')->eq('svncommited')
            ->fetch();
        if($record)
        {
            $this->dao->update(TABLE_ACTION)->data($action)->where('id')->eq($record->id)->exec();
            if($changes)
            {
                $historyID = $this->dao->findByAction($record->id)->from(TABLE_HISTORY)->fetch('id');
                $this->dao->update(TABLE_HISTORY)->data($changes)->where('id')->eq($historyID)->exec();
            }
        }
        else
        {
            $this->dao->insert(TABLE_ACTION)->data($action)->autoCheck()->exec();
            if($changes)
            {
                $actionID = $this->dao->lastInsertID();
                $this->action->logHistory($actionID, array($changes));
            }
        }
    }

    /**
     * Create changes for action from a log.
     * 
     * @param  object    $log 
     * @access public
     * @return array
     */
    public function createActionChanges($log)
    {
        if(!$log->files) return array();
        $diff = '';

        foreach($log->files as $action => $actionFiles)
        {
            foreach($actionFiles as $file) $diff .= $action . " " . $file . "\n";
        }
        $changes->field = 'svncode';
        $changes->old   = '';
        $changes->new   = '';
        $changes->diff  = trim($diff);

        return (array)$changes;
    }

    /**
     * Get products of stories.
     * 
     * @param  array    $stories 
     * @access public
     * @return array
     */
    public function getStoryProducts($stories)
    {
        return $this->dao->select('id, product')->from(TABLE_STORY)->where('id')->in($stories)->fetchPairs();
    }

    /**
     * Get products and projects of tasks.
     * 
     * @param  array    $tasks 
     * @access public
     * @return array
     */
    public function getTaskProductsAndProjects($tasks)
    {
        $records = array();
        $products = $this->dao->select('t1.id, t2.product')
            ->from(TABLE_TASK)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
            ->where('t1.id')->in($tasks)->fetchPairs();

        $projects = $this->dao->select('id, project')->from(TABLE_TASK)->where('id')->in($tasks)->fetchPairs();

        foreach($projects as $taskID => $projectID)
        {
            $record = array();
            $record['project'] = $projectID;
            $record['product'] = isset($products[$taskID]) ? $products[$taskID] : 0;
            $records[$taskID] = $record;
        }
        return $records;
    }

    /**
     * Get products and projects of bugs.
     * 
     * @param  array    $bugs 
     * @access public
     * @return array
     */
    public function getBugProductsAndProjects($bugs)
    {
        return $this->dao->select('id, project, product')->from(TABLE_BUG)->where('id')->in($bugs)->fetchAll('id');
    }

    /**
     * Get the saved revision.
     * 
     * @access public
     * @return int
     */
    public function getSavedRevision()
    {
        if(!file_exists($this->logFile)) return 0;
        return (int)trim(file_get_contents($this->logFile));
    }

    /**
     * Save the last revision.
     * 
     * @param  int    $revision 
     * @access public
     * @return void
     */
    public function saveLastRevision($revision)
    {
        file_put_contents($this->logFile, $revision);
    }

    /**
     * Pring log.
     * 
     * @param  sting    $log 
     * @access public
     * @return void
     */
    public function printLog($log)
    {
        echo helper::now() . " $log\n";
    }
}

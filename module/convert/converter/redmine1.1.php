<?php
/**
 * The model file of redmine convert of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     convert
 * @version     $Id $
 * @link        http://www.zentao.net
 */
class redmine11ConvertModel extends redmineConvertModel
{
    static $convertGroupCount          = 0;
    static $convertUserCount           = 0;
    static $convertProductCount        = 0;
    static $convertProjectCount        = 0;
    static $convertStoryCount          = 0;
    static $convertTaskCount           = 0;
    static $convertBugCount            = 0;
    static $convertProductPlanCount    = 0;
    static $convertTeamCount           = 0;
    static $convertReleaseCount        = 0;
    static $convertBuildCount          = 0;
    static $convertDocLibCount         = 0;
    static $convertDocCount            = 0;
    static $convertFileCount           = 0;

    /**
     * Execute the converter.
     * 
     * @access public
     * @return array
     */
    public function execute()
    {
        $this->clear();
        $this->setTable();
        $this->convertGroup();
        $this->convertUser();
        $this->convertUserGroup();
        $this->convertProduct();
        $this->convertProject();
        $this->convertBuildAndRelease();
        $this->convertProductPlan();
        $this->convertProjectProduct();
        $this->convertTeam();
        $this->convertDocLib();
        $this->convertDoc();
        $this->convertNews();
        $this->convertIssue();
        $this->convertFile();
        $this->dao->dbh($this->dbh);
        $this->loadModel('tree')->fixModulePath();

        $result['groups']       = redmine11ConvertModel::$convertGroupCount;
        $result['users']        = redmine11ConvertModel::$convertUserCount ;
        $result['products']     = redmine11ConvertModel::$convertProductCount ;
        $result['projects']     = redmine11ConvertModel::$convertProjectCount ;
        $result['stories']      = redmine11ConvertModel::$convertStoryCount;
        $result['tasks']        = redmine11ConvertModel::$convertTaskCount ;
        $result['bugs']         = redmine11ConvertModel::$convertBugCount ;
        $result['productPlans'] = redmine11ConvertModel::$convertProductPlanCount;
        $result['teams']        = redmine11ConvertModel::$convertTeamCount;
        $result['releases']     = redmine11ConvertModel::$convertReleaseCount;
        $result['builds']       = redmine11ConvertModel::$convertBuildCount;
        $result['docLibs']      = redmine11ConvertModel::$convertDocLibCount ;
        $result['docs']         = redmine11ConvertModel::$convertDocCount;
        $result['files']        = redmine11ConvertModel::$convertFileCount;
        return $result;
    }                       
                               
    /**                        
     * Set table names.        
     *                         
     * @access public
     * @return void
     */
    public function setTable()
    {
        //$dbPrefix = $this->post->dbPrefix;
        $dbPrefix = '';
        define('REDMINE_TABLE_ATTACHMENTS',               $dbPrefix . 'attachments');
        define('REDMINE_TABLE_AUTH_SOURCES',              $dbPrefix . 'auth_sources');
        define('REDMINE_TABLE_BOARDS',                    $dbPrefix . 'boards');
        define('REDMINE_TABLE_CHANGES',                   $dbPrefix . 'changes');
        define('REDMINE_TABLE_CHANGESETS',                $dbPrefix . 'changesets');
        define('REDMINE_TABLE_CHANGESETS_ISSUES',         $dbPrefix . 'changesets_issues');
        define('REDMINE_TABLE_COMMENTS',                  $dbPrefix . 'comments');
        define('REDMINE_TABLE_CUSTOM_FIELDS',             $dbPrefix . 'custom_fields');
        define('REDMINE_TABLE_CUSTOM_FIELDS_PROJECTS',    $dbPrefix . 'custom_fields_projects');
        define('REDMINE_TABLE_CUSTOM_FIELDS_TRACKERS',    $dbPrefix . 'custom_fields_trackers');
        define('REDMINE_TABLE_CUSTOM_VALUES',             $dbPrefix . 'custom_values');
        define('REDMINE_TABLE_DOCUMENTS',                 $dbPrefix . 'documents');
        define('REDMINE_TABLE_ENABLED_MODULES',           $dbPrefix . 'enabled_modules');
        define('REDMINE_TABLE_ENUMERATIONS',              $dbPrefix . 'enumerations');
        define('REDMINE_TABLE_GROUPS_USERS',              $dbPrefix . 'groups_users');
        define('REDMINE_TABLE_ISSUES',                    $dbPrefix . 'issues');
        define('REDMINE_TABLE_ISSUE_CATEGORIES',          $dbPrefix . 'issue_categories');
        define('REDMINE_TABLE_ISSUE_RELATIONS',           $dbPrefix . 'issue_relations');
        define('REDMINE_TABLE_ISSUE_STATUSES',            $dbPrefix . 'issue_statuses');
        define('REDMINE_TABLE_JOURNALS',                  $dbPrefix . 'journals');
        define('REDMINE_TABLE_JOURNAL_DETAILS',           $dbPrefix . 'journal_details');
        define('REDMINE_TABLE_MEMBERS',                   $dbPrefix . 'members');
        define('REDMINE_TABLE_MEMBER_ROLES',              $dbPrefix . 'member_roles');
        define('REDMINE_TABLE_MESSAGES',                  $dbPrefix . 'messages');
        define('REDMINE_TABLE_NEWS',                      $dbPrefix . 'news');
        define('REDMINE_TABLE_OPEN_ID_AUTHENTICATION_ASSOCIATIONS',   $dbPrefix . 'open_id_authentication_associations');
        define('REDMINE_TABLE_OPEN_ID_AUTHENTICATION_NONCES',         $dbPrefix . 'open_id_authentication_nonces');
        define('REDMINE_TABLE_PROJECTS',                  $dbPrefix . 'projects');
        define('REDMINE_TABLE_PROJECTS_TRACKERS',         $dbPrefix . 'projects_trackers');
        define('REDMINE_TABLE_QUERIES',                   $dbPrefix . 'queries');
        define('REDMINE_TABLE_REPOSITORIES',              $dbPrefix . 'repositories');
        define('REDMINE_TABLE_ROLES',                     $dbPrefix . 'roles');
        define('REDMINE_TABLE_SCHEMA_MIGRATIONS',         $dbPrefix . 'schema_migrations');
        define('REDMINE_TABLE_SETTINGS',                  $dbPrefix . 'settings');
        define('REDMINE_TABLE_TIME_ENTRIES',              $dbPrefix . 'time_entries');
        define('REDMINE_TABLE_TOKENS',                    $dbPrefix . 'tokens');
        define('REDMINE_TABLE_TRACKERS',                  $dbPrefix . 'trackers');
        define('REDMINE_TABLE_USERS',                     $dbPrefix . 'users');
        define('REDMINE_TABLE_USER_PREFERENCES',          $dbPrefix . 'user_preferences');
        define('REDMINE_TABLE_VERSIONS',                  $dbPrefix . 'versions');
        define('REDMINE_TABLE_WATCHERS',                  $dbPrefix . 'watchers');
        define('REDMINE_TABLE_WIKIS',                     $dbPrefix . 'wikis');
        define('REDMINE_TABLE_WIKI_CONTENTS',             $dbPrefix . 'wiki_contents');
        define('REDMINE_TABLE_WIKI_CONTENT_VERSIONS',     $dbPrefix . 'wiki_content_versions');
        define('REDMINE_TABLE_WIKI_PAGES',                $dbPrefix . 'wiki_pages');
        define('REDMINE_TABLE_WIKI_REDIRECTS',            $dbPrefix . 'wiki_redirects');
        define('REDMINE_TABLE_WORKFLOWS',                 $dbPrefix . 'workflows');
    }

    /**
     * Convert groups.
     * 
     * @access public
     * @return void   
     */
    public function convertGroup()
    {
        /* Get group list */
        $groups = $this->dao->dbh($this->sourceDBH)
            ->select("id, lastName AS name")
            ->from(REDMINE_TABLE_USERS)
            ->where('type')->eq('Group')
            ->fetchAll('id', $autoCompany = false);

        $zentaoGroups = $this->dao->dbh($this->dbh)->select('id, name')->from(TABLE_GROUP)->fetchAll();

        /* Insert into zentao */
        $convertCount = 0;
        foreach($groups as $groupID =>$group)
        {
            $mark = false;
            $groupExistID = 0;
            unset($group->id);
            foreach($zentaoGroups as $zentaoGroup)
            {
                if($group->name == $zentaoGroup->name) 
                {
                    $mark =true;
                    $groupExistID = $zentaoGroup->id;
                }
            }
            if($mark == false)
            {
                $this->dao->dbh($this->dbh)->insert(TABLE_GROUP)
                    ->data($group)->exec();
                $this->map['groups'][$groupID] = $this->dao->lastInsertID();
                $convertCount ++;
            }
            else
            {
                self::$info['groups'][] = sprintf($this->lang->convert->errorGroupExists, $group->name);
                $this->map['groups'][$groupID] = $groupExistID;
            }
        }
        redmine11ConvertModel::$convertGroupCount += $convertCount;
    }

    /**
     * Convert users.
     * 
     * @access public
     * @return void 
     */
    public function convertUser()
    {
        /* Get user list. */
        $users = $this->dao->dbh($this->sourceDBH)
            ->select("id, login AS account, firstname, lastname, mail as email")
            ->from(REDMINE_TABLE_USERS)
            ->where('type')->eq('User')
            ->fetchAll('id', $autoCompany = false);

        $zentaoUsers = $this->dao->dbh($this->dbh)->select('account')->from(TABLE_USER)->fetchAll();

        /* Insert into zentao. */
        $convertCount = 0;
        foreach($users as $id => $user)
        {
            $mark = false;
            foreach($zentaoUsers as $zentaoUser)
            {
                if($zentaoUser->account == $user->account) $mark = true;
            }
            if(!$mark)
            {
                $user->password = 'e10adc3949ba59abbe56e057f20f883e';
                $user->realname = $user->lastname . $user->firstname;
                unset($user->id);
                unset($user->lastname);
                unset($user->firstname);
                $this->dao->dbh($this->dbh)->insert(TABLE_USER)->data($user)->exec();
                $this->map['users'][$id] = $this->dao->lastInsertID();
                $convertCount ++;
            }
            else
            {
                self::$info['users'][] = sprintf($this->lang->convert->errorUserExists, $user->account);
            }
        }

        /* Set admin in redmine is super manager */
        $this->dao->dbh($this->dbh)->insert(TABLE_COMPANY)
            ->set('guest')->eq(1)
            ->set('admins')->eq(',admin,')
            ->exec();
        redmine11ConvertModel::$convertUserCount += $convertCount;
    }

    /**
     * convert relationship between user and group. 
     * 
     * @access public
     * @return void
     */
    public function convertUserGroup()
    {
        $this->map['groups'][0] = 0;
        /* Get relation between user and group list. */
        $userGroups = $this->dao->dbh($this->sourceDBH)
            ->select("t1.group_id, t2.login as account")
            ->from(REDMINE_TABLE_GROUPS_USERS)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.user_id = t2.id')
            ->fetchAll('', $autoCompany = false);

        $zentaoUserGroups = $this->dao->dbh($this->dbh)->select('*')->from(TABLE_USERGROUP)->fetchAll();

        /* Insert into zentao. */
        $mark = false;
        foreach($userGroups as $userGroup)
        {
            $userGroup->group = $this->map['groups'][$userGroup->group_id];
            unset($userGroup->group_id);
            foreach($zentaoUserGroups as $zentaoUserGroup)
            {
                if($userGroup->group == $zentaoUserGroup->group and $userGroup->account == $zentaoUserGroup->account)
                {
                    $mark = true;
                }
            }
            if($mark == false)
            {
                $this->dao->dbh($this->dbh)->insert(TABLE_USERGROUP)->data($userGroup)->exec();
            }
        }
    }

    /**
     * convert products.  
     * 
     * @access public
     * @return void 
     */
    public function convertProduct()
    {
        /* Get product list */
        $products = $this->dao->dbh($this->sourceDBH)
            ->select("id, name, description, created_on as createdDate")
            ->from(REDMINE_TABLE_PROJECTS)
            ->fetchAll('id', $autoComapny = false);

        /* Insert into zentao */
        foreach($products as $productID => $product)
        {
            $product->desc = $product->description;
            unset($product->id);
            unset($product->description);
            $this->dao->dbh($this->dbh)->insert(TABLE_PRODUCT)->data($product)->exec();
            $this->map['products'][$productID] = $this->dao->lastInsertID();
        }
        redmine11ConvertModel::$convertProductCount += count($products);
    }

    /**
     * Convert projects.
     * 
     * @access public
     * @return void 
     */
    public function convertProject()
    {
        /* Get project list */
        $projects = $this->dao->dbh($this->sourceDBH)
            ->select("id, name, project_id, description, effective_date AS end")
            ->from(REDMINE_TABLE_VERSIONS)
            ->fetchAll('id', $autoComapny = false);

        /* Insert into zentao */
        foreach($projects as $projectID => $project)
        {
            $productID = $project->project_id;
            $project->desc = $project->description;
            unset($project->id);
            unset($project->project_id);
            unset($project->description);
            $this->dao->dbh($this->dbh)->insert(TABLE_PROJECT)->data($project)->exec();
            $this->map['projects'][$productID][$projectID] = $this->dao->lastInsertID();
            $this->map['project'][$projectID]  = $this->map['projects'][$productID][$projectID];
        }

        /* Create a same name project with product */
        foreach($this->map['products'] as $productID)
        {
            $project = $this->dao->dbh($this->dbh)->select('name')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch();
            $this->dao->dbh($this->dbh)->insert(TABLE_PROJECT)->data($project)->exec();
            $this->map['projectOfProduct'][$productID] = $this->dao->lastinsertID();
        }
        $convertCount = count($projects) + count($this->map['projectOfProduct']);
        redmine11ConvertModel::$convertProjectCount += $convertCount;
    }
    
    /**
     * convert builds and releases 
     * 
     * @access public
     * @return void 
     */
    public function convertBuildAndRelease()
    {
        /* Get build list */
        $buildAndReleases = $this->dao->dbh($this->sourceDBH)
            ->select('id, name, project_id, description, effective_date AS date')
            ->from(REDMINE_TABLE_VERSIONS)
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($buildAndReleases as $id => $buildAndRelease)
        {
            $buildAndRelease->project = $this->map['project'][$id];
            $buildAndRelease->product = $this->map['products'][$buildAndRelease->project_id];
            $buildAndRelease->desc    = $buildAndRelease->description; 
            unset($buildAndRelease->id);
            unset($buildAndRelease->project_id);
            unset($buildAndRelease->description);
            $this->dao->dbh($this->dbh)->insert(TABLE_BUILD)->data($buildAndRelease)->exec();
            $buildAndRelease->build = $this->dao->lastInsertID();
            unset($buildAndRelease->project);
            $this->dao->dbh($this->dbh)->insert(TABLE_RELEASE)->data($buildAndRelease)->exec();
        }
        redmine11ConvertModel::$convertBuildCount += count($buildAndReleases);
        redmine11ConvertModel::$convertReleaseCount += count($buildAndReleases);
    }

    /**
     * convert productPlans 
     * 
     * @access public
     * @return void 
     */
    public function convertProductPlan()
    {
        /* Get productPlan list */
        $productPlans = $this->dao->dbh($this->sourceDBH)
            ->select('id, name, project_id, description, effective_date, created_on AS begin')
            ->from(REDMINE_TABLE_VERSIONS)
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($productPlans as $id => $productPlan)
        {
            $productPlan->product = $this->map['products'][$productPlan->project_id];
            $productPlan->title   = $productPlan->name;
            $productPlan->desc    = $productPlan->description;
            $productPlan->end     = $productPlan->effective_date;
            unset($productPlan->id);
            unset($productPlan->project_id);
            unset($productPlan->name);
            unset($productPlan->description);
            unset($productPlan->effective_date);
            $this->dao->dbh($this->dbh)->insert(TABLE_PRODUCTPLAN)->data($productPlan)->exec();
        }

        /* Create a same plan with product */
        foreach($this->map['products'] as $productID)
        {
            $productPlan = $this->dao->dbh($this->dbh)->select('name as title')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch();
            $productPlan->product = $productID;
            $this->dao->dbh($this->dbh)->insert(TABLE_PRODUCTPLAN)->data($productPlan)->exec();
            $this->map['planOfProduct'][$productID] = $this->dao->lastinsertID();
        }
        $convertCount = count($this->map['products']) + count($productPlans);
        redmine11ConvertModel::$convertProductPlanCount += $convertCount;
    } 

    /**
     * convert relationship between project and product. 
     * 
     * @access public
     * @return void
     */
    public function convertProjectProduct()
    {
        foreach($this->map['projects'] as $productID => $projects)
        {
            foreach($projects as $projectID => $project)
            {
                $this->dao->dbh($this->dbh)->insert(TABLE_PROJECTPRODUCT)
                    ->set('project')->eq($project)
                    ->set('product')->eq($this->map['products'][$productID])
                    ->exec();
            }
        }
    }

    /**
     * convert teams. 
     * 
     * @access public
     * @return void
     */
    public function convertTeam()
    {
        /* Get team list */
        $teams = $this->dao->dbh($this->sourceDBH)
            ->select("t2.login, t1.project_id, t1.created_on AS joinDate")
            ->from(REDMINE_TABLE_MEMBERS)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.user_id = t2.id')
            ->where('t2.type')->eq('User')
            ->fetchAll('', $autoCompany = false);

        /* Insert into zentao */
        foreach($teams as $team)
        {
            $productID = $team->project_id;
            $team->account = $team->login;
            unset($team->project_id);
            unset($team->login);
            foreach($this->map['projects'][$productID] as $projectID)
            {
                $team->project = $projectID;
                $this->dao->dbh($this->dbh)->insert(TABLE_TEAM)->data($team)->exec();
            }
        }
        redmine11ConvertModel::$convertTeamCount += count($teams);
    }

    /**
     * convert docLibs.  
     * 
     * @access public
     * @return void 
     */
    public function convertDocLib()
    {
        /* Get docLib list */
        $docLibs = $this->dao->dbh($this->sourceDBH)
            ->select('id, name')->from(REDMINE_TABLE_ENUMERATIONS)
            ->where('type')->eq('DocumentCategory')
            ->andWhere('active')->eq(1)//carefull, maybe a bug about this.
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($docLibs as $docLibID => $docLib)
        {
            unset($docLib->id);
            $this->dao->dbh($this->dbh)->insert(TABLE_DOCLIB)->data($docLib)->exec();
            $this->map['docLibs'][$docLibID] = $this->dao->lastInsertID();
        }
        redmine11ConvertModel::$convertDocLibCount += count($docLibs);
    }

    /**
     * convert docs.  
     * 
     * @access public
     * @return void 
     */
    public function convertDoc()
    {
        /* Get all docs */
        $docs = $this->dao->dbh($this->sourceDBH)
            ->select("t1.id, t1.project_id AS product, t2.id AS lib, t1.title, t1.description AS content, t1.created_on AS addedDate")
            ->from(REDMINE_TABLE_DOCUMENTS)->alias('t1')
            ->leftjoin(REDMINE_TABLE_ENUMERATIONS)->alias('t2')->on('t1.category_id = t2.id')
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($docs as $docID => $doc)
        {
            unset($doc->id);
            $doc->type = 'text';
            $doc->project = 0;
            $doc->product = $this->map['products'][$doc->product];
            $doc->lib = $this->map['docLibs'][$doc->lib];
            $this->dao->dbh($this->dbh)->insert(TABLE_DOC)->data($doc)->exec();
            $this->map['docs'][$docID] = $this->dao->lastInsertID();
        }
        redmine11ConvertModel::$convertDocCount += count($docs);
    }

    /**
     * convert news. 
     * 
     * @access public
     * @return void 
     */
    public function convertNews()
    {
        /* Get news from redmine */
        $news = $this->dao->dbh($this->sourceDBH)
            ->select("t1.project_id as product, t1.title, t1.summary as digest, t1.description as content, t2.login as addedBy, t1.created_on as addedDate")
            ->from(REDMINE_TABLE_NEWS)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.author_id = t2.id')
            ->fetchAll('', $autoCompany = false);

        /* Create a news docLib  */
        $newLib->name = 'news';
        $this->dao->dbh($this->dbh)->insert(TABLE_DOCLIB)->data($newLib)->exec();
        $this->map['news'] = $this->dao->lastInsertID();
        redmine11ConvertModel::$convertDocLibCount += 1;

        /* Insert into zentao */
        foreach($news as $new)
        {
            $new->product = $this->map['products'][$new->product];
            $new->project = 0;
            $new->lib     = $this->map['news'];
            $new->type    = 'text';

            $this->dao->dbh($this->dbh)->insert(TABLE_DOC)->data($new)->exec();
        }
        redmine11ConvertModel::$convertDocCount += count($news);
    }

    /**
     * convert issue  
     * 
     * @param  array  $aimTypes //aimTypes['issueTypeID'] = aimtype  eg. aimTypes[1] = 'bug';
     * @param  array  $statusTypes //statusTypes['task']['statusTypeID'] = statusType  eg. statusTypes['task'][1] = 'wait';
     *                             //statusTypes['bug']['statusTypeID'] = statusType   eg. statusTypes['bug'][1]  = 'active';
     * @param  array  $priTypes //priTypes['task']['priTypeID'] = priType;   eg. priTypes['task'][1] = 1;              
     * @access public
     * @return void
     */
    public function convertIssue()
    {
        $aimTypes[1] = 'bug';
        $aimTypes[2] = 'story';
        $aimTypes[3] = 'task';
        $statusTypes['task'][1] = 'wait'; 
        $statusTypes['task'][2] = 'wait'; 
        $statusTypes['task'][3] = 'wait'; 
        $statusTypes['bug'][1] = 'active'; 
        $statusTypes['bug'][2] = 'active'; 
        $statusTypes['bug'][3] = 'active'; 
        $statusTypes['story'][1] = 'active'; 
        $statusTypes['story'][2] = 'active'; 
        $statusTypes['story'][3] = 'active'; 
        $priTypes['task'][1] = 1;
        $priTypes['task'][2] = 1;
        $priTypes['task'][3] = 1;
        $priTypes['task'][4] = 1;
        $priTypes['task'][5] = 1;
        $priTypes['bug'][1] = 1;
        $priTypes['bug'][2] = 1;
        $priTypes['bug'][3] = 1;
        $priTypes['bug'][4] = 1;
        $priTypes['bug'][5] = 1;
        $priTypes['story'][1] = 1;
        $priTypes['story'][2] = 1;
        $priTypes['story'][3] = 1;
        $priTypes['story'][4] = 1;
        $priTypes['story'][5] = 1;
        foreach($aimTypes as $issueType => $aimType)
        {
            if('story' == $aimType)
            {
                $this->convertStory($issueType, $statusTypes, $priTypes);
            }
            elseif('task' == $aimType)
            {
                $this->convertTask($issueType, $statusTypes, $priTypes);
            }
            else
            {
                $this->convertBug($issueType, $statusTypes, $priTypes);
            }
        }
    }

    /**
     * convert story 
     * 
     * @param  array    $issueType 
     * @param  array    $statusTypes 
     * @param  array    $priTypes 
     * @access public
     * @return void 
     */
    public function convertStory($issueType, $statusTypes, $priTypes)
    {
        /* Get story list*/
        $stories = $this->dao->dbh($this->sourceDBH)
            ->select("t1.id, t1.project_id as product, t1.subject as title, t1.description as spec, t1.status_id as status, t2.login as assignedTo, t1.priority_id as pri, t3.login as openedBy, t1.created_on as openedDate, t1.estimated_hours as estimate, t1.updated_on as lastEditedDate")
            ->from(REDMINE_TABLE_ISSUES)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.assigned_to_id = t2.id')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t3')->on('t1.author_id = t3.id')
            ->where('t1.tracker_id')->eq($issueType)
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($stories as $issueID => $story)
        {
            $storySpec->title = $story->title;
            $storySpec->spec  = $story->spec;
            unset($story->id);
            unset($story->spec);

            /* Insert story into table story */
            $story->product = $this->map['products'][$story->product];
            $story->module  = 0;
            $story->plan    = $this->map['planOfProduct'][$story->product];
            $story->fromBug = 0;
            $story->pri     = $priTypes['story'][$story->pri];
            $story->status  = $statusTypes['story'][$story->status];
            $story->toBug   = 0;
            $story->duplicateStory = 0;
            $this->dao->dbh($this->dbh)->insert(TABLE_STORY)->data($story)->exec();
            $this->map['issueID'][$issueID] = $this->dao->lastInsertID();
            $this->map['issueType'][$issueID] = 'story';

            /* Insert data into table storySpec */
            $storySpec->story = $this->map['issueID'][$issueID];
            $storySpec->version = 1;
            $this->dao->dbh($this->dbh)->insert(TABLE_STORYSPEC)->data($storySpec)->exec();
        }
        redmine11ConvertModel::$convertStoryCount += count($stories);
    }

    /**
     * convert task 
     * 
     * @param  array    $issueType 
     * @param  array    $statusTypes 
     * @param  array    $priTypes 
     * @access public
     * @return void 
     */
    public function convertTask($issueType, $statusTypes, $priTypes)
    {
        /* Get task list */
        $tasks = $this->dao->dbh($this->sourceDBH)
            ->select("t1.id, t1.project_id as product, t1.fixed_version_id as project, t1.subject as name, t1.description, t1.due_date as deadline, t1.status_id as status, t2.login as assignedTo, t1.priority_id as pri, t3.login as openedBy, t1.created_on as openedDate, t1.estimated_hours as estimate, t1.updated_on as lastEditedDate")
            ->from(REDMINE_TABLE_ISSUES)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.assigned_to_id = t2.id')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t3')->on('t1.author_id = t3.id')
            ->where('t1.tracker_id')->eq($issueType)
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($tasks as $issueID => $task)
        {
            $task->story        = 0;
            $task->storyVersion = 0;
            $task->type         = 'misc';
            $task->pri          = $priTypes['task'][$task->pri];
            $task->desc         = $task->description;
            $task->status       = $statusTypes['task'][$task->status];
            if($task->project == 0)
            {  
                $task->project = $this->map['projectOfProduct'][$task->product];
            }
            else
            {
                $task->project      = $this->map['project'][$task->project];
            }
            unset($task->id);
            unset($task->product);
            unset($task->description);
            $this->dao->dbh($this->dbh)->insert(TABLE_TASK)->data($task)->exec();
            $this->map['issueID'][$issueID] = $this->dao->lastInsertID();
            $this->map['issueType'][$issueID] = 'task';
        }
        redmine11ConvertModel::$convertTaskCount += count($tasks);
    }

    /**
     * convert bug 
     * 
     * @param  array    $issueType 
     * @param  array    $statusTypes 
     * @param  array    $priTypes 
     * @access public
     * @return void 
     */
    public function convertBug($issueType, $statusTypes, $priTypes)
    {
        /* Get bug list */
        $bugs = $this->dao->dbh($this->sourceDBH)
            ->select("t1.id, t1.project_id as product, t1.fixed_version_id project, t1.subject as title, t1.description as steps, t1.status_id as status, t2.login as assignedTo, t1.priority_id as pri, t3.login as openedBy, t1.created_on as openedDate, t1.updated_on as lastEditedDate")
            ->from(REDMINE_TABLE_ISSUES)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.assigned_to_id = t2.id')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t3')->on('t1.author_id = t3.id')
            ->where('t1.tracker_id')->eq($issueType)
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($bugs as $issueID => $bug)
        {
            $bug->product = $this->map['products'][$bug->product];
            $bug->module  = 0;
            $bug->story   = 0;
            $bug->storyVersion = 1;
            $bug->task         = 0;
            $bug->severity     = 3;
            $bug->type         = 'others';
            $bug->status       = $statusTypes['bug'][$bug->status];
            $bug->openedBuild  = 'trunk';
            $bug->duplicateBug = 0;
            $bug->case         = 0;
            $bug->caseVersion  = 1;
            $bug->result       = 0;
            if($bug->project == 0)
            {  
                $bug->project = $this->map['projectOfProduct'][$bug->product];
            }
            else
            {
                $bug->project = $this->map['project'][$bug->project];
            }
            unset($bug->id);
            $this->dao->dbh($this->dbh)->insert(TABLE_BUG)->data($bug)->exec(); 
            $this->map['issueID'][$issueID] = $this->dao->lastInsertID();
            $this->map['issueType'][$issueID] = 'bug';
        }
        redmine11ConvertModel::$convertBugCount += count($bugs);
   }

    /**
     * Convert attachments.
     * 
     * @access public
     * @return void 
     */
    public function convertFile()
    {
        $this->setPath();

        /* Get file list */
        $files = $this->dao->dbh($this->sourceDBH)
            ->select('t1.id, t1.container_id as objectID, t1.container_type as objectType, t1.filename as title, t1.disk_filename as pathname, t1.filesize as size, t2.login as addedBy, t1.created_on as addedDate, description')
            ->from(REDMINE_TABLE_ATTACHMENTS)->alias('t1')
            ->leftJoin(REDMINE_TABLE_USERS)->alias('t2')->on('t1.author_id = t2.id')
            ->fetchAll('id', $autoCompany = false);

        /* Insert into zentao */
        foreach($files as $fileID => $file)
        {
            if($file->description != '')
            {
                $file->title = $file->description;
                unset($file->description);
            }
            else
            {
                unset($file->description);
            }

            /* Transform objectType and objectID */
            if($file->objectType == 'Issue')
            {
                $file->objectType = $this->map['issueType'][$file->objectID]; 
                $file->objectID   = $this->map['issueID'][$file->objectID];
            }
            elseif($file->objectType == 'Document')
            {
                $file->objectType = 'doc' ;
                $file->objectID   = $this->map['docs'][$file->objectID];
            }
            elseif($file->objectType == 'WikiPage')
            {
                continue;
            }
            elseif($file->objectType == 'Version')
            {
                $doc->project = $this->map['project'][$file->objectID];
                $doc = $this->dao->dbh($this->dbh)->select('product')->from(TABLE_PROJECTPRODUCT)->where('project')->eq($doc->project)->fetch();
                $doc->lib = 'project';
                $doc->module = 0;
                $doc->title  = $file->title;
                $doc->type   = 'file';
                $doc->addedBy   = $file->addedBy;
                $doc->addedDate = $file->addedDate;
                $this->dao->dbh($this->dbh)->insert(TABLE_DOC)->data($doc)->exec();
                redmine11ConvertModel::$convertDocCount += 1;

                $file->objectType = 'doc';
                $file->objectID   = $this->dao->lastInsertID();
            }

            $pathname = pathinfo($file->pathname);
            $file->extension = $pathname["extension"];
            unset($file->id);

            /* Insert into database. */
            $this->dao->dbh($this->dbh)->insert(TABLE_FILE)->data($file)->exec();

            /* Copy file. */
            $soureFile = $this->filePath . $file->pathname;
            if(!file_exists($soureFile))
            {
                self::$info['files'][] = sprintf($this->lang->convert->errorFileNotExits, $soureFile);
                continue;
            }
            $targetFile = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . $file->pathname;
            $targetPath = dirname($targetFile);
            if(!is_dir($targetPath)) mkdir($targetPath, 0777, true);
            if(!copy($soureFile, $targetFile))
            {
                self::$info['files'][] = sprintf($this->lang->convert->errorCopyFailed, $targetFile);
            }
        }
        redmine11ConvertModel::$convertFileCount += count($files);
    }

    /**
     * Clear the converted records.
     * 
     * @access public
     * @return void
     */
    public function clear()
    {
        foreach($this->session->state as $table => $maxID)
        {
            $this->dao->dbh($this->dbh)->delete()->from($table)->where('id')->gt($maxID)->exec();
        }
    }
}

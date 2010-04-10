<?php
/**
 * The control file of common module of ZenTaoMS.
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
 * @copyright   Copyright 2009-2010 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     common
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class common extends control
{
    /**
     * ���캯���������Ự�����ع�˾ģ�飬�����ù�˾��Ϣ��
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->sendHeader();
        $this->loadModel('company');
        $this->setCompany();
        $this->setUser();
    }

    /**
     * ����û��Ե�ǰ��������û��Ȩ�ޡ����û��Ȩ�ޣ�����ת����½���档
     * 
     * @access public
     * @return void
     */
    public function checkPriv()
    {
        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();
        if($module == 'user')
        {
            if($method == 'login' or $method == 'logout' or $method == 'deny') return true;
        }
        elseif($module == 'api' and $method == 'getsessionid') 
        {
            return true;
        }

        if(isset($this->app->user))
        {
            if(!common::hasPriv($module, $method))
            {
                $vars = "module=$module&method=$method";
                if(isset($_SERVER['HTTP_REFERER']))
                {
                    $referer  = helper::safe64Encode($_SERVER['HTTP_REFERER']);
                    $vars .= "&referer=$referer";
                }
                $denyLink = $this->createLink('user', 'deny', $vars);

                /* Fix the bug of IE: use js locate, can't get the referer. */
                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
                {
                echo <<<EOT
<a href='$denyLink' id='denylink' style='display:none'>deny</a>
<script language='javascript'>document.getElementById('denylink').click();</script>
EOT;
                }
                else
                {
                    echo js::locate($denyLink);
                }
                exit;
            }
        }
        else
        {
            $this->locate($this->createLink('user', 'login'));
        }
    }

    /* ��鵱ǰ�û���ĳһ��ģ���ĳһ�������Ƿ���Ȩ�޷��ʡ�*/
    public static function hasPriv($module, $method)
    {
        global $app;

        /* ����Ƿ��ǹ���Ա��*/
        $account = ',' . $app->user->account . ',';
        if(strpos($app->company->admins, $account) !== false) return true; 

        /* �ǹ���Ա������Ȩ���б����Ƿ���ڡ�*/
        $rights  = $app->user->rights;
        if(isset($rights[strtolower($module)][strtolower($method)])) return true;
        return false;
    }

    /* ��ӡ��������������*/
    public static function printTopBar()
    {
        global $lang, $app;
        if(isset($app->user)) echo $app->user->realname . ' ';
        if(isset($app->user) and $app->user->account != 'guest')
        {
            echo html::a(helper::createLink('my', 'index'), $lang->myControl);
            echo html::a(helper::createLink('user', 'logout'), $lang->logout);
        }
        else
        {
            echo html::a(helper::createLink('user', 'login'), $lang->login);
        }
        echo html::a('http://www.zentao.cn', $lang->zentaoSite, '_blank');
        echo $lang->sponser;
    }

    /* ��ӡ���˵���*/
    public static function printMainmenu($moduleName)
    {
        global $app, $lang;
        echo "<ul>\n";
        echo "<li>$lang->zentaoMS</li>\n";

        /* �趨��ǰ�����˵��Ĭ����ȡ��ǰ��ģ����������и�ģ������Ӧ�Ĳ˵����飬��ȡ��������Ϊ���˵��*/
        $mainMenu = $moduleName;
        if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;

        /* ѭ����ӡ���˵���*/
        foreach($lang->menu as $menuKey => $menu)
        {
            $active = $menuKey == $mainMenu ? 'class=active' : '';
            list($menuLabel, $module, $method) = explode('|', $menu);

            if(common::hasPriv($module, $method))
            {
                $link  = helper::createLink($module, $method);
                echo "<li $active><nobr><a href='$link'>$menuLabel</a></nobr></li>\n";
            }
        }

        /* ��ӡ������*/
        $moduleName = $app->getModuleName();
        $methodName = $app->getMethodName();
        $searchObject = $moduleName;
        if($moduleName == 'product')
        {
           if($methodName == 'browse') $searchObject = 'story';
        }
        elseif($moduleName == 'project')
        {
            if(strpos('task|story|bug|build', $methodName) !== false) $searchObject = $methodName;
        }
        elseif($moduleName == 'my' or $moduleName == 'user')
        {
            $searchObject = $methodName;
        }

        echo "<li id='searchbox'>"; 
        echo html::select('searchType', $lang->searchObjects, $searchObject);
        echo html::input('searchQuery', $lang->searchTips, "onclick=this.value='' onkeydown='if(event.keyCode==13) shortcut()' class='text-2'");
        echo html::submitButton($lang->go, 'onclick="shortcut()"');
        echo "</li>";
        echo "</ul>\n";
    }

    /* ��ӡģ��Ĳ˵���*/
    public static function printModuleMenu($moduleName)
    {
        global $lang, $app;

        /* û�����ò˵���ֱ���˳���*/
        if(!isset($lang->$moduleName->menu)) {echo "<ul></ul>"; return;}

        /* ��ò˵����ã�����¼��ǰ��ģ�����ͷ�������*/
        $submenus      = $lang->$moduleName->menu;  
        $currentModule = $app->getModuleName();
        $currentMethod = $app->getMethodName();

        /* �˵���ʼ��*/
        echo "<ul>\n";

        /* ѭ������ÿһ���˵��*/
        foreach($submenus as $submenu)
        {
            /* ��ʼ�����á�*/
            $link      = $submenu;
            $subModule = '';
            $alias     = '';
            $float     = '';
            $active    = '';
            $target    = '';

            /* ����ò˵������������ʽ���õģ��򸲸������Ĭ�����á�*/
            if(is_array($submenu)) extract($submenu);

            /* ��ӡ�˵���*/
            if(strpos($link, '|') === false)
            {
                echo "<li>$link</li>\n";
            }
            else
            {
                $link = explode('|', $link);
                list($label, $module, $method) = $link;
                $vars = isset($link[3]) ? $link[3] : '';
                if(common::hasPriv($module, $method))
                {
                    global $app;

                    /* �ж��Ƿ�Ӧ�����ü��*/
                    if($currentModule == $subModule) $active = 'active';
                    if($module == $currentModule and ($method == $currentMethod or strpos($alias, $currentMethod) !== false)) $active = 'active';

                    echo "<li class='$float $active'>" . html::a(helper::createLink($module, $method, $vars), $label, $target) . "</li>\n";
                }
            }
        }
        echo "</ul>\n";
    }

    /* ��ӡ���м������*/
    public static function printBreadMenu($moduleName, $position)
    {
        global $lang;
        $mainMenu = $moduleName;
        if(isset($lang->menugroup->$moduleName)) $mainMenu = $lang->menugroup->$moduleName;
        list($menuLabel, $module, $method) = explode('|', $lang->menu->index);
        echo html::a(helper::createLink($module, $method), $lang->zentaoMS) . $lang->arrow;
        if($moduleName != 'index')
        {
            list($menuLabel, $module, $method) = explode('|', $lang->menu->$mainMenu);
            echo html::a(helper::createLink($module, $method), $menuLabel);
        }
        else
        {
            echo $lang->index->common;
        }
        if(empty($position)) return;
        echo $lang->arrow;
        foreach($position as $key => $link)
        {
            echo $link;
            if(isset($position[$key + 1])) echo $lang->arrow;
        }
    }

    /* ���ò˵��Ĳ�����*/
    public function setMenuVars($menu, $key, $params)
    {
        if(is_array($params))
        {
            if(is_array($menu->$key))
            {
                $menu->$key = (object)$menu->$key;
                $menu->$key->link = vsprintf($menu->$key->link, $params);
                $menu->$key = (array)$menu->$key;
            }
            else 
            {
                $menu->$key = vsprintf($menu->$key, $params);
            }
        }
        else
        {
            if(is_array($menu->$key))
            {
                $menu->$key = (object)$menu->$key;
                $menu->$key->link = sprintf($menu->$key->link, $params);
                $menu->$key = (array)$menu->$key;
            }
            else
            {
                $menu->$key = sprintf($menu->$key, $params);
            }
        }
    }

    /* ��ӡ����orderby�����ӡ� */
    public static function printOrderLink($fieldName, $orderBy, $vars, $label, $module = '', $method = '')
    {
        global $lang, $app;
        if(empty($module)) $module= $app->getModuleName();
        if(empty($method)) $method= $app->getMethodName();
        if(strpos($orderBy, $fieldName) !== false)
        {
            if(stripos($orderBy, 'desc') !== false)
            {
                $orderBy   = str_ireplace('desc', 'asc', $orderBy);
                $className = 'headerSortUp';
            }
            elseif(stripos($orderBy, 'asc')  !== false)
            {
                $orderBy = str_ireplace('asc', 'desc', $orderBy);
                $className = 'headerSortDown';
            }
        }
        else
        {
            $orderBy   = $fieldName . '_' . 'asc';
            $className = 'header';
        }
        $link = helper::createLink($module, $method, sprintf($vars, $orderBy));
        echo "<div class='$className'>" . html::a($link, $label) . '</div>';
    }

    /* ��ӡ���ӣ�����Ȩ��*/
    public static function printLink($module, $method, $vars = '', $label, $target = '', $misc = '')
    {
        if(!common::hasPriv($module, $method)) return false;
        echo html::a(helper::createLink($module, $method, $vars), $label, $target, $misc);
        return true;
    }

    /**
     * ���õ�ǰ���ʵĹ�˾��Ϣ��
     * 
     * ���ȳ��԰��յ�ǰ���ʵ��������Ҷ�Ӧ�Ĺ�˾��Ϣ��
     * ����޷��鵽���ٰ���Ĭ�ϵ��������в��ҡ�
     * ������޷��鵽����ȡ��һ����˾��ΪĬ�ϵĹ�˾��
     * ��ȡ��˾��Ϣ֮�󣬽���д�뵽$_SESSION�С�
     *
     * @access public
     * @return void
     */
    private function setCompany()
    {
        if(isset($_SESSION['company']) and $_SESSION['company']->pms == $_SERVER['HTTP_HOST'])
        {
            $this->app->company = $_SESSION['company'];
        }
        else
        {
            $company = $this->company->getByDomain();
            if(!$company and isset($this->config->default->domain)) $company = $this->company->getByDomain($this->config->default->domain);
            if(!$company) $company = $this->company->getFirst();
            if(!$company) $this->app->error(sprintf($this->lang->error->companyNotFound, $_SERVER['HTTP_HOST']), __FILE__, __LINE__, $exit = true);
            $_SESSION['company'] = $company;
            $this->app->company  = $company;
        }
    }

    /**
     * ���õ�ǰ���ʵ��û���Ϣ��
     * 
     * @access public
     * @return void
     */
    private function setUser()
    {
        if(isset($_SESSION['user']))
        {
            $this->app->user = $_SESSION['user'];
        }
        elseif($this->app->company->guest)
        {
            $user             = new stdClass();
            $user->account    = 'guest';
            $user->realname   = 'guest';
            $user->rights     = $this->loadModel('user')->authorize('guest');
            $_SESSION['user'] = $user;
            $this->app->user = $_SESSION['user'];
        }
    }

    /* �����������Ĳ�Ʒid��session�Ự�С�*/
    public static function saveProductState($productID, $defaultProductID)
    {
        global $app;
        if($productID > 0) $app->session->set('product', (int)$productID);
        if($productID == 0 and $app->session->product == '') $app->session->set('product', $defaultProductID);
        return $app->session->product;
    }

    /* ��������������Ŀid��session�Ự�С�*/
    public static function saveProjectState($projectID, $projects)
    {
        global $app;
        if($projectID > 0) $app->session->set('project', (int)$projectID);
        if($projectID == 0 and $app->session->project == '') $app->session->set('project', $projects[0]);
        if(!in_array($app->session->project, $projects)) $app->session->set('project', $projects[0]);
        return $app->session->project;
    }

    /**
     * ����header��Ϣ���������
     * 
     * @access public
     * @return void
     */
    public function sendHeader()
    {
        header("Content-Type: text/html; Language={$this->config->encoding}");
        header("Cache-control: private");
    }

    /* �Ƚ���������Ԫ�صĲ�ͬ�������޸ļ�¼��*/
    public static function createChanges($old, $new)
    {
        global $config;
        $changes    = array();
        $magicQuote = get_magic_quotes_gpc();
        foreach($new as $key => $value)
        {
            if(strtolower($key) == 'lastediteddate') continue;
            if(strtolower($key) == 'lasteditedby')   continue;
            if(strtolower($key) == 'assigneddate')   continue;

            if($magicQuote) $value = stripslashes($value);
            if($value != $old->$key)
            { 
                $diff = '';
                if(substr_count($value, "\n") > 1 or substr_count($old->$key, "\n") > 1 or strpos('name,title,desc,spec,steps', strtolower($key)) !== false) $diff = self::diff($old->$key, $value);
                $changes[] = array('field' => $key, 'old' => $old->$key, 'new' => $value, 'diff' => $diff);
            }
        }
        return $changes;
    }

    /* �Ƚ������ַ����Ĳ�ͬ��ժ��PHPQAT�Զ������Կ�ܡ�*/
    public static function diff($text1, $text2)
    {
        $w  = explode("\n", trim($text1));
        $o  = explode("\n", trim($text2));
        $w1 = array_diff_assoc($w,$o);
        $o1 = array_diff_assoc($o,$w);
        $w2 = array();
        $o2 = array();
        foreach($w1 as $idx => $val) $w2[sprintf("%03d<",$idx)] = sprintf("%03d- ", $idx+1) . "<del>" . trim($val) . "</del>";
        foreach($o1 as $idx => $val) $o2[sprintf("%03d>",$idx)] = sprintf("%03d+ ", $idx+1) . "<ins>" . trim($val) . "</ins>";
        $diff = array_merge($w2, $o2);
        ksort($diff);
        return implode("\n", $diff);
    }

    /* ���ϵͳURL��ַ��*/
    public function getSysURL()
    {
        global $config;
        $httpType = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 'https' : 'http';
        $httpHost = $_SERVER['HTTP_HOST'];
        return "$httpType://$httpHost";
    }

    /* ���ϵͳĬ�ϵ���ʽ��*/
    public function getDefaultCss()
    {
        global $app;
        $pathFix = $app->getPathFix();
        $cssFile = $app->getAppRoot() . "www{$pathFix}theme{$pathFix}default{$pathFix}style.css";
        $cssContent = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','', file_get_contents($cssFile));
        $cssContent = str_replace(array(" {", "} ", '  ', "\r\n", "\r", "\n", "\t"), array("{", '}', ' ', ''), $cssContent);
        return $cssContent;
    }
}

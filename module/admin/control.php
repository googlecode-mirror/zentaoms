<?php
/**
 * The control file of admin module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class admin extends control
{
    /**
     * Index page of admin module. Locate to action's trash page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate($this->createLink('action', 'trash'));
    }
}

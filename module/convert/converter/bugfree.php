<?php
/**
 * The baisc model file of bugfree convert of ZenTaoMS.
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
 * @package     convert
 * @version     $Id$
 * @link        http://www.zentao.cn
 */
class bugfreeConvertModel extends convertModel
{
    public $map         = array();
    public $filePath    = '';
    static public $info = array();

    /* ���캯�������ӵ����ݿ⡣*/
    public function __construct()
    {
        parent::__construct();
        parent::connectDB();
    }

    /* ���Tables��*/
    public function checkTables()
    {
        return true;
    }

    /* ��鰲װ·����*/
    public function checkPath()
    {
        $this->setPath();
        return file_exists($this->filePath);
    }

    /* ���ø���·����*/
    public function setPath()
    {
        $this->filePath = realpath($this->post->installPath) . $this->app->getPathFix() . 'BugFile' . $this->app->getPathFix();
    }

    /* ִ��ת����*/
    public function execute($version)
    {
    }

    /* ��յ���֮������ݡ�*/
    public function clear()
    {
        foreach($this->session->state as $table => $maxID)
        {
            $this->dao->dbh($this->dbh)->delete()->from($table)->where('id')->gt($maxID)->exec();
        }
    }
}

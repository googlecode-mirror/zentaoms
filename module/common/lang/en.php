<?php
/**
 * The common english language file of ZenTaoMS.
 *
 * All items used commonly should be defined here.
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
$lang->zentaoMS   = 'ZenTaoPMS';
$lang->logout     = 'Logout';
$lang->login      = 'Login';
$lang->currentPos = 'Current POS';
$lang->arrow      = '>>';
$lang->colon      = '::';
$lang->reset      = 'Reset';
$lang->edit       = 'Edit';
$lang->delete     = 'Delete';
$lang->close      = 'Close';
$lang->activate   = 'Activate';
$lang->delete     = 'Delete';
$lang->save       = 'Save';
$lang->actions    = 'Actions';
$lang->comment    = 'Comment';
$lang->history    = 'History';
$lang->welcome    = "Welcome to use %s{$lang->colon}{$lang->zentaoMS}";
$lang->zentaoSite = "Official Site";
$lang->myControl  = "Dashboard";
$lang->sponser    = "<a href='http://www.pujia.com' target='_blank'>PUJIA donated</a>";
$lang->at         = ' at ';
$lang->feature    = 'Feature';
$lang->year       = 'Year';
$lang->downArrow  = '��';
$lang->goback     = 'Go Back';
$lang->selectAll  = 'ȫѡ';
$lang->attatch    = '����';
$lang->reverse    = '���л�˳��';
$lang->addFiles   = '�ϴ��˸��� ';

/* �������˵���*/
$lang->menu->index   = 'Home|index|index';
$lang->menu->my      = 'Dashboard|my|index';
$lang->menu->product = 'Product View|product|index';
$lang->menu->project = 'Project View|project|index';
$lang->menu->qa      = 'QA View|qa|index';
$lang->menu->company = 'Org View|company|index';
$lang->menu->admin   = 'Admin|admin|index';

/* ��ҳ�˵����á�*/
$lang->index->menu->product = '�����Ʒ|product|browse';
$lang->index->menu->project = '�����Ŀ|project|browse';

/* �ҵĵ��̲˵����á�*/
$lang->my->menu->account  = '%s' . $lang->arrow;
$lang->my->menu->todo     = array('link' => '�ҵ�TODO|my|todo|', 'subModule' => 'todo');
$lang->my->menu->task     = '�ҵ�����|my|task|';
$lang->my->menu->project  = '�ҵ���Ŀ|my|project|';
$lang->my->menu->story    = '�ҵ�����|my|story|';
$lang->my->menu->bug      = '�ҵ�Bug|my|bug|';
$lang->my->menu->profile  = array('link' => '�ҵĵ���|my|profile|', 'alias' => 'editprofile');
$lang->todo->menu         = $lang->my->menu;

/* ��Ʒ��ͼ���á�*/
$lang->product->menu->list   = '%s';
$lang->product->menu->story  = array('link' => '�����б�|product|browse|productID=%s',     'subModule' => 'story');
$lang->product->menu->plan   = array('link' => '�ƻ��б�|productplan|browse|productID=%s', 'subModule' => 'productplan');
$lang->product->menu->release= array('link' => '�����б�|release|browse|productID=%s',     'subModule' => 'release');
$lang->product->menu->roadmap= '·��ͼ|product|roadmap|productID=%s';
$lang->product->menu->edit   = '�༭��Ʒ|product|edit|productID=%s';
$lang->product->menu->delete = array('link' => 'ɾ����Ʒ|product|delete|productID=%s', 'target' => 'hiddenwin');
$lang->product->menu->module = 'ά��ģ��|tree|browse|productID=%s&view=product';
$lang->product->menu->create = array('link' => '������Ʒ|product|create', 'float' => 'right');
$lang->story->menu           = $lang->product->menu;
$lang->productplan->menu     = $lang->product->menu;
$lang->release->menu         = $lang->product->menu;

/* ��Ŀ��ͼ�˵����á�*/
$lang->project->menu->list   = '%s';
$lang->project->menu->task   = array('link' => '�����б�|project|task|projectID=%s', 'subModule' => 'task');
$lang->project->menu->story  = array('link' => '�����б�|project|story|projectID=%s', 'alias' => 'linkstory');
$lang->project->menu->bug    = 'Bug�б�|project|bug|projectID=%s';
$lang->project->menu->build  = array('link' => 'Build�б�|project|build|projectID=%s', 'subModule' => 'build');
$lang->project->menu->burn   = 'ȼ��ͼ|project|burn|projectID=%s';
$lang->project->menu->team   = array('link' => '�Ŷӳ�Ա|project|team|projectID=%s', 'alias' => 'managemembers');
$lang->project->menu->line   = $lang->colon;
$lang->project->menu->view   = '������Ϣ|project|view|projectID=%s';
$lang->project->menu->edit   = '�༭��Ŀ|project|edit|projectID=%s';
$lang->project->menu->delete = array('link' => 'ɾ����Ŀ|project|delete|projectID=%s', 'target' => 'hiddenwin');
$lang->project->menu->product= '������Ʒ|project|manageproducts|projectID=%s';

$lang->project->menu->create = array('link' => '������Ŀ|project|create', 'float' => 'right');
$lang->task->menu            = $lang->project->menu;
$lang->build->menu           = $lang->project->menu;

/* QA��ͼ�˵����á�*/
$lang->bug->menu->product  = '%s';
$lang->bug->menu->bug      = array('link' => 'ȱ�ݹ���|bug|browse|productID=%s', 'alias' => 'view,create,edit,resolve,close,active', 'subModule' => 'tree');
$lang->bug->menu->testcase = array('link' => '��������|testcase|browse|productID=%s', 'alias' => 'view,create,edit');
$lang->bug->menu->testtask = array('link' => '��������|testtask|browse|productID=%s');

$lang->testcase->menu->product  = '%s';
$lang->testcase->menu->bug      = array('link' => 'ȱ�ݹ���|bug|browse|productID=%s', 'alias' => 'view,create,edit,resolve,close,active');
$lang->testcase->menu->testcase = array('link' => '��������|testcase|browse|productID=%s', 'alias' => 'view,create,edit', 'subModule' => 'tree');
$lang->testcase->menu->testtask = array('link' => '��������|testtask|browse|productID=%s');

$lang->testtask->menu->product  = '%s';
$lang->testtask->menu->bug      = array('link' => 'ȱ�ݹ���|bug|browse|productID=%s', 'alias' => 'view,create,edit,resolve,close,active');
$lang->testtask->menu->testcase = array('link' => '��������|testcase|browse|productID=%s', 'alias' => 'view,create,edit', 'subModule' => 'tree');
$lang->testtask->menu->testtask = array('link' => '��������|testtask|browse|productID=%s', 'alias' => 'view,create,edit,linkcase');

/* ��֯�ṹ��ͼ�˵����á�*/
$lang->company->menu->browseUser  = array('link' => '�û��б�|company|browse', 'subModule' => 'user');
$lang->company->menu->dept        = array('link' => '����ά��|dept|browse', 'subModule' => 'dept');
$lang->company->menu->browseGroup = array('link' => 'Ȩ�޷���|group|browse', 'subModule' => 'group');
$lang->company->menu->addGroup    = array('link' => '��ӷ���|group|create', 'float' => 'right');
$lang->company->menu->addUser     = array('link' => '����û�|user|create|company=%s&dept=%s&from=company', 'subModule' => 'user', 'float' => 'right');
$lang->dept->menu            = $lang->company->menu;
$lang->group->menu           = $lang->company->menu;

/* �û���Ϣ�˵����á�*/
$lang->user->menu->account  = '%s' . $lang->arrow;
$lang->user->menu->todo     = array('link' => 'TODO�б�|user|todo|account=%s', 'subModule' => 'todo');
$lang->user->menu->task     = '�����б�|user|task|account=%s';
$lang->user->menu->project  = '��Ŀ�б�|user|project|account=%s';
$lang->user->menu->bug      = 'Bug�б�|user|bug|account=%s';
$lang->user->menu->profile  = array('link' => '�û���Ϣ|user|profile|account=%s', 'alias' => 'edit');
$lang->user->menu->browse   = array('link' => '�û�����|company|browse|', 'float' => 'right');

/* ��̨����˵����á�*/
$lang->admin->menu->browseCompany = array('link' => '��˾����|admin|browsecompany', 'subModule' => 'company');
//$lang->admin->menu->convert       = array('link' => '������ϵͳ����|convert|index', 'subModule' => 'convert');
$lang->admin->menu->upgrade       = array('link' => '����|upgrade|index',           'subModule' => 'upgrade');
$lang->admin->menu->createCompany = array('link' => '������˾|company|create', 'float' => 'right');
$lang->convert->menu              = $lang->admin->menu;
$lang->upgrade->menu              = $lang->admin->menu;

/*�˵����ã��������á�*/
$lang->menugroup->release     = 'product';
$lang->menugroup->story       = 'product';
$lang->menugroup->productplan = 'product';
$lang->menugroup->task        = 'project';
$lang->menugroup->build       = 'project';
$lang->menugroup->company     = 'admin';
$lang->menugroup->convert     = 'admin';
$lang->menugroup->upgrade     = 'admin';
$lang->menugroup->user        = 'company';
$lang->menugroup->group       = 'company';
$lang->menugroup->bug         = 'qa';
$lang->menugroup->testcase    = 'qa';
$lang->menugroup->testtask    = 'qa';
$lang->menugroup->people      = 'company';
$lang->menugroup->dept        = 'company';
$lang->menugroup->todo        = 'my';

/* ������ʾ��Ϣ��*/
$lang->error->companyNotFound = "�����ʵ����� %s û�ж�Ӧ�Ĺ�˾��";
$lang->error->length          = array("��%s�����ȴ���Ӧ��Ϊ��%s��", "��%s������Ӧ����������%s�����Ҳ�С�ڡ�%s����");
$lang->error->reg             = "��%s�������ϸ�ʽ��Ӧ��Ϊ:��%s����";
$lang->error->unique          = "��%s���Ѿ��С�%s��������¼�ˡ�";
$lang->error->notempty        = "��%s������Ϊ�ա�";
$lang->error->int             = array("��%s��Ӧ�������֡�", "��%s��Ӧ�����ڡ�%s-%s��֮�䡣");
$lang->error->float           = "��%s��Ӧ�������֣�������С����";
$lang->error->email           = "��%s��Ӧ��Ϊ�Ϸ���EMAIL��";
$lang->error->date            = "��%s��Ӧ��Ϊ�Ϸ������ڡ�";
$lang->error->account         = "��%s��Ӧ��Ϊ�Ϸ����û�����";
$lang->error->passwordsame    = "��������Ӧ����ȡ�";
$lang->error->passwordrule    = "����Ӧ�÷��Ϲ���";

/* ��ҳ��Ϣ��*/
$lang->pager->noRecord  = "��ʱû�м�¼";
$lang->pager->digest    = "��<strong>%s</strong>����¼,ÿҳ <strong>%s</strong>����ҳ�棺<strong>%s/%s</strong> ";
$lang->pager->first     = "��ҳ";
$lang->pager->pre       = "��ҳ";
$lang->pager->next      = "��ҳ";
$lang->pager->last      = "ĩҳ";
$lang->pager->locate    = "GO!";

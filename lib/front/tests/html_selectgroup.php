#!/usr/bin/env php
<?php
/**
 * ����html��selectgroup������
 *
 * 1. ���������
 * 2. name�к�������������֤���ɵ�id�Ƿ���ȷ��
 * 3. name�к������������������֣���֤���ɵ�id�Ƿ���ȷ��
 * 4. ��֤����selectedItems�Ƿ���ȷ��
 * 5. ��֤���selectedItems�Ƿ���ȷ��
 * 6. ��֤selectedItems����options�����ĳһ��key����֤selected�Ƿ���ȷ��
 * 7. ��֤attri�Ĵ����Ƿ���ȷ��
 * 8. ��֤optionsΪ�գ��Ƿ񷵻�false��
 *
 * @author  chunsheng.wang <wwccss@gmail.com>
 * @version $Id$
 */
include '../front.class.php';

$groups['group1']['a'] = 'texta';
$groups['group1']['b'] = 'textb';
$groups['group2']['c'] = 'textc';
$groups['group2']['d'] = 'textd';

echo html::selectgroup('select', $groups);
?>

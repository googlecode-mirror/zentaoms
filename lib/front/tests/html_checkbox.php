#!/usr/bin/env php
<?php
/**
 * ����html��checkbox������
 *
 * 1. ���������
 * 2. ��֤����selectedItems�Ƿ���ȷ��
 * 3. ��֤���selectedItems�Ƿ���ȷ��
 * 4. ��֤selectedItems����options�����ĳһ��key����֤selected�Ƿ���ȷ��
 * 5. ��֤attrib�����Ƿ���ȷ��
 * 6. ��֤optionsΪ�գ��Ƿ񷵻�false��
 *
 * @author  chunsheng.wang <wwccss@gmail.com>
 * @version $Id$
 */
include '../front.class.php';

$options['a']  = 'texta';
$options['b']  = 'textb';
$options['c']  = 'textc';

echo html::checkbox('checkbox', $options) . "\n";
echo html::checkbox('checkbox', $options, 'a') . "\n";
echo html::checkbox('checkbox', $options, 'a,b') . "\n";
echo html::checkbox('checkbox', $options, 'ab') . "\n";
echo html::checkbox('checkbox', $options, '', 'style="color:red"') . "\n";
var_dump(html::checkbox('checkbox', array()));
<<<expect
html_checkbox.expect
expect
?>

#!/usr/bin/env php
<?php
/**
 * ����html��select������
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
 * @author  chunsheng.wang <chunsheng@cnezsoft.com>
 * @version $Id$
 */
include '../front.class.php';

$options['a']  = 'texta';
$options['b']  = 'textb';
$options['c']  = 'textc';

echo html::select('select',   $options);
echo html::select('select[]', $options);
echo html::select('select',   $options, 'a');
echo html::select('select',   $options, 'a,c');
echo html::select('select',   $options, 'ab');
echo html::select('select',   $options, '', 'style="color:red"');
var_dump(html::select('select', array()));
<<<expect
html_select.expect
expect
?>

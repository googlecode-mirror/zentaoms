#!/usr/bin/env php
<?php
/**
 * ����html��radio������
 *
 * 1. ���������
 * 2. ��֤����selectedItems�Ƿ���ȷ��
 * 3. ��֤���selectedItems�Ƿ���ȷ��(û��һ��ѡ�С�)
 * 4. ��֤attrib�����Ƿ���ȷ��
 * 5. ��֤optionsΪ�գ��Ƿ񷵻�false��
 *
 * @author  chunsheng.wang <wwccss@gmail.com>
 * @version $Id$
 */
include '../front.class.php';

$options['a']  = 'texta';
$options['b']  = 'textb';
$options['c']  = 'textc';

echo html::radio('radio', $options);
echo html::radio('radio', $options, 'a');
echo html::radio('radio', $options, 'a,b');
echo html::radio('radio', $options, '', 'style="color:red"');
var_dump(html::radio('radio', array()));
<<<expect
html_radio.expect
expect
?>

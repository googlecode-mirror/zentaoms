#!/usr/bin/env php
<?php
/**
 * 测试html的select方法。
 *
 * 1. 正常情况。
 * 2. name中含有中括弧，验证生成的id是否正确。
 * 3. name中含有中括弧，且有数字，验证生成的id是否正确。
 * 4. 验证单个selectedItems是否正确。
 * 5. 验证多个selectedItems是否正确。
 * 6. 验证selectedItems包含options里面的某一个key，验证selected是否正确。
 * 7. 验证attri的传毒是否正确。
 * 8. 验证options为空，是否返回false。
 *
 * @author  chunsheng.wang <wwccss@gmail.com>
 * @version $Id: html_select.php 1156 2009-04-24 08:53:44Z wwccss $
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

<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/12
 * Time:11:49 上午
 */

$arr = [0,1,2,3];
$tmp = $arr;
$arr[1] = 11;
echo $tmp[1];

echo '<br/>';

$arr = [0,1,2,3];
$x = &$arr[1];
$tmp = $arr;
$arr[1] = 999;
echo $tmp[1]; //999
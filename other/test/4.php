<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/12
 * Time:12:12 下午
 */

//强制分裂
$a = 1;
$b = $a;
$c = &$a;

$c = 5;

echo $a,$b,$c;

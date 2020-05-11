<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/26
 * Time:10:55 下午
 */

$a =1;

$b =&$a;

$b += 5;

echo $a,$b;
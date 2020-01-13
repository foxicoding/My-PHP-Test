<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/12
 * Time:10:47 上午
 */


/**
 * 字符串与数字比较，会提取首字符之前的数字部分 '123a' 会 变成 123，'a' 提取不到就是0
 *
 */
var_dump('a' == 0);      //true
var_dump('1a' == 0);     //false
var_dump('a1' == 0);     //true
var_dump('123a' == 0);   //true

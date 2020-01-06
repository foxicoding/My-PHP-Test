<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:5:18 下午
 */

/**
 * 标量类型声明和返回值的类型声明
 */

declare(strict_types = 1); //strict_type = 表示开启严格模式

function sumOfInts (int ...$ints){
    return array_sum($ints);
}

var_dump(sumOfInts(2,'2',2));
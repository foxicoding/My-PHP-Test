<?php


/**
 *
 * author:ljb
 */


/**
 * 来源：力扣 231题
 * 链接：https://leetcode-cn.com/problems/power-of-two
 * 给定一个整数，编写一个函数来判断它是否是 2 的幂次方。
 *
    示例 1:
    输入: 1
    输出: true
    解释: 20 = 1
    示例 2:

    输入: 16
    输出: true
    解释: 24 = 16
    示例 3:

    输入: 218
    输出: false
 */

function isPowerOfTwo($n) {
    if ($n <=  0){
        return false;
    }
    while($n > 1){
        if ($n % 2 == 0){
            $n = $n/2;
        }else{
            return false;
        }
    }
    return true;
}

$n = 4;
var_dump(isPowerOfTwo($n));
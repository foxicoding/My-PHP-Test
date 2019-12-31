<?php


/**
 * author:ljb
 */

/**
 * 来源：力扣 第 509题
 * 链接：https://leetcode-cn.com/problems/fibonacci-number/
 */

/**
 * 斐波那契数，通常用 F(n) 表示，形成的序列称为斐波那契数列。
 * 该数列由 0 和 1 开始，后面的每一项数字都是前面两项数字的和。也就是：
 */

/**
 * @param $N
 * @return mixed
 */
function fib($N) {
    if ($N < 2){
        return $N;
    }else{
        return $this->fib($N-1) + $this->fib($N-2);
    }
}
$N = 5;
var_dump(fib($N));
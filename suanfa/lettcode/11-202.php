<?php

/**
 *
 */

/**
 * 力扣：202题
 * https://leetcode-cn.com/problems/happy-number/
 * 编写一个算法来判断一个数是不是“快乐数”。
 * 一个“快乐数”定义为：对于一个正整数，
 * 每一次将该数替换为它每个位置上的数字的平方和，
 * 然后重复这个过程直到这个数变为 1，也可能是无限循环但始终变不到 1。如果可以变为 1，那么这个数就是快乐数。
 */

/**
 * 示例: 
    输入: 19
    输出: true
    解释:
    12 + 92 = 82
    82 + 22 = 68
    62 + 82 = 100
    12 + 02 + 02 = 1
 */


/**
 * 20 就不是一个快乐数，一通操作以后，又回到了起点20，
 * 所以需要一个set 来保存所有的和，判断set里面有没有重复的数字
 */

/**
 * @param $n
 * @return bool
 */
function isHappy($n) {
    if ($n == 1){
        return true;
    }
    $arr = [];
    while (true){

        $sum = 0;
        while ($n >= 1){
            $sum += pow($n % 10,2);
            $n = $n/10;
        }
        if ($sum == 1){
            return true;
        }
        if (in_array($sum,$arr)){
            return  false;
        }
        array_push($arr,$sum);
        $n = $sum;
    }
}

$n = 19;
var_dump(isHappy($n));
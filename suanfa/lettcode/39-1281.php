<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/19
 * Time:11:01 上午
 */


/**
 * 来源：力扣（LeetCode）
 * 链接：https://leetcode-cn.com/problems/subtract-the-product-and-sum-of-digits-of-an-integer
 * 给你一个整数 n，请你帮忙计算并返回该整数「各位数字之积」与「各位数字之和」的差。

示例 1：

    输入：n = 234
    输出：15
    解释：
    各位数之积 = 2 * 3 * 4 = 24
    各位数之和 = 2 + 3 + 4 = 9
    结果 = 24 - 9 = 15
    示例 2：

    输入：n = 4421
    输出：21
    解释：
    各位数之积 = 4 * 4 * 2 * 1 = 32
    各位数之和 = 4 + 4 + 2 + 1 = 11
    结果 = 32 - 11 = 21

    提示：
    1 <= n <= 10^5
 */

function subtractProductAndSum($n) {
    echo intval(161 / 62);exit;
    if ($n < 10){
        return $n;
    }
    //直接求
    $product = 1;
    $sum = 0;
    while ($n > 1){
        $a = $n % 10;
        $product = $product * $a;
        $sum = $sum + $a;
        $n /= 10;
    }
    return $product - $sum;
}

$n = 234;
var_dump(subtractProductAndSum($n));
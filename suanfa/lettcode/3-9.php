<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/12/10
 * Time: 9:54 AM
 */


/**
 *
 * 来源:力扣 第9题
 * 链接:https://leetcode-cn.com/problems/palindrome-number/
 * 判断一个整数是否是回文数。回文数是指正序（从左向右）和倒序（从右向左）读都是一样的整数。
    示例 1:

    输入: 121
    输出: true
    示例 2:

    输入: -121
    输出: false
    解释: 从左向右读, 为 -121 。 从右向左读, 为 121- 。因此它不是一个回文数。
    示例 3:

    输入: 10
    输出: false
    解释: 从右向左读, 为 01 。因此它不是一个回文数。
*/

/**
 * @param $num
 * @return bool
 */
function isPalindrome($num){
    if($num < 0 || ($num % 10 == 0) && $num != 0){
        return false;
    }
    $rev = 0;
    while($num > $rev){
        $rev = $rev * 10 + $num % 10;
        $num = intval($num / 10);
    }
    return $num == $rev || $num == intval($rev/10);
}
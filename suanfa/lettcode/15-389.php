<?php



/**
 * ljb
 */


/**
 * 找不同
 * 来自 力扣 ：389 题目
 * https://leetcode-cn.com/problems/find-the-difference/
 */

/**
 * 给定两个字符串 s 和 t，它们只包含小写字母。
 * 字符串 t 由字符串 s 随机重排，然后在随机位置添加一个字母。
 * 请找出在 t 中被添加的字母。
 *
 *
 * 示例:
  输入：s = "abcd" t = "abcde"
  输出：e
  解释：'e' 是那个被添加的字母。
 */

function findTheDifference($s,$t) {
    if (empty($s) && empty($t)){
        return '';
    }
    if (empty($s) && !empty($t)){
        return $t;
    }
    $count = strlen($s);
    $res = 0;
    for($i = 0; $i < $count; $i++){
        $res = $res ^ ord($t[$i]) ^ ord($s[$i]);
    }
    return chr($res ^ ord($t[strlen($t)-1]));
}

$s = 'abcd';
$t = 'abcde';

var_dump(findTheDifference($s,$t));



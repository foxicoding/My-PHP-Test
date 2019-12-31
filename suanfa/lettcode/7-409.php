<?php


/**
 * author:ljb
 */

/**
 * 来源：力扣 第409题
 * 链接：https://leetcode-cn.com/problems/longest-palindrome/
 * 给定一个包含大写字母和小写字母的字符串，找到通过这些字母构造成的最长的回文串。
 * 在构造过程中，请注意区分大小写。比如 "Aa" 不能当做一个回文字符串。
 * 注意:假设字符串的长度不会超过 1010。
 */

/**
 *示例 1:
  输入:"abccccdd"
  输出:7
  解释:我们可以构造的最长的回文串是"dccaccd", 它的长度是 7。
 */

/**
 * @param $s
 * @return int
 */
function longestPalindrome($s) {
    if (empty($s)){
        return 0;
    }
    $arr = [];
    $count = 0;
    $strCount = strlen($s);
    for ($i = 0; $i < $strCount;$i++){
        if (isset($arr[$s[$i]])){
            $count += 2;
            unset($arr[$s[$i]]);
        }else{
            $arr[$s[$i]] = 1;
        }
    }
    return count($arr) > 0 ? $count + 1 : $count;
}

$s = 'dccaccd';
var_dump(longestPalindrome($s));
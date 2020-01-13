<?php


/**
 * author:ljb
 */


/**
 *
 * 来源：力扣 第 125题
 * 链接：https://leetcode-cn.com/problems/valid-palindrome/
 * 给定一个字符串，验证它是否是回文串，只考虑字母和数字字符，可以忽略字母的大小写。
 * 本题中，我们将空字符串定义为有效的回文串。
 *
 *
 *
 * 示例 1:
 * 输入: "A man, a plan, a canal: Panama"
 * 输出: true
 * 示例 2:
 * 输入: "race a car"
 * 输出: false
 */


/**
 * @param $s
 * @return bool
 */
function isPalindrome($s){
    if (empty($s)){
        return true;
    }
    $s = trim($s);
    preg_match_all('/[a-zA-Z0-9]/',$s,$match);
    if (empty($match)){
        return  false;
    }
    $s = strtolower(implode('',$match[0]));
    $i = 0; $j = strlen($s) - 1;
    while ($i <= $j){
        if ($s[$i] != $s[$j]){
            return false;
        }
        $i++;
        $j--;
    }
    return true;
}


$s = "";
$res = isPalindrome($s);
var_dump($res);
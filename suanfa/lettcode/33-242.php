<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:15 下午
 */


/**
 * 来源：力扣 第 42题
 * 链接：https://leetcode-cn.com/problems/valid-anagram
 * 给定两个字符串 s 和 t ，编写一个函数来判断 t 是否是 s 的字母异位词。

    示例 1:

    输入: s = "anagram", t = "nagaram"
    输出: true
    示例 2:

    输入: s = "rat", t = "car"
    输出: false
    说明:
    你可以假设字符串只包含小写字母。

    进阶:
    如果输入字符串包含 unicode 字符怎么办？你能否调整你的解法来应对这种情况？
 */

/**
 * @param $s
 * @param $t
 * @return bool
 */
function isAnagram($s, $t) {
    $sLen = strlen($s);
    $tLen = strlen($t);
    if ($sLen != $tLen){
        return false;
    }
    $sArr = $tArr = [];
    for ($i=0;$i<$sLen; $i++){
        if (isset($sArr[$s[$i]])){
            $sArr[$s[$i]] += 1;
        }else{
            $sArr[$s[$i]] = 1;
        }
        if (isset($tArr[$t[$i]])){
            $tArr[$t[$i]] += 1;
        }else{
            $tArr[$t[$i]] = 1;
        }

    }
    return  $sArr == $tArr;
}

$s = "anagram";
$t = "nagaram";

var_dump(isAnagram($s,$t));
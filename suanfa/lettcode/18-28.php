<?php

/**
 * ljb
 */

/**
 *
 ********************************  KMP 算法    ********************************
 *
 * http://www.ruanyifeng.com/blog/2013/05/Knuth%E2%80%93Morris%E2%80%93Pratt_algorithm.html
 *
 * 来源：力扣 第28题
 * 链接：https://leetcode-cn.com/problems/implement-strstr
 * 实现 strStr() 函数。

    给定一个 haystack 字符串和一个 needle 字符串，
    在 haystack 字符串中找出 needle 字符串出现的第一个位置 (从0开始)。如果不存在，则返回  -1。

    示例 1:
    输入: haystack = "hello", needle = "ll"
    输出: 2

    示例 2:
    输入: haystack = "aaaaa", needle = "bba"
    输出: -1

    说明:
       当 needle 是空字符串时，我们应当返回什么值呢？这是一个在面试中很好的问题。
       对于本题而言，当 needle 是空字符串时我们应当返回 0 。这与C语言的 strstr() 以及 Java的 indexOf() 定义相符。
 */

/**
 * @desc构建next数组
 * @param string $str 模式字符串
 * @return array
 */
function makeNext($str) {
    $len = strlen($str);

    $next = [0];
    for($pos=1, $k=$next[0]; $pos<$len; $pos++) {
        if($str[$k] == $str[$pos]) {
            $k++;
        } else {
            while($k>0 && $str[$pos]!=$str[$k]) {
                $k = $next[$k-1];
            }
        }
        $next[$pos] = $k;
    }

    return $next;
}
$str = 'ABCDABD';
var_dump(makeNext($str));


/**
 * @param string $tString  目标字符串
 * @param string $pString  模式字符串
 * @param bool|false $findAll 是否找出模式串出现的全部位置
 */
function kmp($tString, $pString, $findAll=false) {
    $lenT = strlen($tString);
    $lenP = strlen($pString);
    $next = makeNext($pString);
    $found = false;

    for ($pos=0, $k=0; $pos<$lenT; $pos++) {
        if ($pString[$k] == $tString[$pos]) {
            $k++;
        } else {
            while($k>0 && $pString[$k] != $tString[$pos]) {
                $k = $next[$k-1];
            }
        }
        if ($k == $lenP) {
            $found = true;
            echo 'pattern found at '.($pos-$lenP+1) . PHP_EOL;
            if($findAll) {
                //匹配后需要退回到当前模式串出现的位置 下次循环从下一位置重新开始匹配
                $pos = $pos-$lenP+1;
                $k = 0;
            } else {
                break;
            }
        }
    }
    if(! $found) {
        echo 'pattern not found';
    }
}

kmp('abacabcaba', 'aba', 1);

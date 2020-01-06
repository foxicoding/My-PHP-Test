<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/3
 * Time:6:17 下午
 */


/**
 * 来源：力扣 第14题
 * 链接：https://leetcode-cn.com/problems/longest-common-prefix
 *
 * 编写一个函数来查找字符串数组中的最长公共前缀。

    如果不存在公共前缀，返回空字符串 ""。

    示例 1:

    输入: ["flower","flow","flight"]
    输出: "fl"
    示例 2:

    输入: ["dog","racecar","car"]
    输出: ""
    解释: 输入不存在公共前缀。
    说明:

    所有输入只包含小写字母 a-z 。

 */

/**
 * @param String[] $strs
 * @return String
 */
function longestCommonPrefix($strs) {
    if(empty($strs)){
        return '';
    }
    if (count($strs) == 1){
        return $strs[0];
    }
    $res = $strs[0];
    foreach ($strs as $key => $str){
        $res = $this->compareStr($res,$str);
    }
    return $res;
}

/**
 * @param $str1
 * @param $str2
 * @return string
 */
function compareStr($str1,$str2)
{
    $res = '';
    for ($i = 0;$i<min(strlen($str1),strlen($str2));$i++){
        if ($str1[$i] == $str2[$i]){
            $res .= $str1[$i];
        }else{
            break;
        }
    }
    return $res;
}
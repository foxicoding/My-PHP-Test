<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/14
 * Time:10:36 下午
 */


/**

给定一个未排序的整数数组，找出最长连续序列的长度。

要求算法的时间复杂度为 O(n)。

示例:

输入: [100, 4, 200, 1, 3, 2]
输出: 4
解释: 最长连续序列是 [1, 2, 3, 4]。它的长度为 4。
 */

/**
 * @param $nums
 * @return int|mixed
 */
function longestConsecutive($nums) {
    if(empty($nums)){
        return 0;
    }
    $arr = [];
    $count = count($nums);
    for($i = 0;$i < $count;$i++){
        if(isset($arr[$nums[$i]])){
            continue;
        }
        $arr[$nums[$i]] = 1;
    }
    $max = 0;
    foreach($arr as $k => $v){
        $l = 0;
        $m = 0;
        while(isset($arr[--$k])){
            $l++;
        }
        while(isset($arr[++$k])){
            $m++;
        }
        $max = max($l,$m,$max);
    }
    return $max;
}

$nums = [-2,-3,-3,7,-3,0,5,0,-8,-4,-1,2];
var_dump(longestConsecutive($nums));
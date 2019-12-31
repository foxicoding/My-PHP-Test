<?php


/**
 * author:ljb
 */


/**
 * 来源：力扣 219题
 * 链接：https://leetcode-cn.com/problems/contains-duplicate-ii
 * 给定一个整数数组和一个整数 k，判断数组中是否存在两个不同的索引 i 和 j，使得 nums [i] = nums [j]，并且 i 和 j 的差的绝对值最大为 k。

    示例 1:

    输入: nums = [1,2,3,1], k = 3
    输出: true
    示例 2:

    输入: nums = [1,0,1,1], k = 1
    输出: true
    示例 3:

    输入: nums = [1,2,3,1,2,3], k = 2
    输出: false
 */


function containsNearbyDuplicate($nums, $k) {
    if (empty($nums)){
        return false;
    }
    $arr = [];
    $count = count($nums);
    for ($i = 0;$i < $count;$i++){
        if (isset($arr[$nums[$i]])){
            for ($j = 0;$j < count($arr[$nums[$i]]);$j ++){
                if (abs($arr[$nums[$i]][$j] - $i) <= $k){
                    return true;
                }
            }
        }
        $arr[$nums[$i]][] = $i;
    }
    return false;
}

$nums = [99,99];
$k = 1;
var_dump(containsNearbyDuplicate($nums,$k));
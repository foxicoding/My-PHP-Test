<?php


/**
 * author:ljb
 */

/**
 * 来源：力扣 第217题
 * 链接：https://leetcode-cn.com/problems/contains-duplicate/
 * 给定一个整数数组，判断是否存在重复元素。
 * 如果任何值在数组中出现至少两次，函数返回 true。如果数组中每个元素都不相同，则返回 false
 */


/**
示例 1:
 * 输入: [1,2,3,1]
 * 输出: true
示例 2:
 * 输入: [1,2,3,4]
 * 输出: false
示例 3:
 * 输入: [1,1,1,3,3,4,3,2,4,2]
 * 输出: true
 */

/**
 * @param $nums
 * @return bool
 */
function containsDuplicate($nums) {
    if (empty($nums)){
        return false;
    }
    $count = count($nums);
    $arr = [];
    for ($i = 0;$i < $count;$i++){
        if (isset($arr[$nums[$i]])){
            continue;
        }
        $arr[$nums[$i]] = 1;
    }
    return !($count == count($arr));
}

$nums = [1,1,1,3,3,4,3,2,4,2];

var_dump(containsDuplicate($nums));

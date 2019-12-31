<?php


/**
 * author:ljb
 */

/**
 * 来源：力扣 53 题目
 * 链接：https://leetcode-cn.com/problems/maximum-subarray
 * 给定一个整数数组 nums ，找到一个具有最大和的连续子数组（子数组最少包含一个元素），返回其最大和。

    示例:
    输入: [-2,1,-3,4,-1,2,1,-5,4],
    输出: 6
    解释: 连续子数组 [4,-1,2,1] 的和最大，为 6。
 */

function maxSubArray($nums) {
    if (empty($nums)){
        return 0;
    }
    $max = $sum = $nums[0];
    $count = count($nums);
    for ($i = 0;$i < $count;$i++){
        if ($sum < 0){
            $sum = $nums[$i];
        }else{
            $sum += $nums[$i];
        }
        if ($sum > $max){
            $max = $sum;
        }
    }
    return $max;
}

$nums = [-2,1,-3,4,-1,2,1,-5,4];
var_dump(maxSubArray($nums));
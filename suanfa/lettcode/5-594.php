<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/12/11
 * Time: 11:26 PM
 */


/**
 *
 * 来源:力扣 第594题
 * 链接:https://leetcode-cn.com/problems/longest-harmonious-subsequence/
 * 和谐数组是指一个数组里元素的最大值和最小值之间的差别正好是1。
 * 现在，给定一个整数数组，你需要在所有可能的子序列中找到最长的和谐子序列的长度。
 */


/**
 *
 *  示例 1:
    输入: [1,3,2,2,5,2,3,7]
    输出: 5
    原因: 最长的和谐数组是：[3,2,2,2,3].
    说明: 输入的数组长度最大不超过20,000.
 */


/**
 *
 * @param $nums
 * @return int
 */
function findLHS($nums) {
    if (empty($nums)){
        return 0;
    }
    $countNum = count($nums);

    $countMap = [];
    for ($i = 0; $i < $countNum;$i++){
        if (isset($countMap[$nums[$i]])){
            $countMap[$nums[$i]]++;
        }else{
            $countMap[$nums[$i]] = 1;
        }
    }
    $maxCount = 0;
    $currentMaxCount = 0;
    foreach ($countMap as $num => $count){
        if (isset($countMap[$num+1])){
            $currentMaxCount = $count + $countMap[$num+1];
        }
        if ($currentMaxCount >= $maxCount){
            $maxCount = $currentMaxCount;
        }
    }
    return $maxCount;

}

//$nums = [1,3,2,2,5,2,3,7];
$nums = [1,2,2,1];
print_r(findLHS($nums));
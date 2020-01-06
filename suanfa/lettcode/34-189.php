<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:28 下午
 */

/**
 *
 * 来源：力扣 第189题
 * 链接：https://leetcode-cn.com/problems/rotate-array
 *
 * 给定一个数组，将数组中的元素向右移动 k 个位置，其中 k 是非负数。
 *

    示例 1:
     *
    输入: [1,2,3,4,5,6,7] 和 k = 3
    输出: [5,6,7,1,2,3,4]
    解释:
    向右旋转 1 步: [7,1,2,3,4,5,6]
    向右旋转 2 步: [6,7,1,2,3,4,5]
    向右旋转 3 步: [5,6,7,1,2,3,4]

    示例 2:

    输入: [-1,-100,3,99] 和 k = 2
    输出: [3,99,-1,-100]
    解释:
    向右旋转 1 步: [99,-1,-100,3]
    向右旋转 2 步: [3,99,-1,-100]
    说明:

    尽可能想出更多的解决方案，至少有三种不同的方法可以解决这个问题。
    要求使用空间复杂度为 O(1) 的 原地 算法。
 */

function rotate(&$nums, $k) {
    if (empty($nums)){
        return [];
    }
    if ($k == 0){
        return $nums;
    }
    $count = count($nums);
    $k = $k % $count;
    reverse($nums,0,$count - 1);
    reverse($nums,0,$k - 1);
    reverse($nums,$k,$count - 1);
    return $nums;
}


function reverse(&$nums,$start,$end)
{
    while ($start <= $end){
        $temp = $nums[$start];
        $nums[$start++] = $nums[$end];
        $nums[$end--] = $temp;
    }
}
$nums = [1,2,3,4,5,6,7];
$k = 3;
var_dump(rotate($nums,$k));
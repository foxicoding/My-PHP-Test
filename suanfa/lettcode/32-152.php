<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:3:59 下午
 */


/**
 * 来源：力扣 第152题
 * 链接：https://leetcode-cn.com/problems/maximum-product-subarray
 * 给定一个整数数组 nums ，找出一个序列中乘积最大的连续子序列（该序列至少包含一个数）。

    示例 1:

    输入: [2,3,-2,4]
    输出: 6
    解释: 子数组 [2,3] 有最大乘积 6。
    示例 2:

    输入: [-2,0,-1]
    输出: 0
    解释: 结果不能为 2, 因为 [-2,-1] 不是子数组。
 */

/**
 * @param $nums
 * @return float|int|mixed
 */
function maxProduct($nums) {
    if(empty($nums)){
        return 0;
    }
    $count = count($nums);
    $dp = [];
    for ($i=1;$i<$count;$i++){
        $x = $i % 2;
        $y = ($i - 1) % 2;
        $dp[$x][0] = max();
        $dp[$x][1] = min();

    }
}
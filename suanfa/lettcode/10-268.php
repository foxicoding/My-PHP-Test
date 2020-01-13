<?php

/**
 * author:ljb
 */


/**
 * 力扣：268题
 * https://leetcode-cn.com/problems/missing-number/
 * 给定一个包含 0, 1, 2, ..., n 中 n 个数的序列，找出 0 .. n 中没有出现在序列中的那个数。
 *
 * 示例 1:
    输入: [3,0,1]
    输出: 2
   示例 2:
    输入: [9,6,4,2,3,5,7,0,1]
    输出: 8
 */

/**
 * @param $nums
 * @return int
 */
function missingNumber($nums) {
    if (empty($nums)){
        return 0;
    }
    $res = $count = count($nums);
    for ($i = 0;$i < $count;$i++){
        $res = $res ^ $i ^ $nums[$i];
    }
    return $res;
}
$nums = [3,0,1];
var_dump(missingNumber($nums));

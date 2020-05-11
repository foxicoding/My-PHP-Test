<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/17
 * Time:6:29 下午
 */


/**
 *
 *

给你一个包含 n 个整数的数组 nums，判断 nums 中是否存在三个元素 a，b，c ，使得 a + b + c = 0 ？请你找出所有满足条件且不重复的三元组。

注意：答案中不可以包含重复的三元组。

示例：

给定数组 nums = [-1, 0, 1, 2, -1, -4]，

满足要求的三元组集合为：
[
[-1, 0, 1],
[-1, -1, 2]
]

 */

/**
 * @param $nums
 * @return array
 */
function threeSum($nums) {
    if (empty($nums)){
        return [];
    }
    sort($nums);
    $count = count($nums);
    $res = [];
    for ($i = 0;$i < $count - 2;$i++){
        $left = $i + 1;
        $right = $count - 1;
        while ($left < $right){
            $m = $nums[$i] + $nums[$left] + $nums[$right];
            if ($m > 0){
                $right--;
            }elseif ($m < 0){
                $left++;
            }else{
                $res[] = [$nums[$i],$nums[$left],$nums[$right]];
                while ($left < $right && $nums[$left] == $nums[++$left]){
                    $left++;
                }
                while ($left < $right && $nums[$right] == $nums[--$right]){
                    $right--;
                }
                $left++;
                $right--;
            }
        }
    }
    return $res;
}

$nums = [-1, 0, 1, 2, -1, -4];
$nums = [0,0,0,0];
var_dump(threeSum($nums));


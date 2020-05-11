<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/13
 * Time:6:01 下午
 */


/**

假设按照升序排序的数组在预先未知的某个点上进行了旋转。

( 例如，数组 [0,1,2,4,5,6,7] 可能变为 [4,5,6,7,0,1,2] )。

搜索一个给定的目标值，如果数组中存在这个目标值，则返回它的索引，否则返回 -1 。

你可以假设数组中不存在重复的元素。

你的算法时间复杂度必须是 O(log n) 级别。

示例 1:

输入: nums = [4,5,6,7,0,1,2], target = 0
输出: 4
示例 2:

输入: nums = [4,5,6,7,0,1,2], target = 3
输出: -1

 *
 */

/**
 * @param $nums
 * @param $target
 * @return int
 */
function search($nums,$target)
{
    if (empty($nums)){
        return -1;
    }
    $start = 0;
    $end = count($nums) - 1;
    while ($start <= $end){
        $mid = floor(($start + $end) / 2);
        if ($nums[$mid] == $target){
            return $mid;
        }
        //左边有序
        if ($nums[$mid] >= $nums[$start]){
            if ($target >= $nums[$start] && $target < $nums[$mid]){
                $end = $mid - 1;
            }else{
                $start = $mid + 1;
            }
        }else{
            if ($target > $nums[$mid] && $target <= $nums[$end]){
                $start = $mid + 1;
            }else{
                $end = $mid - 1;
            }
        }
    }
    return  -1;
}

$nums = [4,5,6,7,0,1,2];
$value = 3;
var_dump(search($nums,$value));
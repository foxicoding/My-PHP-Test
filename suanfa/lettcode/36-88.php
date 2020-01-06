<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/6
 * Time:12:38 下午
 */


/**
 * 来源：力扣 第88题
 * 链接：https://leetcode-cn.com/problems/merge-sorted-array
 * 给定两个有序整数数组 nums1 和 nums2，将 nums2 合并到 nums1 中，使得 num1 成为一个有序数组。

    说明:
    初始化 nums1 和 nums2 的元素数量分别为 m 和 n。
    你可以假设 nums1 有足够的空间（空间大小大于或等于 m + n）来保存 nums2 中的元素。
    示例:

    输入:
    nums1 = [1,2,3,0,0,0], m = 3
    nums2 = [2,5,6],       n = 3

    输出: [1,2,2,3,5,6]
 */

/**
 * 题解链接：https://www.cnblogs.com/powercai/p/11012757.html
 * @param $nums1
 * @param $m
 * @param $nums2
 * @param $n
 */

function merge(&$nums1, $m, $nums2, $n) {
    $i = $m - 1;
    $j = $n - 1;
    $k = $m + $n - 1;
    while ($i >= 0 && $j >= 0){
        if ($nums1[$i] > $nums2[$j]){
            $nums1[$k] = $nums1[$i];
            $i--;
        }else{
            $nums1[$k] = $nums2[$j];
            $j--;
        }
        $k--;
    }
    while ($j >= 0) {
        $nums1[$k] = $nums2[$j];
        $j--;
        $k--;
    }
}

$nums1 = [1,2,3,0,0,0];
$m = 3;
$nums2 = [2,5,6];
$n = 3;
merge($nums1,$m,$nums2,$n);
var_dump($nums1);
<?php


/**
 * author:ljb
 */

/**
 * 来源：力扣 第215题
 * 链接：https://leetcode-cn.com/problems/kth-largest-element-in-an-array
 *
 *
 * 在未排序的数组中找到第 k 个最大的元素。请注意，你需要找的是数组排序后的第 k 个最大的元素，而不是第 k 个不同的元素。

    示例 1:

    输入: [3,2,1,5,6,4] 和 k = 2
    输出: 5
    示例 2:

    输入: [3,2,3,1,2,4,5,5,6] 和 k = 4
    输出: 4
    说明:

    你可以假设 k 总是有效的，且 1 ≤ k ≤ 数组的长度。
 */

/**
 * @param Integer[] $nums
 * @param Integer $k
 * @return Integer
 */
function findKthLargest($nums, $k) {
    if(empty($nums)){
        return 0;
    }
    if(count($nums) == 1){
        return $nums[0];
    }
    //构建最小堆
    $minHeap = new SplMinHeap();
    foreach($nums as $num){
        $minHeap->insert($num);
    }
    //移除k-1个元素
    $count = count($nums);
    for($i=0;$i < $count - $k;$i++){
        $minHeap->extract();
    }
    return $minHeap->top();
}
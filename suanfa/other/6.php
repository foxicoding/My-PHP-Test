<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/15
 * Time:10:40 上午
 */


/**
 * 有序数组中的个数平方的个数
 *
题目如下：
给你一个有序整数数组，数组中的数可以是正数、负数、零，请实现一个函数，这个函数返回一个整数：返回这个数组所有数的平方值中有多少种不同的取值。举例：

nums = {-1,1,1,1},

那么你应该返回的是：1。因为这个数组所有数的平方取值都是1，只有一种取值

nums = {-1,0,1,2,3}

你应该返回4，因为nums数组所有元素的平方值一共4种取值：1,0,4,9

在往下看之前，请先进行思考，如果当时是你在面试，你会给出什么样的结题思路？
下面会给出两种解法，最优解：时间复杂度：O(n)、空间复杂度O(1)。无论有没有思路，在往下看之前一定要有自己的思考。

第一种也是最为直接、简单的思路：把nums数组中所有数的绝对值，全部计算完之后再统计有多少种不同的取值。
 */


/**
 * @param $nums
 * @return int
 */
function getNumA($nums)
{
    if (empty($nums)){
        return 0;
    }
    $arr = [];
    $count = count($nums);
    for ($i = 0;$i < $count;$i++){
        $sq = $nums[$i] * $nums[$i];
        if (isset($arr[$sq])){
            continue;
        }
        $arr[$sq] = 1;
    }
    return count($arr);
}

function getNumB($nums){
    if (empty($nums)){
        return 0;
    }
    $res = 0;
    $i = 0;
    $j = count($nums) - 1;
    while ($i <= $j) {
        $num1 = abs($nums[$i]);
        $num2 = abs($nums[$j]);
        $res += 1;
        if ($num1 > $num2){
            while ($i <= $j && abs($nums[$i]) == $num1){
                $i++;
            }
        }else if ($num1 < $num2){
            while ($i <= $j && abs($nums[$j]) == $num2){
                $j--;
            }
        }else{
            while ($i <= $j && abs($nums[$i]) == $num1){
                $i++;
            }
            while ($i <= $j && abs($nums[$j]) == $num2){
                $j--;
            }
        }
    }
    return $res;
}

$nums = [-1,0,1,2,3];
var_dump(getNumA($nums));
var_dump(getNumB($nums));

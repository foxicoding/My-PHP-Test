<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/12/9
 * Time: 7:33 PM
 */


/**
 * 来源：力扣 53 题目
 * 链接：https://leetcode-cn.com/problems/maximum-subarray
 * 输入一个整型数组，数组里有正数也有负数。数组中一个或者连续的多个整数组成一个字数组。
 * 求所有字数组的和的最大值。要求时间复杂度为O(n)。
 * 例如输入的数组为1, -2, 3, 10, -4, 7, 2, -5，和最大的子数组为3, 10, -4, 7, 2，因此输出为该子数组的和18
 */

/**
 *
 * 因为时间复杂度为O(n)，则只能遍历一次数组，这里同时使用两个变量sum和max，其中sum保存的是当前的和，
 * 若sum<0，则从下一个位置从新记录，max记录的是历史的最大值，只有当sum>max时用sum替换max。
 */

/**
 * @param $arr
 * @return int
 */
function findMax(array $arr){
    if (empty($arr)) {
        return 0;
    }

    $length = count($arr);
    $max = $arr[0];  //保存最大的数
    $sum = 0; //保存和
    for ($i = 0; $i < $length; $i++){
        if ($sum >= 0){
            $sum += $arr[$i];
        }else{
            $sum = $arr[$i];
        }
        if ($sum > $max){
            $max = $sum;
        }
    }
    return $max;
}

$arr = [1, -2, 3, 10, -4, 7, 2, -5];
$max = findMax($arr);
print_r($max);

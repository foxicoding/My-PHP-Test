<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/2/25
 * Time:11:39 上午
 */

/**
 * 希尔排序
 */

function shellSort(array $arr)
{
    for ($gap = floor(count($arr) / 2); $gap > 0; $gap = floor($gap / 2)) { // 缩小增量
        for ($i = $gap; $i < count($arr); $i++) { // 组内循环排序
            $j = $i;
            while ($j - $gap >= 0 && $arr[$j] < $arr[$j - $gap]) { //完成组内元素一次排序
                swap($arr, $j, $j - $gap);
                $j -= $gap;
            }
        }
        echo implode(',', $arr) . PHP_EOL; // 完成一次增量输出一次结果
    }
    return $arr;
}
<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/13
 * Time:1:24 下午
 */
//选择排序是一种简单直观的排序算法。

/*
 * 算法步骤：
  1. 首先，在序列中找到最小元素，存放到排序序列的起始位置；
  2. 接着，从剩余未排序元素中继续寻找最小元素，放到已排序序列的末尾。
  3. 重复第二步，直到所有元素均排序完毕。
 */
function select($arr)
{
    if (empty($arr)){
        return [];
    }
    $count = count($arr);
    for ($i=0;$i<$count;$i++) {
        $k = $i;
        for ($j = $i + 1; $j < $count; $j++) {
            if ($arr[$j] < $arr[$k]) {
                $k = $j;
            }
        }
        if ($k != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$k];
            $arr[$k] = $temp;
        }
    }
    return $arr;
}

$arr = [3,4,6,9,1,2,5];
var_dump(select($arr));
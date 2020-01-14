<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:33 下午
 */


/**
 * 时间复杂度：平均 O（nlogn ）  最好O（nlogn）  最坏 O(n^2)
 * 空间复杂度：O(logn)~O(n)
 * 稳定性：不稳定
 * 复杂性：较复杂
 * @param $arr
 * @return array
 */
function quick($arr)
{
    if (empty($arr)){
        return [];
    }
    $key = $arr[0];
    $count = count($arr);
    $left = $right = [];
    for ($i=1;$i<$count;$i++){
        if ($key > $arr[$i]){
            $left[] = $arr[$i];
        }else{
            $right[] = $arr[$i];
        }
    }
    $left = quick($left);
    $right = quick($right);
    return array_merge($left,[$key],$right);
}

$arr = [3,4,6,9,1,2,5];
var_dump(quick($arr));
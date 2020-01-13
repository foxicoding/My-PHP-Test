<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:33 下午
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
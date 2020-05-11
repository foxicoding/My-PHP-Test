<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/24
 * Time:4:41 下午
 */



$a = [1,2,4,5,6,8];
$b = [3,5,7,10,12,15,17];

function merge($arr1,$arr2)
{
    if (empty($arr1) && empty($arr2)){
        return [];
    }
    if (!empty($arr1) && empty($arr2)){
        return $arr1;
    }
    if (empty($arr1) && !empty($arr2)){
        return $arr2;
    }

    $i = count($arr1) - 1;
    $j = count($arr2) - 1;
    $res = [];
    while ($i >=0 && $j >= 0){
        if ($arr1[$i] > $arr2[$j]){
            array_unshift($res,$arr1[$i]);
            $i--;
        }elseif ($arr1[$i] < $arr2[$j]){
            array_unshift($res,$arr2[$j]);
            $j--;
        }else{
            array_unshift($res,$arr1[$i]);
            array_unshift($res,$arr2[$j]);
            $i--;
            $j--;
        }
    }
    while ($i >= 0){
        array_unshift($res,$arr1[$i]);
        $i--;
    }
    while ($i >= 0){
        array_unshift($res,$arr2[$j]);
        $j--;
    }
    return $res;
}

var_dump(merge($a,$b));
<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/19
 * Time:4:19 下午
 */



/**
 * @param $arr
 * @param $value
 * @return int
 */
function erfen($arr,$value)
{
    if (empty($arr)){
        return null;
    }

    $start = 0;
    $end = count($arr) - 1;
    while ($start <= $end){
        $midPos = floor(($start + $end) / 2);
        $midValue = $arr[$midPos];
        if ($midValue == $value){
            return $midPos;
        }
        if ($midValue > $value){
            $end = $midPos - 1;
        }else{
            $start = $midPos + 1;
        }
    }
}

function erfenDigui($arr,$start,$end,$value){
    if($start > $end){
        return false;
    }
    $mid = floor(($start + $end)/2);
    if($value == $arr[$mid]){
        return $mid;
    }
    if($value < $arr[$mid]){
        return bin_search($arr, $start, $mid-1, $value);
    }
    if($value > $arr[$mid]){
        return bin_search($arr,$mid+1,$end,$value);
    }

}

$arr = [1,2,3,4,5,6,7,8,9];
var_dump(erfen($arr,9));


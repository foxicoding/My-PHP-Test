<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:32 下午
 */


function insert($arr)
{
    if (empty($arr)){
        return [];
    }
    $count = count($arr);
    for ($i=1;$i<$count;$i++){
        $temp = $arr[$i];
        $j = $i - 1;
        while ($arr[$j] > $temp){
            $arr[$j+1] = $arr[$j];
            $arr[$j] = $temp;
            $j--;
            if ($j < 0){
                break;
            }
        }
    }
    return $arr;
}

$arr = [3,4,6,9,1,2,5];
var_dump(insert($arr));
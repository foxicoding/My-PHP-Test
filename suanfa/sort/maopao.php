<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/4
 * Time:4:32 下午
 */


/**
 * 冒泡排序
 * @param $arr
 * @return array
 */
function bubble($arr)
{
    if (empty($arr)){
        return [];
    }
    $count = count($arr);
    for ($i = 0;$i < $count;$i++){
        for ($j = $i+1;$j<$count;$j++){
            if ($arr[$i] > $arr[$j]){
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}

$arr = [3,4,6,9,1,2,5];
var_dump(bubble($arr));
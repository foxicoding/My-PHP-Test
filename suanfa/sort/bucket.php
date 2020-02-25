<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/2/25
 * Time:11:39 上午
 */

/**
 * 桶排序
 */


function bucketSort($arr)
{
    if (empty($arr)){
        return [];
    }
    $min = min($arr);
    $max = max($arr);
    //生成桶,默认桶里面只有一个元素
    $bucket = array_fill($min,$max-$min+1,0);
    //数据入桶
    foreach($arr as $v){
        $bucket[$v]++; //对应桶的个数增加
    }
    $result = [];
    //数据出桶
    foreach ($bucket as $k => $v){
        for($i = 0;$i < $v;$i++){
            $result[] = $k;
        }
    }
    return $result;
}

$arr = [10,5,8,3,4,3];
var_dump(bucketSort($arr));
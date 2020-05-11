<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/18
 * Time:3:55 下午
 */


/**
 * @param $nums
 * @param $target
 * @return false|float|int|void
 */
function search1($nums,$target)
{
    if (empty($nums)){
        return;
    }
    $count = count($nums);
    $start = 0;
    $end = $count - 1;
    while ($start <= $end){
        $mid = floor(($start + $end) / 2);
        if ($nums[$mid] == $target){
            return $mid;
        }
        if ($nums[$mid] > $target){
            $end = $mid - 1;
        }else{
            $start = $mid + 1;
        }
    }
    return -1;
}


function search2($nums,$target,$start,$end)
{
    $mid = floor(($start+$end) / 2);
    if ($nums[$mid] == $target){
        return $mid;
    }
    if ($nums[$mid] > $target){
        search2($nums,$target,$start,$mid - 1);
    }else{
        search2($nums,$target,$mid+1,$end);
    }
    return -1;
}

$nums = [1,2,3,4,5,6,7,8];
$target = 5;
var_dump(search1($nums,$target));
$count = count($nums);
var_dump(search2($nums,$target,0,$count));

















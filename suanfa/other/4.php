<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/11
 * Time:4:22 下午
 */


/**
 * 台阶积水问题
 */


/**
 * @param $arr
 * @return int
 */
function getRainNum($arr){
    if (empty($arr)){
        return 0;
    }
    $beforeRain = array_sum($arr);
    var_dump($beforeRain);
    $arr2 = array_unique($arr);//所有台阶的大小分类
    sort($arr2);
    //只有同一级台阶或没有台阶，则无法积水
    if(count($arr2) <= 1){
        return 0;
    }

    //忽略0级台阶
    if($arr2[0] == 0){
        array_shift($arr2);
    }

    $rArr = array_reverse($arr, true);//为了方便查找台阶最后出现的位置
    foreach($arr2 as $a){
        $left = array_search($a, $arr);//该级台阶第一次出现的位置
        $right  = array_search($a, $rArr);//最后出现的位置
        for($i = $left + 1; $i < $right; $i++){
            if($arr[$i] < $a){
                $arr[$i] = $a;
            }
        }
    }

    $afterRain = array_sum($arr);
    var_dump($afterRain);
    $pool = $afterRain - $beforeRain;
    return $pool;
}

$nums = [3,0,1];
$nums1 = [1,2,1,2,3,1,0,1,2,0,1];
var_dump(getRainNum($nums));
<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/11
 * Time:3:36 下午
 */

/**
 * 给定一个数组，O(N) 时间复杂度求出所有元素右边第一个大于该元素的值。

样例输入：1, 5, 3, 6, 4, 8, 9, 10, 2
样例输出：5, 6, 6, 8, 8, 9, 10, -1, -1

样例输入：8, 2, 5, 4, 3, 9, 7, 2, 5
样例输出：9, 5, 9, 9, 9, -1, -1, 5, -1
 */

/**
 * @param $nums
 * @return array
 */
function baoLi($nums)
{
    if (empty($nums)){
        return [];
    }
    $count = count($nums);
    $res = array_fill(0,$count,-1);
    for($i = 0;$i < $count;$i++){
        for($j = $i + 1;$j < $count;$j++){
            if ($nums[$j] > $nums[$i]){
                $res[$i] = $nums[$j];
                break;
            }
        }
    }
    return  $res;
}

function Stack($nums){
    if (empty($nums)){
        return [];
    }
    $count = count($nums);
    $res = array_fill(0,$count,-1);
    $stack = new SplStack();
    for ($i = 0;$i < $count;$i++){
        while(!$stack->isEmpty() && $nums[$i] > $nums[$stack->top()]){
            $res[$stack->top()] = $nums[$i];
            $stack->pop();
        }
       $stack->push($i);
    }
    return $res;
}
$nums = [1,5,3,6,4,8,9,10,2];
var_dump(baoLi($nums));
var_dump(Stack($nums));
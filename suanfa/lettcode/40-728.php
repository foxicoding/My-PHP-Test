<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/19
 * Time:11:21 上午
 */

/**
 * 来源：力扣（LeetCode）
 * 链接：https://leetcode-cn.com/problems/self-dividing-numbers
 * 自除数 是指可以被它包含的每一位数除尽的数。

例如，128 是一个自除数，因为 128 % 1 == 0，128 % 2 == 0，128 % 8 == 0。

还有，自除数不允许包含 0 。

给定上边界和下边界数字，输出一个列表，列表的元素是边界（含边界）内所有的自除数。

示例 1：

输入：
上边界left = 1, 下边界right = 22
输出： [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 15, 22]
注意：

每个输入参数的边界满足 1 <= left <= right <= 10000。

 */

/**
 * @param $left
 * @param $right
 * @return array
 */
function selfDividingNumbers($left, $right) {
    $a = 1e-9;
    var_dump($a);
    if ($right <= 9){
        return range($left,$right);
    }
    $result = [];
    for ($i = $left;$i<=$right;$i++){
        $flag = isDivide($i);
        if ($flag){
            $result[] = $i;
        }
    }
    return $result;
}

function isDivide($num)
{
    $flag = true;
    $temp = $num;
    while ($num >= 1){
        $a = $num % 10;
        if ($a == 0){
            $flag = false;
            break;
        }
        if (($temp % $a) != 0){
            $flag = false;
            break;
        }
        $num /= 10;
    }
    return $flag;
}
$left = 1;
$right = 22;
var_dump(selfDividingNumbers($left,$right));
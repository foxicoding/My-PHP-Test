<?php
/**
 * Created by PhpStorm.
 * User: liujinbao
 * Date: 2019/7/17
 * Time: 11:40 AM
 */




/**
 *
 * 来源：力扣 第169题
 * 链接：https://leetcode-cn.com/problems/majority-element/
 * 摩尔投票算法
 * 参考链接：1.https://www.zhihu.com/question/49973163
 *         2.https://blog.csdn.net/weixin_44105451/article/details/88082814
 *
 * 题目：找出一组数字序列中出现次数大于总数1/2的数字（并且假设这个数字一定存在）
 */

function getMajority($arr)
{
    if (empty($arr)){
        return false;
    }
    $result = 0;
    $time = 0;
    foreach ($arr as $k => $v){
        if ($time == 0) {
            $result = $v;
            $time = 1;
            continue;
        }
        if ($result == $v){
            $time ++;
        }else{
            $time --;
        }

    }
    return $result;
}

$arr = [1,2,1,3,1,1,1,4];

var_dump(getMajority($arr));
<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/14
 * Time:11:51 上午
 */


/**
 * 一群猴子排成一圈，按1,2,…,n依次编号。
 * 然后从第1只开始数，数到第m只,把它踢出圈，
 * 从它后面再开始数，再数到第m只，在把它踢出去…，如此不停的进行下去，直到最后只剩下一只猴子为止，
 * 那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。用程序模拟该过程。
 */

function getKing1($m,$n)
{
    if($m > $n){
        return false;
    }
    $arr = range(1,$n); //生成序号
    $i = 0;
    while (count($arr) > 1){
        foreach ($arr as $k => $v){
            $i++;
            if ($i == $m){
                unset($arr[$k]);
                $i = 0;
            }
        }
    }
    return $arr;
}

function getKing2($m,$n){
    if($m > $n){
        return false;
    }
    $arr = range(1,$n);
    $i = 0;
    while(count($arr) != 1){
        if(($i+1)%$m == 0){
            unset($arr[$i]);
        } else {
            array_push($arr,$arr[$i]);
            unset($arr[$i]);
        }
        $i++;
    }
    return $arr;
}



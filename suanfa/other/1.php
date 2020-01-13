<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/13
 * Time:1:38 下午
 */

/*
 * 求最大的增长数
 */

function getMaxUpNum($str)
{
    if (empty($str)){
        return '0';
    }
    $length = strlen($str);
    $max = $dp = $str[0];
    for ($i = 1; $i < $length; $i++) {
        if ($str[$i] > $str[$i - 1]) {
            $dp = $dp . $str[$i];
        } else {
            $dp = $str[$i];
        }
        if ((int)$dp > (int)$max) {
            $max = $dp;
        }
    }
    return $max;
}

$str = '28953456323456789';

var_dump(getMaxUpNum($str));
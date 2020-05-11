<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/12
 * Time:2:03 下午
 */

/**
 * 给字符串， i am a boy 输出 boy a am i
 */


/**
 * @param $str
 * @return string
 */
function getA($str)
{
    $len = strlen($str);
    $res = '';
    $temp = '';
    for($i=$len-1;$i>=0;$i--){
        if ($str[$i] == ' '){
            $res .= $temp . $str[$i];
            $temp = '';
            continue;
        }
        $temp = $str[$i] . $temp;
    }
    return $res . $temp;
}

$str = 'i am a boy';
var_dump(getA($str));
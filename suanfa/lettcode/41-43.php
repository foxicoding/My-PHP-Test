<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/19
 * Time:4:47 下午
 */


/**
 * @param $num1
 * @param $num2
 * @return float|int
 */
function multiply($num1, $num2) {
    if ($num1 == '0' || $num2 == '0'){
        return 0;
    }
    $length1 = strlen($num1);
    $length2 = strlen($num2);
    $zeroNum1 = $zeroNum2 = 0;
    //把后面的0去掉
    for ($i = $length1 - 1;$i >= 0;$i--){
        if ((int)$num1[$i] == 0){
            $zeroNum1++;
        }else{
            break;
        }
    }
    for ($i = $length2 - 1;$i >= 0;$i--){
        if ((int)$num2[$i] == 0){
            $zeroNum2++;
        }else{
            break;
        }
    }
    $num1 = substr($num1,0,$length1 - $zeroNum1);
    $num2 = substr($num2,0,$length2 - $zeroNum2);
    if (strlen($num1) >= strlen($num2)){
        $longerNum = $num1;
        $shorterNum = $num2;
    }else{
        $longerNum = $num2;
        $shorterNum = $num1;
    }
    $sum = 0;
    $times1 = [];
    for ($i = strlen($shorterNum)-1;$i >= 0;$i--){
        $sumTemp = 0;
        $times2 = [];
        for ($j = strlen($longerNum)-1;$j >= 0;$j--){
            $sumTemp += (string)($longerNum[$j] * $shorterNum[$i]) . implode('',$times2);
            $times2[] = 0;
        }
        $sum = $sum + (int)($sumTemp . implode('',$times1));
        $times1[] = 0;
    }
    if (($zeroNum1 + $zeroNum2) > 0){
        $sum = $sum * pow(10,$zeroNum1 + $zeroNum2);
    }
    return $sum;
}

$num1 = "498828660196";
$num2 = "840477629533";
var_dump(multiply($num1,$num2));
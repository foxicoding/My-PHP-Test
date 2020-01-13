<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/12
 * Time:10:53 上午
 */

$arr = [1,2,3,4,5];

foreach ($arr as &$tmp){

}

foreach ($arr as $tmp){
    var_dump($arr);
}

//由于引用关系，$tmp和$arr[4]绑定了内存地址，所以第二次循环，每次改变$tmp的值，$arr[4]也会随之变动

//var_dump($a); //输出 [1,2,3,4,4]

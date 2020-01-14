<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午6:52
 */
namespace apps\kafka\log;

class MCommon_PerformanceApi
{
    /**
     * 区分压力测试  性能数据
     * @param $app_code
     * @param $curl
     */
    public static function vTest(&$app_code,$curl){
        $aCurl = explode("###",$curl);
        $aCurlLen = count($aCurl);
        if($aCurlLen > 1 && $aCurl[$aCurlLen - 1] == "test_performance"){
            $app_code = "test_performance";
        }
    }
}
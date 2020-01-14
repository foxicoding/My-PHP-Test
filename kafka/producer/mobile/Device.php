<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2018/04/18
 * Time: 下午3:13
 */
namespace apps\kafka\producer;
class MMobile_Device {

    /**
     *  日志字段补充
     * @param $log
     * @return mixed
     */
    public static function aExtendFieldsMain($log){
        $fullLog = self::aExtendBrand($log);

        return $fullLog;
    }

    /**
     * android 下basic属性 新增 brand字段
     * @param $log
     * @return mixed
     */
    private static function aExtendBrand($log){
        $appCode = $log['app_code'];
        $appVer = $log['app_ver'];
        if('com.mfw.roadbook' == $appCode && $appVer >='8.1.6' && isset($log['brand'])){
            $log['brand'] = \apps\mobile\MFacade_Device::SGetCorrectBrandName($log['brand']);
        }
        return $log;
    }


}
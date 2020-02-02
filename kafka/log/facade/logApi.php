<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:23
 */

namespace apps\kafka\log;


class MFacade_logApi
{
    /**
     * 服务端日志采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @param $forbidSpider 自动校验spider数据
     * @return bool
     */
    public static function serverEventLog($appCode,$eventCode,array $attr = array(),$forbidSpider = false){

        return  MServer_SDKApi::vCollect($appCode,$eventCode,$attr,$forbidSpider);
    }

    /**
     * 服务端日志批量采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr 多维数组
     * @param $forbidSpider 自动校验spider数据
     * @return bool
     */
    public static function serverEventMultiLog($appCode,$eventCode,array $attr = array(),$forbidSpider = false){

        return  MServer_SDKApi::vMultiCollect($appCode,$eventCode,$attr,$forbidSpider);
    }

    /**
     * 网页端日志采集接口
     * @param $appCode
     * @param $eventCode
     * @param $eventTime
     * @param $curl
     * @param $xpath
     * @param $pageId
     * @param $attr
     * @return bool
     */
    public static function pageEventLog($appCode,$eventCode,$eventTime,$curl,$xpath,$pageId,$attr){
        return MPage_SDKApi::vCollect($appCode,$eventCode,$eventTime,$curl,$xpath,$pageId,$attr);
    }

    /**
     * app客户端日志采集接口
     * @param array $basic
     * @param array $attr
     * @param bool|false $debug
     * @return  array
     */
    public static function mobileEventLog(array $basic,array $attr = array(),$debug = false){
        return MMobile_SDKApi::vCollect($basic,$attr,$debug);
    }

    /**
     * 微信小程序日志采集接口
     * @param array $basic
     * @param array $attr
     * @return bool
     */
    public static function weAppEventLog(array $basic, array $attr = array()){
        return MWeApp_SDKApi::vCollect($basic,$attr);
    }

    /**
     * 监控数据采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @return int|void
     */
    public static function monitorEventLog($appCode,$eventCode,array $attr = array()){
        return MMonitor_SDKApi::vCollect($appCode,$eventCode,$attr);
    }


    /**
     * 搜索日志采集
     * @param $content
     * @return bool
     */
    public static function elasticSearchLog(array $content){
        return MElasticSearch_SDKApi::vCollect($content);
    }

    /**
     * 金融日志采集
     * @param array $content
     */
    public static function financeEventLog(array $content){
        return MFinance_SDKApi::vCollect($content);
    }

    /**
     * 终端监控日志采集接口
     * @param array $basic
     * @param array $attr
     * @return bool
     */
    public static function feMonitorEventLog(array $basic, array $attr = array()){
        return MFemonitor_SDKApi::vCollect($basic, $attr);
    }

    public static function fileWebLog($topic, array $basic, array $attr = array()) {
        MWeb_FileSDK::collect($topic, $basic, $attr);
    }

    public static function miniEventLog(array $basic, array $attr = array()) {
        MMini_FileSDK::collect($basic, $attr);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:23
 */

namespace apps\kafka;


class MFacade_logApi
{
    //server event
    const SAPP_TRAFFIC = 'traffic';
    const SAPP_TEST = 'test';
    const SAPP_DATA='data';
    const SAPP_SE='se';
    const SAPP_DEFAULT = 'default';
    const SAPP_HOTEL = 'hotel';
    const SAPP_SALES = 'sales';
    const SAPP_CALLCENTER = 'callcenter';
    const SAPP_MDD = 'mdd';
    const SAPP_UGC = 'ugc';
    const SAPP_APP = 'app';
    const SAPP_BRAND = 'brand';
    const SAPP_POI = 'poi';
    const SAPP_USER = 'user';
    const SAPP_GINFO = 'ginfo';
    const SAPP_ORDER = 'pay';
    const SAPP_WENDA = 'wenda';
    const SAPP_FLIGHT = 'flight';
    const SAPP_WENG = 'weng';
    const SAPP_BELL = 'bell';
    const SAPP_PUSH = 'push';

    // monitor event
    const MSOURCE_MOBILE = 'mobile';
    const MSOURCE_PAGE = 'page';
    const MSOURCE_SERVER = 'server';

    /**
     * 服务端日志采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @param $forbidSpider
     * @return bool
     */
    public static function serverEventLog($appCode,$eventCode,array $attr = array(),$forbidSpider = false){

        return  \apps\kafka\log\MFacade_logApi::serverEventLog($appCode,$eventCode,$attr,$forbidSpider);
    }

    /**
     * 服务端日志批量采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @param $forbidSpider
     * @return bool
     */
    public static function serverEventMultiLog($appCode,$eventCode,array $attr = array(),$forbidSpider = false){

        return  \apps\kafka\log\MFacade_logApi::serverEventMultiLog($appCode,$eventCode,$attr,$forbidSpider);
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
        return \apps\kafka\log\MFacade_logApi::pageEventLog($appCode,$eventCode,$eventTime,$curl,$xpath,$pageId,$attr);
    }

    /**
     * app客户端日志采集接口
     * @param array $basic
     * @param array $attr
     * @param bool|false $debug
     * @return  array
     */
    public static function mobileEventLog(array $basic,array $attr = array(),$debug = false){
        return \apps\kafka\log\MFacade_logApi::mobileEventLog($basic,$attr,$debug);
    }

    /**
     * 微信小程序日志采集接口
     * @param array $basic
     * @param array $attr
     * @return bool
     */
    public static function weAppEventLog(array $basic, array $attr = array()){
        return \apps\kafka\log\MFacade_logApi::weAppEventLog($basic,$attr);
    }

    /**
     * 监控数据采集接口
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @return bool
     */
    public static function monitorEventLog($appCode,$eventCode,array $attr = array()){
        return \apps\kafka\log\MFacade_logApi::monitorEventLog($appCode,$eventCode,$attr);
    }

    /**
     * sche phperor 等数据采集接口
     * @param $type
     * @param $content
     * @return bool
     */
    public static function plainLog($type,$content){
        return \apps\kafka\log\MFacade_logApi::plainLog($type,$content);
    }

    /**
     * 短链跳转日志采集接口
     * @param $log
     * @return bool
     */
    public static function jump($log){
        return \apps\kafka\log\MFacade_logApi::jump($log);
    }

    /**
     * POST日志采集接口
     * @param $log
     * @return bool
     */
    public static function post($log){
        return \apps\kafka\log\MFacade_logApi::post($log);
    }

    /**
     * 搜索日志采集
     * @param array $content
     * @return bool
     */
    public static function elasticSearchLog(array $content){
        return \apps\kafka\log\MFacade_logApi::elasticSearchLog($content);
    }

    /**
     * 金融日志采集
     * @param array $content
     * @return mixed
     */
    public static function financeEventLog(array $content){
        return \apps\kafka\log\MFacade_logApi::financeEventLog($content);
    }

    /**
     * 终端监控日志采集接口
     * @param array $basic
     * @param array $attr
     * @return bool
     */
    public static function feMonitorEventLog(array $basic, array $attr = array()){
        return \apps\kafka\log\MFacade_logApi::feMonitorEventLog($basic, $attr);
    }

    public static function fileWebLog($topic, array $basic, array $attr = array()) {
        \apps\kafka\log\MFacade_logApi::fileWebLog($topic, $basic, $attr);
    }

    public static function miniEventLog(array $basic, array $attr = array()) {
        \apps\kafka\log\MFacade_logApi::miniEventLog($basic, $attr);
    }
}
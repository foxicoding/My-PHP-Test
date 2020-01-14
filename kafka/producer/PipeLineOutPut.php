<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 2017/11/23
 * Time: 下午1:55
 */
namespace apps\kafka\producer;

class MPipeLineOutPut {

    /**
     * 管道单实例
     * @var null
     */
    private static $s_DefaultInstance = null;
    private static $s_MobileInstance = null;
    private static $s_PageInstance = null;
    private static $s_ServerInstance = null;
    private static $s_MonitorInstance = null;
    private static $s_WeAppInstance = null;



    /**
     *  数据管道
     * @param $topic 日志源
     * @param $log  消息体
     */
    public static function sPipeLineOutPut($topic,$log){
        switch($topic){
            case 'mobile_event':
                self::sMobilePipeLineOutPut($log);
                break;
            case 'server_event':
                self::sServerPipeLineOutPut($log);
                break;
            case 'page_event':
                self::sPagePipeLineOutPut($log);
                break;
            case 'monitor_event':
                self::sMonitorPipeLineOutPut($log);
                break;
            case 'weapp_event':
                self::sWeAppPipeLineOutPut($log);
                break;
            default:
                self::sDefaultPipeLineOutPut($log);
        }

    }

    /**
     * 默认 管道
     * @param $log
     */
    public static function sDefaultPipeLineOutPut($log){
        if(is_null(self::$s_DefaultInstance)){
            self::$s_DefaultInstance = new MDefaultPipeLine();
        }
        self::$s_DefaultInstance->vPipeLineMain($log);
    }
    /**
     * mobile 管道
     * @param $log
     */
    public static function sMobilePipeLineOutPut($log){
        if(is_null(self::$s_MobileInstance)){
            self::$s_MobileInstance = new MMobilePipeLine();
        }
        self::$s_MobileInstance->vPipeLineMain($log);
    }

    /**
     * server 管道
     * @param $log
     */
    public static function sServerPipeLineOutPut($log){
        if(is_null(self::$s_ServerInstance)){
            self::$s_ServerInstance = new MServerPipeLine();
        }
        self::$s_ServerInstance->vPipeLineMain($log);
    }

    /**
     * page 管道
     * @param $log
     */
    public static function sPagePipeLineOutPut($log){
        if(is_null(self::$s_PageInstance)){
            self::$s_PageInstance = new MPagePipeLine();
        }
        self::$s_PageInstance->vPipeLineMain($log);
    }

    /**
     * monitor 管道
     * @param $log
     */
    public static function sMonitorPipeLineOutPut($log){
        if(is_null(self::$s_MonitorInstance)){
            self::$s_MonitorInstance = new MMonitorPipeLine();
        }
        self::$s_MonitorInstance->vPipeLineMain($log);
    }

    /**
     * WeApp 管道
     * @param $log
     */
    public static function sWeAppPipeLineOutPut($log){
        if(is_null(self::$s_WeAppInstance)){
            self::$s_WeAppInstance = new MWeAppPipeLine();
        }
        self::$s_WeAppInstance->vPipeLineMain($log);
    }
}
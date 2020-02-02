<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 18/10/23
 * Time: 下午4:17
 */
namespace apps\kafka\log;


class MFinance_SDKApi
{

    /**
     * 金融事件日志采集
     * @param array $content
     */
    public static function vCollect(array $content){

        $ip = \Ko_Tool_Ip::SGetClientIP();
        $guid = md5(uniqid($ip . mt_rand(1000, 9999), true));
        $time = time();
        $basic = array(
            'ip_s' => MCommon_CommonApi::getLocalIp(),
            'ctime' => $time,
            'datetime' => date('c', $time),
            'event_guid' => $guid,
            'topic' => 'finance_event',
            'hour' => date('H',$time),
            'dt' => date('Ymd',$time),
            'minute' => date('i',$time),
            'mfw_env' => MFacade_logEnvApi::sGetEnv(),
        );
        $log = array_merge($basic,$content);
        $dir = COMMON_RUNDATA_PATH."filebeat.finance_event/";
        if (!is_dir($dir)) {
            @mkdir($dir);
            @chmod($dir, 0777);
        }
        $filename = $dir.$log['dt'].'.'.posix_getuid().'.'.rand(0, 9);
        $logContent = json_encode($log);
        @file_put_contents($filename, $logContent."\n", FILE_APPEND | LOCK_EX);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;

class MMonitor_SDKApi
{

    /**
     * 监控数据采集接口
     * @param $dataSource
     * @param array $basic
     * @param array $attr
     * @return int|void
     */

    public static function vCollect($appCode,$eventCode,array $attr = array()){
        $appCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $appCode));
        $eventCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $eventCode));
        \Ko_Tool_Str::VForce2UTF8($attr);

        $ip = \Ko_Tool_Ip::SGetClientIP();
        $guid = md5(uniqid($ip . getmypid() . mt_rand(1000, 9999), true));
        $time = time();

        //登录用户
        $uid = \apps\user\MFacade_Api::iLoginUid();
        $basic = array(
            'app_code' => $appCode,
            'event_code' => $eventCode,
            'uid' => $uid,
            'uuid' => \apps\MFacade_Tongji_UuidApi::vGet(),
            'open_udid' => MCommon_CommonApi::getOpenUdid(),
            'ip' => $ip,
            'ip_s' => MCommon_CommonApi::getLocalIp(),
            'ctime' => $time,
            'datetime' => date('c', $time),
            'event_guid' => $guid,
            'topic' => 'monitor_event',
            'hour' => date('H',$time),
            'dt' => date('Ymd',$time),
            'minute' => date('i',$time),
            'mfw_env' => MFacade_logEnvApi::sGetEnv(),
            'attr' => $attr
        );
        $log = json_encode($basic);
        if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES ) {
            return;
        }
        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'/monitor_event/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir.'monitor_event.' . date('YmdHi', $time);
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
        if ('cli' === PHP_SAPI)
        {
            @chmod($filename, 0666);
        }
    }

}
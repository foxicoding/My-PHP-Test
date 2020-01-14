<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/3/6
 * Time: 下午4:17
 */
namespace apps\kafka\log;


class MElasticSearch_SDKApi
{

    /**
     * 搜索日志采集
     * @param $log
     * @return bool
     */
    public static function vCollect(array $content){

        $ip = \Ko_Tool_Ip::SGetClientIP();
        $guid = md5(uniqid($ip . mt_rand(1000, 9999), true));

        //目录检查及创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'elasticsearch/';
        MCommon_CommonApi::checkLogDir($log_dir);

        $filename = $log_dir .'elasticsearch.' . date('YmdHi');
        $log = json_encode($content);
        if (strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES) {
            return;
        }
        //增加Kafka key 值
        $kafka_k_v = $guid.MCommon_CommonApi::KAFKA_KEY_DELI.$log;

        file_put_contents($filename, $kafka_k_v . "\n", FILE_APPEND | LOCK_EX);
        if ('cli' === PHP_SAPI)
        {
            chmod($filename, 0666);
        }
    }

}
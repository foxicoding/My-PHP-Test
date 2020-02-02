<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/3/4
 * Time: 11:46
 */

namespace apps\kafka\log;

class MFemonitor_SDKApi {

    /**
     *
     * 终端监控日志采集
     *
     * @param array $basic
     * @param array $attr
     *
     */
    public static function vCollect(array $basic, array $attr = array()) {
        $url = $basic['url'];

        $time = time();
        $urlInfo = parse_url($url);

        $basic['topic'] = 'femonitor_event';
        $basic['mfw_env'] = MFacade_logEnvApi::sGetEnv();
        $basic['ctime'] = $time;
        $basic['datetime'] = date('c', $time);
        $basic['hour'] = date('H', $time);
        $basic['dt'] = date('Ymd', $time);
        $basic['minute'] = date('i', $time);
        $basic['uid'] = \apps\user\MFacade_Api::iLoginUid();
        $basic['uuid'] = \apps\MFacade_Tongji_UuidApi::vGet();
        $basic['open_udid'] = MCommon_CommonApi::getOpenUdid();
        $basic['uid_admin'] = intval($_SESSION ['admin']['mfwid']);
        $basic['platform'] = MCommon_PlatformApi::vGetPlatform($url);
        $basic['mfwappcode'] = MCommon_PlatformApi::vGetMfwAppCode();
        $basic['mfwappver'] = MCommon_PlatformApi::vGetMfwAppVer();
        $basic['mfwdevver'] = MCommon_PlatformApi::vGetMfwDevVer();
        $basic['host'] = $urlInfo['host'];
        $basic['path'] = $urlInfo['path'];
        $basic['ip'] = \Ko_Tool_Ip::SGetClientIP();
        $basic['ip_s'] = MCommon_CommonApi::getLocalIp();
        $basic['ua'] = \Ko_Web_Request::SHttpUserAgent();

        $basic['attr'] = $attr;

        self::vWriteLog($basic);
    }

    /**
     * @param $log
     */
    private static function vWriteLog($log) {
        $data = json_encode($log);

        $data = self::_dataPipeline($data);

        if (empty($data) || strlen($data) > MCommon_CommonApi::MAX_MESSAGE_BYTES) {
            return;
        }

        //目录检查并创建
        $eventDir = MFacade_logEnvApi::sGetLogPath() . '/femonitor_event/';
        MCommon_CommonApi::checkLogDir($eventDir);
        $filename = $eventDir . 'femonitor_event.' . date('YmdHi');

        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        @file_put_contents($filename, $data . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * @param $log string
     * @return string
     */
    private static function _dataPipeline($log) {
        try {
            $result = \apps\datapipeline\MFacade_dataPipelineApi::femonitorPipeline($log);
        } catch (\Exception $e) {
            $result = $log;
        }

        return $result;
    }

}
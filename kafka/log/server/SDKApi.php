<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */

namespace apps\kafka\log;


class MServer_SDKApi {

    /**
     * 服务端数据采集
     * @param $appCode
     * @param $eventCode
     * @param array $attr
     * @param $forbidSpider
     */
    public static function vCollect($appCode, $eventCode, array $attr = array(), $forbidSpider = false) {
        if (self::isTestData()) {
            return false;
        }

        $appCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $appCode));
        $eventCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $eventCode));
        \Ko_Tool_Str::VForce2UTF8($attr);

        $ip = \Ko_Tool_Ip::SGetClientIP();
        $guid = md5(uniqid($ip . getmypid() . mt_rand(1000, 9999), true));
        $time = time();
        //获取平台及UA
        $host = $_SERVER['HTTP_HOST'];
        if (!empty($host)) {
            $curl = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $curl = "";
        }
        //登录用户
        $uid = \apps\user\MFacade_Api::iLoginUid();
        //获取平台及ua
        $pResult = MCommon_PlatformApi::vCreate($curl);

        $basic = array(
            'app_code' => $appCode,
            'event_code' => $eventCode,
            'uid' => $uid,
            'uid_admin' => intval($_SESSION ['admin']['mfwid']),
            'uuid' => \apps\MFacade_Tongji_UuidApi::vGet(),
            'open_udid' => MCommon_CommonApi::getOpenUdid(),
            'idfa' => MCommon_CommonApi::getIDFA(),
            'platform' => $pResult['platform'],
            'ua' => $pResult['ua'],
            'mfwappcode' => $pResult['mfwappcode'],
            'abtest' => MCommon_CommonApi::getABTest($curl),
            'curl' => \Ko_Tool_Str::SForce2UTF8($curl),
            'ip' => $ip,
            'ip_s' => MCommon_CommonApi::getLocalIp(),
            'ctime' => $time,
            'datetime' => date('c', $time),
            'event_guid' => $guid,
            'topic' => 'server_event',
            'refer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'request_uuid' => isset($_SERVER['HTTP_X_MFWREQUEST_UUID']) ? $_SERVER['HTTP_X_MFWREQUEST_UUID'] : '',
            'hour' => date('H', $time),
            'dt' => date('Ymd', $time),
            'minute' => date('i', $time),
            'mfw_env' => MFacade_logEnvApi::sGetEnv(),
            'attr' => $attr);

        //特殊处理
        MServer_CustomApi::vCreate($basic);

        //过滤爬虫数据
        if ($forbidSpider) {
            MCommon_SpiderApi::vCreate($basic);
        }

        //写入分钟文件
        self::vWriteLog($basic);
    }

    /** 写入分钟文件
     * @param $basic
     * @return bool|int|void
     */
    public static function vWriteLog($basic) {
        $log = json_encode($basic);
        $log = self::_dataPipeline($log);

        if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES) {
            return;
        }
        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath() . '/server_event/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir . 'server_event.' . date('YmdHi', $basic['ctime']);
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        return file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
    }

    /**
     *  服务端批量数据采集
     * @param $appCode
     * @param $eventCode
     * @param array $multiAttr 多维数组
     * @param bool $forbidSpider
     * @return bool|int|void
     */
    public static function vMultiCollect($appCode, $eventCode, array $multiAttr = array(), $forbidSpider = false) {
        if (self::isTestData()) {
            return false;
        }
        $appCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $appCode));
        $eventCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $eventCode));

        $ip = \Ko_Tool_Ip::SGetClientIP();
        //日志时间
        $time = time();

        //获取平台及UA
        $host = $_SERVER['HTTP_HOST'];
        if (!empty($host)) {
            $curl = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $curl = "";
        }
        //登录用户
        $uid = \apps\user\MFacade_Api::iLoginUid();
        //获取平台及ua
        $pResult = MCommon_PlatformApi::vCreate($host);


        $basic = array(
            'app_code' => $appCode,
            'event_code' => $eventCode,
            'uid' => $uid,
            'uuid' => \apps\MFacade_Tongji_UuidApi::vGet(),
            'open_udid' => MCommon_CommonApi::getOpenUdid(),
            'idfa' => MCommon_CommonApi::getIDFA(),
            'platform' => $pResult['platform'],
            'ua' => $pResult['ua'],
            'mfwappcode' => $pResult['mfwappcode'],
            'curl' => $curl,
            'ip' => $ip,
            'ip_s' => MCommon_CommonApi::getLocalIp(),
            'topic' => 'server_event',
            'refer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'request_uuid' => isset($_SERVER['HTTP_X_MFWREQUEST_UUID']) ? $_SERVER['HTTP_X_MFWREQUEST_UUID'] : '',
            'ctime' => $time,
            'datetime' => date('c', $time),
            'mfw_env' => MFacade_logEnvApi::sGetEnv(),
            'hour' => date('H', $time),
            'dt' => date('Ymd', $time)
        );

        $multiLog = self::sMultiAttrLog($basic, $multiAttr, $forbidSpider);
        if (strlen($multiLog) === 0) {
            return false;
        }

        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath() . '/server_event/';
        MCommon_CommonApi::checkLogDir($log_dir);

        $filename = $log_dir . 'server_event.' . date('YmdHi', $time);
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        return file_put_contents($filename, $multiLog . "\n", FILE_APPEND | LOCK_EX);

    }

    /**
     * 合并多条Attr数据
     * @param $basic
     * @param $multiAttr
     * @param $forbidSpider
     * @return string
     */
    public static function sMultiAttrLog($basic, $multiAttr, $forbidSpider) {
        //合并多条日志写入
        $multiBasic = array();
        if (is_array($multiAttr)) {
            foreach ($multiAttr as $attr) {
                if (is_array($attr)) {
                    //日志唯一标识
                    $basic['event_guid'] = md5(uniqid($basic['ip'] . getmypid() . mt_rand(1000, 9999), true));
                    $basic['attr'] = $attr;

                    //特殊处理
                    MServer_CustomApi::vCreate($basic);

                    //过滤爬虫数据
                    if ($forbidSpider) {
                        MCommon_SpiderApi::vCreate($basic);
                    }

                    $log = json_encode($basic);
                    $log = self::_dataPipeline($log);

                    if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES) {
                        continue;
                    }

                    array_push($multiBasic, $log);
                }
            }
        }
        $multiLog = implode("\n", $multiBasic);
        return $multiLog;
    }

    private static function isTestData() {
        if (isset($_SERVER['HTTP_X_MFWDATA_TEST'])) {
            \apps\MFacade_Log_Api::dlog('X-MFWDATA-TEST', json_encode(array(
                        'message' => $_SERVER['HTTP_X_MFWDATA_TEST']
                    )
                )
            );
            return true;
        }

        return false;
    }

    /**
     * @param $log string
     * @return string
     */
    private static function _dataPipeline($log) {
        try {
            $result = \apps\datapipeline\MFacade_dataPipelineApi::serverPipeline($log);
        } catch (\Exception $e) {
            $result = $log;
        }

        return $result;
    }

}

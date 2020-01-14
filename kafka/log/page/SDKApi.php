<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;

class MPage_SDKApi
{
    /**
     * 网页端数据采集
     * @param $appCode
     * @param $eventCode
     * @param $eventTime
     * @param $curl
     * @param $xpath
     * @param $pageid
     * @param $attr
     */
    public static function vCollect($appCode,$eventCode,$eventTime,$curl,$xpath,$pageid,$attr){
        $appCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $appCode));
        $eventCode = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $eventCode));
        $curl = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $curl));
        $xpath = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $xpath));
        $pageid = \Ko_Tool_Str::SForce2UTF8(str_replace(array("\t", "\r", "\n", '$'), '', $pageid));
        $attr = (array)$attr;
        \Ko_Tool_Str::VForce2UTF8($attr);
        $ip = \Ko_Tool_Ip::SGetClientIP();
        $guid = md5(uniqid($ip . getmypid() . mt_rand(1000, 9999), true));
        $time = time();
        //校验app_code
        if (!MCommon_CommonApi::checkValidKey($appCode) || empty($eventCode)) {
            return false;
        }
        $uid = \apps\user\MFacade_Api::iLoginUid();
        //url解析
        $urlInfo = parse_url($curl);
        //获取平台及ua
        $pResult = MCommon_PlatformApi::vCreate($curl);
        //判别压力测试数据
        MCommon_PerformanceApi::vTest($appCode,$curl);
        $basic = array(
            'app_code' => $appCode,
            'event_code' => $eventCode,
            'event_time' => $eventTime,
            'curl'=> $curl,
            'abtest' => !empty($_SERVER['HTTP_ABTEST']) ? $_SERVER['HTTP_ABTEST'] : '',
            'host'=> $urlInfo['host'],
            'path'=> $urlInfo['path'],
            'xpath' => $xpath,
            'pageid' => $pageid,
            'platform' => $pResult['platform'],
            'ua' => $pResult['ua'],
            'mfwappcode' => $pResult['mfwappcode'],
            'mfwappver' => MCommon_PlatformApi::vGetMfwAppVer(),
            'mfwdevver' => MCommon_PlatformApi::vGetMfwDevVer(),
            'uid' => $uid,
            'uuid' => \apps\MFacade_Tongji_UuidApi::vGet(),
            'open_udid' => MCommon_CommonApi::getOpenUdid(),
            'idfa' =>  MCommon_CommonApi::getIDFA(),
            'ip' => $ip,
            'ip_s' => MCommon_CommonApi::getLocalIp(),
            'ctime' => $time,
            'datetime' => date('c', $time),
            'event_guid' => $guid,
            'topic' => 'page_event',
            'uid_admin' => intval($_SESSION ['admin']['mfwid']),
            'hour' => date('H',$time),
            'dt' => date('Ymd',$time),
            'minute' => date('i',$time),
            'mfw_env' => MFacade_logEnvApi::sGetEnv(),
            'attr' => $attr);

        self::transferBasic($basic);

        //过滤爬虫数据
        MCommon_SpiderApi::vPageCreate($basic);

        //写入分钟文件
        self::vWriteLog($basic);
    }

    /**
     * @param $basic
     */
    public static function vWriteLog($basic){
        $log = json_encode($basic);

        $log = self::_dataPipeline($log);

        if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES ) {
            return;
        }
        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'/page_event/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir.'page_event.' . date('YmdHi', $basic['ctime']);
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
        if ('cli' === PHP_SAPI) {
            chmod($filename, 0666);
        }
    }

    private static function transferBasic(&$basic) {
        $basic['uri'] = self::sGetParam('uri');
        $basic['op'] = self::sGetParam('op');
        $basic['protocol'] = self::sGetParam('protocol');
        $basic['pn'] = self::sGetParam('pn');
        $basic['mfw_chid'] = self::sGetParam('mfw_chid');
        $basic['oth_chid'] = self::sGetParam('oth_chid');
        $basic['sdk_ver'] = self::sGetParam('sdk_ver');
        $basic['referrer'] = self::sGetCookie('_r');
    }

    /**
     * 获取Cookie中_r的参数
     *
     * _r表示搜索引擎的渠道
     *
     * @param string
     * @return string
     */
    private static function sGetCookie($key) {
        return urldecode(\Ko_Tool_Input::VClean('c', $key, \Ko_Tool_Input::T_STR));
    }


    /**
     * 参数获取
     * @param $param
     * @return string
     */
    private static function sGetParam($param){
        return urldecode(\Ko_Tool_Input::VClean('r',$param, \Ko_Tool_Input::T_STR));
    }

    /**
     * @param $log string
     * @return string
     */
    private static function _dataPipeline($log) {
        try {
            $result = \apps\datapipeline\MFacade_dataPipelineApi::pagePipeline($log);
        } catch (\Exception $e) {
            $result = $log;
        }

        return $result;
    }
}

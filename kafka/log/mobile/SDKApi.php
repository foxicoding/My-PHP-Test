<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午4:17
 */
namespace apps\kafka\log;

class MMobile_SDKApi
{
    /**
     * app客户端数据采集
     * @param array $basic
     * @param array $attr
     * @param bool|false $debug
     * @return array
     */
    public static function vCollect(array $basic,array $attr = array(),$debug = false){
        $basic['topic'] = 'mobile_event';
        $basic['ctime'] = time ();
        $basic['ip_s'] = MCommon_CommonApi::getLocalIp();
        $basic['abtest'] = self::_getABTest($basic);

        $basic['datetime'] = date('c');
        //修改basic里 mfwuuid 为uuid
        $basic['uuid'] = $basic['mfwuuid'];
        unset($basic['mfwuuid']);
        //增加小时属性
        $basic['hour'] = date('H',$basic['ctime']);
        //增加天属性
        $basic['dt'] = date('Ymd',$basic['ctime']);
        //增加分钟属性
        $basic['minute'] = date('i',$basic['ctime']);
        //server guid
        $server_guid = md5(uniqid($basic['ip_s'] . mt_rand(1000, 9999), true));
        //event_time 转 int
        $basic['event_time'] = intval($basic['event_time']);
        //获取ua
        $basic['user_agent'] = $_SERVER["HTTP_USER_AGENT"];
        $basic['mfw_env'] = MFacade_logEnvApi::sGetEnv();
        if (!self::_isValidMobileEvent($basic, $attr))
        {
            $attr['_keys_watcher'] = 1;
            //return false;
        }
        //basic 字段处理
        foreach ($basic as &$pValue)
        {
            if (is_string($pValue))
            {
                $pValue = str_replace(array("\t", "\r", "\n"), ' ', $pValue);
                $pValue = \Ko_Tool_Str::SForce2UTF8($pValue);
            }
        }

        //attr 字段处理
        $attr['_dc_collect_audit_sdk_out'] = (int)(microtime(true) * 1000);
        foreach ($attr as &$sub_value) {
            if (is_string($sub_value)) {
                $sub_value = str_replace(array("\t", "\r", "\n"), ' ', $sub_value);
                $sub_value = \Ko_Tool_Str::SForce2UTF8($sub_value);
            }
        }
        $isdebug = $debug ? '.debug' : '';
        $is_debug_dir=$debug? '_debug':'';

        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'/mobile_event'.$is_debug_dir.'/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir.'mobile_event.' . date('YmdHi') . $isdebug;

        $basic['attr'] = $attr;
        $log = json_encode($basic);

        $log = self::_dataPipeline($log);

        if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES ) {
            return null;
        }
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);
        file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);

        MMobile_KafkaBeat::collect($basic);
        return $basic;
    }


    /**
     * @param $basic
     * @param $attr
     * @return bool
     */
    private static function _isValidMobileEvent($basic, $attr)
    {
        $eventCode = $basic['event_code'];
        if (!MCommon_CommonApi::checkValidKey($eventCode))
        {
            //error_log(__CLASS__ . '::MobileEvent - Error event code: ' . $eventCode
            //		. "\t" . json_encode($basic) . json_encode($attr));
            return false;
        }

        foreach ($attr as $k => $v)
        {
            if (!MCommon_CommonApi::checkValidKey($k))
            {
                //error_log(__CLASS__ . '::MobileEvent - Error event attr key: ' . $k
                //	. "\t" . json_encode($basic) . json_encode($attr));
                return false;
            }
        }
        return true;
    }

    private static function _getABTest($basic)
    {
        if (isset($basic['abtest']) && ! empty($basic['abtest'])) {
            return $basic['abtest'];
        } else {
            return !empty($_SERVER['HTTP_ABTEST']) ? $_SERVER['HTTP_ABTEST'] : '';
        }
    }

    /**
     * @param $log string
     * @return string
     */
    private static function _dataPipeline($log) {
        try {
            $result = \apps\datapipeline\MFacade_dataPipelineApi::mobilePipeline($log);
        }catch (\Exception $e) {
            $result = $log;
        }

        return $result;
    }
}
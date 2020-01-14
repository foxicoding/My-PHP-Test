<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/2/7
 * Time: 下午5:44
 */
namespace apps\kafka\log;


class MWeApp_SDKApi
{
    /** 微信小程序数据采集
     * @param array $basic
     * @param array $attr
     * @return bool
     */

    public static function vCollect(array $basic, array $attr = array()){
        $basic['topic'] = 'weapp_event';
        $basic['ctime'] = time ();
        $basic['ip_s'] = MCommon_CommonApi::getLocalIp();

        $basic['datetime'] = date('c');
        $basic['ip'] = \Ko_Tool_Ip::SGetClientIP();
        $basic['client_ip'] = $basic['ip'];
        //增加小时属性
        $basic['hour'] = date('H',$basic['ctime']);
        //增加天属性
        $basic['dt'] = date('Ymd',$basic['ctime']);
        //增加分钟属性
        $basic['minute'] = date('i',$basic['ctime']);
        
        //server guid(对V2.0版本之前sdk未获取event_guid的处理)
        if (!$basic['event_guid']) {
            $guid = $basic['ip_s'] . getmypid() . mt_rand(1000, 9999);
            $basic['server_guid'] = md5(uniqid( $guid, true));
            $basic['event_guid'] = $basic['server_guid'];
        }
        
        //event_time 转 int
        $basic['event_time'] = intval($basic['event_time']);
        //获取ua
        $basic['user_agent'] = $_SERVER["HTTP_USER_AGENT"];
        //服务环境
        $basic['mfw_env'] = MFacade_logEnvApi::sGetEnv();
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
        foreach ($attr as &$sub_value) {
            if (is_string($sub_value)) {
                $sub_value = str_replace(array("\t", "\r", "\n"), ' ', $sub_value);
                $sub_value = \Ko_Tool_Str::SForce2UTF8($sub_value);
            }
        }
        //目录检查并创建
        $log_dir = MFacade_logEnvApi::sGetLogPath().'/weapp_event/';
        MCommon_CommonApi::checkLogDir($log_dir);
        $filename = $log_dir .'weapp_event.' . date('YmdHi',$basic['ctime']);
        $basic['attr'] = $attr;
        $log = json_encode($basic);
        if (empty($log) || strlen($log) > MCommon_CommonApi::MAX_MESSAGE_BYTES ) {
            return;
        }
        //文件权限
        MCommon_CommonApi::checkFileMod($filename);

        $ret = file_put_contents($filename, $log . "\n", FILE_APPEND | LOCK_EX);
        return $ret;
    }
}